<?php
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name ='DbSW';

$con = mysqli_connect($db_host,$db_username,$db_password,$db_name) or die('Erreur de connexion à la base de donnée');
$_SESSION['con'] = $con;

?>