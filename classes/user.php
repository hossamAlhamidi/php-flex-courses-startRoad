<?php 

class User {

    function isAdmin(){
        return isset($_SESSION['user_role']) && $_SESSION['user_role']=="admin";
    }


    function name(){
        if(isset($_SESSION['user_name'])){
            return $_SESSION['user_name'];
        }
       return 'guest';
    }
}
?>