<?php
$pageTitle="Edit Blog";
include "includes/session.php";
include "includes/dbFunctions.php";
include "includes/dbConnection.php";
include "includes/header.php";
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<?php 
    ob_start();
    
    if(isset($_SESSION['username'])){
        $id;
        
        if(isset($_GET['id'])){
            $id =$_GET['id'];
            $row = getBlogDetails($conn,$id);
        }
?>

<section id="ProjEdit" style="box-sizing:border-box; width: 100%; background-color:#cfe9fe";>
    <div style="padding:100px;">

        <div style="background:teal;color:white;width:fit-content; min-width:200px;text-align:center;font-size:30px;padding:5px">
            Edit Blog - <?php echo $row['title'];?>
        </div>
        
        <form action="" method="POST" enctype="multipart/form-data">
            <div style="border:solid teal 1px; background: white; padding:50px;">
    
                <div class="row">
                    <div class="col-2">
                        <label for="title">Title</label>
                    </div>
                    <div class="col-10">
                    <textarea name="title" rows="1" cols="100"><?php echo $row['title'];?></textarea><br>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-2">
                        <label for="teaser">Teaser</label>
                    </div>
                    <div class="col-10">
                        <textarea name="teaser" rows="3" cols="100"><?php echo $row['teaser'];?></textarea><br>
                    </div>
                </div>

                <div class="row">
                    <div class="col-2">
                        <label for="blog_text">Content</label>
                    </div>
                    <div class="col-10">
                        <textarea name="blog_text" rows="15" cols="100"><?php echo $row['blog_text'];?></textarea><br>
                    </div>
                </div>
                
                <hr/>
                <div class="row">
                    <div class="col-2">
                        <label for="categoryTag">Category/Tag</label>
                    </div>
                    <div class="col-10">
                        <div style="width:60%;">
                            <?php include "selectCategoryTag.php"; ?>     
                        </div>
                    </div>
                </div>

                <hr/>
                <div class="row">
                    <div class="col-2">
                        <label for="Image">Image</label>
                    </div>
                    <div class="col-10">
                        <div style="width:60%;">                            
                            <?php
                                $result=getBlogImages($conn,$id);
                                $countOfImages = $result->num_rows;
                                
                                if($countOfImages > 0){
                                    while ($row = $result->fetch_assoc()){
                                        
                                        $existingImageName = $row['image'];
                                        $existingImageId = $row['image_id'];
                                        
                                        if ($countOfImages >0){
                                            echo $existingImageName;

                                            if ($countOfImages > 1){?>
                                            <a href='imageDelete.php?id=<?php echo $id?>&imageId=<?php echo $existingImageId?>&type=blog' 
                                                onclick='return confirm("Are you sure you want to delete? This will permanently delete the image in the website")'>X</a>
                                            <?php
                                            }
                                            echo "<br>";
                                        }
                                    }
                                }
                            ?>
                            </br></br>
                            <?php include "image.php"?>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="id" value="<?php echo $id?>">

            </div>

            <div style="text-align:center;"><br/>
                <button type="submit" name="updateBlog">Update Blog</button>
            </div>            
        </form>        
    </div>
</section>

<?php
    if($_SERVER['REQUEST_METHOD']==="POST" && isset($_POST['updateBlog'])){
        try{

            include "uploadImage.php";
            
            if ($_POST['title'] && $_POST['teaser'] && $_POST['blog_text'] && 
            $_POST['categoryList'] && $_POST['tagList']){
                $id  = $_POST['id'];
                $title = $_POST['title'];
                $teaser= $_POST['teaser'];
                $blog_text = $_POST['blog_text'];
                $categoryId = $_POST['categoryList'];
                $tagId = $_POST['tagList'];
                
                if (isset($_POST['imageList'])){
                    foreach ($_POST['imageList'] as $imageId){
                        array_push($imageIds,$imageId);
                    }
                }

                $countOfImages += sizeOf($imageIds);
                if($countOfImages>=1){
                    $rowsAffected=updateBlogPost($conn,$title,$teaser,$blog_text,$categoryId,$tagId,$imageIds,$id);

                    if($rowsAffected > 0){
                        redirectTo('blogDetails.php?id='.$id.'&imageIndex=0&message=saved');
                    } 
                }else{
                    echo "At least 1 image per blog is required";
                }   
            }else{
                echo "Please enter required fields";
            }
        }catch(Exception $ex){
            echo "Whoops something broke: ",$ex->getMessage();
        }
    }
}else{
    redirectTo("login.php?message=failed");
}
?>

<?php include "includes/footer.php"; ?>


