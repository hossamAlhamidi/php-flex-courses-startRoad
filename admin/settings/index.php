<?php 
$title = "settings";
// include __DIR__."../";

include "../template/header.php"; 
 if($_SERVER['REQUEST_METHOD']=="POST"){
    $st = $mysqli->prepare("UPDATE settings
     set admin_email = ? , app_name = ? 
     where id = 1");
    $st->bind_param('ss',$dbAdminEmail , $dbAppName);
    $dbAdminEmail = $_POST['admin_email'];
    $dbAppName = $_POST['app_name'];

    $st->execute();
    echo "<script>location.href='index.php'</script>";
 }

?>

<div class="card p-3">
  <h3>Settings</h3>
  <form action="" method="post">

    <div class="form-group my-3">
        <label for="app_name">App Name</label>
        <input type="text" class="form-control" value="<?php echo $config['app_name'] ?>" name="app_name" id="app_name">
    </div>

    <div class="form-group my-3">
        <label for="admin_email">admin email</label>
        <input type="text" class="form-control" value="<?php echo $config['admin_email'] ?>" name="admin_email" id="admin_email">
    </div>

    <button class="btn btn-primary">Update Settings</button>

  </form>

</div>

<?php include __DIR__ .'/../template/footer.php' ?>