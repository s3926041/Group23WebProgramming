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

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          </ul>

        </div>
      </div>
    </nav>
  </header>
  <main>
    <div class="container-fluid  my-4 border p-3 rounded" id='con'>
      <h4 class="mb-4 text-center">Customer Registration</h4>
      <form class='' method='post' enctype="multipart/form-data" id='form'>
        <div class="mb-3">
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
          <label for="name" class="form-label ">Your name:</label>
          <input type="text" class="form-control fivechar" id="name" name='name' required>
        </div>
        <div class="mb-3 ">
          <label for="address" class="form-label ">Address</label>
          <input type="text" class="form-control fivechar" id="address" name='address' required>
        </div>
        <div class="mb-3 ">
          <label for="image" class="form-label">Image</label>
          <input type="file" class="form-control" id="image" name='image'>
        </div>
        <div class="mb-3 text-center">
          <span id="error" style="color:crimson"></span>
        </div>
        <div class=" d-flex justify-content-center align-items-center">
          <button type="submit" class="btn btn-primary w200" name="customer_reg">Submit</button>
        </div>
      </form>
    </div>
  <script src="./validate.js"></script>
    <?php
    global $con;
    if (isset($_POST['customer_reg'])) {
      $username = $_POST['username'];
      $password = $_POST['password'];
      $password2 = $_POST['password2'];
      $validate = validate($username, $password,$password2);
      if ($validate =='' ) {
        $hashp = password_hash($password, PASSWORD_DEFAULT);
        $name = $_POST['name'];
        $address = $_POST['address'];
        $image = $_FILES['image']['name'];
        $tmp_image = $_FILES['image']['tmp_name'];
        $query = "select username from `user_table` where username= '$username'";
        $resquery = mysqli_query($con, $query);
        $count = mysqli_num_rows($resquery);
        if ($count > 0) {
          echo "<script> alert('Username existed!');</script>";
        } else {
          move_uploaded_file($tmp_image, "../users/userImages/$image");
          $query = "insert into `user_table` (username,password,image,role) values ('$username','$hashp','$image','customer');";
          $resquery = mysqli_query($con, $query);

          $query = "select user_id from `user_table` where username='$username'";
          $resquery = mysqli_query($con, $query);
          if ($rowdata = mysqli_fetch_assoc($resquery)) {
            $userId = $rowdata['user_id'];
            $query = "insert into `customer_table` (user_id,name,address) values ('$userId','$name','$address');";
            $execute = mysqli_query($con, $query);
            if ($execute) echo "<script> alert('Registered!');window.open('customers.php','_self'); </script>";
          }
        }
      }  else echo"<script>alert('$validate') </script>";
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