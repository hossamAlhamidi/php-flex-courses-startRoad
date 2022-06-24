<?php 
require_once __DIR__."/../config/database.php";
 $uploadDir = "uploads";

function filterString($input){
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    if(empty($input)){
        return false;
    }
    else
    return $input;
}

function filterEmail($input){
   $input = filter_var(trim($input),FILTER_SANITIZE_EMAIL);

   if(filter_var($input,FILTER_VALIDATE_EMAIL)){
       return $input;
   }
   else {
       return false;
   }
}

function canUpload($file){
    $allowed = [
        "jpg"=>"image/jpg",
        "png"=> "image/png",
        "gif"=> "image/gif"

    ];
    // $fileType = $_FILES['document']['type'];
    $fileMimeType = mime_content_type($file['tmp_name']);
    $fileMaxSize = 500 * 1024;
    $fileSize = $file['size'];
 
    if(!in_array($fileMimeType,$allowed)){
       return "file type is not supported";
    }
    if($fileSize > $fileMaxSize){
        return "file size is big";
    }

    return true;
}
$name = $email = $msg = "";
$nameError = $emailError = $documentError = $msgError = "";

if($_SERVER['REQUEST_METHOD'] == "POST"){

     $name = filterString($_POST['name']);
     $email = filterEmail($_POST['email']);
     $msg = filterString($_POST['message']);
     if(!$name){
         $nameError = "Your name is required";
     }
     else{
         $_SESSION['contact_form']["visitor_name"] = $name;
     }

     if(!$email){
         $emailError="Your email is invalid";
     }  
     else{
        $_SESSION['contact_form']["visitor_email"] = $email;
    }

     if(!$msg){
        $msgError = "Please enter your message";
    }
    else{
        $_SESSION['contact_form']["visitor_message"] = $msg;
    }


    // echo "<pre>";
    //   print_r($_POST);
    //   print_r($_FILES);
    // echo"</pre>";
    if(isset($_FILES['document'])&& $_FILES['document']['error']==0){

        if(canUpload($_FILES['document'])===true){
           
            if(!is_dir($uploadDir)){
            umask(0);
            mkdir($uploadDir,0775);
            }

            $fileName = time().$_FILES['document']['name'];

            if(file_exists($uploadDir.'/'.$fileName)){
                $documentError="file already exists";
            }
            else
            move_uploaded_file($_FILES['document']["tmp_name"],$uploadDir.'/'.$fileName);
            // define ('SITE_ROOT', realpath(dirname(__FILE__)));
        }
        else{
            $documentError = canUpload($_FILES['document']);
        }
    
    }

    if(!$nameError && !$emailError && !$documentError && !$msgError){
        if(isset($fileName)){
            $filePath = "$uploadDir/$fileName";
        }
        else{
            $filePath = "";
        }
        
        $service_id = $_POST['service_id'];
        // $insert_form = "Insert INTO messages(contact_name,email,document,message,service_id) VALUES('$name','$email',
        // '$filePath','$msg','$service_id')";
        // $mysqli->query($insert_form);
        $statement = $mysqli->prepare("Insert Into messages(contact_name,email,document,message,service_id) 
        VALUES(?,?,?,?,?)");
        $statement->bind_param("ssssi",$dbContactName,$dbEmail,$dbDocument,$dbMessage,$dbServiceId);
        $dbContactName = $name;
        $dbEmail = $email;
        $dbDocument = $filePath;
        $dbMessage = $msg;
        $dbServiceId = $service_id;

        $statement->execute();
        // mail($config['admin_email'],"hossam","message");
        unset($_SESSION['contact_form']);
        echo "clear";
    }
}
?>
