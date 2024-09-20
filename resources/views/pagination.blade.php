<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('stylesheet/main.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="{{ asset('javascripts/bootstrap.bundle.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Pagination</title>
</head>
<body>
    <div class="container shadow rounded mt-5">
        <div class="d-flex justify-content-center">
            <div class="d-flex">
                <div class="d-flex justify-content-between mb-3">
                    <h2>ALL USERS</h2>
                    <input type="text" id="search" class="form-control w-50" placeholder="Search Users....">
                </div>
                <div class="ms-5">
                    <span class="fs-6 badge rounded-pill text-bg-danger">
                        Total Users: {{ count($users) }}
                    </span>
                </div>

            </div>
        </div>
        <hr>
    <table class="table table-condensed">
        <thead>
            <tr class="table-primary">
                <th scope="col">#</th>
                <th scope="col">Firstname</th>
                <th scope="col">Lastname</th>
                <th scope="col">Email</th>
                <th scope="col">Contact</th>
                <th scope="col">Address</th>
                <th scope="col">Delete</th>
                <th scope="col">Edit</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <th scope="row">{{$user->id}}</th>
                    <td>{{ $user->firstname }}</td>
                    <td>{{ $user->lastname }}</td>
                    <td class="text-primary">{{ $user->email }}</td>
                    <td>{{ $user->contact }}</td>
                    <td>{{ $user->address }}</td>
                    <th scope="col"><button class="btn btn-danger"><i class="bi bi-trash"></i></button></th>
                    <th scope="col"><button class="btn btn-success"><i class="bi bi-pencil-square"></i></button></th>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center my-4">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($users->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">
                            <i class="bi bi-arrow-left"></i> Previous
                        </span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $users->previousPageUrl() }}" aria-label="Previous">
                            <i class="bi bi-arrow-left"></i> Previous
                        </a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($users->links()->elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $users->currentPage())
                                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($users->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $users->nextPageUrl() }}" aria-label="Next">
                            Next <i class="bi bi-arrow-right"></i>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">
                            Next <i class="bi bi-arrow-right"></i>
                        </span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
    </div>
    <script>
       $(document).ready(function(){
            $("#search").on('keyup', function(){
                const query = $(this).val();

                $.ajax({
                    url: `/api/search-users`,
                    type: 'GET',
                    data: { query: query },
                    success: function(users){
                        let rows = '';

                        $.each(users, function(index, user){
                            rows += `
                                <tr>
                                <th scope="row">{{ $user->id }}</th>
                                <td>{{ $user->firstname }}</td>
                                <td>{{ $user->lastname }}</td>
                                <td class="text-primary">{{ $user->email }}</td>
                                <td>{{ $user->contact }}</td>
                                <td>{{ $user->address }}</td>
                                <th scope="col">
                                    <button class="btn btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </th>
                                <th scope="col">
                                    <button class="btn btn-success">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                </th>
                            </tr>
                            `;
                        });

                        $('tbody').html(rows);
                    },
                    error: function(error){
                        console.error('Error fetching users', error);
                    }
                })
            })
       })
    </script>
</body>
</html>
