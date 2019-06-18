<?php
	include('outils_trombi.php');
	//=========================================================================================================
	//page de traitement & normale, utilisée pour enregistrer les nouvelles inscriptions dans la BDD
	//=========================================================================================================

	
	if ( strlen( $_POST['mois_naiss_inscription'] )  < 2 )
		$_POST['mois_naiss_inscription'] = '0'.$_POST['mois_naiss_inscription'] ;
	
	$date_naissance = $_POST['jour_naiss_inscription']."-".$_POST['mois_naiss_inscription']."-".$_POST['annee_naiss_inscription'] ;
	
	$random_bin_mail = bin2hex(openssl_random_pseudo_bytes(10)); // permet de générer la clé de vérification de mail, 10 caractères hexa

	
	$marqueurs = array('mdp'=>$_POST['mdp_inscription'] , 'prenom'=>$_POST['prenom_inscription'] , 'nom'=> $_POST['nom_inscription'] , 'date_naiss'=>$date_naissance , 'mail'=>$_POST['mail_inscription'] , 'cle_mail'=>$random_bin_mail);
	requete_SQL_secu("INSERT INTO `pt801282`.`PERSONNES` 
	(`Mdp_Utilisateur`, `Prenom_Utilisateur`, `Nom_Utilisateur`, `Anniversaire_Utilisateur`, `Mail_Utilisateur` , Mail_Confirme)
	VALUES ( :mdp , :prenom , :nom , :date_naiss , :mail , :cle_mail ) " , $marqueurs );
	
	$texte_mail = "<html>
	<head>
	<title>HTML email</title>
	</head>
	<body>
	<h1>Valider votre inscription sur Trombinouc</h1><p>en cliquant <a href='http://isis.unice.fr/~pt801282/ext/M2105_PHP/Trombinouc_v1.2/valid.php?cle=".$random_bin_mail."'>ici</a></p>
	</body>
	</html>" ;
	
	
	mail($_POST['mail_inscription'], 'Validation inscription Trombinouc', $texte_mail, "MIME-Version: 1.0" . "\r\n". "Content-type:text/html;charset=UTF-8" . "\r\n" . "From: <trombinouc@nepasrepondre.fr>" . "\r\n");
	$title = "Inscription - Trombinouc";
	include('base_html.php'); 
?>
		<header>
			<p>Inscription</p>
		</header>
					
		<section>
			<div class="alert alert-primary" role="alert">Votre inscription a bien été enregistrée !<br>
			Confirmez-la en naviguant vers le lien qui vous a été envoyé par email.</div>
		</section>
			
		<a role="button" href="index.php" class="btn btn-primary btn-lg">Accueil</a>

 
		
			
			
			
		</section>
	</body>
</html>