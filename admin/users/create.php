<?php 
$title = "create";
include __DIR__."/../template/header.php";

$name="";
$email = "";
$role = "";
$errors = [];
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = mysqli_real_escape_string($mysqli,$_POST["email"]);
    $name = mysqli_real_escape_string($mysqli,$_POST["name"]);
    $password = mysqli_real_escape_string($mysqli,$_POST["password"]);
    $role = mysqli_real_escape_string($mysqli,$_POST["role"]);
   
  
    if(empty($email)){array_push($errors,"Email is required");}
    if(empty($name)){array_push($errors,"name is required");}
    if(empty($password)){array_push($errors,"password is required");}
    if(empty($role)){array_push($errors,"Role is required");}

    
    if(count($errors)==0){
        $userExist = $mysqli->query("select email from users where email = '$email' limit 1");

        if($userExist->num_rows){
            array_push($errors,"Email is already registered");
        }

    }

    if(count($errors)==0){
    $password =  password_hash($password,PASSWORD_DEFAULT);
     $query = "INSERT INTO users(email,name,password,role) VALUES('$email','$name','$password','$role')";
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