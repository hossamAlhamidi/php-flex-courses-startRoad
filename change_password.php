<?php
$title = "change password";
require_once './template/header.php';
require './config/database.php';
if(isset($_SESSION["logged_in"])){
    header("location:index.php");
}

if(!isset($_GET['token']) || !$_GET['token']){
  die("token is missing");
}

$now = date("Y-m-d H:i:s");
$statement = $mysqli->prepare("select * from password_resets where token = ? and expires_at > '$now'");
$statement->bind_param("s",$token);
$token = $_GET['token'];
$statement->execute();
$result = $statement->get_result();

if($result->num_rows==0){
    die("not valid token");
} ;


$errors = [];
if($_SERVER["REQUEST_METHOD"] == "POST"){
  
    $password = mysqli_real_escape_string($mysqli,$_POST["password"]);
    $password_confirmation = mysqli_real_escape_string($mysqli,$_POST["password_confirmation"]);
    if(empty($password)){array_push($errors,"password is required");}
    if(empty($password_confirmation)){array_push($errors,"password_confirmation is required");}
    if($password != $password_confirmation){array_push($errors,"passwords dont match");}


      
    if(count($errors)==0){
      $user_id = $result->fetch_assoc()['user_id'];
    
      $hashed_password = password_hash($password,PASSWORD_DEFAULT);
      $mysqli->query("UPDATE users set password = '$hashed_password' where id = $user_id");

      $mysqli->query("DELETE from password_resets where user_id = $user_id");

      $_SESSION['success_message'] = "your password has been changed , please log in";
      header("location:login.php");
      die();
      

    }

  
  }

?>

<div class="container pt-5">

 <h4 class="text-muted">enter your new password</h4>
 <hr>
 <?php include "./template/errors.php" ?>
 <form action="" method="post">
     <div class="form-group my-3">
         <label for="password">password</label>
         <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" >
     </div>

     <div class="form-group my-3">
         <label for="password_confirmation">Confirm password</label>
         <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm your password" >
     </div>

    <div class="form-group my-3">
        <button class="btn btn-primary">reset</button>
    </div>

 </form>
</div>

<?php 

?>