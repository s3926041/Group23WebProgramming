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
    <title>Customers</title>
    <!-- CSS only -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx"
      crossorigin="anonymous"
    />
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="../styles.css">
  </head>
  <?php
  
  ?>

    <body>
      <header>
        <nav class="navbar navbar-expand-lg bg-light">
          <div class="container-fluid">
            <a class="navbar-brand" href="<?php myaccount_link() ?>">Group 23</a>
            <button
              class="navbar-toggler"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent"
              aria-expanded="false"
              aria-label="Toggle navigation"
            >
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <div class="navbar-nav me-auto mb-lg-0">
              </div>
              
              <div class="nav-item mx-lg-4">Hi <strong><?php name(); ?></strong></div>
              <a class="nav-link mob" href="../index.php?logout"
                  >Logout</a
                >
            </div>
          </div>
        </nav>
      </header>
      <main>
        <div class="container-fluid">
          <?php ?>

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
 
        </div>
      </main>
      <?php include('../includes/footer.php')?>
    <!-- JavaScript Bundle with Popper -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
