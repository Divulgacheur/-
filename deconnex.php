<?php
	//=========================================================================================================
	//page de traitement utilisée pour la déconnexion
	//=========================================================================================================
	
	session_start();
	// Ici le code PHP qui détruit la session ...
	$_SESSION = [];
	session_destroy();
	//setcookie('PHPSESSID',"",time()-3600,'/');
	// Le cookie de session reste malgré le session_destroy, je n'ai donc
	// trouvé que ce moyen pour le détruire, car déconnexion ne se fait pas
	// autrement
	
	header('Location:index.php?msg=deco');
	exit();
?>