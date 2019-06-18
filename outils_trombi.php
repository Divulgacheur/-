<?php
	//=========================================================================================================
	//page à inclure regroupant diverses fonctions
	//=========================================================================================================


include("/home/rtel/etu/rt2018/pt801282/www/.ht_mysql.inc");

$bdd = new PDO("mysql:host=localhost;dbname=$base", $user, $password);
$bdd->exec('SET NAMES utf8');

function url_photo_profil($id_profil, $dossier){ //permet de trouver le fichier de la photo de profil de l'utilisateur donné
	$trouve = false;
	foreach( scandir("./".$dossier ) as $fic){ 	//recherche les images portant l'id de l'utilisateur
		$nom_fichier_parcouru = explode('.' , $fic );
		if ( $nom_fichier_parcouru[0] == "img_".$id_profil ){
			return $fic;
			$trouve = true;
			break;
		}
	}
	if (!$trouve)
		return "img_defaut.jpg";
}

function requete_SQL($string_requete){ //fonction permettant d'entrer directement des instructions SQL qui seront exécutées [et dont le résultat sera retourné]
	global $bdd;
	$req = $bdd->prepare($string_requete);
	$req->execute();
	$resultat_requete =$req->fetchall(PDO::FETCH_ASSOC);
	$req->closeCursor();
 

	return $resultat_requete;
}

function requete_SQL_secu($string_requete,$tab_marqueurs){ //fonction permettant d'entrer directement des instructions SQL qui seront exécutées [et dont le résultat sera retourné]
	global $bdd;
	$req = $bdd->prepare($string_requete);
	$req->execute($tab_marqueurs);	// utilisation des marqueurs nominatifs pour lutter contre les injections SQL
	$resultat_requete =$req->fetchall(PDO::FETCH_ASSOC);
	$req->closeCursor();
 

	return $resultat_requete;
}

function listeRep($unRep) {
	    $allFic=array();
	    if (is_dir($unRep) == FALSE) {
	        echo "{$unRep} n'est pas un répertoire !";
	    }
	    else {
	    	$rep = opendir($unRep);
	    	if ($rep == FALSE) {
	    	    echo "Impossible d'ouvrir le répertoire {$unRep}";
	    	}
	    	else {
	    	    while (($fic = readdir($rep)) == TRUE) {
					if ($fic != '.' && $fic!='..') $allFic[]=$fic;
	    	    }
	    	    closedir($rep);
	    	    sort($allFic);
	    	}
	    }
	    return $allFic;
	}


function trad_duree_temps($temps){
	$temps = new DateTime($temps);
	
	$date_actuelle = new DateTime();
	
	
	$diff = $date_actuelle->getTimestamp() - $temps->getTimestamp() ;
	  	
	if ($diff < 60)
		return "à l'instant";
	elseif ( $diff < 3600)
		return "il y a ".floor($diff/60)." minutes ";
	elseif ( $diff < 60*60*2)
		return "il y a une heure ";
	elseif ( $diff < 60*60*24)
		return "il y a ".floor($diff/3600)." heures ";	
	elseif ( $diff < 60*60*24*2)
		return "hier ";
	elseif ( $diff < 60*60*24*30)
		return "il y a ".floor($diff/(3600*24))." jours ";
	elseif ( $diff < 60*60*24*30*12)
		return "il y a ".floor($diff/(3600*24*30))." mois. ";
	elseif ( $diff < 60*60*24*30*12*100)
		return "il y a ".floor($diff/(3600*24*30*12))." ans. ";	
}

$tab_trad_visibilite = array('Moi uniquement' , 'Amis' , 'Amis et leurs amis' , 'Tout le monde');

function debug($tab){
	echo "<pre>";
	print_r($tab);
	echo "</pre>";
}
?>