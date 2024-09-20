$(document).ready(function () {
    $('#deleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var firstname = button.data('user-firstname');
        var lastname = button.data('user-lastname');

        var modal = $(this);
        modal.find('.modal-body .DisplayName').text(`${firstname} ${lastname}`);
    });
});

$(document).ready(function(){
    loadPaginatedUsers();

    $("#search_button").on('click', function(){
        const query = $("#search_user").val().trim();

        if(query === ''){
            $("#display_search_result").html(`<span class="alert alert-danger p-1">Nothing to search</span>`);
            loadPaginatedUsers();
        }else{

        $.ajax({
            url: `/api/search-users`,
            type: 'GET',
            data: { "search-users": query },
            success: function(users){
                let rows = '';

                if(users.length === 0){
                    $("#display_search_result").html(`<span class="alert alert-danger p-1">User Not Found</span>`);
                }else{
                    $("#display_search_result").html(`<span></span>`);
                    $.each(users, function(index, user){
                    rows += `
                        <tr>
                        <th scope="row">${user.id}</th>
                        <td>${user.firstname}</td>
                        <td>${user.lastname}</td>
                        <td class="text-primary">${user.email}</td>
                        <td>${user.contact}</td>
                        <td>${user.address}</td>
                        <th scope="col">
                            <button class="btn btn-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal"
                                data-user-firstname="${user.firstname}"
                                data-user-lastname="${user.lastname}">
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
            }
                },


            error: function(error){
                console.error('Error fetching users', error);
            }
        })
        }

    })
});

function loadPaginatedUsers(page = 1) {
$.ajax({
    url: `/`,
    type: 'GET',
    success: function (users) {
        let rows = '';
        $.each(users, function (index, user) {
            rows += `
                <tr>
                    <th scope="row">${user.id}</th>
                    <td>${(user.firstname)}</td>
                    <td>${(user.lastname)}</td>
                    <td class="text-primary">${(user.email)}</td>
                    <td>${(user.contact)}</td>
                    <td>${(user.address)}</td>
                    <th scope="col">
                            <button class="btn btn-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal"
                                data-user-firstname="${user.firstname}"
                                data-user-lastname="${user.lastname}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </th>
                    <td>
                        <button class="btn btn-success">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                    </td>
                </tr>
            `;
        });

        $('tbody').html(rows);

    },
    error: function (error) {
        console.error('Error loading paginated users', error);
    }
});
}

loadPaginatedUsers();
