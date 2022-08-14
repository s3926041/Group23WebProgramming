<?php
include('../includes/connect.php');
include('../functions/functions.php');
redrmyAc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo $_SESSION['role']?></title>
  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../styles.css">
</head>
<?php

?>

<body>
  <header>
    <nav class="navbar navbar-expand-lg bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="<?php myaccount_link() ?>">Group 23</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <div class="navbar-nav me-auto mb-lg-0">
          </div>

          <div class="nav-item mx-lg-4">Hi <strong><?php name(); ?></strong></div>
          <a class="nav-link mob" href="../index.php?logout">Logout</a>
        </div>
      </div>
    </nav>
  </header>
  <main>
    <?php
    $role = $_SESSION['role'];
    $userId = $_SESSION['id'];
    $username = $_SESSION['username'];
    $img = $_SESSION['img'];
    ?>
    <div class="container-fluid">
      <div class="card d-flex">
        <div class=""> <img class="card-img-top" src="./userImages/<?php echo $img ?>" alt="Card image cap"></div>
        <div class="card-body">
          <h5 class="card-title">User ID: <span><?php echo $userId ?></span></h5>
          <h5 class="card-title">Username: <span><?php echo $username ?></span></h5>
          <h5 class="card-title">User role: <span><?php echo $role ?></span></h5>
          <?php 
          if($role =='customer'){
            $query = "select * from `customer_table` where user_id =$userId";
            $row = mysqli_fetch_assoc(mysqli_query($con,$query));
            $name = $row['name'];
            $address = $row['address'];
            echo"
            <h5 class='card-title'>Name: <span>$name</span></h5>
            <h5 class='card-title'>Address: <span> $address</span></h5>";
          }
          else if($role=='vendor')
          {
            $query = "select * from `vendor_table` where user_id =$userId";
            $row = mysqli_fetch_assoc(mysqli_query($con,$query));
            $name = $row['business_name'];
            $address = $row['business_address'];
            echo"
            <h5 class='card-title'>Business name: <span>$name</span></h5>
            <h5 class='card-title'>Business address: <span> $address</span></h5>";

          }
          else{
            $query = "select * from `shipper_table` where user_id =$userId";
            $row = mysqli_fetch_assoc(mysqli_query($con,$query));
            $hub = $row['hub_id'];
            echo"
            <h5 class='card-title'>Distribution Hub ID: <span> $hub</span></h5>";
          }
          ?>
        </div>
      </div>
    </div>
  </main>
  <?php include('../includes/footer.php') ?>
  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>

</html>