<?php
	//=========================================================================================================
	//page utilisée pour faire aboutir les utilisateurs essayant de visiter un profil non-existant
	//=========================================================================================================
	
	include('base_include.php');
	include('base_html.php');
	include('header.php');
	
	
?>
	<h1>Erreur 404</h1>
	<h3>Mais comment êtes vous arrivé là !?</h3>
	
	<?php if( key($_GET) == 'pfl_unk')
		echo "<p>erreur, profil non-trouvé</p>";
	?>