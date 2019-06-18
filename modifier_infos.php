<?php
	//=========================================================================================================
	//page de traitement utilisée pour modifier dans la BDD les informations et paramètres de l'utilisateur
	//=========================================================================================================

	session_start();
	
	if ($_SESSION['nom_compte'] == '' ){
		header('Location:index.php?msg=inv');
		exit();
	}
		
	include("/home/rtel/etu/rt2018/pt801282/www/.ht_mysql.inc");
	$bdd = new PDO("mysql:host=localhost;dbname=$base", $user, $password);
	$bdd->exec('SET NAMES utf8');	

	$sql = "UPDATE `pt801282`.`PERSONNES` SET `Param_Visibilite_Publi` = '{$_POST['Param_Visibilite_Publi']}' WHERE `PERSONNES`.`Id_Utilisateur` = {$_SESSION['id_compte']}";
	$req = $bdd->prepare($sql);
	$req->execute();
	$req->closeCursor();

	$_SESSION['Param_Visibilite_Publi'] = $_POST['Param_Visibilite_Publi'];

	header('Location:'.$_SERVER['HTTP_REFERER'].'?succes');
	exit();







?>