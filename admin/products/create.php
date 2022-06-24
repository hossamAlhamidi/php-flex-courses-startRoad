<?php 
$title = "create product";
include __DIR__."/../template/header.php";
require_once __DIR__.'/../../classes/Upload.php';
$name="";
$price = "";
$description = "";
$errors = [];
if($_SERVER["REQUEST_METHOD"] == "POST"){
   
   
    print_r($_FILES["image"]);

    $name = mysqli_real_escape_string($mysqli,$_POST["name"]);
    $price = mysqli_real_escape_string($mysqli,$_POST["price"]);
    $description = mysqli_real_escape_string($mysqli,$_POST["description"]);
   
  
  
    if(empty($name)){array_push($errors,"name is required");}
    if(empty($price)){array_push($errors,"price is required");}
    if(empty($description)){array_push($errors,"description is required");}
    if(empty($_FILES['image']['name'])){array_push($errors,"image is required");}
 
    
    // if(count($errors)==0){
    //     $service_exist = $mysqli->query("select email from users where email = '$email' limit 1");

    //     if($service_exist->num_rows){
    //         array_push($errors,"service is already registered");
    //     }

    // }
    $date = Date("Ym");
    $upload = new Upload("uploads/products/".$date);
    $upload->file= $_FILES['image'];
    // $errors = $upload->upload();
    $upload->upload()? $errors = $upload->upload():null;

    if(count($errors)==0){
  
     $query = "INSERT INTO products(name,description,price,image) VALUES('$name','$description','$price','$upload->filePath')";
     $mysqli->query($query);
     if($mysqli->error){
        array_push($errors,$mysqli->error);
     }
     else{
        echo "<script>location.href='index.php'</script>";
     }
   
      
    }
  }
?>

<div class="card">
    <?php include __DIR__."/../template/errors.php" ?>
<form class="p-3" action="" method="post" enctype="multipart/form-data">
    
    <div class="form-group my-3">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name" value="<?php echo $name?>" >
    </div>

    <div class="form-group my-3">
        <label for="description">description</label>
        <textarea type="text" cols="30" rows="10" class="form-control" name="description" id="description"><?php echo $description ?></textarea>
    </div>


    <div class="form-group my-3">
        <label for="price">price</label>
        <input type="number" class="form-control" name="price" id="price" placeholder="Enter  price" value="<?php echo $price?>" >
    </div>

    <div class="form-group my-3">
        <label for="image">Image</label>
        <input type="file"  name="image">
    </div>

    <div class="form-group my-3">
        <button type="submit" class="btn btn-success">Create</button>
    </div>

 </form>
</div>

<?php include __DIR__."/../template/footer.php"?> 