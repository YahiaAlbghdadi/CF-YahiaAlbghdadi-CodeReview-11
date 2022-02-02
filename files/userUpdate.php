<?php
require_once '../compos/connection.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['adm']) && !isset ($_SESSION[ 'user']) && !isset ($_SESSION[ 'superAdm']) ) {
    header("Location: login.php");
    exit;
   }

if(isset($_SESSION['adm']) ) {
    header("Location: dashboard.php");
    exit;
   }
$userRank = "";

if(isset($_SESSION['user']) ) {
    $userRank = "d-none";
   }



  
 $database = new Database;
 $connection = $database->conn;
 
if (isset($_GET[ 'id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM accounts WHERE id = {$id}";
    $result = $connection->query($sql);
    if ($result->num_rows == 1) {
        $fetchedResult = $result->fetch_assoc();
        $firstName = $fetchedResult['firstName'];
        $lastName = $fetchedResult['lastName'];
        $dateOfBirth = $fetchedResult['dateOfBirth'];
        $image = $fetchedResult['image'];
        $rank = $fetchedResult['rank'];
        $email = $fetchedResult['email'];
    }  
 }
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
    <meta name="viewport"   content="width=device-width, initial-scale=1.0">
  <title>Update Animal</title>
  <?php require_once '../compos/boot.php'?>
</head>
<body>
    <div class="container p-5">
       <h2>Update</h2>       
       <img class='img-thumbnail rounded-circle'  src='../images/<?= $fetchedResult['image'] ?>' alt="<?= $firstName ?>">
       <form action="../actions/aUserUpdate.php" method="post" enctype="multipart/form-data">
           <table  class="table">
               <tr>
                   <th>USER FIRST NAME</th>
                   <td><input class="form-control"  type="text"  name ="firstName" placeholder = "USER FIRST NAME"  value="<?= $firstName ?>"   /></td>
               </tr>
               <tr>
                   <th>USER LAST NAME</th>
                   <td><input class="form-control"  type="text"  name ="lastName" placeholder = "USER LAST NAME"  value="<?= $lastName ?>"   /></td>
               </tr>
               <tr>
                   <th>USER DATE OF BIRTH </th>
                   <td><input class="form-control"  type="date"  name ="dateOfBirth" placeholder = "USER DATE OF BIRTH"  value="<?= $dateOfBirth ?>"   /></td>
               </tr>

               <tr>
               <tr>
                   <th>USER EMAIL</th>
                    <td><input class= "form-control " type ="text"  name="email"  placeholder= "USER EMAIL"   value = "<?= $email?>"/></td>
               </tr>
               <tr class="<?=$userRank?>">
                       <th>USER RANK</th>
                        <td><input placeholder="USER RANK" class='form-control'  list="stage" value  ="<?= $rank?>" name="rank" /></label>
                        <datalist  id="stage">
                        <option value="user">
                        <option value="adm">
                        <option value="superAdm">
                        </datalist></td>
                   </tr>
               <tr>
                   <th>USER IMAGE</th>
                    <td><input  class= "form-control"  type ="file" placeholder="USER IMAGE"  name = "image"  /></td>
                </tr>
                <tr>
                    <input   type = "hidden"   name = "id"   value = "<?= $fetchedResult['id'] ?>"  />
                    <input   type = "hidden"   name = "image"   value = "<?= $image ?>"  />
                    <td><button   name = "submit"   class = "btn btn-success"   type = "submit"> Save Changes </button></td>
                    <td><a href = "dashboard.php"><button class = "btn btn-warning" type = "button"> Back </button></a></td>
                </tr>
            </table>
        </form>    
</div>
</body>
</html>