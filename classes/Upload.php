<?php 
class Upload{
   protected $uploadDir = "";
   protected $defaultUploadDir = "uploads";
   public $file ;
   public $fileName;
   public $filePath;
   protected $rootDir;
   protected $errors = [];


    public function __construct($uploadDir , $rootDir = false)
    {
        if($rootDir){
            $this->rootDir = $rootDir;
        }
        else{
            $this->rootDir = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR ."flexcorses".DIRECTORY_SEPARATOR ."start";
        }

        $this->filePath = $uploadDir;
        $this->uploadDir = $this->rootDir. "/".$uploadDir;
    }
    
    protected function validate(){
        if(!$this->isMimeAllowed()){
            array_push($this->errors,"mime type is not allowed");
        }
        else if(!$this->isSizeAllowed()){
            array_push($this->errors,"size too big ,size limit is 10m");
        }
        return $this->errors;
    }

        protected function createUploadDir(){

            if(!is_dir($this->uploadDir)){
                umask(0);
                if(!mkdir($this->uploadDir,0775)){
                    array_push($this->errors,"could not made dir");
                    return false;
                }
                }

                return true;

        }


    public function upload(){
        $this->fileName = time().$this->fileName;
        $this->filePath .= "/".$this->fileName;

        if($this->validate()){
            return $this->errors;
        }

        if(! $this->createUploadDir()){
            return $this->errors;
        }

        if(! move_uploaded_file($this->file['tmp_name'],$this->uploadDir ."/".$this->fileName)){
            array_push($this->errors , "error uploading your file");
            return $this->errors;
        }


    }
    protected function isMimeAllowed(){

        $allowed = [
            "jpg"=>"image/jpg",
            "png"=> "image/png",
            "gif"=> "image/gif",
            "jpeg"=> "image/jpeg"
    
        ];
        $fileMimeType = mime_content_type($this->file['tmp_name']);
        if(!in_array($fileMimeType,$allowed)){
            return false;
        }
        return true;
    }

    protected function isSizeAllowed(){
        $fileMaxSize = 10 * 1024 * 1024;
        $fileSize = $this->file['size'];

        if($fileSize > $fileMaxSize){
            return false;
        }
        return true;
    }
}

?>