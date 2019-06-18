<?php
	//===========================================================================================================================
	//page où tout utilisateur est rédirigé s'il essaye de visiter le profil d'un utilisateur qu'il a bloqué ou qu'il l'a bloqué
	//===========================================================================================================================

	include('base_include.php');
	include('base_html.php');
	include('header.php');
	
	if (key($_GET) == 'par_moi')
		echo "Vous avez bloqué ce profil";
	elseif (key($_GET) == 'par_lui')
		echo "Vous ne pouvez pas voir ce profil car vous avez été bloqué";
		
		
?>