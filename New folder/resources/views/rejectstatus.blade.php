<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Form</title>

    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Your custom CSS styles -->
    <style>
        /* Add your custom styles here */
        body {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <h2>Rejected Comment</h2>

        <form action="{{route('updatestatus')}}" method="post">
        @csrf
        <input type="hidden" name="id" value="{{$gu_id}}">
            <div class="form-group">
                <textarea class="form-control" id="comment" name="businesscomment" rows="4" placeholder="Enter your comment"></textarea>
            </div>
            
            <!-- Your other form fields go here -->
           <input type="submit" class="btn btn-primary">
            <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
        </form>
    </div>
    
    <!-- Add Bootstrap JS and Popper.js scripts if needed -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
