<?php 
	//=========================================================================================================
	//page de traitement utilisée pour vérifier les informations saisies par un utilisateur souhaitant se connecter
	//=========================================================================================================
	
	include("outils_trombi.php");

	$resultat_mail= requete_SQL_secu("SELECT * FROM `PERSONNES` WHERE Mail_Utilisateur = :login" , array('login'=> $_POST['login']) );

if ($resultat_mail[0]['Mdp_Utilisateur'] == $_POST['mdp']){
	session_start();
	$_SESSION["nom_compte"]=$resultat_mail[0]['Nom_Utilisateur'];
	$_SESSION["prenom_compte"]=$resultat_mail[0]['Prenom_Utilisateur'];
	$_SESSION["id_compte"]=$resultat_mail[0]['Id_Utilisateur'];
	$_SESSION["date_naiss"]=$resultat_mail[0]['Anniversaire_Utilisateur'];
	$_SESSION['Param_Visibilite_Publi']=$resultat_mail[0]['Param_Visibilite_Publi'];
	header('Location:profil.php');
	exit();
	
} else {
	header('Location:index.php?msg=err');
	exit();
}
	

?>