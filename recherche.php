<?php 
	//=========================================================================================================
	//page utilisée pour afficher les résultats d'une recherche d'un utilisateur
	//=========================================================================================================

	$title = "Trombinouc - Recherche";
	include('base_include.php');
	include('base_html.php');
	include('header.php');	
	?>
	
	<h2>Résultat de la recherche “<?php
	$recherche_decompose = explode(' ',htmlspecialchars($_GET['r']));
	
	echo htmlspecialchars($_GET['r']) . "”</h2>";
	
	$resultat = requete_SQL("SELECT Id_Utilisateur,Prenom_Utilisateur,Nom_Utilisateur FROM `PERSONNES` WHERE `Prenom_Utilisateur` 
	LIKE '%".htmlspecialchars($_GET['r'])."%' OR `Nom_Utilisateur` LIKE '%".htmlspecialchars($_GET['r'])."%' OR ('".$recherche_decompose[0]."' LIKE Prenom_Utilisateur AND '".$recherche_decompose[1]."' LIKE Nom_Utilisateur)");

	
	foreach( $resultat as $un_resultat){
		echo "<a href='profil.php?id=" . $un_resultat['Id_Utilisateur'] ."'><img class='img_profil_s' src='./Images_Profil/" ;
		echo url_photo_profil($un_resultat['Id_Utilisateur'], "Images_Profil");
		echo "' alt >";
		echo $un_resultat['Prenom_Utilisateur'] . " " . $un_resultat['Nom_Utilisateur'] . "</a><br>\n";
	}
	
	if ( empty($resultat) )
		echo "Aucun résultat.";
	
?>