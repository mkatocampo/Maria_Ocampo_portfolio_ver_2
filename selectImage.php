<!-- Search by image -->
<select name="imageList[]" multiple
    style="width:300px; background-color:white;border:gray solid 1px;">
    
    <?php 
        //$imageId = 0;
        $imageIds = array();
        //Check that the correct form is posted
        if(isset($_POST['add'])){
            //Check that imageList is not empty
            if(!empty($_POST['imageList'])){
                //set id from imageList Value
                $imageIds=$_POST['imageList'];
            }            
        }

        if(!empty($_GET['id']) && !empty($_GET['type'])){
            //set id from imageList 
            $type=$_GET['type'];
            if($type=="blog"){
                $result=getBlogImages($conn,$id);
            }else if($type=="proj"){
                $result=getProjImages($conn,$id);
            }
            
            $countOfImages = $result->num_rows;                                
                if($countOfImages > 0){
                    while ($row = $result->fetch_assoc()){
                        $imageId = $row['id'];
                        array_push($imageIds,$imageId);
                    }
                }
        }           

        $sql="Select * from images";
        $result=$conn->query($sql);
        while($row=$result->fetch_assoc()){
            //Check if id is the same as the current id variable
            if(in_array($row['id'],$imageIds)){
                //set the selected attribute
                $selected=" Selected = 'selected'";
            }else{
                $selected="";
            }
            echo "<option value='".$row['id']. "'".$selected.">".$row['image']."</option>";
        }
    ?>
</select>