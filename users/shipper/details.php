<h3 class="mb-3 text-center">Order Details:</h3>
<?php 
  global $con;
  $oId = $_GET['order_id'];
  $query ="select * from `order_table` where order_id=$oId limit 1";
  $res = mysqli_query($con,$query);
  $row = mysqli_fetch_assoc($res);
  $hub = $row['hub_id'];
  $uId = $row['user_id'];
  $query ="select * from `customer_table` where user_id=$uId limit 1";
  $res = mysqli_query($con,$query);
  $row = mysqli_fetch_assoc($res);
  $name = $row['name'];
  $address = $row['address'];
  echo "
  <div class= 'd-flex flex-column'>
  <span class='my-1 fw-bold'>Order ID: <span class='fw-normal'>$oId</span></span> 
  <span class='my-1 fw-bold'>User ID: <span class='fw-normal'>$uId</span></span> 
  <span class='my-1 fw-bold'>Distribution hub ID: <span class='fw-normal'>$hub</span></span> 
  <span class='my-1 fw-bold'>Customer's name: <span class='fw-normal'>$name</span></span> 
  <span class='my-1 fw-bold'>Customer's address: <span class='fw-normal'>$address</span></span>
  </div>
  "
?>

<form action="" method='post'class="d-flex my-3">
  <div class="d-flex ">  <label for="status" class="">Status</label>
<select class="text-center mx-3" style="width:100px ;" name="status" id="status">
  <option value="active">active</option>
  <option value="delivered">delivered</option>
  <option value="canceled">canceled</option>
</select></div>
<input type="submit" value="Update"  style="width:100px ;" class="form-control  mx-3">
</form>
<?php 
if(isset($_POST['status'])){
  $s = $_POST['status'];
  $query ="update `order_table` set status ='$s' where order_id=$oId";
  $res = mysqli_query($con,$query);
  if($s != 'active'){
    echo "<script> window.open('./shipper.php') </script>";
  }

}
?>
<table class="table text-center">
  <thead>
    <tr>
      <th >Product ID</th>
      <th >Name</th>
      <th >Image</th>
      <th >Price</th>
      <th >Quantity</th>
    </tr>
  </thead>
  <tbody>
<?php
  $query ="select * from `order_details` where order_id=$oId";
  $res = mysqli_query($con,$query);
  while($row = mysqli_fetch_assoc($res)){
    $pid = $row['product_id'];
    $quantity = $row['quantity'];
    $query = "select * from `products` where product_id=$pid limit 1" ;
    $r = mysqli_fetch_assoc(mysqli_query($con,$query));
    $pname = $r['product_name'];
    $price = $r['product_price'];
    $img = $r['product_img'];
    echo "<tr>
      <th class='text-center' scope='row'>$pid</th>
      <td class='text-center h120'>$pname</td>
      <td class='text-center h120'>
          <img src='../../pImages/$img' alt='cart-image' class='vendor_img'>
      </td>
      <td class='text-center h120'>$price</td>
      <td class='text-center h120'>$quantity</td>
      </tr>";
  }
?>

  </tbody>
</table>

<span></span>