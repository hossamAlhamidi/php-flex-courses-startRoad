<?php 
$title = "Edit Services";
include __DIR__."/../template/header.php";

if(!isset($_GET['id']) || !$_GET['id'] ){
    die("id is missing");
}

$errors = [];

$query = $mysqli->prepare("select * from services where id = ? limit 1");
$query->bind_param("i",$serviceId);
$serviceId = $_GET['id'];
$query->execute();

$service = $query->get_Result()->fetch_assoc();
$name = $service['name'];
$description = $service['description'];
$price = $service['price'];


if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty($_POST['name'])){array_push($errors,"name is required");}
    if(empty($_POST['price'])){array_push($errors,"price is required");}
    if(empty($_POST['description'])){array_push($errors,"description is required");}

    if(!count($errors)){

        $st = $mysqli->prepare("UPDATE services 
        set name = ? , description = ? , price = ?
        where id = ?");
        $st->bind_param("ssdi",$dbName,$dbDescription,$dbPrice,$dbId);
        $dbName = $_POST['name'];
        $dbPrice = $_POST['price'];
        $dbDescription = $_POST['description'];
      
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
    <form class="p-3" action="" method="post">
    
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
        <button class="btn btn-success">Edit</button>
    </div>

 </form>
</div>
<?php include __DIR__."/../template/footer.php"?> 