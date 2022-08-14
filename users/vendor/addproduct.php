<?php
add_product();
?>
<h3>Add Product</h3>
<form action="" method="post" enctype="multipart/form-data" class="mb-2 d-flex justify-content-center">
  <div class="input-group mb-3 ">
    <input type="text" class="form-control" placeholder="Product name" name="pName" required>
  </div>
  <div class="input-group ">
    <input type="text" class="form-control" placeholder="Price" name="pPrice" required>
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
    <input type="submit" class="form-control" id="hover" value="Add" name="add_product">
  </div>
</form>
