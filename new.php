<?php
session_start();
include("partials/_dbconnect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RDiscuss</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary" style="height: 70px;">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">RDiscuss</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Top Categories
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php
                        $sql = "SELECT category_name, category_id FROM `categories`";
                        $result = mysqli_query($conn, $sql);

                        while ($row = mysqli_fetch_array($result)) {
                            echo '<li><a class="dropdown-item" href="threadlist.php?catid=' . $row['category_id'] . '">' . $row['category_name'] . '</a></li>';
                        }
                        ?>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>
            </ul>
            <div class="d-flex mx-2">
                <form class="d-flex" role="search">
                    <input class="form-control me-2 my-3" type="search" placeholder="Search" aria-label="Search" style="height: 35px;">
                    <button class="btn btn-outline-success my-3" type="submit" style="height: 35px;">Search</button>
                </form>
                <?php
                if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
                    echo '<p class="mx-2" style="padding-top:20px;">Welcome ' . $_SESSION['user_email'] . '</p>
                          <a href="partials/_logout.php" class="btn btn-primary mx-2 p-2 py-1 my-3" style="height: 35px;">Logout</a>';
                } else {
                    echo '<button class="btn btn-primary mx-2 my-3" style="height: 35px;" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
                          <button class="btn btn-primary mr-2 my-3" style="height: 35px;" data-bs-toggle="modal" data-bs-target="#signupModal">Signup</button>';
                }
                ?>
            </div>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
