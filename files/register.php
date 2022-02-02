<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['user'])) {
   header("Location: home.php" );
}
if (isset($_SESSION[ 'adm' ]) && isset($_SESSION[ 'superAdm' ])) {
   header("Location: dashboard.php");
}
require_once  '../compos/connection.php';
require_once '../compos/fileUpload.php' ;
$database = new Database;
$connection = $database->conn;

$error = false;
$firstName = $lastName = $email = $dateOfBirth = $pass = $image = '';
$firstNameError = $lastNameError = $emailError = $dateError = $passError = $picError = '';
if (isset($_POST[ 'btn-signup'])) {

   $firstName = trim($_POST['firstName']);

   $firstName = strip_tags($firstName);


   $firstName = htmlspecialchars($firstName);
   
   $lastName = trim($_POST['lastName']);
   $lastName = strip_tags($lastName);
   $lastName = htmlspecialchars($lastName);    

   $email = trim($_POST['email']);
   $email = strip_tags($email);
   $email = htmlspecialchars($email);

   $dateOfBirth = trim($_POST['dateOfBirth']);
   $dateOfBirth = strip_tags($dateOfBirth);
   $dateOfBirth = htmlspecialchars($dateOfBirth);

   $pass = trim($_POST['pass']);
   $pass = strip_tags($pass);
   $pass = htmlspecialchars($pass);

   $uploadError = '';
   $image = fileUpload($_FILES['image']);

   if (empty($firstName) || empty($lastName)) {
       $error = true;
       $firstNameError = "Please enter your full name and surname";
   } else if (strlen($firstName) <3  || strlen($lastName) <3) {
       $error = true;
       $firstNameError = "Name and surname must have at least 3 characters.";
   } else if (!preg_match("/[a-zA-Z]+$/", $firstName) || !preg_match("/[a-zA-Z]+$/", $lastName)) {
       $error = true;
       $firstNameError = "Name and surname must contain only letters and no spaces.";
   }
 
   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
       $error = true;
       $emailError = "Please enter valid email address.";
   } else {
       $sql = "SELECT email FROM accounts WHERE email='$email'";
       $result = mysqli_query($connection, $sql);
       $count = mysqli_num_rows($result);
       if ($count != 0) {
           $error = true;
           $emailError = "Provided Email is already in use.";
       }
   }
   if (empty($dateOfBirth)) {
       $error = true;
       $dateError = "Please enter your date of birth.";
   }
   if (empty($pass)) {
       $error = true;
       $passError = "Please enter password.";
   } else if (strlen($pass) <6 ) {
       $error = true;
       $passError = "Password must have at least 6 characters." ;
   }

   $password = hash('sha256', $pass);
    if (!$error) {

       $sql = "INSERT INTO accounts(firstName, lastName, password, dateOfBirth, email, image)
                 VALUES('$firstName', '$lastName', '$password', '$dateOfBirth', '$email', '$image->fileName')";
       $result = mysqli_query($connection, $sql);

       if ($result) {
           $errTyp = "success";
           $errMSG = "Successfully registered, you may login now";
           $uploadError = ($image->error != 0) ? $image->ErrorMessage : '';
           header("refresh:3;url=login.php");

       } else {
           $errTyp = "danger";
           $errMSG = "Something went wrong, try again later..." ;
           $uploadError = ($image->error != 0) ? $image->ErrorMessage : '';
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
</head>
<body>
<div class ="container ">
  <form class="w-75 mainDiv"  method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off"  enctype="multipart/form-data">
            <h2>Sign Up.</h2>
           <hr/>
           <?php
           if (isset($errMSG)) {
           ?>
           <div class="alert alert-<?php echo $errTyp ?>"  >
                        <p><?php echo $errMSG; ?></p>
                        <p><?php echo $uploadError; ?></p>
           </div>

           <?php
           }
           ?>

           <input type ="text"  name="firstName"  class="form-control"   placeholder="First name" maxlength="50" value= "<?php echo $firstName ?>"   />
              <span class="text-danger" > <?php echo $firstNameError; ?> </span>

            <input type ="text"   name="lastName"  class ="form-control"  placeholder= "Surname" maxlength="50"  value="<?php echo $lastName ?>"  />
              <span class="text-danger" > <?php echo  $firstNameError; ?> </span >

           <input  type="email"  name="email" class ="form-control" placeholder ="Enter Your Email" maxlength="40" value = "<?php echo $email ?>"  />
              <span  class="text-danger" > <?php  echo $emailError; ?> </span>
            <div class ="d-flex">
               <input class='form-control w-50'  type="date"   name="dateOfBirth"  value = "<?php echo $dateOfBirth ?>"/>
                <span  class="text-danger" > <?php  echo $dateError; ?> </span>

                <input  class='form-control w-50' type="file" name= "image" >
                <span  class= "text-danger" >  <?php   echo  $picError; ?>   </span >
            </div >
            <input   type = "password"   name = "pass"   class = "form-control"   placeholder = "Enter Password"   maxlength = "15"   />
              <span   class = "text-danger" >   <?php   echo  $passError; ?>   </span >
            <hr />
            <button   type = "submit"   class = "btn btn-block btn-primary"   name = "btn-signup" > Sign Up </button >
            <hr />
            <a href = "login.php" class="btn btn-success"> Sign in Here... <a >
  </form >
  </div >

</body >
</html >