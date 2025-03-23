<?php


// Unsplash API access key
$access_key = '14WeCBbvS_edWGA46lQ6gQyq0Ln734KNKJcK98KzWKM';

// API URL to search for images based on the keyword
$url = "https://api.unsplash.com/search/photos?query=coding&client_id=" . $access_key;
$url2 = "https://api.unsplash.com/search/photos?query=programmer&client_id=" . $access_key;
$url3 = "https://api.unsplash.com/search/photos?query=microsoft&client_id=" . $access_key;
// $url4 = "https://api.unsplash.com/search/photos?query=python-code&client_id=" . $access_key;

// Initialize cURL
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the API request
$response = curl_exec($ch);



// Decode the JSON response
$data = json_decode($response, true);
curl_setopt($ch, CURLOPT_URL, $url2);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the API request
$response2 = curl_exec($ch);



// Decode the JSON response
$data2 = json_decode($response2, true);
curl_setopt($ch, CURLOPT_URL, $url3);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the API request
$response3 = curl_exec($ch);



// Decode the JSON response
$data3 = json_decode($response3, true);
curl_setopt($ch, CURLOPT_URL, $url3);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the API request


// Close the cURL session
// Print the decoded data to see its structure


// Check if 'results' is set in the response and if there are any results
if (isset($data['results']) && is_array($data['results']) && count($data['results']) > 0) {
    // Get the total number of results
    $total_results = count($data['results']);

    // Pick a random index from the results
    $random_index = rand(0, $total_results - 1);

    // Get the image URL from the random result
    $image_url = $data['results'][$random_index]['urls']['regular']; // Use 'regular' size or choose other sizes like 'full', 'small', etc.

    // Get the image URL from the random result
    $image_url2 = $data2['results'][$random_index]['urls']['regular']; // Use 'regular' size or choose other sizes like 'full', 'small', etc.
    $random_index3 = rand(0, $total_results - 1);

    // Get the image URL from the random result
    $image_url3 = $data3['results'][$random_index]['urls']['regular']; // Use 'regular' size or choose other sizes like 'full', 'small', etc.
    // Use 'regular' size or choose other sizes like 'full', 'small', etc.


}

?>





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
    if (isset($_GET['password']) && $_GET['password'] == 'invalid') {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Invalid Password.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    
    if (isset($_GET['loggedin']) && $_GET['loggedin'] == 'invalid') {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Invalid Username.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    
        if (isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == 'true') {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> You are now signed in!.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        }if (isset($_GET['signupsuccess']) && $_GET['signupsuccess'] != 'true'){
            $showError=$_GET['signupsuccess'];
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Error! </strong>'.$showError.'.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        }

    
    ?>

    <!-- category slider starts here -->

    <div id="carouselExample" class="carousel slide">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <?php
                echo '<img src="' . htmlspecialchars($image_url) . '" alt="" style="width:1520px; height:400px; object-fit:cover;">';
                ?>

            </div>
            <div class="carousel-item">
                <?php
                echo '<img src="' . htmlspecialchars($image_url2) . '" alt="" style="width:1520px; height:400px; object-fit:cover;">';
                ?>
            </div>
            <div class="carousel-item"><?php
            echo '<img src="' . htmlspecialchars($image_url3) . '"alt="" style="width:1520px; height:400px; object-fit:cover;">';
            ?>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- category container starts here -->


    <div class="container my-4">
        <h2 class="text-center my-3 ">RDiscuss - Categories</h2>
        <div class="row my-3" style="margin-left:100px;margin-bottom:18px; margin-top:10px">

            <!-- fetch all the categories -->
            <?php $sql = "SELECT * FROM `categories`";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $cat = $row['category_name'];
                $id = $row['category_id'];
                $catdesc = $row['category_description'];
                $access_key = '14WeCBbvS_edWGA46lQ6gQyq0Ln734KNKJcK98KzWKM'; // Replace with your valid access key
            
                $url4 = "https://api.unsplash.com/search/photos?query=" . $cat . "-code&client_id=" . $access_key;

                // Initialize cURL
                $ch = curl_init();

                // Set cURL options
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response4 = curl_exec($ch);
                // Decode the JSON response
                $data4 = json_decode($response4, true);
                if (isset($data4['results']) && is_array($data4['results']) && count($data4['results']) > 0) {
                    // Get the total number of results
                    $total_results = count($data['results']);

                    // Pick a random index from the results
                    $random_index = rand(0, $total_results - 1);
                    $image_url4 = $data4['results'][$random_index]['urls']['regular'];
                }
                // echo $row['category_id']; 
                echo '<div class="col-md-4 my-2">
                        <div class="card" style="width: 18rem;">
                    
                        <img src="' . htmlspecialchars($image_url4) . '" class="card-img-top" alt="..." width="200" height="200">
                    

                        <div class="card-body">
                            <h5 class="card-title"><a href="threadlist.php?catid=' . $id . '">' . $cat . '</a></h5>
                            <p class="card-text">' . substr($catdesc, 0, 100) . '...</p>
                            <a href="threadlist.php?catid=' . $id . '" class="btn btn-primary">View Threads</a>
                        </div>
                    </div>
                </div>';

            }
            curl_close($ch);

            ?>

            <!-- use a for loop to iterate through categories -->

        </div></div>

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