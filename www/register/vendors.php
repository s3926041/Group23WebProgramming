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
  <title>Register</title>
  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous" />
  <link rel="stylesheet" href="./general.css">
  <link rel="stylesheet" href="../styles.css">
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
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          </ul>
        </div>
      </div>
    </nav>
  </header>
  <main class="center_main">
    <div class="container-fluid  my-4 border p-3 rounded" id='con'>
      <h4 class="mb-4 text-center">Vendor Registration</h4>
      <form class='' method='post' enctype="multipart/form-data" id='form'>
        <div class="mb-3 ">
          <label for="username" class="form-label">Username:</label>
          <input type="text" class="form-control " id="username" name='username' value='<?php if(isset($_POST['username'])) $var = $_POST['username'];else $var = ""; echo $var;  ?>' required>
        </div>
        <div class="mb-3 ">
          <label for="Password1" class="form-label">Password:</label>
          <input type="password" class="form-control" id="Password1" name='password' value='<?php if(isset($_POST['password'])) $var = $_POST['password'];else $var = ""; echo $var;  ?>' required>
        </div>
        <div class="mb-3 ">
          <label for="Password2" class="form-label">Confirm password:</label>
          <input type="password" class="form-control" id="Password2" name='password2' value='<?php if(isset($_POST['password2'])) $var = $_POST['password2'];else $var = ""; echo $var;  ?>' required>
        </div>
        <div class="mb-3 ">
          <label for="name" class="form-label">Bussiness name:</label>
          <input type="text" class="form-control fivechar" id="name" name='name' value='<?php if(isset($_POST['name'])) $var = $_POST['name'];else $var = ""; echo $var;  ?>' required>
        </div>
        <div class="mb-3 ">
          <label for="address" class="form-label">Bussiness adress</label>
          <input type="text" class="form-control fivechar" id="address" name='address' value='<?php if(isset($_POST['address'])) $var = $_POST['address'];else $var = ""; echo $var;  ?>' required>
        </div>
        <div class="mb-3 ">
          <label for="image" class="form-label">Image</label>
          <input type="file" class="form-control" id="image" name='image' required>
        </div>
        <div class="mb-3 text-center">
          <span id="error"></span>
        </div>
        <div class=" d-flex justify-content-center align-items-center mb-3">
          <button type="submit" class="btn btn-primary w200" name="vendor_reg">Submit</button>
        </div>

      </form>
    </div>
    <?php
    register('vendor')
    ?>
  </main>
  <?php
  include('../includes/footer.php');
  ?>
  <!-- JavaScript Bundle with Popper -->
  <script src="./validate.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>

</html>