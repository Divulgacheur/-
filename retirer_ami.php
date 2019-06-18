<?php 
	//=========================================================================================================
	//page de traitement permettant de retirer un utilisateur de sa liste d'amis
	//=========================================================================================================

include('base_include.php');

requete_SQL("DELETE FROM `pt801282`.`RELATIONS` WHERE `RELATIONS`.`membre_omega` =".$_SESSION['id_compte']." AND `membre_alpha` = ".$_SESSION['dernier_profil_visite']) ;
requete_SQL("DELETE FROM `pt801282`.`RELATIONS` WHERE `RELATIONS`.`membre_alpha` =".$_SESSION['id_compte']." AND `membre_omega` = ".$_SESSION['dernier_profil_visite']) ;

header('Location:amis.php');
exit();
?>