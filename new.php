<?php
  echo "<script>
  cart = JSON.parse(localStorage.getItem('cart'))
  let count = Object.keys(cart).length
  </script>";
$string = "<script>document.write(Object.keys(cart)[0])</script> ";   
                        echo intval($string);
                        ?>