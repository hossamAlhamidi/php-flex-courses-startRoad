<?php
$title = "password reset";
require_once './template/header.php';
require './config/database.php';
if(isset($_SESSION["logged_in"])){
    header("location:index.php");
}

$errors = [];
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = mysqli_real_escape_string($mysqli,$_POST["email"]);
  
    if(empty($email)){array_push($errors,"Email is required");}
      
    if(count($errors)==0){
        $userExist = $mysqli->query("select * from users where email = '$email' limit 1");

        if($userExist->num_rows>0){
            $user_id = $userExist->fetch_assoc()['id'];

            $mysqli->query("DELETE FROM password_resets where user_id = $user_id");

            $token = bin2hex(random_bytes(16));
            $expires_at = date('Y-m-d H:i:s',strtotime('+1 day'));
            $mysqli->query("INSERT INTO password_resets(user_id,token,expires_at) VALUES('$user_id','$token','$expires_at')");
            $_SESSION['success_message'] = "please check your email";
            header("location:password_reset.php");
            die();
        }
        else {
            $_SESSION['success_message'] = "not found";
            header("location:password_reset.php");
            die();
        }
      

    }

  
  }

?>

<div class="container pt-5">

 <h4 class="text-muted">Please fill in your Email</h4>
 <hr>
 <?php include "./template/errors.php" ?>
 <form action="" method="post">
     <div class="form-group my-3">
         <label for="email">email</label>
         <input type="text" class="form-control" name="email" id="email" placeholder="Enter your email" >
     </div>


    <div class="form-group my-3">
        <button class="btn btn-primary">reset request</button>
    </div>

 </form>
</div>

<?php 

?>