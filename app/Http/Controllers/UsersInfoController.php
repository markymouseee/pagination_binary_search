<?php

namespace App\Http\Controllers;

use App\Models\UsersInfo;
use Illuminate\Http\Request;

class UsersInfoController extends Controller
{
    public function index(Request $request){
       $query = UsersInfo::query();

       if ($request->has('sort')) {
        $sort = $request->get('sort');
        if ($sort === 'id_asc') {
            $query->orderBy('id', 'asc');
        } elseif ($sort === 'firstname_asc') {
            $query->orderBy('firstname', 'asc');
        }
    }

        $users = $query->paginate(10);

        return view('pagination', compact('users'));
    }

    public function search(Request $request){
        $query = $request->input("search-users");

        $usersArray = $this->getUsersArray();

        $result = $this->findMatches($query, $usersArray);

        return response()->json(array_slice($result, 0, 10));

    }

    private function getUsersArray(){
        return UsersInfo::orderBy('firstname')->orderBy('lastname')->get()->toArray();
    }

    private function findMatches($query, $usersArray){
        $terms = array_map('trim', explode(' ', $query));
        $result = [];

        foreach($terms as $term){
            $matches = $this->binarySearch($usersArray, $term);
            $result = array_merge($result, $matches);
        }

        if(trim($query) !== ''){
            $exactMatches = array_filter($usersArray, function($user) use ($query){
                return stripos("{$user['firstname']} {$user['lastname']}", $query) !== false;
            });

            $result = array_merge($result, array_values($exactMatches));
        }

        return array_map("unserialize", array_unique(array_map("serialize", $result)));
    }

    private function binarySearch(array $users, string $query){
        $low = 0;
        $high = count($users) - 1;
        $matches = [];

        while ($low <= $high) {
            $mid = floor(($low + $high) / 2);
            $compareValue = "{$users[$mid]['firstname']} {$users[$mid]['lastname']}";

            // Check if the search query matches
            if (stripos($compareValue, $query) !== false) {
                // If a match is found, collect matches from the middle outwards
                $matches[] = $users[$mid];

                // Search left
                $left = $mid - 1;
                while ($left >= 0 && stripos("{$users[$left]['firstname']} {$users[$left]['lastname']}", $query) !== false) {
                    $matches[] = $users[$left];
                    $left--;
                }

                // Search right
                $right = $mid + 1;
                while ($right < count($users) && stripos("{$users[$right]['firstname']} {$users[$right]['lastname']}", $query) !== false) {
                    $matches[] = $users[$right];
                    $right++;
                }

                break; // Exit the loop after finding matches
            } elseif ($compareValue < $query) {
                $low = $mid + 1; // Move to the right half
            } else {
                $high = $mid - 1; // Move to the left half
            }
        }

        return $matches; // Return collected matches
    }
}
