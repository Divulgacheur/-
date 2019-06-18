<?php

session_start();

if ( empty($_SESSION['nom_compte']) ){
	header('Location:index.php?msg=inv');
	exit();
}

include("/home/rtel/etu/rt2018/pt801282/www/.ht_mysql.inc");
$bdd = new PDO("mysql:host=localhost;dbname=$base", $user, $password);
$bdd->exec('SET NAMES utf8');


include('outils_trombi.php');
?>