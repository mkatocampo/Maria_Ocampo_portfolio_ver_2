<?php 
$pageTitle = "Blog";
include "includes/session.php";
include "includes/dbFunctions.php";
include "includes/dbConnection.php";
include "includes/header.php";
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<section id="BlogDetails" style="box-sizing:border-box; width: 100%; background-color:#cfe9fe";>

<?php
    $id;
    if(isset($_GET['id'])){
        $id =$_GET['id'];
        $row = getBlogDetails($conn,$id);
    }

    $time=strtotime($row['created_at']);
    $id = $row['id'];
    $title = $row['title'];
    $description = $row['teaser'];
    $category = $row['category'];
    $tag = $row['tag'];
    $content = $row['blog_text'];
?>

<div style="padding:100px;width:1000px;margin:auto;">

    <?php
        if(isset($_SESSION['username'])){
            if(!empty($_GET['message'])) {
                $message = $_GET['message'];
                echo "Entry successfully saved.<hr>";
        }
    }?>

        <div style="background:teal;color:white;width:fit-content; min-width:200px;text-align:center;font-size:30px;padding:5px">
            <?php echo $title; ?>
        </div>
        
        <div style="border:solid teal 1px; background: white; padding:10px;">
            <small>Date Posted: <?php echo date('d-m-Y',$time), " | ", $category, " #", $tag; ?></small>
            <hr>
            
            <div style="text-align: center;">  
                <?php
                    $result=getBlogImages($conn,$id);
                    include "imageDisplay.php";

                    if ($imageIndex>0){
                        echo "<a href='blogDetails.php?id=$id&imageIndex=$prev'> Prev </a>";
                    }
                    if ($imageIndex < $countOfImages - 1){
                        echo "<a href='blogDetails.php?id=$id&imageIndex=$next'> Next </a>";
                    }
                ?>
                <br><br>
            </div>

            <p style="display:inline-block; text-align:justify;"><?php echo $content?></p><br>
        </div>

        <div style="background:teal;opacity:0.6;">
            <a href='allBlogs.php' style="color:white;" class='card-link'>All Blogs</a>
            <?php if(isset($_SESSION['username'])){?>
                
                <a href='blogEdit.php?id=<?php echo $id ?>&type=blog' style="color:white;">Edit</a>
                <a href='blogDelete.php?id=<?php echo $id ?>' style="color:white;" onclick='return confirm("Are you sure you want to delete?")'>Delete</a>
            <?php } ?>
        </div>
        
    </div>   
</div>
</section>