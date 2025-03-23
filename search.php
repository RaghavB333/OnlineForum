
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to RDiscuss- Coding Forums</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<style>
    .container {
        min-height: 78.5vh;
    }
</style>

<body>

    <?php include("partials/_header.php"); ?>
    <?php include("partials/_dbconnect.php");
    ?>
    <!-- Search results -->

    <div class="container my-3">
        <h1 class="text-center py-1">
            Search results for <em><?php echo $_GET["search"] ?></em>
        </h1>
        <?php 
        $query=$_GET["search"];
        $sql = "SELECT * FROM `threads` WHERE MATCH(thread_title, thread_desc) AGAINST ('$query' IN NATURAL LANGUAGE MODE)";
        $result = mysqli_query($conn, $sql);
        $noresults=true;
        while ($row = mysqli_fetch_assoc($result)) {
            $noresults=false;
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thread_id=$row['thread_id'];
            $url="thread.php?threadid=".$thread_id;
        
        echo'<div class="result">
        <h3><a href="'.$url.'" class="text-dark">'.$title.'</a></h3><p>'.$desc.'</p></div>';}
     if($noresults){
        echo '<div class="bg-light p-5 mb-4 rounded-3">
                <div class="container-fluid py-5">
                    <p class="display-5">No Results Found</p>
                    <p class="col-md-8 fs-4">Suggestions:<ul>

                    <li>Make sure that all words are spelled correctly.</li>
                    <li>Try different keywords.</li>
                    <li>Try more general keywords.</li></ul>
                    </p>
                </div>
                </div>';
     }
        ?>
        </div>
        <div class="results">
            <h3></h3>
        </div>
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