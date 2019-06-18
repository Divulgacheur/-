<?php
	include('base_include.php');
		
	//=========================================================================================================
	//page de traitement utilisée pour enregistrer dans la BDD les informations entrées par l'utilisateur pour créer une nouvelle publication
	//=========================================================================================================
	
	
	$sql = "INSERT INTO `pt801282`.`PUBLICATIONS` 
	( `Id_Auteur`, `Texte_Publication`, `Id_Destinataire_Publication`, `Visibilite_Publication`)
	VALUES (".$_SESSION['id_compte'].", '" . addslashes($_POST['contenu_publication']) . "', '".$_POST['id_profil_destination']."', '{$_POST['visibilite_publication']}' )";
	$req = $bdd->prepare($sql);
	$req->execute();
	$req->closeCursor();
	
	header('Location:'.$_SERVER['HTTP_REFERER']);
	exit();
	
	
	
	
	?>
