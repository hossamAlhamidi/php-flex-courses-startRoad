<?php 
session_start();
require_once __DIR__ . '/../config/app.php' ;
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang=<?php echo $config['lang'] ?>>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <title><?php echo $title?></title>

    <style>
        .custom-image-css{
            height: 200px;
            background-size: cover;
            background-position: center;
        }
        .CON{
	max-width: 1170px;
	margin:auto;
}
.R{
	display: flex;
	flex-wrap: wrap;
}
ul{
	list-style: none;
}
.footerS{
	background-color: #24262b;
    padding: 70px 0;
}
.footer-colS{
   width: 25%;
   padding: 0 15px;
   text-align: right;
}
.footer-colS h4{
	font-size: 18px;
	color: #ffffff;
	text-transform: capitalize;
	margin-bottom: 35px;
	font-weight: 500;
	position: relative;
}
.footer-colS h4::before{
	content: '';
	position: absolute;
	left:0;
	bottom: -10px;

	height: 2px;
	box-sizing: border-box;
	width: 50px;
}
.footer-colS ul li:not(:last-child){
	margin-bottom: 10px;
}
.footer-colS ul li a{
	font-size: 16px;
	text-transform: capitalize;
	color: #ffffff;
	text-decoration: none;
	font-weight: 300;
	color: #bbbbbb;
	display: block;
	transition: all 0.3s ease;
}
.footer-colS ul li a:hover{
	color: #ffffff;
	padding-right: 8px;
}
.footer-colS .social-links a{
	display: inline-block;
	height: 40px;
	width: 40px;
	background-color: rgba(255,255,255,0.2);
	margin:0 10px 10px 0;
	text-align: center;
	line-height: 40px;
	border-radius: 50%;
	color: #ffffff;
	transition: all 0.5s ease;
}
.footer-colS .social-links a:hover{
	color: #24262b;
	background-color: #ffffff;
}

/* #order-status{
  border: 2px solid #f3f3f3;
} */

/*responsive*/
@media(max-width: 767px){
  .footer-colS{
    width: 50%;
    margin-bottom: 30px;
}
}
@media(max-width: 574px){
  .footer-colS{
    width: 100%;
}
}

    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand text-light" href="<?php echo $config["app_url"]?>"><?php echo $config["app_name"] ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item text-light">
          <a class="nav-link active text-light" aria-current="page" href="<?php echo $config["app_url"]?>">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="<?php echo $config["app_url"]?>contact.php">Contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="<?php echo $config["app_url"]?>message.php">messages</a>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto">
        <?php if(!isset($_SESSION["logged_in"])): ?>
       <li class="nav-item">
        <a class="nav-link text-light" href="<?php echo $config["app_url"]?>login.php">Login</a>
      </li>
       <li class="nav-item">
        <a class="nav-link text-light" href="<?php echo $config["app_url"]?>Register.php">Register</a>
     </li>
     <?php else: ?>
      <li class="nav-item">
        <a class="nav-link text-light" href="#"><?php if(isset($_SESSION['user_name']))echo $_SESSION["user_name"] ?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-light" href="<?php echo $config["app_url"]?>logout.php">Logout</a>
      </li>
      <?php endif ?>
      </ul>

    </div>
  </div>
</nav>
<div class="container mt-4">
 <?php include "welcome_message.php" ?>
 </div>