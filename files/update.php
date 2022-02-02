<?php
require_once '../compos/connection.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
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
 
if (isset($_GET[ 'id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM animals WHERE id = {$id}";
    $result = $connection->query($sql);
    if ($result->num_rows == 1) {
        $fetchedResult = $result->fetch_assoc();
        $name = $fetchedResult['name'];
        $location = $fetchedResult['location'];
        $age = $fetchedResult['age'];
        $image = $fetchedResult['image'];
        $stage = $fetchedResult['stage'];
        $hobbies = $fetchedResult['hobbies'];
        $description = $fetchedResult['description'];
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
    <div class="container ">
       <h2>Update</h2>       
       <img class='img-thumbnail rounded-circle'  src='../images/<?= $fetchedResult['image'] ?>' alt="<?= $name ?>">
       <form action="../actions/aUpdate.php" method="post" enctype="multipart/form-data">
           <table  class="table">
               <tr>
                   <th>ANIMAL NAME</th>
                   <td><input class="form-control"  type="text"  name ="name" placeholder = "Animal Name"  value="<?= $name ?>"   /></td>
               </tr>
               <tr>
                   <th>ANIMAL AGE</th>
                   <td><input class="form-control"  type="text"  name ="age" placeholder = "Animal age"  value="<?= $age ?>"   /></td>
               </tr>

               <tr>
               <tr>
                   <th>ANIMAL DESCRIPTION</th>
                    <td><input class= "form-control " type ="text"  name="description"  placeholder= "Animal Description"   value = "<?= $description?>"/></td>
               </tr>
               <tr>
                   <th>ANIMAL LOCATION</th>
                    <td><input class= "form-control" type ="text"  name="location"  placeholder= "Animal Location"   value = "<?= $location?>"/></td>
               </tr>
               <tr>
                       <th>STAGE</th>
                        <td><input class='form-control'  list="stage" value  ="<?= $stage ?>" name="stage" /></label>
                        <datalist  id="stage">
                        <option value="Small">
                        <option value="Large">
                        <option value="Senior">
                        </datalist></td>
                   </tr>
               <tr>
                   <th>ANIMAL HOBBIES</th>
                    <td><input class= "form-control" type ="text"  name="hobbies"  placeholder= "Animal Hobbies"   value = "<?= $hobbies?>"/></td>
               </tr>

               <tr>
                   <th>IMAGE</th>
                    <td><input  class= "form-control"  type ="file"   name = "image"  /></td>
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