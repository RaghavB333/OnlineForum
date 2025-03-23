<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to RDiscuss- Coding Forums</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <?php include("partials/_header.php"); ?>
    <?php include("partials/_dbconnect.php"); ?>
    <?php
    $id = $_GET['catid'];
    $sql = "SELECT * FROM categories WHERE category_id=$id";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $catname = $row['category_name'];
        $catdesc = $row['category_description'];
    }

    ?>
    <?php
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == 'POST') {
        //insert thread into db
        // $th_uid = $_SESSION["user_email"];
    
        $th_uid = mysqli_real_escape_string($conn, $_SESSION["user_email"]); // Sanitize the email
        $sql2 = "SELECT `sno` FROM `users` WHERE `user_email`='$th_uid'";
        $result2 = mysqli_query($conn, $sql2);
        if ($result2 && mysqli_num_rows($result2) > 0) {
            $row = mysqli_fetch_assoc($result2); // Fetch a single row as an associative array
            $sno = $row['sno'];
        }
        $th_title = $_POST['title'];
        $th_desc = $_POST['desc'];

       
        $th_title=str_replace('<','&lt', $th_title);
        $th_title=str_replace('>','&gt', $th_title);
        
        $th_desc=str_replace('<','&lt', $th_desc);
        $th_desc=str_replace('>','&gt', $th_desc);

        $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`,`thread_user_id`,`created`) VALUES ('$th_title', '$th_desc', '$id','$sno', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if ($showAlert) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success !</strong> Your thread has been posted. Please wait for the community to respond to it.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
        }
    }
    ?>
    <!-- category slider starts here -->



    <!-- category container starts here -->


    <div class="container my-4 px-5">
        <div class="p-5 mb-4 bg-light rounded-3">
            <div class="container-fluid py-5">
                <h1 class="display-5 fw-bold">Welcome to <?php echo $catname ?> Forums</h1>
                <p class="fs-4"><?php echo $catdesc ?></p>
                <hr class="my-4">
                <p>This forum is a peer to peer forum. <br>1. Be Respectful and Courteous
                    <br>
                    2. Stay On Topic
                    <br>
                    3. Search Before Posting
                    <br>
                    4. Provide Clear and Detailed Information
                    <br>
                    5. No Plagiarism
                    <br>
                    6. Constructive Criticism Only
                    <br>
                    7. No Spam or Self-Promotion
                    <br>
                    8. Keep It Professional
                    <br>
                    9. Follow the Forum Structure
                    <br>
                    10. Report Inappropriate Behavior
                </p>
                <button class="btn btn-success btn-lg" type="button">Learn more</button>
            </div>
        </div>
    </div>
    <div class="container px-5">
        <h1>Start a Discussion</h1>
        <?php


        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            echo '<form action="' . $_SERVER['REQUEST_URI'] . '" method="POST">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Problem Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">Keep your title as short and crisp as possible</div>
            </div>
            <div class="mb-3">
                <label for="exampleTextarea" class="form-label">Elaborate your concern</label>
                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    ';
        } else {
            echo '
        <p class="lead px-1">
            You are not logged in. Login to start a discussion.
        </p>
';
        }
        ?>
    </div>
    <div class="container my-4 px-5">
        <h1 class="py-2">Browse questions</h1>
        <?php
        $id = $_GET['catid'];
        $sql = "SELECT * FROM threads WHERE thread_cat_id=$id";
        $result = mysqli_query($conn, $sql);
        $noResult = true;
        while ($row = mysqli_fetch_assoc($result)) {
            $noResult = false;
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $id = $row['thread_id'];
            $thread_time = $row['created'];
            $thread_user_id = $row['thread_user_id'];
            $sql2 = "SELECT user_email FROM users WHERE sno='$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);



            echo '<div class="media d-flex my-4">
            <div><img src="userDefault.png" width="54px" class="mr-3" alt="..."></div>
            <div class="media-body">
            
                <h5 class="mt-0"><a class="text-dark" href="thread.php?threadid=' . $id . '">' . $title . '</a></h5>
                ' . $desc . '
            </div><p class="fw-bold my-0 position-absolute" style="right:200px;">Asked by: ' . $row2['user_email'] . ' at ' . $thread_time . '</p>
        </div>';
        }
        if ($noResult) {
            echo '<div class="bg-light p-5 mb-4 rounded-3">
                <div class="container-fluid py-5">
                    <p class="display-5">No Threads Found</p>
                    <p class="col-md-8 fs-4">Be the first person to ask a question</p>
                </div>
                </div>

            ';
        }
        ?>


    </div>

    <?php include("partials/_footer.php"); ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
</body>

</html>