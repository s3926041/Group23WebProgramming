
<script>
  let products = {};
  let temp = 0
  let pname
  let pPrice
  let pImage
  let vendorname
</script>
   <?php 
      global $tempPrice;
      $tempPrice = 0;
   include('includes/connect.php');
   global $con;
  $query = "select * from `products`";
  $res = mysqli_query($con,$query);
   while ($r_data = mysqli_fetch_assoc($res)) {
    $pId =  $r_data['product_id'];
    $pName = $r_data['product_name'];
    $pPrice = $r_data['product_price'];
    $pImage = $r_data['product_img'];
    $vendor = $r_data['vendor'];
    $query = "select * from `vendor_table` where user_id= $vendor";
    $venquery = mysqli_query($con, $query);
    $r_data = mysqli_fetch_assoc($venquery);
    $vendorname = $r_data['bussiness_name'];
    echo "<script>
    pname = '$pName'
    pPrice = $pPrice
    pImage = '$pImage'
    vendorname = '$vendorname'
    temp += pPrice
    products[$pId] = {'pname': pname,'pPrice': pPrice,'pImage' : pImage, 'vendorname': vendorname}
    </script>". "";
   }
    ?>
    <script>
      localStorage.setItem('products',JSON.stringify(products))
      let cart = JSON.parse(localStorage.getItem('cart'))
      for(let key in cart){
          pname = products[key].pname
          pPrice = products[key].pPrice
          pImage = products[key].pImage
          vendorname = products[key].vendorname
          let html = `<tr> <th class='text-center' >${key}</th> <td style='height:120px;'  class='text-center'>${pname}</td> <td style='height:120px;'  class='text-center' id='img'> <img src='./pImages/${pImage}' alt='cart-image' style='width: 150px;height: 100%; object-fit:contain;'> </td> <td style='height:120px;'  class='text-center'>${pPrice}</td> <td style='height:120px;'  class='text-center'> <form method='post'> <div class='d-flex w-100 justify-content-center'> <input type='hidden' name='pId' value='${key}'> <input class='text-center rounded mx-2 form-control' style='width:80px' type='number' name='quantity' min='1' max='100' value='${cart[key]}' required> <input class='text-center rounded mx-2 form-control' type='submit' value='Update' name='update' style='width:80px'> </div> </form> </td> <td style='height:120px;' >${vendorname} </td> <td style='height:120px;'> <form method='post'> <div class='d-flex w-100 justify-content-center'> <input type='hidden' name='pId' value='${key}'> <input class='text-center rounded mx-2 form-control' type='submit' value='Remove' name='remove' style='width:80px'> </div> </form> </td> </tr>`
          const h2 = document.getElementById("append");
          h2.insertAdjacentHTML("afterend", html);
      }
    </script>
