<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

    require_once "../compos/connection.php";
    
    $database = new Database;
    $connection = $database->conn;
    
    if(isset($_SESSION["user"])){
        header("Location: home.php");
    }

    if (isset($_SESSION['adm']) && isset($_SESSION['superAdm'])) {
        header("Location: dashboard.php");
        exit;
     }
    
    $error = false;
    $email = $emailError = $passError = "";
    if(isset($_POST["btn-login"])){
        $email = trim($_POST["email"]);
        $email = strip_tags($email);
        $email = htmlspecialchars($email);

        $pass = trim($_POST["pass"]);
        $pass = strip_tags($pass);
        $pass = htmlspecialchars($pass);

        if(empty($email)){
            $error = true;
            $emailError = "please enter your email";
        }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $error = true;
            $emailError = "please type a valid email";
        }

        if(empty($pass)){
            $error = true;
            $passError = "please enter your password";
        }

        if(!$error){
            $password = hash("sha256", $pass);

            $sql = "SELECT * FROM accounts WHERE email = '$email'";
            $result = mysqli_query($connection, $sql);
            $row = mysqli_fetch_assoc($result);
            $count = mysqli_num_rows($result);

            if($count == 1 && $row["password"] == $password){
                if($row["rank"] == "adm"){
                    $_SESSION["adm"] = $row["id"];
                    header("Location: dashboard.php");
                }elseif($row["rank"] == "superAdm"){
                    $_SESSION["superAdm"] = $row["id"];
                    header("Location: dashboard.php");
                }
                else {
                    $_SESSION["user"] = $row["id"];
                    header("Location: home.php");
                }
            }else {
                $errMSG = "Incorrect Credentials, Try again..." ;
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en" >
<head>
   <meta charset="UTF-8">
    <meta name="viewport"   content="width=device-width, initial-scale=1.0">
<title>Login & Registration System </title>
<?php require_once  '../compos/boot.php'?>
<style>
    body{
        background-color: #76448A ;
        color: #F5B041;
    }
    .conClass{
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%,-50%);
    }
    .header{
        font-size: 70px;
        margin-top: 40px;
    }
    .factorySpan{
        color: #CB4335;
    }
    .btnsDiv{
        display: flex;
        justify-content: space-between;
    }
</style>
</head>
<body >
   <div class="container ">
       <h1 class="text-center header">Welcome to Adopt<span class="factorySpan">Factory</span> </h1>
       <form class="w-50 conClass formHolder mainDiv "  method="post" action= "" autocomplete="off" >
       <?php if(isset($errMSG)){
                echo $errMSG;
            };?>
           <h2>LOGIN</h2>
           <hr/>
       
           <input type="email"  autocomplete="off" name= "email" class="form-control p-1"  placeholder="Your Email" value="<?php echo $email; ?>"  maxlength ="40" />
           <span class="text-danger " ><?php echo $emailError; ?></span >

           <input  type="password" name= "pass"  class="form-control  p-1"  placeholder="Your Password" maxlength="15"  />
           <span class= "text-danger "><?php echo $passError; ?></span>
           <hr/>
           <div class=" btnsDiv">
               <div>
           <button class="btn btn-block btn-warning"  type="submit" name ="btn-login">SIGN IN</button></div> <div class="d-flex"> <p class="mt-3">OR</p> <a class="text-decoration-none mt-3 ms-2"  type="submit" href="register.php" name ="btn-login">CREATE AN ACCOUNT</a></div>
           </div>
           <hr/>
        </form>

   </div>
</body >
</html>