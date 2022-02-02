<?php

require_once '../compos/connection.php';
require_once "../actions/aSearch.php";

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
$dClass ="";
$cClass ="";
if (isset($_SESSION["adm"])) {
    $dClass = "d-none";
    $cClass = "col-12";
 }else{
     $dClass = "";
     $cClass = "col-2";

 }
 
$database = new Database;
$connection = $database->conn;

$ban="";
if(isset($_SESSION['superAdm'])){
    $ban = "!= 'superAdm'";
}else{
    $ban = "= 'user' ";

}
// $id = $_SESSION['adm'];
$acSql = "SELECT * FROM accounts WHERE rank $ban";
$acResult = mysqli_query($connection, $acSql);

$accounts = '';
$animals = '';
if (mysqli_num_rows($acResult) > 0) {
   while ($row = mysqli_fetch_assoc($acResult)) {
       $accounts .= "<tr>
           <td><img class='img-thumbnail rounded-circle' src='../images/" . $row['image'] . "' alt=" . $row['firstName'] . "></td>
           <td>" . $row['firstName'] . " " . $row['lastName'] . "</td>
           <td>" . $row['dateOfBirth'] . "</td>
           <td>" . $row['email'] . "</td>
           <td><a href='userUpdate.php?id=" . $row['id'] . "'><button class='btn btn-primary btn-sm' type='button'>Edit</button></a>
           <a href='userDelete.php?id=" . $row['id'] . "'><button class='btn btn-danger btn-sm' type='button'>Delete</button></a></td>
        </tr>";
   }
} else {
   $accounts = "<tr><td colspan='5'><center>No Data Available </center></td></tr>";
}



?>





<!DOCTYPE html>
<html lang="en" >
<head>
   <meta charset="UTF-8">
    <meta name="viewport"   content="width=device-width, initial-scale=1.0">
   <title>Adm-DashBoard</title>
   <?php require_once '../compos/boot.php' ?>
</head>
<body >
<?php require_once '../compos/navbar.php' ?>

<div class="container" >
   <div class= "row">
       <div  class="<?=$cClass?>">
       <img class="userImage"  src="../images/admavatar.png" alt= "Adm avatar" >
       <p class="">Administrator </p>
       <a class="btn btn-primary p-1"  href="logout.php?logout">Sign Out </a>
       </div >
       <div  class="col-8 mt-2 <?=$dClass?>">
        <p class='h2' >Users</p>
       <table class='table table-striped '>
           <thead  class='table-success'>
               <tr>
                   <th>Picture</th>
                   <th>Name</th >
                   <th>Date of birth</th>
                   <th>Email</th>
                   <th>Action</th >
               </tr>
           </thead>
           <tbody>
            <?=$accounts?>
            </tbody>
        </table>
       </div>
   </div>
   <div  class="text-center pt-5">
   <a class="btn btn-secondary " href="create.php">ADD AN ANIMAL</a>
   </div>
   <h1 class="animals text-success text-center p-5">
       ANIMALS
   </h1>
   <div class="container">
        <div class="row" id="searchedResult">
            <?=$print?>
        </div>
    </div>
    <script>
function loadDoc() {
let xhttp = new XMLHttpRequest(); 
xhttp.onload = function() {
    if (this.status == 200 ) {
        document.getElementById("searchedResult").innerHTML = this.responseText;
    }
};

var animal = document.getElementById("animal").value;
xhttp.open("GET", '../actions/aSearch.php?animal='+animal , true); 
xhttp.send();
}
document.getElementById("animal").addEventListener("keyup", loadDoc);
</script>
</div>
</body>
</html>

