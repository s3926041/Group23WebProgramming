<?php
include('includes/connect.php');
include('./functions/functions.php');
if (isset($_SESSION['role']) and !isset($_GET['logout'])) {
    if ($_SESSION['role'] == 'vendor') echo "<script> alert('You are already logged in!');
    window.open('./users/vendor/vendor.php','_self');</script>";
    if ($_SESSION['role'] == 'shipper') echo "<script> alert('You are already logged in!');
    window.open('./users/shipper/shipper.php','_self');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Homepage</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous" />

    <link rel="stylesheet" href="./styles.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="./index.php">Group 23</a>
                <button class="navbar-toggler" id='but' type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    </ul>
                    <form class="d-flex mob" role="search" method="get">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_data" />
                        <input type="submit" value="Search" class="btn btn-outline-success" name="search_product">
                    </form>
                    <a class="nav-link mob" href="./cart.php"><img src="./cart.png" alt="cart_img" id='cart'> <sup id='total_cart' class="align-bottom"></sup></a>
                    <?php

                    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                        echo "<a class='nav-link mob' href='./users/myaccount.php'>My Account</a>
    <a class='nav-link mob' href='./index.php?logout'>Logout</a>
    ";
                    } else {
                        echo "<a class='nav-link mob' href='./login/login.php'>Login/Registering</a>";
                    } ?>
                </div>
            </div>
        </nav>
    </header>
  <script src="./app.js"></script>
    <main class='center_main'>
        <?php
        if (isset($_GET['search_product'])) {
            $data = $_GET['search_data'];
            echo "<script>window.open('index.php?search_data=$data&search_product=Search','_self') </script>";
        } else {
            echo "<div class='container-fluid d-flex justify-content-center my-4'>";

            view_product();
            echo "</div>";
        }
        ?>
    </main>
    <?php
    include('includes/footer.php');
    ?>
  <script src="./nav.js"></script>
</body>

</html>