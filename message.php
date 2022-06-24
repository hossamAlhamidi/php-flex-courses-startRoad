<?php 
$title = "message";
require_once './template/header.php';
require_once './config/database.php';

// $query = "select * ,m.id as message_id , s.id as service_id
// from messages m left join services s 
// on m.service_id = s.id";
// $messages = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);

$st = $mysqli->prepare("select * ,m.id as message_id , s.id as service_id
from messages m left join services s 
on m.service_id = s.id limit ?");
$st->bind_param("i",$limit);

isset($_GET["limit"])?$limit=$_GET["limit"]:$limit=5;
$st->execute();
$messages = $st->get_result()->fetch_all(MYSQLI_ASSOC);

?>
<div class="container my-5" style="min-height: 400px">

  <?php if(! isset($_GET['id'])) {?>
    <h2>received messages</h2>
<div class="table-respoinsive">
   <table class="table table-hover table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>name</th>
            <th>email</th>
            <th>service name</th>
            <th>document</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>

   <?php 
   foreach($messages as $message){
   ?>
  <tr>
      <td><?php echo $message['message_id'] ?></td>
      <td><?php echo $message['contact_name'] ?></td>
      <td><?php echo $message['email'] ?></td>
      <td><?php echo $message['name'] ?></td>
      <td><?php echo $message['document'] ?></td>
      <td>
          <a href="?id=<?php echo $message["message_id"] ?>"><button class="btn btn-sm btn-primary">View</button></a>
          <form onsubmit="return confirm('are you sure')" action="" method="post" style="display:inline-block">
          <input type="hidden" name="message_id" value="<?php echo $message['message_id'] ?>">
            <button  class="btn btn-sm btn-danger">Delete</button>
          </form>
    </td>
  </tr>

<?php }?>

   </tbody>

</table> 
</div>
<?php }
else {
  
    $message_query = "select * from messages m left join services s on m.service_id = s.id where m.id =".$_GET['id'];
  $message=  $mysqli->query($message_query)->fetch_array(MYSQLI_ASSOC);

    ?>
    <div class="card">
        <h5 class="card-header">
         Message from: <?php echo $message["contact_name"] ?>
         <div class="small"><?php echo $message["email"] ?></div>
        </h5>
        <div class="card-body">
         <div>Service: 
         <?php if($message['name']){
             echo $message['name'];
         }else{
             echo "no service";
         } ?>

         </div>   
        <?php echo $message["message"] ?>
        </div>
        <?php if($message['document']){ ?>
        <div class="card-footer">
         attachment: <a href="<?php echo $config['app_url'].$message['document']?>">download attachment</a>
        </div>
        <?php }?>
    </div>
 <?php    
}
?>
   </div>



<?php 

if(isset($_POST['message_id'])){
    // $query="delete from messages where id =".$_POST["message_id"];
    // $mysqli->query($query);
    $st = $mysqli->prepare("delete from messages where id = ?");
    $st->bind_param("i",$messageId);
    $messageId = $_POST["message_id"];
    $st->execute();

    echo "<script> location.href = 'message.php'</script>";
  
}
require_once './template/footer.php';
?>