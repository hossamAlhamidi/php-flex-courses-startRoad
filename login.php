<?php
$title = "Login form";
require_once './template/header.php';
require './config/database.php';
if(isset($_SESSION["logged_in"])){
    header("location:index.php");
}
$email = "";
$errors = [];
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = mysqli_real_escape_string($mysqli,$_POST["email"]);
    $password = mysqli_real_escape_string($mysqli,$_POST["password"]);
  
    if(empty($email)){array_push($errors,"Email is required");}
    if(empty($password)){array_push($errors,"password is required");}
      
    if(count($errors)==0){
        $userExist = $mysqli->query("select * from users where email = '$email' limit 1");

        if($userExist->num_rows==0){
            array_push($errors,"Email is not found");
        }
        else{
            $found_user = $userExist->fetch_assoc();
            if( password_verify($password,$found_user['password'])){
                    $_SESSION["logged_in"] = true;
                    $_SESSION["user_id"] = $found_user['id'];
                    $_SESSION['user_role'] = $found_user['role'];
                    $_SESSION["user_name"] = $found_user['name'];
                    $_SESSION["success_message"] = "$found_user[name],Welcome Back";
                    if($found_user['role']=="admin"){
                        header("location:admin/template");
                    }
                    else
                    header("location:index.php");
            }
            else{
                array_push($errors,"wrong password");
            }
        }

    }

    // if(count($errors)==0){
    // $password =  password_hash($password,PASSWORD_DEFAULT);
    //  $query = "INSERT INTO users(email,name,password) VALUES('$email','$name','$password')";
    //  $mysqli->query($query);

    //  $_SESSION["logged_in"] = true;
    //  $_SESSION["user_id"] = $mysqli->insert_id;
    //  $_SESSION["user_name"] = $name;
    //  $_SESSION["success_message"] = "$name,Welcome Back";
    //  header("location:index.php");
    // }
  }

?>

<div class="container pt-5">
<div class="row col-md-6 mx-auto">
 <h4 class="text-muted">Please fill in your information</h4>
 <hr>
 <?php include "./template/errors.php" ?>
 <form action="" method="post">
     <div class="form-group my-3">
         <label for="email">email</label>
         <input type="text" class="form-control" name="email" id="email" placeholder="Enter your email" value="<?php echo $email?>" >
     </div>



    <div class="form-group my-3">
        <label for="password">password</label>
        <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" >
    </div>


    <div class="form-group my-3">
        <button class="btn btn-success">Login</button>
        <a href="password_reset.php">Forgot your password?</a>
    </div>

 </form>
</div>
</div>

<?php 

?>