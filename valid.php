<?php
	include("outils_trombi.php");	
	
	//=========================================================================================================
	//page de traitement utilisée pour la vérification des adresses mail à la création d'un compte utilisateur
	//=========================================================================================================
	
	$resultat = requete_SQL("SELECT * FROM PERSONNES WHERE Mail_Confirme='".$_GET['cle'] ."'");
	//la clé transmise dans $_GET en suivant le lien reçu par mail est vérifiée
	
	if ( !empty( $resultat) ){
		//si cette clé corrrespond à un utilisateur existant
		requete_SQL("UPDATE `pt801282`.`PERSONNES` SET `Mail_Confirme` = 'True' WHERE `PERSONNES`.`Id_Utilisateur` = " . $resultat[0]['Id_Utilisateur']);
		//on remplace la valeur du champ Mail_Confirme de l'utilisateur par True
		
		header('Location:index.php?msg=verif_mail_succes');
		exit();
	}
	else {
		header('Location:index.php?msg=verif_mail_echec');
		exit();
	}
		