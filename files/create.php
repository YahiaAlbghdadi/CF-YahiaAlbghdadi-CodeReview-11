<?php
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
     
?>

<!DOCTYPE html>
<html lang="en" >
   <head>
       <meta charset="UTF-8">
        <meta name="viewport" content ="width=device-width, initial-scale=1.0">
       <?php require_once '../compos/boot.php'?>
       <title>Create Animal</title>
   </head>
   <body>
   <div class="container p-5">
       <h2>Create new Animal</h2>       
       <form action="../actions/aCreate.php" method="post" enctype="multipart/form-data">
           <table  class="table">
               <tr>
                   <th>ANIMAL NAME</th>
                   <td><input class="form-control"  type="text"  name ="name" placeholder = "Animal Name" /></td>
               </tr>
               <tr>
                   <th>ANIMAL AGE</th>
                   <td><input class="form-control"  type="text"  name ="age" placeholder = "Animal age" /></td>
               </tr>

               <tr>
               <tr>
                   <th>ANIMAL DESCRIPTION</th>
                    <td><input class= "form-control " type ="text"  name="description"  placeholder= "Animal Description" /></td>
               </tr>
               <tr>
                   <th>ANIMAL LOCATION</th>
                    <td><input class= "form-control" type ="text"  name="location"  placeholder= "Animal Location" ></td>
               </tr>
               <tr>
                       <th>STAGE</th>
                        <td><input placeholder="Animal Stage" class='form-control'  list="stage" name="stage" /></label>
                        <datalist  id="stage">
                        <option value="Small">
                        <option value="Large">
                        <option value="Senior">
                        </datalist></td>
                   </tr>
               <tr>
                   <th>ANIMAL HOBBIES</th>
                    <td><input class= "form-control" type ="text"  name="hobbies"  placeholder= "Animal Hobbies"  /></td>
               </tr>

               <tr>
                   <th>IMAGE</th>
                    <td><input  class= "form-control"  type ="file"   name = "image"  /></td>
                </tr>
                <tr>
                    <input   type = "hidden"   name = "id"   value = "<?= $fetchedResult['id'] ?>"  />
                    <input   type = "hidden"   name = "image"   value = "<?= $image ?>"  />
                    <td><button   name = "submit"   class = "btn btn-success"   type = "submit"> Save Changes </button></td>
                    <td><a href = "../files/dashboard.php"><button class = "btn btn-warning" type = "button"> Back </button></a></td>
                </tr>
            </table>
        </form>    
</div>
   </body>
</html>