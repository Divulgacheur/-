<?php
	include('base_include.php');
	
	$marqueurs = array('expediteur'=>$_SESSION['id_compte'] , 'destinataire'=>$_POST['destinataire'] , 'contenu_msg'=>$_POST['contenu_msg'] );
	requete_SQL_secu("INSERT INTO `pt801282`.`MESSAGES` (`Id_Expediteur`, `Id_Destinataire`, `Contenu_Message`, `Date_Message`) VALUES (:expediteur, :destinataire, :contenu_msg, CURRENT_TIMESTAMP )" , $marqueurs);

	header('Location:'.$_SERVER['HTTP_REFERER']);
	exit();
	
?>