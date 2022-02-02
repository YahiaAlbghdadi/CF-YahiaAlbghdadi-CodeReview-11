<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../compos/connection.php';
require_once '../compos/fileUpload.php';
if( !isset($_SESSION['adm']) && !isset ($_SESSION['user']) && !isset ($_SESSION['superAdm']) ) {
   header("Location: ../files/login.php");
   exit;
  }


  if(isset($_SESSION['adm'])){
      header("location: ../files/dashboard.php");
  }
 
$database = new Database;
$connection = $database->conn;

$class = 'd-none';
if (isset($_POST["submit" ])) {
    $id = $_POST['id'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $rank = $_POST['rank'];
    $email = $_POST['email'];
    $imageArray = fileUpload($_FILES['image']);
    $image = $imageArray->fileName;
    $uploadError = '';    

   if ($imageArray->error == 0) {      
       ($_POST["image"] == "avatar.png") ?: unlink("../images/$_POST[image]");
       $sql = "UPDATE accounts SET firstName='$firstName',lastName='$lastName',dateOfBirth='$dateOfBirth',email='$email',image='$image', rank='$rank'  WHERE id = {$id}";
   } else {
    $sql = "UPDATE accounts SET firstName='$firstName',lastName='$lastName',dateOfBirth='$dateOfBirth',email='$email', rank='$rank'  WHERE id = {$id}";
}
    if ($connection->query($sql)) {    
       $class = "alert alert-success";
       $message = "The record was successfully updated";
       $uploadError = ($imageArray->error != 0) ? $imageArray->ErrorMessage : '';
       header("refresh:3;url=../files/dashboard.php");
   } else {
       $class = "alert alert-danger";
       $message = "Error while updating record : <br>" . $connection->error;
       $uploadError = ($imageArray->error != 0) ? $imageArray->ErrorMessage : '';
   }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>aUserUpdate</title>
    <?php require_once '../compos/boot.php'?>
</head>
<body>
<div class ="container">
   <div class="<?=$class; ?>"  role="alert">
       <p><?=($message) ?? ''; ?></p>
        <p><?=($uploadError) ?? ''; ?></p>       
    </div>
</div>

</body>
</html>