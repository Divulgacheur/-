<?php
	//=========================================================================================================
	//page de traitement utilisée pour déplacer et renommer les images uploadés par l'utilisateur 
	//=========================================================================================================

session_start();

$nom_fic = (explode('.' , $_FILES[$_POST['submit']]["name"] ) );
$nom_fichier = "img_".$_SESSION["id_compte"] . "." . end($nom_fic); //le nom du fichier téléchargé sera img_x avec l'extension avec laquelle il a été téléchargé
$cible_fichier = "./".$_POST['submit']."/" . $nom_fichier;

 
$rep = opendir("./".$_POST['submit']."/");
	
if( $_FILES[$_POST['submit']]["error"]==0 ){ //si un fichier a bien été téléchargé sans erreurs
	while (($fic = readdir($rep)) == TRUE){ //on lit les fichiers du répertoire de destination

		$parties = explode('.',$fic); //on regarde seulement le nom du fichier sans l'extension
		
		if($parties[0] == "img_".$_SESSION["id_compte"] ) //s'il existe déjà une image de l'utilisateur
			unlink("./".$_POST['submit']."/".$fic); //on la supprime
			//on supprime toutes les images de l'utilisateur avant d'ajouter la nouvelle, car les anciennes ne sont pas forcement écrasées notamment en cas d'extensions différentes
	}
}

if (move_uploaded_file( $_FILES[$_POST['submit']]['tmp_name'], $cible_fichier)){ //si le fichier téléchargé a été correctement déplacé dans la bonne destination
	header('Location:parametres.php?img_succes');
	exit();
} else {
	header('Location:parametres.php?img_echec');
	exit();
}
?>