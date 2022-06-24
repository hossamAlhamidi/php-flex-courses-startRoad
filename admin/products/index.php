<?php 
$title = "products";
// include __DIR__."../";

include "../template/header.php";



if($_SERVER["REQUEST_METHOD"]=="POST"){
    $st = $mysqli->prepare("delete from products where id = ?");
    $st->bind_param("i",$productId);
    $productId = $_POST['product_id'];
    $st->execute();

    if($_POST['image']){
        unlink($_SERVER["DOCUMENT_ROOT"].DIRECTORY_SEPARATOR."flexcorses".DIRECTORY_SEPARATOR ."start/".$_POST['image']);
    }

    echo "<script>location.href='index.php'</script>";

}

?>

<?php 
$products = $mysqli->query("select * from products order by id")->fetch_all(MYSQLI_ASSOC);
?>
<div class="card">
    
  <div class="card-header">
    <a href="Create.php" class="btn btn-sm btn-success">Create product</a>
   <p>
   products:<?php  echo count($products)?> 
   </p> 
</div>
<div class="table-responsive">
    <table class="table table striped">
     <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Description</th>
            <th>price</th>
            <th>Image</th>
            <th class="col-12 justify-content-center">Actions</th>
        </tr>
     </thead>
     <tbody>
        <?php foreach($products as $product): ?>
            <tr>
                <td><?php echo $product['id'] ?></td>
                <td><?php echo $product['name'] ?></td>
                <td><?php echo $product['description'] ?></td>
                <td><?php echo $product['price'] ?></td>
                <td><img src="<?php echo $config['app_url'].$product['image'] ?>" width="50"></td>
                <td class="col-12 justify-content-center">
                    <a href="edit.php?id=<?php echo $product['id'] ?>" class="btn btn-warning">Edit</a>
                   <form onsubmit="return confirm('are you sure')" method="post" style="display:inline-block;">
                    <input type="hidden" name="product_id" value="<?php echo $product['id'] ?>">
                    <input type="hidden" name="image" value="<?php echo $product['image'] ?>">
                    <button type="submit" class="btn btn-danger">Delete</button>
                   </form>
            </td>
            </tr>

            <?php endforeach ?>
     </tbody>

    </table>
</div>
</div>

<?php include __DIR__."/../template/footer.php"?> 