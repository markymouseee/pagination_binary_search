<?php

namespace App\Http\Controllers;

use App\Models\UsersInfo;
use Illuminate\Http\Request;

class UsersInfoController extends Controller
{
    public function index(){
       $users = UsersInfo::paginate(10);

        return view('pagination', compact('users'));
    }

    public function search(Request $request){
        $query = $request->input('search-users');

        $users = UsersInfo::where('firstname', 'LIKE', "%{$query}%")
                    ->orWhere('lastname', 'LIKE', "%{$query}%")
                    ->orWhere('email', 'LIKE', "%{$query}%")->get();

                    return response()->json($users);

        // $users = UsersInfo::orderBy('firstname')->get();

        // if(empty($query)){
        //     return response()->json($users);
        // }

        // $result = $this->binarySearch($users, $query);

        // return response()->json($result);

    }


            //Binary Search Algorithm
    // private function binarySearch($users, $query){

    //     $start_index = 0;
    //     $end_index = count($users) - 1;
    //     $result = [];

    //     while($start_index <= $end_index){
    //         $middle_index = (int)(($start_index + $end_index) / 2);

    //         $currentName = strtolower($users[$middle_index]->firstName);

    //         if(strpos($currentName, $query) !== false){
    //             $result[] = $users[$middle_index];

    //             $left = $middle_index - 1;

    //             while($left >= 0 && strpos(strtolower($users[$left]->firstname), $query) !== false){
    //                 array_unshift($result, $users[$left]);
    //                 $left--;
    //             }

    //             $right = $middle_index + 1;

    //             while($right < count($users) && strpos(strtolower($users[$right]->firstName), $query) !== false){
    //                 $result[] = $users[$right];
    //                 $right++;
    //             }

    //             break;
    //         }elseif($currentName < $query){
    //             $start_index = $middle_index + 1;
    //         }else{
    //             $end_index = $middle_index - 1;
    //         }
    //     }

    //     return $result;
    // }
}
