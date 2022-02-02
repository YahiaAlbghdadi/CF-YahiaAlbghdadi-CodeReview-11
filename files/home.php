<?php

require_once "../compos/connection.php";
require_once "../actions/aSearch.php";
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['adm']) && isset($_SESSION['superAdm'])) {
    header("Location: dashboard.php");
    exit;
 }
 if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: login.php" );
     exit;
 }


 

$database = new Database;
$connection = $database->conn;


$acSql = "SELECT * FROM accounts WHERE id = {$_SESSION['user']}";
$acResult = mysqli_query($connection,$acSql);
$acFetched = $acResult->fetch_assoc();


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <?php require_once '../compos/boot.php' ?>
  <style>
      body{
        font-family: 'Nunito', sans-serif;
        padding: 0px;
        margin: 0px;
        background-color: rgb(244, 119, 106);

      }
      .adoptBtns {
        max-height: 38px;
    }
    .factorySpan1{
        color: #F5B041;
    }
    .factorySpan2{
        color: #CB4335;
    }




  </style>
</head>
<body>
<?php require_once '../compos/navbar.php' ?>

<div class="user ">
<li class="nav-item dropdown list-unstyled">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="../images/<?=$acFetched['image']?>" alt="" class="img-thumbnail rounded-circle">
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="#">User: <?=$acFetched['firstName']?> <?=$acFetched['lastName']?></a></li>
            <li><a class="dropdown-item" href="userUpdate.php?id=<?=$acFetched['id']?>">Update my profile </a></li>
            <li><a class="dropdown-item" href="logout.php?logout">Logout</a></li>
          </ul>
        </li>
</div>
    <div class="container">
        <div class="text-white p-5">
            <h1 class="text-center header">Adopt Animals from all over the World with <span class="factorySpan1">Adopt</span><span class="factorySpan2">Factory</span> </h1>
        </div>
        <div id="carouselExampleIndicators" class="carousel slide " data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="5" aria-label="Slide 5"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="../images/cat.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="../images/dog1.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="../images/rabbit.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="../images/parrot.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="../images/dog2.jpg" class="d-block w-100" alt="...">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
<div class="text-white p-5 mt-5">
            <h1 class="text-center header">Animals that are ready to be adopted: </h1>
        </div>
        <div class="row p-5 mb-2" id="searchedResult">
            <?=$print?>
        </div>
    </div>
    <?php require_once '../compos/footer.php' ?>

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
</body>
</html>


