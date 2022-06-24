<?php 
class Service {

    public $available;
    public $taxRate;


    function __construct()
    {
        $this->available = true;
        $this->taxRate = 0;
    }

    function __destruct()
    {
        
    }

    public function all(){
        return [
            ["name"=>"consultant","price"=>100,"days"=>["mon","sun"]],
            ["name"=>"training","price"=>200,"days"=>["mon","sun","thu"]],
            ["name"=>"design","price"=>150,"days"=>["sun"]]

        ];
    }

    public function totalPrice($price){
        if($this->taxRate >0){
            return $price + ($price * $this->taxRate);
        }

        return $price;
    }
}
?>