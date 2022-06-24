<?php 
$title = "edit";
include __DIR__."/../template/header.php";

if(!isset($_GET['id']) || !$_GET['id'] ){
    die("id is missing");
}
$errors = [];

$query = $mysqli->prepare("select * from users where id = ? limit 1");
$query->bind_param("i",$userId);
$userId = $_GET['id'];
$query->execute();

$user = $query->get_Result()->fetch_assoc();
$name = $user['name'];
$email = $user['email'];
$role = $user['role'];

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty($_POST['email'])){array_push($errors,"Email is required");}
    if(empty($_POST['name'])){array_push($errors,"name is required");}
    if(empty($_POST['role'])){array_push($errors,"Role is required");}

    if(!count($errors)){

        $st = $mysqli->prepare("UPDATE users 
        set name = ? , email = ? , password = ? , role = ? 
        where id = ?");
        $st->bind_param("ssssi",$dbName,$dbEmail,$dbPassword,$dbRole,$dbId);
        $dbName = $_POST['name'];
        $dbEmail = $_POST['email'];
        $dbRole = $_POST['role'];
        $_POST['password']? $dbPassword =  password_hash($_POST['password'],PASSWORD_DEFAULT) : $dbPassword = $user['password'];
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
         <label for="email">email</label>
         <input type="text" class="form-control" name="email" id="email" placeholder="Enter your email" value="<?php echo $email?>" >
     </div>

    <div class="form-group my-3">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name" value="<?php echo $name?>" >
    </div>


    <div class="form-group my-3">
        <label for="password">password</label>
        <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" >
    </div>

   <div class="form-group">
    <label for="role">Role</label>
    <select name="role" id="role" class="form-control">
        <option value="user" <?php if($role=="user") echo "selected"; ?> >User</option>
        <option value="admin"  <?php if($role=="admin") echo "selected"; ?>>Admin</option>
    </select>
   </div>

    <div class="form-group my-3">
        <button class="btn btn-success">Create</button>
    </div>

 </form>
</div>
<?php include __DIR__."/../template/footer.php"?> 