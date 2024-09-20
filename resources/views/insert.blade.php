<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('stylesheet/insert.css') }}">
    <link rel="stylesheet" href="{{ asset('stylesheet/main.css') }}">
    <script src="{{ asset('javascripts/bootstrap.bundle.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Binary Search Tree</title>
</head>
<body>
    <form id="insertForm">
        @csrf
        <div class="input-body">
            <h1>Binary Search Insert</h1>
            <input type="number" name="value" placeholder="Value" class="form-control" required><br>
            <input type="number" name="root_id" placeholder="Root ID" class="form-control"><br>
            <button type="submit" class="btn btn-primary w-100">Insert Value</button>
        </div>

        <span id="displayResult">

        </span>
    </form>


    <script>
        $("#insertForm").submit(function(e){
            e.preventDefault();

            $.ajax({
                url: '/api/bst/insert',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response){
                    $("#displayResult").html('<div class="alert alert-success text-center mt-3">Value Inserted: ' + JSON.stringify(response) + '</div>');
                },
                error: function(error){
                    $("#displayResult").html('<div class="alert alert-danger text-center mt-3">Value Not Inserted</div>');
                }
            })
        })
    </script>
</body>
</html>
