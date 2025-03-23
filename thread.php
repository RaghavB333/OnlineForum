
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
    
    $id = $_GET['threadid'];
    $sql = "SELECT * FROM `threads` WHERE thread_id=$id";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
        $uid= $row['thread_user_id'];
    }
    $sql3= "SELECT * FROM `users` where sno='$uid'";
    $result3 = mysqli_query($conn, $sql3);
    while ($row3 = mysqli_fetch_assoc($result3)) {
        $postedby= $row3["user_email"];
    }
    ?>
    <?php
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == 'POST') {
        //insert comments into db
        $comment = $_POST['comment'];
        $comment=str_replace('<','&lt', $comment);
        $comment=str_replace('>','&gt', $comment);
        $th_uid = mysqli_real_escape_string($conn, $_SESSION["user_email"]); // Sanitize the email
        $sql2 = "SELECT `sno` FROM `users` WHERE `user_email`='$th_uid'";
        $result2 = mysqli_query($conn, $sql2);

        if ($result2 && mysqli_num_rows($result2) > 0) {
            $row = mysqli_fetch_assoc($result2); // Fetch a single row as an associative array
            $sno = $row['sno'];}

        $sql = "INSERT INTO `comments` ( `comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment', '$id', '$sno', current_timestamp());";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if ($showAlert) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Your comment has been added.
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
                <h1 class="display-5 fw-bold"><?php echo $title ?></h1>
                <p class="fs-4"><?php echo $desc ?></p>
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
                <p>Posted by <b><?php echo $postedby; ?></b></p>
            </div>
        </div>

    </div>

    <?php
    echo '<div class="container px-5">
        <h1>Post a comment</h1></div>';

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

        echo ' <form action="' . $_SERVER['REQUEST_URI'] . '" method="POST" class="container px-5">

            <div class="mb-3">
                <label for="exampleTextarea" class="form-label">Type your comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
            </div> 

            <button type="submit" class="btn btn-success">Post Comment</button>
        </form>
    </div>'
        ;
    }
    else{
        echo '<div class="container">
        <p class="lead px-4 mx-3">
            You are not logged in. Login to post a comment.
        </p>
    </div>';
    }

    ?>
    <div class="container my-4 px-5">
        <h1 class="py-2">Discussions</h1>
        <?php
        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `comments` WHERE thread_id=$id";
        $result = mysqli_query($conn, $sql);
        $noResult = true;
        while ($row = mysqli_fetch_assoc($result)) {
            $noResult = false;
            $id = $row["comment_id"];
            $content = $row['comment_content'];
            $comment_time = $row['comment_time'];
            $thread_user_id = $row['comment_by'];

            $sql2 = "SELECT user_email FROM users WHERE sno='$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);

            echo '<div class="media d-flex my-4">
            <div><img src="userDefault.png" width="54px" class="mr-3" alt="..."></div>
            <div class="media-body px-2"><p class="fw-bold my-0">'.$row2['user_email'].' at ' . $comment_time . '</p>
               ' . $content . ' 
            </div>
        </div>';
        }
        if ($noResult) {
            echo '<div class="bg-light p-5 mb-4 rounded-3">
                <div class="container-fluid py-5">
                    <p class="display-5">No Comments Found</p>
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