<?php 
$pageTitle = "Project";
include "includes/session.php";
include "includes/dbFunctions.php";
include "includes/dbConnection.php";
include "includes/header.php";
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<section id="ProjDetails" style="box-sizing:border-box; width: 100%; background-color:#ffc5da";>

<?php
    $id;
    if(isset($_GET['id'])){
        $id =$_GET['id'];
        $row = getProjDetails($conn,$id);
    }

    $time=strtotime($row['created_at']);
    $id = $row['id'];
    $title = $row['title'];
    $description = $row['teaser'];
    $category = $row['category'];
    $tag = $row['tag'];
    $content = $row['proj_text'];
?>

<div style="padding:100px;width:1000px;margin:auto;">

    <?php
        if(isset($_SESSION['username'])){
            if(!empty($_GET['message'])) {
                $message = $_GET['message'];
                echo "Entry successfully saved.<hr>";
        }
    }?>

        <div style="background:palevioletred;width:fit-content; min-width:200px;text-align:center;font-size:30px;padding:5px">
            <?php echo $title; ?>
        </div>
        
        <div style="border:solid palevioletred 1px; background: white; padding:10px;">
            <small>Date Posted: <?php echo date('d-m-Y',$time), " | ", $category, " #", $tag; ?></small>
            <hr>
            
            <div style="text-align: center;">  
                <?php
                    $result=getProjImages($conn,$id);
                    include "imageDisplay.php";

                    if ($imageIndex>0){
                        echo "<a href='projDetails.php?id=$id&imageIndex=$prev'> Prev </a>";
                    }
                    if ($imageIndex < $countOfImages - 1){
                        echo "<a href='projDetails.php?id=$id&imageIndex=$next'> Next </a>";
                    }
                ?>
                <br><br>
            </div>

            <p style="display:inline-block; text-align:justify;"><?php echo $content?></p><br>
        </div>

        <div style="background:palevioletred;opacity:0.5;">
            <a href='allProjs.php' class='card-link'>All Projects</a>
            <?php if(isset($_SESSION['username'])){?>
                <a href='projEdit.php?id=<?php echo $id ?>&type=proj'>Edit</a>
                <a href='projDelete.php?id=<?php echo $id ?>' onclick='return confirm("Are you sure you want to delete?")'>Delete</a>
            <?php } ?>
        </div>
        
    </div>   
</div>
</section>