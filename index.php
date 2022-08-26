<?php
include('includes/connect.php');
include('./functions/functions.php');
if (isset($_SESSION['role']) and !isset($_GET['logout'])) {
  if ($_SESSION['role'] == 'vendor') echo "<script> 
  window.open('./users/vendor/vendor.php','_self');</script>";
  if ($_SESSION['role'] == 'shipper') echo "<script> 
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
  <?php include('./includes/toast.php') ?>
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
          <a class="nav-link mob" href="./cart.php"><img src="./cart.png" alt="cart_img" id='cart'> <sup id='total_cart' class="align-bottom"></sup></a>
          <?php
          if (isset($_SESSION['loggedin']) and $_SESSION['loggedin'] == true and !isset($_GET['logout'])) {
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
  <script src="./toast.js"></script>
  <script src="./app.js"></script>
  <?php
  logout();
  ?>
  <main>
    <div class="container">
      <div class="row text-center my-4">
        <h2>Products</h2>
      </div>
      <div class="row form-floating d-flex w200">
        <form method="GET" class="d-flex align-items-end">
          <div class=" mx-2">
            <label for="min">Min</label>
            <input type="number" id="min" name="min" class="form-control filter_input" value="<?php if (isset($_GET['min'])) {$min = $_GET['min']; echo $min;} else echo 0; ?>" required>
          </div>
          <div class=" mx-2">
            <label for="max">Max</label>
            <input type="number" id="max" name="max" class="form-control filter_input" value="<?php if (isset($_GET['max'])) {$max = $_GET['max'];echo $max; } else echo 10000000; ?>" required>
          </div>
          <input type="submit" value="Filter" name="filter" class="form-control mx-2 filter_input">
        </form>

      </div>
      <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3">
        <?php
        if (isset($_GET['filter'])) {
          filter();
        } else
        if (isset($_GET['search_product'])) {
          search_product();
        } else
          get_product();
        ?>
      </div>
    </div>
  </main>
  <?php
  logout();
  include('includes/footer.php');
  ?>
  <!-- JavaScript Bundle with Popper -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>
</html>