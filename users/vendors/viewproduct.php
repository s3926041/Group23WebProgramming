<?php
include('../../includes/connect.php');
?>
<h3 class="mb-3">View Products</h3>
<table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Name</th>
      <th scope="col">Price</th>
      <th scope="col">Description</th>
    </tr>
  </thead>
  <tbody>
  <?php
          $select_products = "select * from `products`";
          $result_products = mysqli_query($con,$select_products);
          while($row_data = mysqli_fetch_assoc($result_products)){
            $pId = $row_data['product_id'];
            $pName = $row_data['product_name'];
            $pPrice = $row_data['product_price'];
            $pImage = $row_data['product_img'];
            $pDes = $row_data['product_description'];
            echo "<tr>
            <th scope='row'>$pId</th>
            <td>$pName</td>
            <td>$pPrice</td>
            <td>$pDes</td>
          </tr>";
          }
          ?>
  </tbody>
</table>