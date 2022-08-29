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
  <title>My Account</title>
  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous" />
  <link rel="stylesheet" href="../styles.css">
</head>
<?php

?>
<body>
<?php include('../includes/toast.php') ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  <script src="../toast.js"> 
</script>
<script>  if(localStorage.getItem('imgChange') !== null){
    setToast('bg-success','Avatar changed!')
    localStorage.removeItem('imgChange')
  }</script>
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
          <?php if($_SESSION['role'] =='vendor'){
            echo "<div class='nav-item mx-lg-4 mob'>
            <a href='./vendor/vendor.php?viewproduct' >View All Product</a>
          </div>
          <div class='nav-item mx-lg-4 mob'>
            <a href='./vendor/vendor.php?addproduct' >Add Product</a>
          </div>";
          }
          elseif ($_SESSION['role'] =='shipper'){
            echo " <div class='nav-item mx-lg-4 mob'>
            <a href='./shipper/shipper.php' >All Orders</a>
          </div>";
          }
           ?>
          <div class="nav-item mx-lg-4">Hi <strong><?php name(); ?></strong></div>
          <a class="nav-link mob" href="../index.php?logout">Logout</a>
        </div>
      </div>
    </nav>
  </header>
  <main class="center_main">
    <?php
    $userdata =  (array) json_decode(file_get_contents('../../accounts.txt'),true);
    $role = $_SESSION['role'];
    $userId = $_SESSION['id'];
    $username = $_SESSION['username'];
    $img = $_SESSION['img'];
    ?>
    <div class="container d-flex justify-content-center my-4" style='width:320px' id='form'>
      <div class="card d-flex w-100">
        <div class="d-flex justify-content-center flex-column align-items-center"> <img class="card-img-top" src="./userImages/<?php echo $img ?>" alt="Card image cap">
        <form method='post' enctype="multipart/form-data" class="d-flex flex-column align-items-center">
        <input type="file" name="img" id="img" class="" onchange="form.submit()" style="display: none" >
        <label for="img" class="" style="cursor:pointer;color:blue;">Change Image</label>
        
      </form>
    </div>
    <?php
        if(isset($_FILES['img'])){
          $image = $_FILES['img']['name'];
          $tmp_image = $_FILES['img']['tmp_name'];
          move_uploaded_file($tmp_image, "./userImages/$image");
          $userdata[$username]['image'] =$image;
          file_put_contents('../../accounts.txt',json_encode($userdata,JSON_PRETTY_PRINT));
          $_SESSION['img']= $image;
          echo "<script>
          localStorage.setItem('imgChange','true')
          window.open('./myaccount.php','_self') </script>";
        }
    ?>
        <div class="card-body d-flex flex-column">
          <span class="card-title strong">User ID: <span><?php echo $userId ?></span></span>
          <span class="card-title strong">Username: <span><?php echo $username ?></span></span>
          <span class="card-title strong">User role: <span><?php echo $role ?></span></span>
          <?php 
          $name = $userdata[$username]['name'];
          $address = $userdata[$username]['address'];
          if($role =='customer'){
            echo"
            <span class='card-title'>Name: <span>$name</span></span>
            <span class='card-title'>Address: <span> $address</span></span>";
          }
          else if($role=='vendor')
          {

            echo"
            <span class='card-title strong'>Business name: <span>$name</span></span>
            <span class='card-title strong'>Business address: <span> $address</span></span>";

          }
          else{
            $hub = $userdata[$username]['hub'];
            echo"
            <span class='card-title'>Name: <span>$name</span></span>
            <span class='card-title'>Address: <span> $address</span></span>
            <span class='card-title strong'>Distribution Hub ID: <span> $hub</span></span>";
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