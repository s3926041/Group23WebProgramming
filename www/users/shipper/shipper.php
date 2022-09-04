<?php
include('../../includes/connect.php');
include('../../functions/functions.php');
redr('shipper');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Shipper</title>
  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous" />

  <link rel="stylesheet" href="../../styles.css" />
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="./shipper.php">Group 23</a>
        <button class="navbar-toggler" id='but' type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <div class="navbar-nav me-auto mb-lg-0"></div>
          <div class='nav-item mx-lg-4 mob'>
            <a href='shipper.php' >All Orders</a>
          </div>
          <?php
            echo "<a class='nav-link mob' href='../myaccount.php'>My Account</a>
    <a class='nav-link mob' href='../../index.php?logout'>Logout</a>"
          ?>

        </div>
      </div>
    </nav>
  </header>

  <main>
    <div class="container my-4 ">
      <?php 
      if(isset($_GET['order_id'])){
        include('./details.php');
      }else
      include('./allorders.php');
      ?>
    </div>
  </main>
  <?php
    include('../../includes/footer.php');
  ?>
  <script src="../../nav.js"></script>
</body>

</html>