<?php 
$mysqli = new mysqli("localhost","root","","app");
if($mysqli->connect_error){
    die("db connection failed ". $mysqli->connect_error);
}


?>