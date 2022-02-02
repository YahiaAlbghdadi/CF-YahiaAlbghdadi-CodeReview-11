<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    .navFirst{
      color: #F5B041;
    }
    .navSecond{
      color: #CB4335;
    }
    .navWord:hover .navFirst{
      color: #CB4335;

    }
    .navWord:hover .navSecond{
      color: #F5B041;

    }

  </style>
</head>
<body>
<nav class="navbar sticky-top bg-light  navbar-expand-lg navbar-light ">
  <div class="container-fluid">
    <div class="navWord">
    <a class="h4 pe-5 navFirst  text-decoration-none" href="home.php">Adopt<span class="navSecond ">Factory</span></a>
    </div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="home.php">Home</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Animals
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="general.php">young & Adult Animals</a></li>
            <li><a class="dropdown-item" href="senior.php">Senior Animals</a></li>
          </ul>
        </li>
      </ul>
      <form class="d-flex">
        <input id="animal"  class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
      
    </div>
  </div>
</nav>



</body>
</html>