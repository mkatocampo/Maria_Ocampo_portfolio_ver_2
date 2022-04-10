<?php  
    $imageIds = array();
    $images = array_filter($_FILES["uploadImage"]["name"]);
    
    if(!empty($images)){
        foreach($_FILES["uploadImage"]["name"] as $key=>$val){
            $image = $_FILES["uploadImage"]["name"][$key];
            $tempname = $_FILES["uploadImage"]["tmp_name"][$key];    
            $folder = "images/".$image;

            $imageId=addImage($conn,$image);
            array_push($imageIds, $imageId);
            //move file to images folder
            move_uploaded_file($tempname, $folder);
        }
    }
?>