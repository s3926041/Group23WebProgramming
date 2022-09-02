<?php
session_start();

function generate($para,$sec,$id,$min,$max)
{
  $productData = (array) json_decode(file_get_contents('../products.txt'),true);
  $count = 0;
  foreach($productData as $key => $value){
    if(gettype($value) == 'array'){
      if($id == ''){
        if(str_contains(strtolower($key),strtolower($sec)) and $value['price'] >$min and $value['price'] < $max){
          $pId = $value['id'];
          $pName = $value['name'];
          $pPrice = $value['price'];
          $pImage = $value['image'];
          $pDes = $value['des'];
          $w50 = 'w-50';
          $wh300 = '';
          $c = 'd-flex justify-content-center align-content-center flex-column';
          $container = "";
          $imgClass = "card-img-top";
          if ($para == 2) {
            $container = 'product_details_container';
            $imgClass = 'product_details_img';
            $w50 = '';
            $wh300 = 'w300';
          }
          if ($para == 1)
            echo "<div class='col my-2 p-4'>";
          echo    "<div class='card $container'>
                <div class='d-flex justify-content-center border-bottom'>
                  <img
                    src='./pImages/$pImage'
                    class='$imgClass'
                    alt='product-image'
                  />
                  </div>
                  <div class='card-body $c $wh300'>
                  <div class='mb-3'>
                    <h5 class='card-title mb-3'>$pName</h5><div class='card-text mb-3 fw-normal'>Price: <span class='price mx-1'>$pPrice</span></div>";
          if ($para == 2) echo "<p class='card-text mb-1'>Description: $pDes</p>";
          echo "   </div><div class=' d-flex justify-content-center'> ";
          echo "<a id='$pId' class='btn btn-primary p-2 $w50 mr5' onclick='addcart($pId)' >Add to cart</a>";
          if ($para == 1)
            echo "<a href='product_details.php?product_id=$pId' class='btn btn-info p-2  w-50 ml5' >View more</a>";
          echo "</div></div></div>";
          if ($para == 1)
            echo "</div>";
          $count += 1;
        }
      }
      else{
        if($value['id'] == $id){
          if(str_contains(strtolower($key),strtolower($sec)) and $value['price'] >$min and $value['price'] < $max){
            $pId = $value['id'];
            $pName = $value['name'];
            $pPrice = $value['price'];
            $pImage = $value['image'];
            $pDes = $value['des'];
            $w50 = 'w-50';
            $wh300 = '';
            $c = 'd-flex justify-content-center align-content-center flex-column';
            $container = "";
            $imgClass = "card-img-top";
            if ($para == 2) {
              $container = 'product_details_container';
              $imgClass = 'product_details_img';
              $w50 = '';
              $wh300 = 'w300';
            }
            if ($para == 1)
              echo "<div class='col my-2 p-4'>";
            echo    "<div class='card $container'>
                  <div class='d-flex justify-content-center border-bottom'>
                    <img
                      src='./pImages/$pImage'
                      class='$imgClass'
                      alt='product-image'
                    />
                    </div>
                    <div class='card-body $c $wh300'>
                    <div class='mb-3'>
                      <h5 class='card-title mb-3'>$pName</h5><div class='card-text mb-3 fw-normal'>Price: <span class='price mx-1'>$pPrice</span></div>";
            if ($para == 2) echo "<p class='card-text mb-1'>Description: $pDes</p>";
            echo "   </div><div class=' d-flex justify-content-center'> ";
            echo "<a id='$pId' class='btn btn-primary p-2 $w50 mr5' onclick='addcart($pId)' >Add to cart</a>";
            if ($para == 1)
              echo "<a href='product_details.php?product_id=$pId' class='btn btn-info p-2  w-50 ml5' >View more</a>";
            echo "</div></div></div>";
            if ($para == 1)
              echo "</div>";
          }
        }
      }
    }
  }
  if($sec != '' or $min !=0 or $max !=100000000){
    if($count == 0 ){
      echo "<h2  class='nodata_message'>No product meets requirements </h2>";
    }
  }
}

function get_product()
{
  generate(1,'','',0,100000000);
}
function search_product()
{
  $search_data = $_GET['search_data'];
  generate(1, $search_data,'',0,100000000);

}

function view_product()
{
  $id = $_GET['product_id'];
  generate(2, '',$id,0,100000000);
}

function filter()
{
  $min = $_GET['min'];
  $max = $_GET['max'];
  generate(1, '','',$min,$max);

}
function name()
{
  $name = $_SESSION['username'];
  echo "$name";
}

function register($post){
  $val = $post .'_reg';
  if (isset($_POST[$val])) {
    $exist = false;
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $validate = validate($username, $password,$password2);
    if ($validate =='' ) {
      $hashp = password_hash($password, PASSWORD_DEFAULT);
      $name = $_POST['name'];
      $address = $_POST['address'];
      $image = $_FILES['image']['name'];
      $tmp_image = $_FILES['image']['tmp_name'];
      $userdata =  (array) json_decode(file_get_contents('../../accounts.txt'),true);
      if ($userdata != null) {
        if (array_key_exists($username,  $userdata)) {
          $exist = true; 
          echo "<script> setToast('bg-danger','Username existed!');</script>";
        } 
        elseif($post == 'vendor'){
          foreach($userdata as $key => $value){
              if(gettype($value) == 'array')
              if($value['name'] == $name and $value["role"] == "vendor"){
                $exist = true;
                echo "<script> setToast('bg-danger','Vendor name existed!');</script>";
                break;
              }elseif($value['address'] == $address  and $value["role"] == "vendor"){
                $exist = true;
                echo "<script> setToast('bg-danger','Vendor address existed!');</script>";
                break;
              }
          }
        }
      } else{
        $userdata=array();
        $userdata['autoID'] = 0;
      }
     
      if(!$exist){
        move_uploaded_file($tmp_image, "../users/userImages/$image");
        $userdata[$username]['id'] = $userdata['autoID'];
        $userdata['autoID'] += 1;
        $userdata[$username]['password'] = $hashp;
        $userdata[$username]['name'] = $name;
        $userdata[$username]['address'] = $address;
        $userdata[$username]['image'] = $image;
        if(isset($_POST['hub']))
          $userdata[$username]['hub'] = $_POST['hub'];
        $userdata[$username]['role'] = $post;
        file_put_contents('../../accounts.txt',json_encode($userdata,JSON_PRETTY_PRINT));
        echo "<script> setToast('bg-success','Registered!') </script>";
      }
    } else echo "<script>setToast('bg-danger','$validate') </script>";
}
}

function vendor_product()
{
  $userId = $_SESSION['id'];
  $productData = (array) json_decode(file_get_contents('../../../products.txt'),true);
  foreach($productData as $key => $value){
    if(gettype($value) == 'array' and $value['vendor_id'] == $userId){
      $pId = $value['id'];
      $pName = $value['name'];
      $pPrice = $value['price'];
      $pImage = $value['image'];
      $pDes = $value['des'];
      echo "<tr>
      <th class='text-center' scope='row'>$pId</th>
      <td class='text-center h120'>$pName</td>
      <td class='text-center h120'>
          <img src='../../pImages/$pImage' alt='vendor_product' class='vendor_img'>
      </td>
      <td class='text-center h120'>$pPrice</td>
      <td class='text-center h120'>$pDes</td>
      </tr>";
    }

  }
     
  
}
function add_product()
{
  if (isset($_POST['add_product'])) {
    $pName = $_POST['pName'];
    $productData = (array) json_decode(file_get_contents('../../../products.txt'),true);
    if ($productData != null and array_key_exists($pName,$productData)) {
      echo "<script> setToast('bg-danger','Product name existed') </script>";
    } else {
      if($productData == null){
        $productData=array();
        $productData['autoID'] = 0;
      }
      $pImage = $_FILES['pImage']['name'];
      $tempImage =$_FILES['pImage']['tmp_name'];
      move_uploaded_file($tempImage, "../../pImages/$pImage");
      $productData[$pName]['id'] = $productData['autoID'];
      $productData['autoID'] += 1;
      $productData[$pName]['name'] = $_POST['pName'];
      $productData[$pName]['price'] = $_POST['pPrice'];
      $productData[$pName]['image'] = $_FILES['pImage']['name'];
      $productData[$pName]['des'] = $_POST['pDes'];
      $productData[$pName]['vendor_id'] = $_SESSION['id'];
      file_put_contents('../../../products.txt',json_encode($productData,JSON_PRETTY_PRINT));
       echo "<script> setToast('bg-success','Product added succesfully!')</script>";
     
    }
  }
}
function shipper_orders()
{
  $userId = $_SESSION['id'];
  $userdata =  (array) json_decode(file_get_contents('../../../accounts.txt'),true);
  $hub = 0;
  foreach($userdata as $key => $value){
    if(gettype($value) =='array')
    if(strval($value['id']) == $userId){
      $hub = $value['hub'];
      break;
    }
  }
  $orderdata = (array) json_decode(file_get_contents('../../../order.txt'),true);
   foreach($orderdata as $key => $value ){
    if(gettype($value) == 'array' and $value['status'] == 'active' and $value['hub_id'] == $hub){
      $oId = $key;
      $userId = $value['user_id'];
      $status = $value['status'];
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
    session_destroy();
    $_SESSION['loggedin'] = false;
    echo "<script> 
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
    if ($val == '')  echo "<script>window.open('../index.php','_self');</script> ";
  } else echo "<script>window.open('../index.php','_self');</script> ";
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
    if (!$check) echo "<script>window.history.go(-1);</script> ";
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