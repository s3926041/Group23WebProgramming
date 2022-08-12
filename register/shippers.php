<?php
include('../includes/connect.php');
include('../functions/functions.php')
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register</title>
  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="./general.css">
  <link rel="stylesheet" href="../styles.css">
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="../index.php">Group 23</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          </ul>
          <a class="nav-link mob" href="../cart.php"><i class="fa-solid fa-cart-shopping"></i> <sup><?php cart_item() ?></sup></a>
          <a class="nav-link mob" href="../login/login.php">Login/Registering</a>
        </div>
      </div>
    </nav>
  </header>

  <main>
    <div class="container-fluid  my-4 border p-3 rounded" id='con'>
      <h4 class="mb-4 text-center">Shipper Registration</h4>
      <form class='' method='post' enctype="multipart/form-data">
        <div class="mb-3 ">
          <label for="username" class="form-label">Username:</label>
          <input type="text" class="form-control" id="username" name='username' required>
        </div>
        <div class="mb-3 ">
          <label for="Password1" class="form-label">Password:</label>
          <input type="password" class="form-control" id="Password1" name='password' required>
        </div>
        <div class="mb-3 ">
          <label for="Password2" class="form-label">Confirm password:</label>
          <input type="password" class="form-control" id="Password2" name='password2' required>
        </div>
        <div class="mb-3 ">
          <label for="name" class="form-label">Your name:</label>
          <input type="text" class="form-control" id="name" name='name' required>
        </div>
        <div class="mb-3 ">
          <label for="image" class="form-label">Image</label>
          <input type="file" class="form-control" id="image" name='image'>
        </div>
        <div class="mb-3">
          <label for="hub">Distribution hub:</label>
          <select name="hub" class="form-control" id="hub">
            <?php $query = "select * from `distribution_hub`";
            $res = mysqli_query($con, $query);
            while($row = mysqli_fetch_assoc($res)){
              $hub_id = $row['hub_id'];
              $name = $row['name'];
              
              echo"<option value='$hub_id'>$name</option>";
            }
            ?>
          </select>
        </div>
        <div class=" d-flex justify-content-center align-items-center">
          <button type="submit" class="btn btn-primary w200" name="shipper_reg">Submit</button>
        </div>
      </form>
    </div>
    <?php
    global $con;
    if (isset($_POST['shipper_reg'])) {
      $username = $_POST['username'];
      $password = $_POST['password'];
      $hashp = password_hash($password, PASSWORD_DEFAULT);
      $password2 = $_POST['password2'];
      $name = $_POST['name'];
      $image = $_FILES['image']['name'];
      $tmp_image = $_FILES['image']['tmp_name'];
      $hub = $_POST['hub'];
      $query = "select username from `user_table` where username= '$username'";
      $resquery = mysqli_query($con, $query);
      $count = mysqli_num_rows($resquery);
      if ($count > 0) {
        echo "<script> alert('Username existed!');</script>";
      } else {
        //
        if ($password != $password2) {
          echo "<script> alert('Password not match!');</script>";
        } else {
          move_uploaded_file($tmp_image, "../users/userImages/$image");
          $query = "insert into `user_table` (username,password,image,role) values ('$username','$hashp','$image','shipper');";
          $resquery = mysqli_query($con, $query);

          $query = "select user_id from `user_table` where username='$username'";
          $resquery = mysqli_query($con, $query);
          if ($rowdata = mysqli_fetch_assoc($resquery)) {
            $userId = $rowdata['user_id'];
            $query = "insert into `shipper_table` (user_id,hub_id) values ('$userId','$hub');";
            $execute = mysqli_query($con, $query);
            if ($execute) echo "<script> alert('Registered!');window.open('shippers.php','_self'); </script>";
          }
        }
      }
    }
    ?>
  </main>
  <?php
  include('../includes/footer.php');
  ?>
  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>

</html>