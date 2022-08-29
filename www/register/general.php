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
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx"
      crossorigin="anonymous"
    />
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

    <main class="center_main">
      <div class="card p-4 mx-auto d-flex my-4" id="card">
        <h2 class="mb-3">Registering</h2>
        <h5 class="">Your role:</h5>
       <a href="./customers.php" class="btn mb-3 w-75 btn-primary"> Customer</a>
     <a href="./vendors.php" class="btn mb-3 w-75 btn-secondary">   Vendors</a>
     <a href="./shippers.php" class="btn mb-3 w-75 btn-dark">Shippers</a>
     <a href="../login/login.php" >Already have a account? Login</a>
      </div>
    </main>
    <?php
  include('../includes/footer.php');
  ?>
    <!-- JavaScript Bundle with Popper -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
