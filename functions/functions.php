<?php
include('./includes/connect.php');
function get_product(){
    global $con;
    $select_products = "select * from `products` order by rand() LIMIT 12";
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
                <a href='#' class='btn btn-primary p-2 w-50'style='margin-right:5%' >Add to cart</a>
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
              <a href='#' class='btn btn-primary p-2 w-50'style='margin-right:5%' >Add to cart</a>
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
  }
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

          </div>
      </div>";
        }
    
}
          
          
?>
