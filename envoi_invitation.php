<?php
	//=========================================================================================================
	//page de traitement utilisée pour enregistrer dans la BDD une invitation envoyée à un utilisateur
	//=========================================================================================================
	
	session_start();

	if ($_SESSION['nom_compte'] == '' ){
		header('Location:index.php?msg=inv');
		exit();
	}
	
	
	include("/home/rtel/etu/rt2018/pt801282/www/.ht_mysql.inc");
	$bdd = new PDO("mysql:host=localhost;dbname=$base", $user, $password);
	$bdd->exec('SET NAMES utf8');
	
	
	//pour envoyer une invitation, on ajoute une entrée dans RELATIONS
	
	$requete_ajout_relation_sens1="INSERT INTO `pt801282`.`RELATIONS`
	(`membre_alpha`, `membre_omega`, `date_debut_relation`, `Etat_Relation`) 
	VALUES ('".$_SESSION['id_compte']."', '".key ( $_POST )."', CURRENT_TIME(), 1 ) ";
	//on ajoute la relation dans la table, avec l'etat "en attente d'acceptation" (1)

	
	
	$req1 = $bdd->prepare($requete_ajout_relation_sens1);
	$req1->execute();
	$req1->closeCursor();
	
	header("Location:amis.php");
	exit();
?>