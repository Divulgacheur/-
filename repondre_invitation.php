<?php
	//=========================================================================================================
	//page de traitement permettant à un utilisateur de répondre positivement ou non à une requête d'ami reçue
	//=========================================================================================================
	include('base_include.php');
	
	if( key($_POST) == 'oui'){ // si l'utilisateur a cliqué sur le bouton accepter (name='oui')
		
		$requete_acceptation="INSERT INTO `pt801282`.`RELATIONS`
		(`membre_alpha`, `membre_omega`, `date_debut_relation`, `Etat_Relation`) 
		VALUES ( '{$_SESSION['id_compte']}', '{$_POST[membre_alpha]}', CURRENT_TIME(), 0 ) ";
		//on ajoute la seconde relation dans la table, avec l'etat "amis" (0)

		$req1 = $bdd->prepare($requete_acceptation);
		$req1->execute();
		$req1->closeCursor();
		
		//on met à jour la premiere relation qui était à l'état 'demande'
		$req_seconde="UPDATE `pt801282`.`RELATIONS` SET `Etat_Relation` = '0'
		WHERE `RELATIONS`.`id_relation` = {$_POST['id_relation']}";
		
		$req1 = $bdd->prepare($req_seconde);
		$req1->execute();
		$req1->closeCursor();
		
		header("Location:amis.php");
		exit();
		
	} elseif ( key($_POST) == 'non'){ // si l'utilisateur a cliqué sur le bouton refuser (name='non')
		
		echo "requete refusée";
	} else {
		header('Location:erreur_404.php');
		exit();
	}
?>