<?php
include('includes/connect.php');
include('./functions/functions.php');
redr('customer')
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./styles.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="./index.php">Group 23</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        
                    </ul>
                    <form class="d-flex mob" role="search" method="get">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_data" />
                        <input type="submit" value="Search" class="btn btn-outline-success" name="search_product">
                    </form>
                    <a class="nav-link mob" href="./cart.php"><i class="fa-solid fa-cart-shopping"></i> <sup id='total_cart'></sup></a>
                    <?php 
                  
          if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    echo "<a class='nav-link mob' href='./users/customer/myaccount.php'>My Account</a>
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
    <main>
        <?php
        if(isset($_GET['search_product'])){
            echo "<div class='container'>
            <div class='row text-center my-4'>
              <h2>Products</h2>
            </div>
            <div class='row form-floating d-flex mx-3 w200'>
            </div>
            <div class='row row-cols-1 row-cols-md-2 row-cols-xxl-3'>";
            search_product();
            echo "</div>
            </div>";
        }else{
            echo "<div class='container-fluid d-flex justify-content-center my-4'>";
            view_product(); 
            echo"</div>";
           
        }    
        ?>
    </main>
    <?php
    include('includes/footer.php');
    ?>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>

</html>