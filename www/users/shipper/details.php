<h3 class="mb-3 text-center">Order Details:</h3>
<?php 
  $oId = $_GET['order_id'];
  $orderdata = (array) json_decode(file_get_contents('../../../order.txt'),true);
  

  $hub = $orderdata[$oId]['hub_id'];
  $uId = $orderdata[$oId]['user_id'];

  $userdata = (array) json_decode(file_get_contents('../../../accounts.txt'),true);
  foreach($userdata as $key => $value){
    if(gettype($value) =='array')
    if(strval($value['id']) == $uId){
      $name = $value['name'];
      $address = $value['address'];
      break;
    }
  }
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

<form method='post' class="d-flex my-3">
  <div class="d-flex ">  <label for="status" class="">Status</label>
<select class="text-center mx-3 w100"  name="status" id="status">
  <option value="active">active</option>
  <option value="delivered">delivered</option>
  <option value="canceled">canceled</option>
</select></div>
<input type="submit" value="Update" class="form-control mx-3 w100">
</form>
<?php 
if(isset($_POST['status'])){
  $s = $_POST['status'];
  if($s != 'active'){
    $orderdata[$oId]['status'] = $s;
    file_put_contents('../../../order.txt',json_encode($orderdata,JSON_PRETTY_PRINT));
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
  $productData = (array) json_decode(file_get_contents('../../../products.txt'), true);
  foreach($orderdata[$oId]['details'] as $key => $value){
 
    $pid = $value['p_id'];
    $quantity = $value['quantity'];
    foreach($productData as $key => $value){
      if(gettype($value) =='array')
      if(strval($value['id']) == $pid){
        $pname = $value['name'];
        $price = $value['price'];
        $img = $value['image'];
        break;
      }
    }
    echo "<tr>
    <th class='text-center' scope='row'>$pid</th>
    <td class='text-center h120'>$pname</td>
    <td class='text-center h120'>
        <img src='../../pImages/$img' alt='' class='vendor_img'>
    </td>
    <td class='text-center h120'>$price</td>
    <td class='text-center h120'>$quantity</td>
    </tr>";

  }
    
  
?>

  </tbody>
</table>

<span></span>