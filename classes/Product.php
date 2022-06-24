<?php 
 class Product extends Service {


    public static function allProduct(){
        return [
            ["name"=>"phone","price"=>500],
            ["name"=>"mouse","price"=>30],
            ["name"=>"keyboard","price"=>100],
        ];
    }
 }

?>