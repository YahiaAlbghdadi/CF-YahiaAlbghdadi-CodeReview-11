<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../compos/connection.php';
require_once '../compos/fileUpload.php';
if (!isset($_SESSION['adm' ]) && !isset($_SESSION['user']) && !isset($_SESSION['superAdm'])) {
    header("Location: login.php" );
     exit;
 }
 if ( isset($_SESSION["user"])) {
    header("Location: home.php");
    exit;
 }
  
$database = new Database;
$connection = $database->conn;

$class = 'd-none';
if (isset($_POST["submit" ])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $location = $_POST['location'];
    $age = $_POST['age'];
    $stage = $_POST['stage'];
    $hobbies = $_POST['hobbies'];
    $description = $_POST['description'];
    $imageArray = fileUpload($_FILES['image']);
    $image = $imageArray->fileName;
    $uploadError = '';    

   if ($imageArray->error == 0) {      
       ($_POST["image"] == "animal.png") ?: unlink("../images/$_POST[image]");
       $sql = "UPDATE animals SET name = '$name', location = '$location',stage = '$stage', hobbies = '$hobbies', description = '$description', age = '$age', image = '$image' WHERE id = {$id}";
   } else {
       $sql = "UPDATE animals SET name = '$name', location = '$location',stage = '$stage', hobbies = '$hobbies', description = '$description', age = '$age' WHERE id = {$id}";
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
    <title>aUpdate</title>
    <?php require_once '../compos/boot.php'?>
</head>
<body>
<div class ="container">
   <div class="<?php echo $class; ?>"  role="alert">
       <p><?php echo ($message) ?? ''; ?></p>
        <p><?php echo ($uploadError) ?? ''; ?></p>       
    </div>
</div>

</body>
</html>