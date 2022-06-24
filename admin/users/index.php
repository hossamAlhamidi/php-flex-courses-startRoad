<?php 
$title = "users";
// include __DIR__."../";

include "../template/header.php";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $st = $mysqli->prepare("delete from users where id = ?");
    $st->bind_param("i",$userId);
    $userId = $_POST['user_id'];
    $st->execute();

    echo "<script>location.href='index.php'</script>";

}

?>

<?php 
$users = $mysqli->query("select * from users order by id")->fetch_all(MYSQLI_ASSOC);
?>
<div class="card">
    
  <div class="card-header">
    <a href="Create.php" class="btn btn-sm btn-success">Create user</a>
   <p>
       users:<?php  echo count($users)?> 
   </p> 
</div>
<div class="table-responsive">
    <table class="table table striped">
     <thead>
        <tr>
            <th>#</th>
            <th>Email</th>
            <th>Name</th>
            <th>Role</th>
            <th class="col-12 justify-content-center">Actions</th>
        </tr>
     </thead>
     <tbody>
        <?php foreach($users as $user): ?>
            <tr>
                <td><?php echo $user['id'] ?></td>
                <td><?php echo $user['email'] ?></td>
                <td><?php echo $user['name'] ?></td>
                <td><?php echo $user['role'] ?></td>
                <td class="col-12 justify-content-center">
                    <a href="edit.php?id=<?php echo $user['id'] ?>" class="btn btn-warning">Edit</a>
                   <form onsubmit="return confirm('are you sure')" method="post" style="display:inline-block;">
                    <input type="hidden" name="user_id" value="<?php echo $user['id'] ?>">
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