<?php
	//=========================================================================================================
	//page utilisée pour afficher l'ensemble des fichiers images présents dans le répertoire 'Galerie'
	//=========================================================================================================
	
	$title = "Galerie - Trombinouc";
	include('base_include.php');
	include('base_html.php');
	include('header.php');
	

	
	foreach(listeRep('./Galerie') as $fic)
		echo "<img width=300 src='./Galerie/{$fic}' >";
		
		
