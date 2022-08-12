<?php
session_start();
function generate($para,$res){
    if($para == 1){
      cart('index.php');
    }
    else cart('');
    while ($row_data = mysqli_fetch_assoc($res)) {
    $pId = $row_data['product_id'];
    $pName = $row_data['product_name'];
    $pPrice = $row_data['product_price'];
    $pImage = $row_data['product_img'];
    $pDes = $row_data['product_description'];
    if($para== 1)
    echo "<div class='col my-2 p-4'>";
            
      echo    "<div class='card'>
            <img
              src='./pImages/$pImage'
              class='card-img-top'
              alt='product-image'
            />
            <div class='card-body d-flex justify-content-center flex-column'>
            <div class=''>
              <h5 class='card-title'>$pName</h5>
              <p class='card-text'>
                  $pDes
              </p>
              <div class=''>Price: $pPrice</div>
              </div>
              <div class=' d-flex justify-content-center'> 
              <a href='index.php?add_to_cart=$pId' class='btn btn-primary p-2 w-50 mr5' >Add to cart</a>";
              if($para== 1)
             echo "<a href='product_details.php?product_id=$pId' class='btn btn-info p-2  w-50 ml5' >View more</a>";
            echo "</div></div></div>";
        if($para== 1)
        echo "</div>";
  } 
}

function get_product()
{
  global $con;
  $query = "select * from `products` ";
  $res = mysqli_query($con, $query);
  generate(1,$res);
}
function search_product()
{
  global $con;
  $search_data = $_GET['search_data'];
  $query = "select * from `products` where product_name like '%$search_data%'";
  $res = mysqli_query($con, $query);
  generate(1,$res);
  $count = mysqli_num_rows($res);
  if ($count == 0) {
    echo "<h2  class='nodata_message'>No product meets requirements </h2>";
  }
}

function view_product()
{
  global $con;

    $product_id = $_GET['product_id'];
    $query = "select * from `products` where product_id=$product_id";
    $res = mysqli_query($con, $query);
    generate(2,$res);
}

function filter()
{
  global $con;
  $min = $_GET['min'];
  $max = $_GET['max'];
  $query = "select * from `products` where product_price >= $min and product_price <= $max ";
  $res = mysqli_query($con, $query);
  generate(1,$res);
  $count = mysqli_num_rows($res);
  if ($count == 0) {
    echo "<h2  class='nodata_message'>No product meets requirements </h2>";
  }
}
function cart($link)
{
  if (isset($_GET['add_to_cart'])) {
    $pId = $_GET['add_to_cart'];

    echo "<script>
    if (localStorage.getItem('cart') === null){
      let cart = {'$pId' : 1}
      localStorage.setItem('cart',JSON.stringify(cart))
    }
    else{
    let str = localStorage.getItem('cart')
    let cart = JSON.parse(str)
    if('$pId' in cart){
      let i = parseInt(cart['$pId']) +1 
      cart[$pId] = i
    }
    else{
        cart['$pId'] = 1
    }
    let count = 0

    for(let key in cart){
      count += cart[key]
      }
    localStorage.setItem('cart',JSON.stringify(cart))
    document.getElementById('total_cart').innerHTML = count;
    console.log('$link')
    if('$link' == 'index.php'){
      window.open('index.php','_self')
    }
    else window.open('product_details.php?product_id=$pId','_self')
  }
    </script>";
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
          <img src='../../pImages/$pImage' alt='cart-image' class=card-image-top>
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

function logout()
{
  if (isset($_GET['logout'])) {
    $_SESSION['loggedin'] = false;
    $_SESSION['username'] = '';
    $_SESSION['role'] = '';
    $_SESSION['id'] = '';
    echo "<script> alert('Logging out...');
    window.open('index.php','_self');</script>";
  }
}

function cant_access()
{
  if(isset($_SESSION['loggedin'])){
  if ($_SESSION['loggedin'] == true) {
    if ($_SESSION['role'] == 'customer') {
      echo "<script> alert('You are already logged in!');
      window.open('../index.php','_self');</script>";
    } else if ($_SESSION['role'] == 'vendor') {
      echo "<script> alert('You are already logged in!');
      window.open('../users/vendors/vendors.php','_self');</script>";
    } elseif ($_SESSION['role'] == 'shipper') {
      echo "<script> alert('You are already logged in!');
      window.open('../users/shippers/shippers.php','_self');</script>";
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
    echo "./vendors/vendors.php";
  } else  if ($val == 'shipper') {
    echo "./shippers/shippers.php";
  } 
}
function redrmyAc(){
  if(isset($_SESSION['role'])){
    $val = $_SESSION['role'];
    if($val== '')  echo "<script>alert('You are not having permission to access this URL');window.open('../index.php','_self');</script> ";
  }
}
function redr($role)
{
  if(!isset($_SESSION['role'])){
    if($role != 'customer'){
      echo "<script>alert('You are not having permission to access this URL');window.open('../../index.php','_self');</script> ";
    }
  }
  else{
    $val = $_SESSION['role'];
  // echo "<script>alert('$val');</script>";
  if($role=='customer'){
    if(!isset($_GET['logout']))
    if($val!='' and $val!='customer'){
      echo "<script>alert('You are not having permission to access this URL');window.open('./index.php','_self');</script> ";
    }
  }
  else
  if ($val!=$role)
  {
    echo "<script>alert('You are not having permission to access this URL');window.open('../../index.php','_self');</script> ";
  }
}
}

