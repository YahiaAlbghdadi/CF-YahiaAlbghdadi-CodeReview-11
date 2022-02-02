<?php
require_once "../compos/connection.php";
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
$btns = "";
$database = new Database;
$connection = $database->conn;

if(!$_GET){
  $print="";
  $sql = "SELECT * FROM animals";
  $result = $connection->query($sql);
  $fetchedRes = $result->fetch_all(MYSQLI_ASSOC);
  foreach($fetchedRes as $animal){
    if(isset($_SESSION['adm'])){
      $btns = "<div class='card-body d-flex justify-content-around align-items-center'>
      <a href='update.php?id={$animal['id']}' class='btns btn btn-info m-3 text-decoration-none '>Update Animal</a>
      <a href='delete.php?id={$animal['id']}' class='btns btn btn-danger text-decoration-none m-3 '>Delete Animal</a>
      </div>";
    }if(isset($_SESSION['superAdm'])){
      $btns = "<div class='card-body d-flex justify-content-around align-items-center'>
      <a href='update.php?id={$animal['id']}' class='btns btn btn-info m-3 text-decoration-none '>Update Animal</a>
      <a href='delete.php?id={$animal['id']}' class='btns btn btn-danger text-decoration-none m-3 '>Delete Animal</a>
      </div>";

    }if(isset($_SESSION['user'])){
      $btns = "    <div class='card-body d-flex justify-content-around'>
      <a  class='adoptBtns btn btn-success text-decoration-none '>Adopt Animal</a>
    </div>
    ";
    }
    
    $print .= "
    <div class=' card pt-2 animal mainDiv' style='width: 18rem;'>
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
    {$btns}
  </div>
    ";
  }
}else{
      $animal =  $_GET["animal"];
      $sql = "SELECT * from animals WHERE name LIKE '$animal%'";
      $result = $connection->query($sql);
      if($result->num_rows == 0){
          echo "No Results";
      }else {
          $animals = $result->fetch_all(MYSQLI_ASSOC);

      foreach($animals as $animal){
        if(isset($_SESSION['adm'])){
          $btns = "<div class='card-body d-flex justify-content-around align-items-center'>
          <a href='update.php?id={$animal['id']}' class='btns btn btn-info m-3 text-decoration-none '>Update Animal</a>
          <a href='delete.php?id={$animal['id']}' class='btns btn btn-danger text-decoration-none m-3 '>Delete Animal</a>
          </div>";
        }if(isset($_SESSION['superAdm'])){
          $btns = "<div class='card-body d-flex justify-content-around align-items-center'>
          <a href='update.php?id={$animal['id']}' class='btns btn btn-info m-3 text-decoration-none '>Update Animal</a>
          <a href='delete.php?id={$animal['id']}' class='btns btn btn-danger text-decoration-none m-3 '>Delete Animal</a>
          </div>";
    
        }else{
          $btns = "    <div class='card-body d-flex justify-content-around'>
          <a  class='adoptBtns btn btn-success text-decoration-none '>Adopt Animal</a>
        </div>
        ";
        }
         echo "
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
          {$btns}

        </div>
          ";
      }
    }}
