<?php 
$title = "Services";
// include __DIR__."../";

include "../template/header.php";



if($_SERVER["REQUEST_METHOD"]=="POST"){
    $st = $mysqli->prepare("delete from services where id = ?");
    $st->bind_param("i",$service_id);
    $service_id = $_POST['service_id'];
    $st->execute();

    echo "<script>location.href='index.php'</script>";

}

?>

<?php 
$services = $mysqli->query("select * from services order by id")->fetch_all(MYSQLI_ASSOC);
?>
<div class="card">
    
  <div class="card-header">
    <a href="Create.php" class="btn btn-sm btn-success">Create Service</a>
   <p>
       services:<?php  echo count($services)?> 
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
            <th class="col-12 justify-content-center">Actions</th>
        </tr>
     </thead>
     <tbody>
        <?php foreach($services as $service): ?>
            <tr>
                <td><?php echo $service['id'] ?></td>
                <td><?php echo $service['name'] ?></td>
                <td><?php echo $service['description'] ?></td>
                <td><?php echo $service['price'] ?></td>
                <td class="col-12 justify-content-center">
                    <a href="edit.php?id=<?php echo $service['id'] ?>" class="btn btn-warning">Edit</a>
                   <form onsubmit="return confirm('are you sure')" method="post" style="display:inline-block;">
                    <input type="hidden" name="service_id" value="<?php echo $service['id'] ?>">
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