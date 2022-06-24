<?php 
$title = "Contact";
require_once './template/header.php';
require_once 'includes/uploader.php';
require './classes/Service.php';
$Service = new Service();
$Service->taxRate = 0.05;

$services = $mysqli->query("select id,name,price from services")->fetch_all(MYSQLI_ASSOC);
?>
<div class="container">
    <!-- <a href="<?php //echo $uploadDir?>/iphone.png">download</a> -->
    <?php 
    isset($_SESSION['contact_form']['visitor_name'])? $sender = $_SESSION['contact_form']['visitor_name']:$sender = "";
    
    ?>
    <div class="row col-md-6 mx-auto">

   
    <h1>Contact</h1>
    <form action=<?php echo $_SERVER['PHP_SELF'] ?> method="post" enctype="multipart/form-data">
    <div class="form-group mb-3">
        <label for="name"> name</label>
        <input type="text" value="<?php if(isset($_SESSION['contact_form']['visitor_name'])) echo $_SESSION['contact_form']['visitor_name'] ?>" placeholder="Enter your name" name="name" id="name" class="form-control">
        <span class="text-danger"><?php echo $nameError ?></span>
    </div>

    <div class="form-group mb-3">
        <label for="email"> email</label>
        <input type="email" value="<?php if(isset($_SESSION['contact_form']['visitor_email'])) echo $_SESSION['contact_form']['visitor_email'] ?>" placeholder="Enter your email" name="email" id="email" class="form-control">
        <span class="text-danger"><?php echo $emailError ?></span>
    </div>

    <div class="form-group mb-3">
        <label for="document"> Document</label>
        <input type="file"  name="document" id="document" >
        <span class="text-danger"><?php echo $documentError ?></span>
    </div>

    <div class="form-group mb-3">
        <label for="service"> Services</label>
        <select  name="service_id" id="service" class="form-control" > 
        <?php foreach($services as $service){ ?>
            <option value="<?php echo $service['id'] ?>">  
            <?php echo $service['name'] ?>
                <?php echo $Service->totalPrice($service['price']) . " SAR" ?>
            
           </option>
            <?php } ?>

        </select>
     
    </div>

    <div class="form-group mb-3">
        <label for="email"> message</label>
        <textarea type="text" name="message" id="message" class="form-control"><?php if(isset($_SESSION['contact_form']['visitor_message'])) echo $_SESSION['contact_form']['visitor_message']?></textarea>
        <span class="text-danger"><?php echo $msgError ?></span>
    </div>
    <button class="btn btn-primary mb-4">Send</button>
    </form>
    </div>
</div>
<?php
require_once './template/footer.php';
?>