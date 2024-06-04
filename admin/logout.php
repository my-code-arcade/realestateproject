<?php
//require_once '../admin/connection.inc.php';
session_start();
echo "hereeee";

unset($_SESSION['islogin']);
unset($_SESSION['username']);
print_r($_SESSION);

header('location:index.php');
// die();

?>