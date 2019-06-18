<?php 
include('base_include.php');


//etat relation à 2 car état = bloqué

if (empty(requete_SQL("SELECT * FROM RELATIONS WHERE membre_omega={$_SESSION['id_compte']} AND membre_alpha={$_SESSION['dernier_profil_visite']} OR membre_omega={$_SESSION['dernier_profil_visite']} AND membre_alpha={$_SESSION['id_compte']}")) )
	{	//s'il n'existe pas de relation on la créer avec l'état = 3 (bloqué)
		requete_SQL("INSERT INTO `pt801282`.`RELATIONS` (`membre_alpha`, `membre_omega`, `Etat_Relation`) VALUES ( {$_SESSION['id_compte']}, {$_SESSION['dernier_profil_visite']}, 2)");
		
		
		
	} else {
		//s'il existe déjà une relation entre les deux personnes à bloquer, on change seulement le champ de l'état par 3 == bloqué
		requete_SQL("UPDATE `pt801282`.`RELATIONS` SET `Etat_Relation` = '2' WHERE membre_omega={$_SESSION['id_compte']} AND membre_alpha={$_SESSION['dernier_profil_visite']} OR membre_omega={$_SESSION['dernier_profil_visite']} AND membre_alpha={$_SESSION['id_compte']}");
		
		
	}
	
	header('Location:'.$_SERVER['HTTP_REFERER']);
	exit();
?>