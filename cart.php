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
                        echo "<a class='nav-link mob' href='./users/myaccount.php'>My Account</a>
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
                <tbody id="append">
                    <script>
                        let products = {};
                        let temp = 0
                        let pname
                        let pPrice
                        let pImage
                        let vendorname
                        let cart = JSON.parse(localStorage.getItem('cart'))
                     
                        function display(cart) {
                            localStorage.setItem('products', JSON.stringify(products))
                            for (let key in cart) {
                                pname = products[key].pname
                                pPrice = products[key].pPrice
                                pImage = products[key].pImage
                                vendorname = products[key].vendorname
                                temp += pPrice*cart[key]
                                let html = `<tr> <th class='text-center' >${key}</th> <td style='height:120px;'  class='text-center'>${pname}</td> <td style='height:120px;'  class='text-center' id='img'> <img src='./pImages/${pImage}' alt='cart-image' style='width: 150px;height: 100%; object-fit:contain;'> </td> <td style='height:120px;'  class='text-center'>${pPrice}</td> <td style='height:120px;'  class='text-center'> <form method='post'> <div class='d-flex w-100 justify-content-center'> <input type='hidden' name='pId' value='${key}'> <input class='text-center rounded mx-2 form-control' style='width:80px' type='number' name='quantity' min='1' max='100' value='${cart[key]}' required> <input class='text-center rounded mx-2 form-control' type='submit' value='Update' name='update' style='width:80px'> </div> </form> </td> <td style='height:120px;' >${vendorname} </td> <td style='height:120px;'> <form method='post'> <div class='d-flex w-100 justify-content-center'> <input type='hidden' name='pId' value='${key}'> <input class='text-center rounded mx-2 form-control' type='submit' value='Remove' name='remove' style='width:80px'> </div> </form> </td> </tr>`
                                let append = document.getElementById('append');
                                append.insertAdjacentHTML('afterend', html);
                            }
                          
                        }
                        function update(pid,quantity){
                            cart[pid] = quantity
                            localStorage.setItem('cart',JSON.stringify(cart));
                         
                        }
                        function remove(pid){
                            delete cart[pid]
                            localStorage.setItem('cart',JSON.stringify(cart));
                  
                        }
                       
                    </script>
                    <?php
                    global $tempPrice;
                    $tempPrice = '0';
                    global $con;
                    $query = "select * from `products`";
                    $res = mysqli_query($con, $query);
                    while ($r_data = mysqli_fetch_assoc($res)) {
                        $pId =  $r_data['product_id'];
                        $pName = $r_data['product_name'];
                        $pPrice = $r_data['product_price'];
                        $pImage = $r_data['product_img'];
                        $vendor = $r_data['vendor'];
                        $query = "select * from `vendor_table` where user_id= $vendor";
                        $venquery = mysqli_query($con, $query);
                        $r_data = mysqli_fetch_assoc($venquery);
                        $vendorname = $r_data['bussiness_name'];
                        echo "<script>
                            pname = '$pName'
                            pPrice = $pPrice
                            pImage = '$pImage'
                            vendorname = '$vendorname'
                            products[$pId] = {'pname': pname,'pPrice': pPrice,'pImage' : pImage, 'vendorname': vendorname}
                            </script>";
                    }
                    echo "<script> display(cart) </script>"
                    ?>
                </tbody>
            </table>

            <!-- Remove item -->
            <?php

            global $con;
            if(isset($_POST['update'])) {
                $pId = $_POST['pId'];
                $quantity = $_POST['quantity'];                             
                    echo "<script>update('$pId',$quantity) 
                    window.open('cart.php','_self')</script>";
            }
            else
            if(isset($_POST['remove'])){
                $pId = $_POST['pId'];
                    echo "
                    <script>remove('$pId') 
                    window.open('cart.php','_self')</script>";
                
            }
            ?>
            <div class="row my-4 row-col-md-3">
                <div class="d-flex">
                    <h4 class="m-0">Total price:</h4>
                    <span class='mx-2' style='font-size:20px'>
                        <script>
                            document.write(temp)
                        </script>
                    </span>
                </div>
               
                <form action="" method="post" class="d-flex m-0">
                    <input type="hidden" name="json" id="json" value="">
                    <script>          document.getElementById('json').value = JSON.stringify(cart)</script>
                    <a href="./index.php" class="form-control m-2" style='width:180px; text-decoration:none'>Continue Shopping</a>
                    <input type="submit" value="Order" class="form-control m-2" name="order" style='width:180px; text-decoration:none'>
                </form>
        
                <!-- <a href="./cart.php?order" class="form-control m-2" style='width:180px; text-decoration:none'>Order</a> -->
              
                <?php
                global $con;
                if (isset($_POST['order'])) {
                    if ($_SESSION['loggedin'] and $_SESSION['role'] ='customer') {
                        $json1 = $_POST['json'];
                        $json = json_decode($json1,true);
                        if($json == null){
                            echo"<script> alert('Cart is empty!');
                            </script>";
                        }
                        else{
                         
                                $userid = $_SESSION['id'];
                                $query = "insert into `order_table` (user_id) values ('$userid')";
                                $res = mysqli_query($con,$query);
                                $query = "select max(order_id) from `order_table`";
                                $res2 = mysqli_query($con,$query);
                                $row = mysqli_fetch_assoc($res2);
                                $orderId = $row['max(order_id)'];
                                foreach($json as $key => $value){
                                    $query = "insert into `order_details` (order_id,product_id,quantity) values ('$orderId','$key','$value')";
                                    $res = mysqli_query($con,$query);
                                }
                                echo "<script> alert('You have placed an order !')
                                 localStorage.clear(); window.open('./cart.php','_self');</script>";
                            
                        }
                       
                    } else {
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