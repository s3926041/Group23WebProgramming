<?php
include('includes/connect.php');
include('./functions/functions.php');
redr('customer');
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
    <link rel="stylesheet" href="./styles.css">
</head>

<body>
    <?php include('./includes/toast.php') ?>
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
        <?php include('./includes/toast.php') ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
        <script src="./toast.js"></script>
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
                            for (let key in cart) {
                                pname = products[key].pname
                                pPrice = products[key].pPrice
                                pImage = products[key].pImage
                           
                                temp += pPrice * cart[key]
                                let html = `<tr> <th class='text-center' >${key}</th> 
                                <td   class='text-center h120'>${pname}</td>
                                <td   class='text-center h120' > <img src='./pImages/${pImage}' alt='cart-image' class='vendor_img'>
                                 </td> <td  class='text-center h120'>${pPrice}</td>
                                  <td  class='text-center h120'> <form method='post'> 
                                  <div class='d-flex w-100 justify-content-center'> 
                                   <input id='${key}' class='text-center rounded mx-2 form-control' style='width:80px' type='text'
                                    name='quantity' onkeyup='change_quantity(${key},this.value,${cart[key]},1)' onchange='change_quantity(${key},this.value,${cart[key]},2)' value='${cart[key]}' required>
                                   </div> </form> </td>  <td class='120'> <form method='post'> <div class='d-flex w-100 justify-content-center'> <input type='hidden' name='pId' value='${key}'>
                                <input class='text-center rounded mx-2 form-control' type='submit' value='Remove' name='remove' style='width:80px'> </div> </form> </td> </tr>`
                                let append = document.getElementById('append');
                                append.insertAdjacentHTML('afterend', html);
                            }
                        }

                        function remove(pid) {
                            delete cart[pid]
                            localStorage.setItem('cart', JSON.stringify(cart));
                        }

                        function isNumeric(str) {
                            if (typeof str != "string") return false
                            return !isNaN(str) && !isNaN(parseFloat(str))
                        }

                        function change_quantity(pid, value, prev, para) {
                            if (isNumeric(value)) {
                                let intValue = parseInt(value);
                                console.log(intValue)
                                let intId = parseInt(pid);
                                if (intValue > 0) {
                                    cart[pid] = intValue
                                    localStorage.setItem('cart', JSON.stringify(cart));
                                    temp = 0
                                    for (let key in cart) {
                                        pPrice = products[key].pPrice
                                        temp += pPrice * cart[key]
                                    }
                                    document.getElementById('total_price').innerHTML = temp;
                                } else {
                                    setToast('bg-danger', 'Quantity must be greater than 0! ')
                                    document.getElementById(`${pid}`).value = cart[pid]
                                }
                            } else {
                                if (!value == '') {
                                    // alert('Inapopriate input!')
                                    setToast('bg-danger', 'Inapopriate input!')
                                    document.getElementById(`${pid}`).value = cart[pid]
                                } else if (para == 2) {
                                    // alert('You can not leave this field blank')
                                    setToast('bg-danger', 'You can not leave this field blank!')
                                    document.getElementById(`${pid}`).value = cart[pid]
                                }
                            }
                            document.getElementById('json').value = JSON.stringify(cart)
                        }
                    </script>
                    <?php
                    global $tempPrice;
                    $tempPrice = '0';
                    $productData = (array) json_decode(file_get_contents('../products.txt'), true);

                    foreach ($productData as $key => $value) {
                        if (gettype($value) == 'array') {
                            $pId =  $value['id'];
                            $pName = $value['name'];
                            $pPrice = $value['price'];
                            $pImage = $value['image'];
                            $vendor = $value['vendor_id'];
                            // $vendorname = $value['business_name'];
                            echo "<script>
                            pname = '$pName'
                            pPrice = $pPrice
                            pImage = '$pImage'
                            products[$pId] = {'pname': pname,'pPrice': pPrice,'pImage' : pImage}
                            localStorage.setItem('products', JSON.stringify(products))
                            </script>";
                        }
                    }
                    echo "<script> display(cart) </script>"
                    ?>
                </tbody>
            </table>
            <?php

            global $con;
            if (isset($_POST['remove'])) {
                $pId = $_POST['pId'];
                echo "
                    <script>
                    remove('$pId') 
                    window.open('cart.php','_self')</script>";
            }
            ?>
            <div class="row my-4 row-col-md-3">
                <div class="d-flex">
                    <h4 class="m-0">Total price:</h4>
                    <span class='mx-2' style='font-size:20px' id='total_price'>
                    </span>
                </div>
                <script>
                    document.getElementById('total_price').innerHTML = temp;
                </script>

                <form method="post" class="d-flex m-0">
                    <input type="hidden" name="json" id="json" value="">
                    <script>
                        document.getElementById('json').value = JSON.stringify(cart)
                    </script>
                    <a href="./index.php" class="form-control m-2" style='width:180px; text-decoration:none'>Continue Shopping</a>
                    <input type="submit" value="Order" class="form-control m-2" name="order" style='width:180px; text-decoration:none'>
                </form>

                <!-- <a href="./cart.php?order" class="form-control m-2" style='width:180px; text-decoration:none'>Order</a> -->

                <?php
                global $con;
                if (isset($_POST['order'])) {
                    if (isset($_SESSION['loggedin']) and $_SESSION['loggedin'] == true and $_SESSION['role'] == 'customer') {
                        $json1 = $_POST['json'];
                        
                        $json = json_decode($json1, true);     
                        if ($json == null) {
                            echo "<script> setToast('bg-danger','Cart is empty!');
                            </script>";
                        } else {
                            $userid = $_SESSION['id'];

                            $hubdata =  (array) json_decode(file_get_contents('../hub.txt'),true);
                            $randomHub = array_rand($hubdata,1);
                            $hub_id = $hubdata[$randomHub]['id'];

                            $orderdata = (array) json_decode(file_get_contents('../order.txt'),true);
                            if($orderdata == null){
                                $orderdata = array();
                                $orderdata['autoID'] = 0;
                            }
                            $oid = $orderdata['autoID'];
                            $orderdata[$oid]['user_id'] = $userid;
                            $orderdata[$oid]['hub_id'] = $hub_id;
                            $orderdata[$oid]['status'] = 'active';
                         
                            $details = array();
                            foreach ($json as $key => $value) {
                                array_push($details,array("p_id" => $key,"quantity" => $value));
                            }
                            $orderdata[$oid]['details'] = array();
                           $orderdata[$oid]['details'] = $details;
                            $orderdata['autoID'] += 1;
                            file_put_contents('../order.txt',json_encode($orderdata,JSON_PRETTY_PRINT));
                            echo "<script> alert('You have placed an order !'); window.open('cart.php','_self');
                                 localStorage.clear();</script>";
                        }
                    } else {
                        echo "<script>setToast('bg-danger','You need to login first!');
                                </script>";
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