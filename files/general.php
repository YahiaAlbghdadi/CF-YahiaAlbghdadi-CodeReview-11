<?php

require_once "../compos/connection.php";
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

$sql = "SELECT * FROM animals where stage != 'Senior'";
$result = mysqli_query($connection,$sql);

$acSql = "SELECT * FROM accounts WHERE id = {$_SESSION['user']}";
$acResult = mysqli_query($connection,$acSql);
$acFetched = $acResult->fetch_assoc();


$print = "";
    if(mysqli_num_rows($result) > 0){

    while($animal = $result->fetch_assoc()){
      
        $print .= "
        <div class='card pt-2 animal mainDiv' style='width: 18rem;'>
        <img src='../images/{$animal['image']}' class='card-img-top' alt='...'>
        <div class='card-body'>
          <h5 class='card-title'>{$animal['name']}</h5>
          <p class='card-text text-secondary'>{$animal['description']}</p>
        </div>
        <ul class='list-group list-group-flush'>
        <li class='list-group-item'>Location: {$animal['location']}</li>
          <li class='list-group-item'>Hobbies: {$animal['hobbies']}</li>
          <li class='list-group-item'>Age: {$animal['age']}</li>
        </ul>
        <div class='card-body d-flex justify-content-around'>
          <a  class=' btn btn-success text-decoration-none adoptBtns'>Adopt Animal</a>
        </div>
      </div>
        ";}

    }else{
        $print .= "No Products found";
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
    <?php require_once "../compos/boot.php"?>
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
    .userImg {
    max-width: 3em;
    max-height: 3em;
    margin: 10px auto;
    border-radius: 70px;
}

  </style>

</head>
<body>
<?php require_once '../compos/navbar.php' ?>
<div class="user">
<li class="nav-item dropdown list-unstyled">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="../images/<?=$acFetched['image']?>" alt="" class="userImg">
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="#">User: <?=$acFetched['firstName']?> <?=$acFetched['lastName']?></a></li>
            <li><a class="dropdown-item" href="userUpdate.php?id=<?=$acFetched['id']?>">Update my profile </a></li>
            <li><a class="dropdown-item" href="logout.php?logout">Logout</a></li>
          </ul>
        </li>
</div>
    <div class="container">
    <div class="text-white p-5 ">
            <h1 class="text-center header">Small and Large Animals: </h1>
        </div>

        <div class="row mb-5">
            <?=$print?>
        </div>
    </div>
    <?php require_once '../compos/footer.php' ?>

</body>
</html>

