<?php
	//explication champ Etat_Relation : 0=amis , 1=en attente d'acceptation , 2=bloque
	
	include('base_include.php');
		
		$requete_ajout_relation_sens1="INSERT INTO `pt801282`.`RELATIONS`
		(`membre_alpha`, `membre_omega`, `date_debut_relation`, `Etat_Relation`) 
		VALUES ('".key ( $_POST )."', '".$_SESSION['id_compte']."', CURRENT_TIME(), 1 ) ";
		//on ajoute la relation dans la table, avec l'état "en attente d'acceptation" (1)
		$requete_ajout_relation_sens2="INSERT INTO `pt801282`.`RELATIONS`
		(`membre_alpha`, `membre_omega`, `date_debut_relation`,`Etat_Relation`) 
		VALUES ('".$_SESSION['id_compte']."', '".key( $_POST )."', CURRENT_TIME() , 1) ";
		
		$req1 = $bdd->prepare($requete_ajout_relation_sens1);
		$req1->execute();
		$req1->closeCursor();
		
		$req2 = $bdd->prepare($requete_ajout_relation_sens2);
		$req2->execute();	
		$req2->closeCursor();


	header('Location:amis.php');
	exit();

?>