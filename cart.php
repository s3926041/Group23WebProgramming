<?php
include('includes/connect.php');
include('./functions/functions.php')
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cart</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./styles.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="./index.php">Group 23</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    </ul>
                    </li>
                    </ul>
                    <?php 
          if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    echo "<a class='nav-link mob' href='./users/customer/myaccount.php'>My Account</a>
    <a class='nav-link mob' href='./index.php?logout'>Logout</a>
    ";
} else {
    echo "<a class='nav-link mob' href='./login/login.php'>Login/Registering</a>";
} ?>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <div class="container text-center my-4">
            <h2 class="my-2">Cart</h2>           
                <table class="table" style="overflow-x:auto;">
                    <thead class="thead-light">
                        <tr>
                            <th class='text-center' scope='col'>ID:</th>
                            <th class='text-center' scope='col'>Product</th>
                            <th class='text-center' scope='col'>Image</th>
                            <th class='text-center' scope='col'>Price</th>
                            <th class='text-center' scope='col'>Quantity</th>
                            <th class='text-center' scope='col'>Vendors</th>
                            <th class='text-center' scope='col'>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php   
                        global $tempPrice;
                        $tempPrice = 0;
                        global $con;                   
                        echo "<script>
                        cart = JSON.parse(localStorage.getItem('cart'))
                        let count = Object.keys(cart).length
                        </script>";
                        $count = "<script>document.writeln(parseInt(count))</script> ";
                        echo (int) $count;
                        $i = 0;      
                        $string = "<script>document.writeln(Object.keys(cart)[0])</script> ";   
                        echo $string;

                        $pId = (int) $string;          
                        echo $pId; 
                        while ($i < $count) {
                            echo "<script>
                           console.log($i)
                            </script>";
                            $string =  "<script> document.write(parseInt(Object.keys(cart)[$i])) </script> ";  
                            $pId = (int)$string;
                            $query = "select * from `products` where product_id=$pId";
                            $r_query = mysqli_query($con, $query);
                            $r_data = mysqli_fetch_assoc($r_query);
                            $pName = $r_data['product_name'];
                            $pPrice = $r_data['product_price'];
                            $quantity = "<script> document.write(parseInt(Object.values(cart)[$i])) </script> "; 
                            $subPrice = $pPrice *$quantity;
                            $tempPrice += $subPrice;
                            $pImage = $r_data['product_img'];
                            $vendor = $r_data['vendor'];
                            $query = "select * from `vendor_table` where user_id= $vendor";
                            $venquery = mysqli_query($con, $query);
                            $r_data = mysqli_fetch_assoc($venquery);
                            $vendorname = $r_data['bussiness_name'];
                            echo "<tr>
                            <th class='text-center' scope='row'>$pId</th>
                            <td style='height:120px;'  class='text-center'>$pName</td>
                            <td style='height:120px;'  class='text-center'>
                                <img src='./pImages/$pImage' alt='cart-image' style='width: 150px;height: 100%; object-fit:contain;'>
                            </td>
                            <td style='height:120px;'  class='text-center'>$pPrice</td>
                            <td style='height:120px;'  class='text-center'>
                            <form method='post'>
                            <div class='d-flex w-100 justify-content-center'>
                            <input type='hidden' name='pId' value='$pId'>
                            <input class='text-center rounded mx-2 form-control' style='width:80px' type='number' name='quantity' min='1' max='100' value='$quantity' required>
                            <input class='text-center rounded mx-2 form-control' type='submit' value='Update' name='update' style='width:80px'>
                            </div>                      
                            </form>            
                            </td>
                            <td style='height:120px;' >$vendorname </td>
                              <td style='height:120px;'>
                              <form method='post'>
                              <div class='d-flex w-100 justify-content-center'> 
                              <input type='hidden' name='pId' value='$pId'>                           
                              <input class='text-center rounded mx-2 form-control' type='submit' value='Remove' name='remove' style='width:80px'>
                              </div>
                              </form>
                            </td>
                        </tr>";
                        $i++;
                    }
                        
                       
                        ?>
                    </tbody>
                </table>

            <!-- Remove item -->
            <?php
       
            // global $con;
            // if(isset($_POST['update'])) {
            //     $pId = $_POST['pId'];
            //     $quantity = $_POST['quantity'];
            //     $query = "update `cart_details` set quantity=$quantity where ip_address='$ip' and product_id=$pId";
            //     $res=mysqli_query($con, $query);
            //     if($res){
            //         echo "<script>window.open('cart.php','_self')</script>";
            //     }
            // }
            // else
            // if(isset($_POST['remove'])){
            //     $pId = $_POST['pId'];
            //     $query = "Delete from `cart_details` where ip_address='$ip' and product_id=$pId";
            //     $res=mysqli_query($con, $query);
            //     if($res){
            //         echo "<script>window.open('cart.php','_self')</script>";
            //     }
            // }
            ?>
            <div class="row my-4 row-col-md-3" >
                <div class="d-flex">
                <h4 class="m-0">Total price:</h4>
                <span class='mx-2' style='font-size:20px'> <?php echo $tempPrice ?></span>
                </div>
                <a href="./index.php" class="form-control m-2" style='width:180px; text-decoration:none'>Continue Shopping</a>
                <a href="./cart.php?order" class="form-control m-2" style='width:180px; text-decoration:none'>Order</a>
                <?php
                global $con;
                if(isset($_GET['order'])){
                    if($_SESSION['loggedin']){
                        $query = "Delete from `cart_details`";
                        $res=mysqli_query($con, $query);
                        echo "<script> alert('Ok br...');window.open('cart.php','_self');</script>";
                    }
                    else{
                        echo "<script> alert('You need to login first');
                                window.open('./login/login.php','_self');</script>";
                    }
                }
                ?>
            </div>
        </div>
    </main>
    <?php
    include('includes/footer.php');
    ?>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>

</html>