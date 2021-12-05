<?php
if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
//PHP判断ajax请求:HTTP_X_REQUESTED_WITH
echo "此請求來自AJAX";
}
else{
  include("includes/header.php");
  include("includes/footer.php");

  //echo "<script>openPage('$url')</script>"
  //exit();
}



 ?>
