<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}require_once '../compos/connection.php';
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

if ($_POST) {
   $id = $_POST['id'];
   $image = $_POST['image'];
   ($image =="avatar.png")?: unlink("../images/$image");

  $sql = "DELETE FROM accounts WHERE id = {$id}";
  if ($connection->query($sql)) {
   $class = "alert alert-success" ;
   $message = "Successfully Deleted!";
   header("refresh:3;url=../files/dashboard.php");
} else {
   $class = "alert alert-danger";
   $message = "The entry was not deleted due to: <br>" . $connection->error;
}
}


?>


<!DOCTYPE html>
<html lang= "en">
   <head>
       <meta  charset="UTF-8">
       <title>aDelete</title>
       <?php require_once '../compos/boot.php' ?> 
   </head>
   <body>
       <div  class="container">
           <div class="mt-3 mb-3" >
               <h1>Delete request response</h1>
           </div>
            <div class="alert alert-<?=$class;?>" role="alert">
               <p><?=$message;?></p >
               <a href ='../files/dashboard.php'><button class= "btn btn-success" type='button'>Dashboard</button></a>
            </div>
       </div >
   </body>
</html>