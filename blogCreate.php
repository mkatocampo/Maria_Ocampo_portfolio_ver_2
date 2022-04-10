<?php
$pageTitle="Add Blog";
include "includes/session.php";
include "includes/dbFunctions.php";
include "includes/dbConnection.php";
include "includes/header.php";
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<?php 
    ob_start();
    
    if(isset($_SESSION['username'])){
?>

<section id="ProjCreate" style="box-sizing:border-box; width: 100%; background-color:#cfe9fe";>
    <div style="padding:100px;">
        
        <div style="background:teal;width:fit-content; min-width:200px;text-align:center;font-size:30px;padding:5px">
            New Blog
        </div>
        
        <form action="" method="POST" enctype="multipart/form-data">
            <div style="border:solid teal 1px; background: white; padding:50px;">
                <div class="row">
                    <div class="col-2">
                        <label for="title">Title</label>
                    </div>
                    <div class="col-10">
                    <textarea name="title" rows="1" cols="100"></textarea><br>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-2">
                        <label for="teaser">Teaser</label>
                    </div>
                    <div class="col-10">
                        <textarea name="teaser" rows="3" cols="100"></textarea><br>
                    </div>
                </div>

                <div class="row">
                    <div class="col-2">
                        <label for="blog_text">Content</label>
                    </div>
                    <div class="col-10">
                        <textarea name="blog_text" rows="15" cols="100"></textarea><br>
                    </div>
                </div>

                <hr/>
                <div class="row">
                    <div class="col-2">
                        <label for="categoryTag">Category/Tag</label>
                    </div>
                    <div class="col-10">
                        <div style="width:60%;">
                            <?php include "selectCategoryTag.php";?> 
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
                            <?php include "image.php"?>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="id" value="<?php echo $id?>">
            </div>

            <div style="text-align:center;">
                </br>
                <button type="submit" name="addBlog">Add Blog</button>
            </div>

        </form>
    </div>
</section>

<?php
    if($_SERVER['REQUEST_METHOD']==="POST" && isset($_POST['addBlog'])){
        try{
            
            include "uploadImage.php";
            
            if ($_POST['title'] && $_POST['teaser'] && $_POST['blog_text'] && 
            $_POST['categoryList'] && $_POST['tagList'] && ($_FILES["uploadImage"]["name"] || $_POST['imageList'])){
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

                if(count($imageIds)>=1){
                    $id=addBlogPost($conn,$title,$teaser,$blog_text,$categoryId,$tagId,$imageIds);

                    if($id != null){
                        redirectTo('blogDetails.php?id='.$id.'&imageIndex=0&message=saved');
                    }  
                }else{
                    echo "At least one image should be uploaded.";
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


