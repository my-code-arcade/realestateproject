<!doctype html>
<?php

ini_set('display_errors', '1');
ini_set('error_reporting', E_ALL);
//var_dump(function_exists('mysqli_connect'));
$connect = mysqli_connect("localhost","root","","realestatedb");
$message ="";
$msgFlag=  false;
//secho $connect;
if ( ! $connect ) {
   die( 'Could not connect: ' . mysql_error() );
} else {
   echo 'Connection established';
}
session_start();
if(isset($_POST['register'])){
$username = mysqli_real_escape_string($connect, $_POST['username']);
$password= mysqli_real_escape_string($connect, $_POST['password']);
$password = md5($password);

$selectQuery = "select * from users where username = '$username'";
$result = mysqli_query($connect,$selectQuery);
if(mysqli_num_rows($result) == 0){
   $query = "INSERT INTO users(username, userpwd) VALUES('$username', '$password') ";

   if( mysqli_query($connect,$query)){
      $message= "Registration Done";
      $msgFlag=true;
   }
}else{
  $message= "Duplicate User";
}
}
?>
<html class="no-js" lang="">
   <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Login Page</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="assets/css/normalize.css">
      <link rel="stylesheet" href="assets/css/bootstrap.min.css">
      <link rel="stylesheet" href="assets/css/font-awesome.min.css">
      <link rel="stylesheet" href="assets/css/themify-icons.css">
      <link rel="stylesheet" href="assets/css/pe-icon-7-filled.css">
      <link rel="stylesheet" href="assets/css/flag-icon.min.css">
      <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
      <link rel="stylesheet" href="assets/css/style.css">
      <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
   </head>
   <body class="bg-dark">
      <div class="sufee-login d-flex align-content-center flex-wrap">
         <div class="container">
            <div class="login-content">
               <div class="login-form mt-150">
                  <form method="post">
                     <div class="form-group">
                        <label>Enter Email address</label>
                        <input type="email" name="username" class="form-control" placeholder="Email">
                     </div>
                     <div class="form-group">
                        <label>Enter Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password">
                     </div>
                     <!-- <div class="form-group">
                        <label>Re-Enter Password</label>
                        <input type="password" class="form-control" placeholder="Password">
                     </div> -->
                   
                     <button type="submit" name="register" class="btn btn-success btn-flat m-b-30 m-t-30">Sign up</button>
                     <?php echo $msgFlag === true ? '<p style="font-size:14px;color:green;" >'. $message.'</p>' : '<p style="font-size:14px;color:red;" >'.$message.'</p>' ?>
					</form>
               </div>
            </div>
         </div>
      </div>
      <script src="assets/js/vendor/jquery-2.1.4.min.js" type="text/javascript"></script>
      <script src="assets/js/popper.min.js" type="text/javascript"></script>
      <script src="assets/js/plugins.js" type="text/javascript"></script>
      <script src="assets/js/main.js" type="text/javascript"></script>
   </body>
</html>