<?php 
$title = "Edit Product";
include __DIR__."/../template/header.php";
require_once __DIR__.'/../../classes/Upload.php';

if(!isset($_GET['id']) || !$_GET['id'] ){
    die("id is missing");
}

$errors = [];

$query = $mysqli->prepare("select * from products where id = ? limit 1");
$query->bind_param("i",$productId);
$productId = $_GET['id'];
$query->execute();

$product = $query->get_Result()->fetch_assoc();
$name = $product['name'];
$description = $product['description'];
$price = $product['price'];
$image = $product['image'];


if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty($_POST['name'])){array_push($errors,"name is required");}
    if(empty($_POST['price'])){array_push($errors,"price is required");}
    if(empty($_POST['description'])){array_push($errors,"description is required");}

    if(isset($_FILES['image']['name']) && $_FILES['image']['error']==0){
       
        $upload = new Upload('uploads/products');
        $upload->file = $_FILES['image'];
        // $errors = $upload->upload();
        $upload->upload()? $errors = $upload->upload():null;

        if(!count($errors)){
            unlink($_SERVER["DOCUMENT_ROOT"].DIRECTORY_SEPARATOR."flexcorses".DIRECTORY_SEPARATOR ."start/".$image);
            $image = $upload->filePath;
        }

    }

    if(!count($errors)){

        $st = $mysqli->prepare("UPDATE products 
        set name = ? , description = ? , price = ?,image=?
        where id = ?");
        $st->bind_param("ssdsi",$dbName,$dbDescription,$dbPrice,$dbImage,$dbId);
        $dbName = $_POST['name'];
        $dbPrice = $_POST['price'];
        $dbDescription = $_POST['description'];
        $dbImage = $image;
      
        $dbId = $_GET['id'];

        $st->execute();
        
        if($st->error){
            array_push($errors,$st->error);
        }
        else {
            echo "<script>location.href = 'index.php'</script>";
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
        <img src="<?php echo $config['app_url'].'/'.$image ?>" width="150" />
        <input type="file"  name="image">
    </div>

    <div class="form-group my-3">
        <button type="submit" class="btn btn-success">Edit</button>
    </div>

 </form>
</div>
<?php include __DIR__."/../template/footer.php"?> 