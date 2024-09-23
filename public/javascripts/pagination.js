
$(document).ready(function () {
    // Initialize all event handlers and functions
    initializeEventHandlers();
    loadPaginatedUsers();
});

// Initialize all event handlers
function initializeEventHandlers() {
    handleSearchInput();
    setupModal();
    handleSortUsers();
    handleSearchButtonClick();
    hideSuggestionsOnClickOutside();
}

// Handle search input in the user search field
function handleSearchInput() {
    $('#search_user').on('input', function () {
        const query = $(this).val();
        if (query.length > 1) {
            fetchUserSuggestions(query);
        } else {
            clearSuggestions();
        }
    });

    $('#suggestions').on('click', 'a', function (e) {
        e.preventDefault();
        const selectedText = $(this).text();
        $('#search_user').val(selectedText);
        clearSuggestions();
    });
}

// Fetch user suggestions from the API
async function fetchUserSuggestions(query) {
    try {
        const response = await fetch(`/api/search-users?search-users=${query}`);
        const users = await response.json();

        displaySuggestions(users);
    } catch (error) {
        console.error("Error fetching suggestion", error);
    }

//    $.ajax({
//         url: '/api/search-users',
//         type: 'GET',
//         data: { "search-users": query },
//         success: function(users){
//             displaySuggestions(users);
//         },
//         error: function(error){
//             console.log("Error fetching suggestions: " + error);
//         }
//    })
}

// Display suggestions in the dropdown
function displaySuggestions(users) {
    const suggestions = $('#suggestions');
    suggestions.empty(); // Clear previous suggestions

    users.forEach(function (user) {
        suggestions.append(
            `<a href="#" class="list-group-item list-group-item-action">${user.firstname} ${user.lastname}</a>`
        );
    });
}

// Clear the suggestions dropdown
function clearSuggestions() {
    $('#suggestions').empty();
}

// Set up delete modal to display selected user information
function setupModal() {
    $('#deleteModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const firstname = button.data('user-firstname');
        const lastname = button.data('user-lastname');

        $(this).find('.modal-body .DisplayName').text(`${firstname} ${lastname}`);
    });
}

// Handle sorting of users when sort option is changed
function handleSortUsers() {
    $('#sort_users').change(function () {
        const sortBy = $(this).val();
        window.location.href = `?sort=${sortBy}`;
    });
}

// Handle the search button click event
function handleSearchButtonClick() {
    $("#search_button").on('click', function () {
        const query = $("#search_user").val().trim();
        if (query === '') {
            displaySearchError('Nothing to search');
            loadPaginatedUsers(); // Reload users if the search query is empty
        } else {
            searchUsers(query);
        }
    });
}

// Fetch users based on search query
function searchUsers(query) {
    $.ajax({
        url: `/api/search-users`,
        type: 'GET',
        data: { "search-users": query },
        success: function (users) {
            if (users.length === 0) {
                displaySearchError('User Not Found');
            } else {
                renderUsers(users);
            }
        },
        error: function (error) {
            console.error('Error fetching users', error);
        }
    });
}

// Display search result error message
function displaySearchError(message) {
    $("#display_search_result").html(`<span class="alert alert-danger p-1">${message}</span>`);
}

// Render user rows in the table
function renderUsers(users) {
    let rows = '';
    $("#display_search_result").html(`<span></span>`);
    $.each(users, function (index, user) {
        rows += `
            <tr>
                <th scope="row">${user.id}</th>
                <td>${user.firstname}</td>
                <td>${user.lastname}</td>
                <td class="text-primary">${user.email}</td>
                <td>${user.contact}</td>
                <td>${user.address}</td>
                <td>
                    <button class="btn btn-danger"
                        data-bs-toggle="modal"
                        data-bs-target="#deleteModal"
                        data-user-firstname="${user.firstname}"
                        data-user-lastname="${user.lastname}">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
                <td>
                    <button class="btn btn-success">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                </td>
            </tr>
        `;
    });

    $('tbody').html(rows);
}

// Load paginated users from the server
async function loadPaginatedUsers(page = 1) {
    try {
        const response = await fetch(`/?=${page}`);
        const users = await response.json();
        renderUsers(users);
    } catch (error) {
        console.error("Error loading paginated users", error)
    }

    // $.ajax({
    //     url: `/`, // You might need to specify the correct endpoint if pagination is used
    //     type: 'GET',
    //     success: function (users) {
    //         renderUsers(users);
    //     },
    //     error: function (error) {
    //         console.error('Error loading paginated users', error);
    //     }
    // });
}

// Hide suggestions when clicking outside the search area
function hideSuggestionsOnClickOutside() {
    $(document).click(function (e) {
        if (!$(e.target).closest('#search_user, #suggestions').length) {
            clearSuggestions();
        }
    });
}
