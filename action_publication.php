<?php
include('base_include.php');
	//=========================================================================================================
	//page de traitement utilisée pour supprimer ou commenter une publication
	//=========================================================================================================
	
if ( isset($_POST['a_supprimer'])  ){	//si l'action à effectuer sur la publication est une suppression
	
	$sql = "DELETE FROM `pt801282`.`PUBLICATIONS` WHERE `PUBLICATIONS`.`Id_Publication` =" . $_POST['a_supprimer']; 
	$req = $bdd->prepare($sql);
	$req->execute();
	$req->closeCursor();

} else if ( key($_POST) == 'reponse' ){ //si l'action à effectuer sur la publication est un commentaire
	
	$marqueurs = array('publi'=>$_POST['id_publication'] , 'auteur'=>$_SESSION['id_compte'] , 'contenu'=>$_POST['reponse'] );
	requete_SQL_secu("INSERT INTO `pt801282`.`COMMENTAIRES`
	(`Id_Publication_Associe`, `Id_Auteur`, `Texte_Commentaire`)
	VALUES (:publi, :auteur, :contenu ) ", $marqueurs );

}

header('Location:'.$_SERVER['HTTP_REFERER']);
exit();

?>