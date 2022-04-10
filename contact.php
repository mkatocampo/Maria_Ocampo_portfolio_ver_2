<?php
$pageTitle ="Login";
include "includes/session.php";   
include "includes/dbFunctions.php";
include "includes/dbConnection.php";
include "includes/header.php";
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<section id="Blogs" style="box-sizing:border-box; width: 100%;  min-height: 100vh; background-color:#ffd7e6";>
<div style="padding:100px;">
    <h1 style="font-family: 'Lobster', cursive; color:#8e7f97">Contact Maria</h1>
    <hr>

    <?php
    if($_SERVER['REQUEST_METHOD']==="POST" && isset($_POST['send'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];
        $formcontent=" From: $name \n Email: $email \n Message: $message";
        $recipient = "ocampo.mkb@gmail.com";
        $subject = "Message from $name";
        $mailheader = "From: $name \r\n";
        mail($recipient, $subject, $formcontent, $mailheader) or die("Error!");
        echo "Thank You!";
    }
    ?>

    <br><br>
    <form action="contact.php" method="post">
        <table>
            <tr>
                <td><label>Name</label></td> 
                <td><input type="text" name="name"></td>
            </tr>

            <tr>
                <td><label>Email</label></td>
                <td><input type="text" name="email"></td>
            </tr>

            <tr>
                <td><label>Message</label></td>
                <td><textarea name="message" rows="6" cols="25"></textarea></td>
            </tr>
            
        </table>
        <button type="submit" name="send">Send</button>
    </form>
</div>




</section>

<?php include "includes/footer.php"; ?>