<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   <?php 
   $welcome = "hello to my world";
  echo  strlen($welcome);
  echo str_word_count($welcome);
  echo str_replace('hello',"مرحبا", $welcome);
  echo strrev($welcome);

  $arr = ['ahmed','hossam','amal'];
  foreach($arr as $index=> $names){
      echo $index .' '.$names;

  }

  $name = 'khaled';
  function test(){
       global $name;
       echo $name;
  }

  test()
   ?> 
</body>
</html>