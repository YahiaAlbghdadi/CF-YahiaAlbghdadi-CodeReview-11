<?php

require_once "../compos/connection.php";
if (session_status() == PHP_SESSION_NONE) {
    session_start();

}if(!isset($_SESSION['adm']) && !isset ($_SESSION[ 'user']) && !isset ($_SESSION[ 'superAdm']) ) {
    header("Location: login.php");
    exit;
   }

   if(isset($_SESSION['user']) ) {
    header("Location: home.php");
    exit;
   }

   if(isset($_SESSION['adm']) ) {
    header("Location: dashboard.php");
    exit;
   }



$database = new Database;
$connection = $database->conn;


if($_GET['id']) {
   $id = $_GET['id'];
   $sql = "SELECT * FROM accounts WHERE id = {$id}" ;
   $result = mysqli_query($connection, $sql);
   $fetchedR = mysqli_fetch_assoc($result);
   if (mysqli_num_rows($result) == 1) {
      $name = $fetchedR['lastName' ];
      $dateOfBirth= $fetchedR['dateOfBirth'];
      $rank = $fetchedR['rank'];
      $image = $fetchedR['image'];
} }


?>

<!DOCTYPE html>
<html lang="en" >
<head>
   <meta charset="UTF-8">
    <meta name="viewport"   content="width=device-width, initial-scale=1.0">
   <title>Delete User</title>
    <?php require_once '../compos/boot.php' ?>
</head>
<body>
<div  class="<?= $class; ?>" role="alert" >
       <p><?= ($message) ?? ''; ?></p>           
</div>
<fieldset>
<legend class='h2 mb-3' >Delete request <img class= 'img-thumbnail rounded-circle'  src='../images/<?= $fetchedR["image"] ?>' alt="<?= $name ?>"></legend >
<h5>You have selected the data below: </h5>
<table  class="table w-75 mt-3">
<tr>
           <td>Name: <?="$name "?></td>
           <td>Date of Birth: <?= $dateOfBirth?></td>
           <td>Rank: <?= $rank?></td>

</tr>
</table>

<h3 class="mb-4" >Do you really want to delete this User?</h3 >
<form action="../actions/aUserDelete.php"  method="post">
  <input type="hidden" name ="id" value= "<?= $id ?>" />
  <input type= "hidden" name= "image" value= "<?= $image ?>" />
  <button class="btn btn-danger"  type="submit"> Yes, delete this User! </button  >
  <a  href="dashboard.php" ><button  class="btn btn-warning"  type= "button">No, go back!</button></a>
</form >
</fieldset>
</body>
</html >