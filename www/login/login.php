<?php
include('../includes/connect.php');
include('../functions/functions.php');
cant_access();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous" />
  <link rel="stylesheet" href="./login.css" />
  <link rel="stylesheet" href="../styles.css" />
</head>

<body>
  <?php include('../includes/toast.php') ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  <script src="../toast.js"></script>

  <header>
    <nav class="navbar navbar-expand-lg bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="../index.php">Group 23</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>
        </div>
      </div>
    </nav>
  </header>
  <main class="center_main">
    <div class="card p-4 mx-auto my-4" id="card">
      <h2 class="center">Login</h2>
      <div class="row">
        <div class="col">
          <form method="post" id="form">
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name='username' 
              value='<?php if (isset($_POST['username'])) $username =$_POST['username'];
              else $username ="";
              echo "$username";
              ?>'
              />
            </div>
            <div class="mb-3">
              <label for="Password1" class="form-label">Password</label>
              <input type="password" class="form-control" id="Password1" name="password" />
            </div>
            <div class="mb-3"><a href="../register/general.php">Don't have acount? Registering</a></div>
            <div class="mb-3 ">
          <span id="error"></span>
        </div>

            <button type="submit" class="btn btn-primary" name="login">Submit</button>
          </form>
        </div>
      </div>
    </div>
    <?php

    if (isset($_POST['login'])) {
      $username = $_POST['username'];
      $password = $_POST['password'];

      $userdata =  (array) json_decode(file_get_contents('../../accounts.txt'),true);
      print_r($userdata);
      if ($userdata != null and array_key_exists($username,$userdata)) {
        if (password_verify($password, $userdata[$username]['password'])) {
          $_SESSION['loggedin'] = true;
          $_SESSION['username'] = $username;
          $_SESSION['role'] = $userdata[$username]['role'];
          $_SESSION['id'] = $userdata[$username]['id'];
          $_SESSION['img'] = $userdata[$username]['image'];
          if (isset($_SESSION['failed_login'])) {
            unset($_SESSION['failed_login']);
          }
          if ($userdata[$username]['role'] == 'customer') {
            echo "<script>window.open('../index.php','_self');</script> ";
          } else if ($userdata[$username]['role'] == 'vendor') {
            echo "<script>window.open('../users/vendor/vendor.php','_self');</script> ";
          } else  if ($userdata[$username]['role'] == 'shipper') {
            echo "<script>window.open('../users/shipper/shipper.php','_self');</script> ";
          }
        } else {
          echo"<script>setToast('bg-danger','Wrong Password!')</script>";
        }
      } else {
        echo"<script>setToast('bg-danger','Username not exist!')</script>";
      }
    } 
    ?>
  </main>
  <?php
  include('../includes/footer.php');
  ?>
  <script src="./validate.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>

</html>