<?php
session_start();
function get_product(){
    global $con;
    $select_products = "select * from `products` order by product_id LIMIT 12";
          $result_products = mysqli_query($con,$select_products);
          while($row_data = mysqli_fetch_assoc($result_products)){
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
function search_product(){
  global $con;
  if(isset($_GET['search_product'])){
    $search_data = $_GET['search_data'];
  }
        $select_products = "select * from `products` where product_name like '%$search_data%'";
        $result_products = mysqli_query($con,$select_products);
       
        $count = 0;
        while($row_data = mysqli_fetch_assoc($result_products)){
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
        if($count == 0 ){
          echo "<h1  style='margin:40px 0;color:crimson; width: 100%; text-align: center'>No product contain '$search_data' </h1>";
        }
} 

function view_product(){
  global $con;
  if(isset($_GET['product_id'])){
    $product_id = $_GET['product_id'];
        $query = "select * from `products` where product_id=$product_id";
        $result_products = mysqli_query($con,$query);
        $count = 0;
        while($row_data = mysqli_fetch_assoc($result_products)){
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
function getIPAddress() {  
  //whether ip is from the share internet  
   if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
              $ip = $_SERVER['HTTP_CLIENT_IP'];  
      }  
  //whether ip is from the proxy  
  elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
              $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
   }  
//whether ip is from the remote address  
  else{  
           $ip = $_SERVER['REMOTE_ADDR'];  
   }  
   return $ip;  
}  
function cart(){
  if(isset($_GET['add_to_cart'])){
    global $con;
    $query = "CREATE TABLE if not exists `ecommerce`.`cart_details` (`product_id` INT(255) NOT NULL , `ip_address` VARCHAR(255) NOT NULL , `quantity` INT(100) NOT NULL , PRIMARY KEY (`product_id`)) ENGINE = InnoDB;";
    $result_query = mysqli_query($con,$query);

    $getIp =  getIPAddress();
    $pId = $_GET['add_to_cart'];
    $query = "select * from `cart_details` where ip_address='$getIp' and product_id =$pId";
    $result_query = mysqli_query($con,$query);
    $count = mysqli_num_rows($result_query);
    if($count > 0  ){
      $row_data = mysqli_fetch_assoc($result_query);
      $newquantity = $row_data['quantity']+1;
      $query = "update `cart_details` set quantity=$newquantity where ip_address='$getIp' and product_id =$pId";
      $result_query = mysqli_query($con,$query);
      echo "<script>
      window.open('index.php','_self');</script>";
    }
    else{
      $query = "insert into `cart_details` (product_id,ip_address,quantity) values('$pId','$getIp',1)";
      $result_query = mysqli_query($con,$query);
      echo "<script>
      window.open('index.php','_self');</script>";
    }
  }
}
function cart_item(){
  if(isset($_GET['add_to_cart'])){
    global $con;
    $getIp =  getIPAddress();
    $query = "select * from `cart_details` where ip_address='$getIp'";
    $result_query = mysqli_query($con,$query);
    $count = 0;
    while($row_data = mysqli_fetch_assoc($result_query)){
      $count += $row_data['quantity'];
    }
    echo $count;
  }
  else{
    global $con;
    $getIp =  getIPAddress();
    $query = "select * from `cart_details` where ip_address='$getIp'";
    $result_query = mysqli_query($con,$query);
    $count = 0;
    while($row_data = mysqli_fetch_assoc($result_query)){
      $count += $row_data['quantity'];
    }
    echo $count;
  }
}
function cart2(){
  if(isset($_GET['add_cart'])){
    global $con;
    $query = "CREATE TABLE if not exists `ecommerce`.`cart_details` (`product_id` INT(255) NOT NULL , `ip_address` VARCHAR(255) NOT NULL , `quantity` INT(100) NOT NULL , PRIMARY KEY (`product_id`)) ENGINE = InnoDB;";
    $result_query = mysqli_query($con,$query);

    $getIp =  getIPAddress();
    $pId = $_GET['add_cart'];
    $query = "select * from `cart_details` where ip_address='$getIp' and product_id =$pId";
    $result_query = mysqli_query($con,$query);
    $count = mysqli_num_rows($result_query);
    if($count > 0  ){
      $row_data = mysqli_fetch_assoc($result_query);
      $newquantity = $row_data['quantity']+1;
      $query = "update `cart_details` set quantity=$newquantity where ip_address='$getIp' and product_id =$pId";
      $result_query = mysqli_query($con,$query);
      echo "<script>
      window.open('product_details.php?product_id=$pId','_self');</script>";
    }
    else{
      $query = "insert into `cart_details` (product_id,ip_address,quantity) values('$pId','$getIp',1)";
      $result_query = mysqli_query($con,$query);
      echo "<script>
      window.open('product_details.php?product_id=$pId','_self');</script>";
    }
  }
}
function cart_item2(){
  if(isset($_GET['add_cart'])){
    global $con;
    $getIp =  getIPAddress();
    $query = "select * from `cart_details` where ip_address='$getIp'";
    $result_query = mysqli_query($con,$query);
    $count = 0;
    while($row_data = mysqli_fetch_assoc($result_query)){
      $count += $row_data['quantity'];
    }
    echo $count;
  }
  else{
    global $con;
    $getIp =  getIPAddress();
    $query = "select * from `cart_details` where ip_address='$getIp'";
    $result_query = mysqli_query($con,$query);
    $count = 0;
    while($row_data = mysqli_fetch_assoc($result_query)){
      $count += $row_data['quantity'];
    }
    echo $count;
  }
}
function name(){
  $name = $_SESSION['username'];
  echo "$name";
}
function vendor_product(){
  global $con;
  $userId = $_SESSION['id'];
  $select_products = "select * from `products` where vendor='$userId'";
  $result_products = mysqli_query($con,$select_products);
  $count = mysqli_num_rows($result_products);
  if($count >0){
    while($row_data = mysqli_fetch_assoc($result_products)){
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
function add_product(){
  global $con;
  if (isset($_POST['add_product'])) {
    $pName = $_POST['pName'];
    echo "<script> $pName </script>";
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

function logout(){
  if(isset($_GET['logout'])){
    $_SESSION['loggedin'] = false;
    $_SESSION['username'] ='';
    $_SESSION['role'] = '';
    $_SESSION['id'] = '';
    echo "<script> alert('Logging out...');
    window.open('index.php','_self');</script>";
  }
}




function redr($role){
  $val = $_SESSION['role'];
  // echo "<script>alert('$val');</script>";
  if($val != $role){
      if($val=='customer'){
          echo "<script>alert('You are not having permission to access this URL');window.open('../index.php','_self');</script> ";
        }
        else if($val =='vendor'){
          echo "<script>alert('You are not having permission to access this URL');window.open('../users/vendors/vendors.php','_self');</script> ";
        }
        else  if($val =='shipper'){
          echo "<script>alert('You are not having permission to access this URL');window.open('../users/shippers/shippers.php','_self');</script> ";
        }
        else echo "<script> alert('You are not having permission to access this URL');
        window.open('../../index.php','_self');</script>";
  }
}