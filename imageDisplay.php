<?php
    $countOfImages = $result->num_rows;
    $imagesToDisplay = array();
    $imageIndex=$_GET['imageIndex'];

    if($countOfImages > 0){
        while ($row = $result->fetch_assoc()){
            $imageName = $row['image'];
            array_push($imagesToDisplay,$imageName);
        }
    }

    $values = array_values( $imagesToDisplay );
    $next = $imageIndex + 1;
    $prev = $imageIndex - 1;
?>

<img src='<?php echo "images/",$values[$imageIndex] ?>' width='450px' alt='$image' />
<br>
                   