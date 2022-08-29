<h3 class="mb-3 text-center">Active Orders:</h3>
<table class="table">
  <thead>
    <tr>
      <th >Order ID</th>
      <th >User ID</th>
      <th >Hub ID</th>
      <th >Status</th>

      <th class="w200" ></th>
    </tr>
  </thead>
  <tbody>
  <?php
    shipper_orders();
  ?>
  </tbody>
</table>