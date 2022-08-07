<?php
include('../../includes/connect.php');
if(isset($_POST['add_product'])){
    $pName = $_POST['pName'];
    if(mysqli_num_rows(mysqli_query($con,"select * from `products` where product_name ='$pName'"))>0){
        echo "<script> alert('Product name existed') </script>";
    }
    else{
    $pPrice = $_POST['pPrice'];
    $pImage = $_FILES['pImage']['name'];
    $tempImage = $_FILES['pImage']['tmp_name'];
    $pDes = $_POST['pDes'];
    move_uploaded_file($tempImage,"../../pImages/$pImage");
    $insert_query = "insert into `products` (product_name,product_price,product_img,product_description) values('$pName','$pPrice','$pImage','$pDes')";
    $result=mysqli_query($con,$insert_query);
    if($result){
        echo "<script> alert('Product added succesfully!') </script>";
    }
    else echo "<script> alert('Failed!') </script>";
    }
}
?>
<h3>Add Product</h3>
<form action="" method="post" enctype="multipart/form-data" class="mb-2 d-flex justify-content-center">
<div class="input-group mb-3 ">
  <input type="text" class="form-control" placeholder="Product name" name="pName" required>
</div>
<div class="input-group ">
  <input type="text" class="form-control" placeholder="Price" name="pPrice"required >
</div>
<div class="input-group p-1 ">
<label for="img">Image:</label>
</div>
<div class="input-group mb-3 ">
  
  <input type="file" class="form-control" name="pImage" id="img" required>
</div>
<div class="input-group mb-3 ">
  <input type="text" class="form-control" placeholder="Description" name="pDes" required>
</div>
<div class="input-group mb-3">
  <input type="submit" class="form-control" id="hover" value="Add" name="add_product" >
</div>
</form>