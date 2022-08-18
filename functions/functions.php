<?php
session_start();
function generate($para, $res)
{
  while ($row_data = mysqli_fetch_assoc($res)) {
    $pId = $row_data['product_id'];
    $pName = $row_data['product_name'];
    $pPrice = $row_data['product_price'];
    $pImage = $row_data['product_img'];
    $pDes = $row_data['product_description'];
    $w50 = 'w-50';
    $wh300 = '';
    $c = 'd-flex justify-content-center align-content-center flex-column';
    $containerId = "";
    $imgId = "";
    if ($para == 2) {
      $containerId = 'product_details_container';
      $imgId = 'product_details_img';
      $w50 = '';
      $wh300 = 'w300';
    }
    if ($para == 1)
      echo "<div class='col my-2 p-4'>";

    echo    "<div class='card ' id='$containerId'>
          <div class='d-flex justify-content-center'>
            <img
              src='./pImages/$pImage'
              class='card-img-top'
              alt='product-image'
              id='$imgId'
            />
            </div>
            <div class='card-body $c $wh300'>
            <div class='mb-3'>
              <h5 class='card-title mb-3'>$pName</h5><div class='card-text mb-3 fw-normal'>Price: <span class='price mx-1'>$pPrice<span></div>";
    if ($para == 2) echo "<p class='card-text mb-1'>Description: $pDes</p>";                        
    echo "   </div><div class=' d-flex justify-content-center'> ";                           
    echo "<a id='$pId' class='btn btn-primary p-2 $w50 mr5'onclick='addcart($pId)' >Add to cart</a>";
    if ($para == 1)
      echo "<a href='product_details.php?product_id=$pId' class='btn btn-info p-2  w-50 ml5' >View more</a>";
    echo "</div></div></div>";
    if ($para == 1)
      echo "</div>";
  }
}

function get_product()
{
  global $con;
  $query = "select * from `products` ";
  $res = mysqli_query($con, $query);
  generate(1, $res);
}
function search_product()
{
  global $con;
  $search_data = $_GET['search_data'];
  $query = "select * from `products` where product_name like '%$search_data%'";
  $res = mysqli_query($con, $query);
  generate(1, $res);
  $count = mysqli_num_rows($res);
  if ($count == 0) {
    echo "<h2  class='nodata_message'>No product meets requirements </h2>";
  }
}

function view_product()
{
  global $con;
  $product_id = $_GET['product_id'];
  $query = "select * from `products` where product_id=$product_id limit 1";
  $res = mysqli_query($con, $query);
  generate(2, $res);
}

function filter()
{
  global $con;
  $min = $_GET['min'];
  $max = $_GET['max'];
  $query = "select * from `products` where product_price >= $min and product_price <= $max ";
  $res = mysqli_query($con, $query);
  generate(1, $res);
  $count = mysqli_num_rows($res);
  if ($count == 0) {
    echo "<h2  class='nodata_message'>No product meets requirements </h2>";
  }
}
function name()
{
  $name = $_SESSION['username'];
  echo "$name";
}
function vendor_product()
{
  global $con;
  $userId = $_SESSION['id'];
  $select_products = "select * from `products` where vendor='$userId'";
  $result_products = mysqli_query($con, $select_products);
  $count = mysqli_num_rows($result_products);
  if ($count > 0) {
    while ($row_data = mysqli_fetch_assoc($result_products)) {
      $pId = $row_data['product_id'];
      $pName = $row_data['product_name'];
      $pPrice = $row_data['product_price'];
      $pImage = $row_data['product_img'];
      $pDes = $row_data['product_description'];
      echo "<tr>
      <th class='text-center' scope='row'>$pId</th>
      <td class='text-center h120'>$pName</td>
      <td class='text-center h120'>
          <img src='../../pImages/$pImage' alt='cart-image' class='vendor_img'>
      </td>
      <td class='text-center h120'>$pPrice</td>
      <td class='text-center h120'>$pDes</td>
      </tr>";
    }
  }
}
function add_product()
{
  global $con;
  if (isset($_POST['add_product'])) {
    $pName = $_POST['pName'];
    if (mysqli_num_rows(mysqli_query($con, "select * from `products` where product_name ='$pName'")) > 0) {
      echo "<script> alert('Product name existed') </script>";
    } else {
      $pName = $_POST['pName'];
      $pPrice = $_POST['pPrice'];
      $pImage = $_FILES['pImage']['name'];
      $tempImage = $_FILES['pImage']['tmp_name'];
      $pDes = $_POST['pDes'];
      $userId = $_SESSION['id'];
      move_uploaded_file($tempImage, "../../pImages/$pImage");
      $insert_query = "insert into `products` (product_name,product_price,product_img,product_description,vendor) values('$pName','$pPrice','$pImage','$pDes','$userId')";
      $result = mysqli_query($con, $insert_query);
      if ($result) {
        echo "<script> alert('Product added succesfully!')
           </script>";
      } else echo "<script> alert('Failed!') </script>";
    }
  }
}
function shipper_orders()
{
  global $con;
  $userId = $_SESSION['id'];
  $query = "select * from `shipper_table` where user_id=$userId limit 1";
  $res = mysqli_query($con, $query);
  $row_data = mysqli_fetch_assoc($res);
  $hub = $row_data['hub_id'];

  $query = "select * from `order_table` where status='active' and hub_id=$hub";
  $res = mysqli_query($con, $query);
  $count = mysqli_num_rows($res);
  if ($count > 0) {
    while ($row_data = mysqli_fetch_assoc($res)) {
      $oId = $row_data['order_id'];
      $userId = $row_data['user_id'];
      $status = $row_data['status'];
      echo "<tr>
      <th class=''  scope='row'>$oId</th>
      <td class='' >$userId</td>
   
      <td  class=''>$hub</td>
      <td  class=''>$status</td>
      <td  class='d-flex justify-content-center w200' ><a href='./shipper.php?order_id=$oId' class='text-center form-control w200'>Order Details</a></td>
      </tr>";
    }
  }
}

function logout()
{
  if (isset($_GET['logout'])) {
    $_SESSION['loggedin'] = false;
    $_SESSION['username'] = '';
    $_SESSION['role'] = '';
    $_SESSION['id'] = '';
    $_SESSION['img'] = '';
    echo "<script> alert('Logged out!');
    window.open('index.php','_self');</script>";
  }
}

function cant_access()
{
  if (isset($_SESSION['loggedin'])) {
    if ($_SESSION['loggedin'] == true) {
      if ($_SESSION['role'] == 'customer') {
        echo "<script> alert('You are already logged in!');
      window.open('../index.php','_self');</script>";
      } else if ($_SESSION['role'] == 'vendor') {
        echo "<script> alert('You are already logged in!');
      window.open('../users/vendor/vendor.php','_self');</script>";
      } elseif ($_SESSION['role'] == 'shipper') {
        echo "<script> alert('You are already logged in!');
      window.open('../users/shipper/shipper.php','_self');</script>";
      }
    }
  }
}

function myaccount_link()
{
  $val = $_SESSION['role'];
  // echo "<script>alert('$val');</script>";
  if ($val == 'customer') {
    echo "../index.php";
  } else if ($val == 'vendor') {
    echo "./vendor/vendor.php";
  } else  if ($val == 'shipper') {
    echo "./shipper/shipper.php";
  }
}
function redrmyAc()
{
  if (isset($_SESSION['role'])) {
    $val = $_SESSION['role'];
    if ($val == '')  echo "<script>alert('You are not having permission to access this URL');window.open('../index.php','_self');</script> ";
  }
}
function redr($role)
{
  if (!isset($_GET['logout'])) {
    $check = true;
    if (!isset($_SESSION['role'])) {
      if ($role != 'customer') $check = false;
    } else {
      $value = $_SESSION['role'];

      if ($value != $role) {
        if ($value == '') {
          if ($role != 'customer')
            $check = false;
        } else
          $check = false;
      }
    }
    if (!$check) echo "<script>alert('You are not having permission to access this URL');window.history.go(-1);</script> ";
  }
}
function validate($username, $password, $password2)
{
  $err = '';
  //PASSWORD VALIDATION
  $number = preg_match('@[0-9]@', $password);
  $uppercase = preg_match('@[A-Z]@', $password);
  $lowercase = preg_match('@[a-z]@', $password);
  $specialChars = preg_match('/[!@#$%^&*]+/', $password);
  if (strlen($password) < 8 || strlen($password) > 20 || !$number || !$uppercase || !$lowercase || !$specialChars) {
    $err = "Password must contains at least one upper case letter, at least one lower case letter, at least one digit, at least one special letter in the set !@#$%^&*, NO other kind of characters, has a length from 8 to 20 characters";
  }
  if ($password != $password2) {
    $err = "Confirm password not match";
  }
  //USERNAME VALIDATION
  if (strlen($username) < 8 || strlen($username) > 15 || !ctype_alnum($username)) {
    $err = "Username contains only letters (lower and upper case) and digits, has a length from 8 to 15 characters, unique";
  }
  return $err;
}
