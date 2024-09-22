$(document).ready(function () {
    // Detect input in the search field
    $('#search_user').on('input', function () {
        let query = $(this).val();

        // If input is not empty, make an AJAX call
        if (query.length > 1) {
            $.ajax({
                url: '/api/search-users', // Your API endpoint
                method: 'GET',
                data: { "search-users": query },
                success: function (response) {
                    let suggestions = $('#suggestions');
                    suggestions.empty(); // Clear previous suggestions

                    // Display suggestions
                    response.forEach(function (user) {
                        suggestions.append(
                            `<a href="#" class="list-group-item list-group-item-action">${user.firstname} ${user.lastname}</a>`
                        );
                    });
                },
                error: function (xhr) {
                    console.error('Error fetching suggestions:', xhr);
                }
            });
        } else {
            // Clear suggestions if input is empty
            $('#suggestions').empty();
        }
    });

    // Handle click on suggestion
    $('#suggestions').on('click', 'a', function (e) {
        e.preventDefault();
        let selectedText = $(this).text();
        $('#search_user').val(selectedText);
        $('#suggestions').empty(); // Clear suggestions after selection
    });

    // Hide suggestions when clicking outside
    $(document).click(function (e) {
        if (!$(e.target).closest('#search_user, #suggestions').length) {
            $('#suggestions').empty();
        }
    });
});



$(document).ready(function () {
    $('#deleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var firstname = button.data('user-firstname');
        var lastname = button.data('user-lastname');

        var modal = $(this);
        modal.find('.modal-body .DisplayName').text(`${firstname} ${lastname}`);
    });
});

$(document).ready(function() {
    $('#sort_users').change(function() {
        const sortBy = $(this).val();

        window.location.href = `?sort=${sortBy}`;
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
