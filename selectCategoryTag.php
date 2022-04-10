<div class="row">
    <div class="col-6">
        <!-- Search by category -->
        <select name="categoryList" style="width:300px;">
            <option value="0">--Select a Category--</option>
            <?php 
                $categoryId = 0;

                //Check that the correct form is posted
                if(isset($_POST['search'])){
                    //Check that categoryList is not empty
                    if(!empty($_POST['categoryList'])){
                        //set id from categoryList Value
                        $categoryId=$_POST['categoryList'];
                    }            
                }

                if(!empty($_GET['id'])){
                    //set id from categoryList Value
                    if (getBlogDetails($conn,$id)){
                        $row = getBlogDetails($conn,$id);
                        $categoryId=$row['category_id'];;
                    }else{
                        $row = getProjDetails($conn,$id);
                        $categoryId=$row['category_id'];;
                    }
                }

                $sql="Select * from categories";
                $result=$conn->query($sql);
                while($row=$result->fetch_assoc()){
                    //Check if id is the same as the current id variable
                    if($row['id']==$categoryId){
                        //set the selected attribute
                        $selected=" Selected = 'selected'";
                    }else{
                        $selected="";
                    }
                    echo "<option value='".$row['id']. "'".$selected.">".$row['category']."</option>";
                }
            ?>
        </select>
    </div>
    <div class="col-6">
        <!-- Search by tag -->
        <select name="tagList" style="width:300px;">
            <option value="0">--Select a Tag--</option>
            <?php
                $tagId = 0;
                //Check that the correct form is posted
                if(isset($_POST['search'])){
                    //Check that tagList is not empty
                    if(!empty($_POST['tagList'])){
                        //set id from tagList Value
                        $tagId=$_POST['tagList'];
                    }
                }

                if(!empty($_GET['id'])){
                    //set id from categoryList Value
                    if (getBlogDetails($conn,$id)){
                        $row = getBlogDetails($conn,$id);
                        $tagId=$row['tag_id'];;
                    }else{
                        $row = getProjDetails($conn,$id);
                        $tagId=$row['tag_id'];;
                    }
                }

                $sql="Select * from tags";
                $result=$conn->query($sql);
                while($row=$result->fetch_assoc()){
                    //Check if id is the same as the current id variable
                    if($row['id']==$tagId){
                        //set the selected attribute
                        $selected=" Selected = 'selected'";
                    }else{
                        $selected="";
                    }
                    echo "<option value='".$row['id']. "'".$selected.">".$row['tag']."</option>";
                }
            ?>
        </select>
    </div>
</div>




