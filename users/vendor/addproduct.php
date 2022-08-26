<?php
add_product();
?>
<h3>Add Product</h3>
<form method="post" enctype="multipart/form-data" class="mb-2 d-flex justify-content-center" id='form'>
  <div class="input-group mb-3 ">
    <input type="text" class="form-control" placeholder="Product name" name="pName" required id='name' value='<?php if(isset($_POST['pName'])) $var = $_POST['pName'];else $var = ""; echo $var;  ?>'>
  </div>
  <div class="input-group ">
    <input type="text" class="form-control" placeholder="Price" name="pPrice" required id='price' value='<?php if(isset($_POST['pPrice'])) $var = $_POST['pPrice'];else $var = ""; echo $var;  ?>'>
  </div>
  <div class="input-group p-1 ">
    <label for="img">Image:</label>
  </div>
  <div class="input-group mb-3 ">
    <input type="file" class="form-control" name="pImage" id="img" required>
  </div>
  <div class="input-group mb-3 ">
    <textarea type="text" class="form-control" placeholder="Description" name="pDes" required id='des' value='<?php if(isset($_POST['pDes'])) $var = $_POST['pDes'];else $var = ""; echo $var;  ?>'> </textarea>
  </div>
  <div class="mb-3 text-center">
    <span id="error" ></span>
  </div>
  <div class="input-group mb-3">
    <input type="submit" class="form-control" id="hover" value="Add" name="add_product">
  </div>
</form>
<script src="./validate.js"></script>