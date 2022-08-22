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
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx"
      crossorigin="anonymous"
    />

    <link rel="stylesheet" href="./login.css" />
    <link rel="stylesheet" href="../styles.css" />
  </head>
  <body>
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
            <form method="post">
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name = 'username' />
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label"
                  >Password</label
                >
                <input
                  type="password"
                  class="form-control"
                  id="exampleInputPassword1"
                  name = "password"
                />
              </div>
              <div class="mb-3"><a href="../register/general.php" >Don't have acount? Registering</a></div>

              <button type="submit" class="btn btn-primary" name="login">Submit</button>
            </form>
          </div>
        </div>
      </div>
        <?php
        global $con;
        if(isset($_POST['login'])){
          $username = $_POST['username'];
          $password = $_POST['password'];
          $query = "select * from `user_table` where username='$username'";
          $resquery = mysqli_query($con,$query);
          $count = mysqli_num_rows($resquery);
          $row = mysqli_fetch_assoc($resquery);
          if($count>0){
            if(password_verify($password,$row['password'])){
              session_start();
              $_SESSION['loggedin'] = true;
              $_SESSION['username'] = $username;
              $_SESSION['role'] = $row['role'];
              $_SESSION['id'] = $row['user_id'];
              $_SESSION['img'] = $row['image'];
              echo "<script>alert('Login successful!') </script> ";
              if($row['role']=='customer'){
                echo "<script>window.open('../index.php','_self');</script> ";
              }
              else if($row['role'] =='vendor'){
                echo "<script>window.open('../users/vendor/vendor.php','_self');</script> ";
              }
              else  if($row['role'] =='shipper'){
                echo "<script>window.open('../users/shipper/shipper.php','_self');</script> ";
              }
            }
            else{
              echo "<script>alert('Wrong password!') </script> ";
            }
          }
          else{
            echo "<script>alert('Unknown username!') </script> ";
          }
        }
        ?>
    </main>
    <?php
  include('../includes/footer.php');
  ?>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
