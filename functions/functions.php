<?php
session_start();
function get_product()
{
  global $con;
  $select_products = "select * from `products` order by product_id LIMIT 12";
  $result_products = mysqli_query($con, $select_products);
  while ($row_data = mysqli_fetch_assoc($result_products)) {
    $pId = $row_data['product_id'];
    $pName = $row_data['product_name'];
    $pPrice = $row_data['product_price'];
    $pImage = $row_data['product_img'];
    $pDes = $row_data['product_description'];
    echo "<div class='col my-2 p-4'>
            <div class='card'>
              <img
                src='./pImages/$pImage'
                class='card-img-top'
                alt='product-image'
                style='height:200px;
                width: 100%;
               object-fit: contain;'
              />
              <div class='card-body d-flex justify-content-center' style='flex-direction: column'>
              <div class=''>
                <h5 class='card-title'>$pName</h5>
                <p class='card-text'>
                    $pDes
                </p>
                <div class=''>Price: $pPrice</div>
                </div>
                <div class=' d-flex justify-content-center'> 
                <a href='index.php?add_to_cart=$pId' class='btn btn-primary p-2 w-50'style='margin-right:5%' >Add to cart</a>
                <a href='product_details.php?product_id=$pId' class='btn btn-info p-2  w-50' style='margin-left:5%' >View more</a>
                </div>
              </div>
            </div>
          </div>";
  }
}
function search_product()
{
  global $con;
  if (isset($_GET['search_product'])) {
    $search_data = $_GET['search_data'];
  }
  $select_products = "select * from `products` where product_name like '%$search_data%'";
  $result_products = mysqli_query($con, $select_products);

  $count = 0;
  while ($row_data = mysqli_fetch_assoc($result_products)) {
    $count++;
    $pId = $row_data['product_id'];
    $pName = $row_data['product_name'];
    $pPrice = $row_data['product_price'];
    $pImage = $row_data['product_img'];
    $pDes = $row_data['product_description'];
    echo "<div class='col my-2 p-4'>
          <div class='card'>
            <img
              src='./pImages/$pImage'
              class='card-img-top'
              alt='product-image'
              style='height:200px;
              width: 100%;
             object-fit: contain;'
            />
            <div class='card-body d-flex justify-content-center' style='flex-direction: column'>
            <div class=''>
              <h5 class='card-title'>$pName</h5>
              <p class='card-text'>
                  $pDes
              </p>
              <div class=''>Price: $pPrice</div>
              </div>
              <div class=' d-flex justify-content-center'> 
              <a href='index.php?add_to_cart=$pId' class='btn btn-primary p-2 w-50'style='margin-right:5%' >Add to cart</a>
              <a href='product_details.php?product_id=$pId' class='btn btn-info p-2  w-50' style='margin-left:5%' >View more</a>
              </div>
            </div>
          </div>
        </div>";
  }
  if ($count == 0) {
    echo "<h1  style='margin:40px 0;color:crimson; width: 100%; text-align: center'>No product contain '$search_data' </h1>";
  }
}

function view_product()
{
  global $con;
  if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $query = "select * from `products` where product_id=$product_id";
    $result_products = mysqli_query($con, $query);
    $count = 0;
    while ($row_data = mysqli_fetch_assoc($result_products)) {
      $count++;
      $pId = $row_data['product_id'];
      $pName = $row_data['product_name'];
      $pPrice = $row_data['product_price'];
      $pImage = $row_data['product_img'];
      $pDes = $row_data['product_description'];
      echo "  <div class='card'style='width:200px'>
          <img src='./pImages/$pImage' class='card-img-top' alt='product-image' style='height:200px;
              width: 100%;
             object-fit: contain;' />
          <div class='card-body d-flex justify-content-center' style='flex-direction: column'>
              <div class=''>
                  <h5 class='card-title'>$pName</h5>
                  <p class='card-text'>
                      $pDes
                  </p>
                  <div class=''>Price: $pPrice</div>
              </div>
              <div class=' d-flex justify-content-center'> 
              <a href='product_details.php?add_cart=$pId' class='btn btn-primary p-2 w-50'style='margin-right:5%' >Add to cart</a>
              </div>

          </div>
      </div>";
    }
  }
}

function filter()
{
  global $con;
  $min = $_POST['min'];
  $max = $_POST['max'];
  $query = "select * from `products` where product_price >= $min and product_price <= $max ";
  $execute = mysqli_query($con, $query);
  $count = 0;
  while ($row_data = mysqli_fetch_assoc($execute)) {
    $count++;
    $pId = $row_data['product_id'];
    $pName = $row_data['product_name'];
    $pPrice = $row_data['product_price'];
    $pImage = $row_data['product_img'];
    $pDes = $row_data['product_description'];
    echo "<div class='col my-2 p-4'>
      <div class='card'>
        <img
          src='./pImages/$pImage'
          class='card-img-top'
          alt='product-image'
          style='height:200px;
          width: 100%;
         object-fit: contain;'
        />
        <div class='card-body d-flex justify-content-center' style='flex-direction: column'>
        <div class=''>
          <h5 class='card-title'>$pName</h5>
          <p class='card-text'>
              $pDes
          </p>
          <div class=''>Price: $pPrice</div>
          </div>
          <div class=' d-flex justify-content-center'> 
          <a href='index.php?add_to_cart=$pId' class='btn btn-primary p-2 w-50'style='margin-right:5%' >Add to cart</a>
          <a href='product_details.php?product_id=$pId' class='btn btn-info p-2  w-50' style='margin-left:5%' >View more</a>
          </div>
        </div>
      </div>
    </div>";
  }
  if ($count == 0) {
    echo "<h2  style='margin:40px 0;color:crimson; width: 100%; text-align: center'>No product meets requirements </h2>";
  }
}
function cart()
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
    localStorage.setItem('cart',JSON.stringify(cart))
  }
  window.open('index.php','_self')
    </script>";
  }
}
function cart_item()
{
    echo "<script>
let cart = JSON.parse(localStorage.getItem('cart'))
console.log(cart)
let count = 0
for(let key in cart){
  count+= cart[key]
  }</script>";
    $count = "<script> document.write(parseInt(count)) </script>";
    echo $count;
}
function cart2()
{
  if (isset($_GET['add_cart'])) {
    $pId = $_GET['add_cart'];
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
    localStorage.setItem('cart',JSON.stringify(cart))
  }
  window.open('product_details.php?product_id=$pId','_self')
    </script>";
  }
}
function cart_item2()
{
  echo "<script>
let cart = JSON.parse(localStorage.getItem('cart'))
console.log(cart)
let count = 0
for(let key in cart){
  count+= cart[key]
  }</script>";
    $count = "<script> document.write(parseInt(count)) </script>";
    echo $count;
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
      <td style='height:120px;'  class='text-center'>$pName</td>
      <td style='height:120px;'  class='text-center'>
          <img src='../../pImages/$pImage' alt='cart-image' style='width: 150px;height: 100%; object-fit:contain'>
      </td>
      <td style='height:120px;'  class='text-center'>$pPrice</td>
      <td style='height:120px;'  class='text-center'>$pDes</td>
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
  } else echo "";
}
function redr()
{
  $val = $_SESSION['role'];
  // echo "<script>alert('$val');</script>";
  if (!$_SESSION['role'] and $val != '')
    echo "<script>alert('You are not having permission to access this URL');window.open('../index.php','_self');</script> ";
}
