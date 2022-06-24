<?php
$title = "Home page";
require_once './template/header.php';
require "./classes/Service.php";
require "./classes/Product.php";
require './config/database.php';

$service = new Service();
$productObj = new Product();
$productObj->taxRate = 0.1;



?>
<?php
if ($service->available) {

?>
    <div class="container">
        <h1>welcome to our website</h1>
        <div class="row">
       <?php 
       $products = $mysqli->query("select * from products")->fetch_all(MYSQLI_ASSOC);
       foreach($products as $product){   ?>
       <div class="col-md-4">
           <div class="card mb-3">
                <!-- <img class="card-image-top" src="<?php //echo $config["app_url"]. $product['image'] ?>"> -->
                <div class="custom-image-css" style="background-image:url('<?php echo $config["app_url"]. $product['image'] ?>')"></div>
               <div class="card-body text-center">
               <div class="card-title"><?php echo $product['name'] ?></div>
               <div> <?php echo $product['price'] ?>SAR</div>
               <div> <?php echo $product['description'] ?></div>
     
               </div>
           </div>
       </div>
    
    
 <?php }?>
 </div>
    </div>


<?php
$mysqli->close();
}

require_once './template/footer.php';
?>