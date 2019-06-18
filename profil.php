<?php
	//=========================================================================================================
	//page utilisée pour visualiser son profil ou celui de n'importe quel utilisateur de Trombinouc
	//=========================================================================================================

	include('base_include.php');

	$ami_avec_lui = false;
	//on fait requête SQL pour chercher si id $_GET corrrespond à qq dans PERSONNES
	
	$resultat_utilisateur = requete_SQL("SELECT * FROM `PERSONNES` WHERE `Id_Utilisateur` = {$_GET['id']} ");
	
	
	
	if( empty($_GET) || $resultat_utilisateur[0]['Id_Utilisateur']==$_SESSION["id_compte"] ){
		//si $_GET vide ou $_GET contient notre id, c'est donc qu'on regarde notre profil, c'est bon
		
		define ('NOM' , $_SESSION["nom_compte"] );
		define ('PRENOM' , $_SESSION["prenom_compte"] );
		define ('ID_PROFIL' , $_SESSION["id_compte"] );
		
		$est_ce_mon_profil = true;
		$niveau_relation = 0;
		$title = "Mon profil";
		
	} elseif( !empty($resultat_utilisateur) ){
		//si URL comporte id utilisateur existant, c'est bon
		
		define ('PRENOM' , $resultat_utilisateur[0]['Prenom_Utilisateur']);
		define ('NOM' , $resultat_utilisateur[0]['Nom_Utilisateur'] );
		define ('ID_PROFIL' , $resultat_utilisateur[0]['Id_Utilisateur'] );
		$_SESSION['dernier_profil_visite'] = ID_PROFIL;
		$title = "Profil de " . PRENOM . " " . NOM;
		$est_ce_mon_profil = false;
		
		
		if(!empty(requete_SQL("SELECT * FROM RELATIONS WHERE membre_alpha=".ID_PROFIL." AND membre_omega={$_SESSION['id_compte']} AND Etat_Relation=2")) ){
			header('Location:profil_bloque.php?par_lui');
			exit();
		}
		
		if(!empty(requete_SQL("SELECT * FROM RELATIONS WHERE membre_omega=".ID_PROFIL." AND membre_alpha={$_SESSION['id_compte']} AND Etat_Relation=2") )){
			header('Location:profil_bloque.php?par_moi');
			exit();
		}
		 
		$amis = requete_SQL("SELECT Id_Utilisateur, Etat_Relation
		FROM `RELATIONS` INNER JOIN PERSONNES ON `membre_omega`=Id_Utilisateur 
		WHERE `membre_alpha`={$_SESSION['id_compte']} AND Etat_Relation=0 ");

		// on regarde si l'utilisateur connecté est ami avec le profil visualisé
		
		foreach($amis as $ami){ 
		
			if (ID_PROFIL ==$ami['Id_Utilisateur']){
				$ami_avec_lui = true;
				$niveau_relation = 1;
				 
				break;
			}
		}
			if (!$ami_avec_lui){
			
		
			$sql="SELECT Nom_Utilisateur, Prenom_Utilisateur, Id_Utilisateur
			FROM `RELATIONS` INNER JOIN PERSONNES ON `membre_omega`=Id_Utilisateur 
			WHERE `membre_alpha`=".$_SESSION["id_compte"]." AND Etat_Relation=0 AND Id_Utilisateur IN
			(SELECT Id_Utilisateur
			FROM `RELATIONS` INNER JOIN PERSONNES ON `membre_omega`=Id_Utilisateur 
			WHERE `membre_alpha`=".ID_PROFIL." AND Etat_Relation=0)";
			$req = $bdd->prepare($sql);
			$req->execute();	//requete retournant les amis en commun entre l'utilisateur connecté et le profil visté
			$amis_en_commun =$req->fetchall(PDO::FETCH_ASSOC);
			$req->closeCursor(); 
		
			if (empty($amis_en_commun))
				$niveau_relation = 3;
			else
				$niveau_relation = 2;
	}
		
	} else { //si l'id du profil donné dans l'URL n'existe pas, c'est pas bon
		
		header('Location:erreur_404.php?pfl_unk');
		exit();
	}
	
	include('base_html.php');
	include('header.php');
	
?>

	

	<img class="img-fluid " src="./Images_Couverture/<?php echo url_photo_profil(ID_PROFIL, "Images_Couverture") ?>" alt><br>
	<div class='row'>
		<div class='col-md-1 col-2'></div>
		<div class='col-md-3 col-8 float-middle'>
			<img class="img_profil img-fluid" src='./Images_Profil/<?php echo url_photo_profil(ID_PROFIL, "Images_Profil"); ?>' alt>
		</div>
		<div id='nom_profil' class='col-md-6' >
		
	
<?php if (!$est_ce_mon_profil) echo "<div class='dropdown'>
	<button class='btn dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>"; ?>
	<span class='nom_profil'><?php echo PRENOM." ".NOM; ?></span>
		</button>

<?php if (!$est_ce_mon_profil){ echo "<div class='dropdown-menu' aria-labelledby='dropdownMenuButton'><a class='dropdown-item' href='messenger.php?id=".ID_PROFIL."'>Message privé</a>";
			if ($ami_avec_lui) echo "<a class='dropdown-item' href='retirer_ami.php'>Retirer des mes amis</a>";
			echo "<a class='dropdown-item' href='#'>Signaler</a>
		<a class='dropdown-item' href='bloquer_qq.php'>Bloquer</a>
		</div></div>"; } ?>
		
	<p><?php if ( $niveau_relation == 2){ echo "Vous avez " . count($amis_en_commun) . " amis en commun.<br>" ;
		foreach($amis_en_commun as $un_ami_en_commun) echo "<img class='img_profil_s' src='./Images_Profil/".url_photo_profil($un_ami_en_commun['Id_Utilisateur'],"Images_Profil")."' alt>" ; 
	} else if ($niveau_relation == 3) echo "Aucun amis en commun" ;?></p>
	
	
	</div>
	<div class='col-md-2' >
	<?php if (!$est_ce_mon_profil && $ami_avec_lui) echo "<div id='etiquette_amis'>Amis&nbsp;<img src='../Images/check_symbole.png' alt></div>";
	//permet d'afficher le nom du profil et une étiquette indiquant si on est amis avec lui ?>
		</div>
	</div>
	<br>
	<?php echo "vous êtes donc un $tab_trad_visibilite[$niveau_relation]" ?>
	<form method='POST' action='./publier.php'>
		<p>
		<textarea class='form-control' id='contenu_publication' name='contenu_publication' autocomplete="off" placeholder='<?php if($est_ce_mon_profil) echo "Exprimez-vous..." ; else echo "Publiez sur le journal de ". PRENOM; ?>'  rows='8' cols='50' required ></textarea>
		</p>
		<div class='form-row'>
			<div class="col-md-9 mb-3">
			<?php if ($est_ce_mon_profil){
				echo "<select class='custom-select' name='visibilite_publication' id='visibilite_publication' >";

				foreach($tab_trad_visibilite as $un => $une ){ //affiche les différents niveaux de confidentialité de la publication
					echo "<option value={$un} style='background-image:url(./icones/visib{$un}.png);'"; //affiche par défaut le paramètre du compte
					if ( $un == $_SESSION['Param_Visibilite_Publi'] )
						echo " selected";
					echo " >$une</option>";
				}
			}				
			?>
			</select></div>
			<div class="col-md-3 mb-3">
			<button class='btn btn-primary btn-block' id='envoi_publication' name='envoi_publication' type='submit' value='envoi'>Publier</button>
			</div>
		</div>
		
		<input type="hidden" name="id_profil_destination" value="<?php echo ID_PROFIL ?>">
		</form>
		<br><br><br><br> 
	
	
<?php
	$resultat_publications= requete_SQL("SELECT *, TIMESTAMP(`Date_Publication`) AS `Date_Pub`
	FROM `PUBLICATIONS` INNER JOIN `PERSONNES` ON Id_Auteur=Id_Utilisateur WHERE `Id_Destinataire_Publication`= ".ID_PROFIL."
	 AND `Visibilite_Publication` >= $niveau_relation ORDER BY `PUBLICATIONS`.`Date_Publication` DESC");

			
		
	foreach( $resultat_publications as $num_publication => $une_publication ){ //pour chaque publication
		echo "<div class='media mt-3'>";
			echo "<div class='ml-2'>";
				echo "<img class='img_profil_s mr-3' src='./Images_Profil/"; //affiche image profil auteur
				echo url_photo_profil($une_publication['Id_Utilisateur'], 'Images_Profil') . "' alt ></div> ";
			echo "<div class='media-body'>" ;
				echo "<h6><a href='profil.php?id=". $une_publication['Id_Utilisateur']."'>". $une_publication['Prenom_Utilisateur']." ".$une_publication['Nom_Utilisateur']."</a>\n";
				// affiche auteur publication avec lien vers son profil
			echo "<small>a publié <span class='date' title='le ".date("d/m/Y à H:i",strtotime($une_publication['Date_Publication']))."'>".trad_duree_temps( $une_publication['Date_Publication'] )."</span></small>";
			if($est_ce_mon_profil){
				echo "<img title='visible pour ".$tab_trad_visibilite[$une_publication['Visibilite_Publication']]."' class='float-right' src='icones/visib".$une_publication['Visibilite_Publication'].".png'>";
			}
			
			echo "</h6>";
			echo "<p>".$une_publication['Texte_Publication']."</p>\n";
		
			echo "<form autocomplete='off' method='post' action='./action_publication.php' >";
				
				echo "<div id='emplacement_reponse$num_publication' class='emplacement_reponse input-group mb-3 input-group-sm' >";
					echo "<input class='form-control reponse'  placeholder='Votre réponse...' name='reponse'>";
					echo "<div class='input-group-prepend'><button class='input-group-text '>Envoyer</button></div></div>";
					echo "<div class='btn-group btn-group-sm' role='group'>";
					echo "<button class='toggle_reponse btn btn-secondary' type='button' onclick='toggle_reponse($num_publication)'>commenter</button>";
					echo "<input name='id_publication' value='".$une_publication['Id_Publication']."' type='hidden' >";
				if ($est_ce_mon_profil)		//affiche les publications, date/heure, auteur et bouton pour supprimer si c'est votre profil
					echo "<button type='submit' class='btn btn-secondary'  name='a_supprimer' value='".$une_publication['Id_Publication']."'>supprimer</button>\n";
		echo "</div>\n</form>\n";
		
	$commentaires= requete_SQL("SELECT Texte_Commentaire, Prenom_Utilisateur, Nom_Utilisateur, Date_Commentaire, Id_Auteur
	FROM `COMMENTAIRES` INNER JOIN PERSONNES ON `Id_Auteur`=Id_Utilisateur 
	WHERE `Id_Publication_Associe` = ". $une_publication['Id_Publication'] );

	//requete retournant les commentaires associés à la publication

	//echo "<pre>";
	//print_r($commentaires);
	//echo "</pre>";
	
	foreach($commentaires as $un_commentaire){ //pour chaque commentaire
		
		echo "<div class='media mt-2'>";
						echo "<div class='media-left'>";
				echo "<img class='img_profil_s mr-3' src='./Images_Profil/";
				echo url_photo_profil($un_commentaire['Id_Auteur'], 'Images_Profil') . "' alt ></div> ";
			echo "<div class='media-body'>" ;
				echo "<h6><a href='profil.php?id=". $un_commentaire['Id_Auteur']. "'>". $un_commentaire['Prenom_Utilisateur']." ".$un_commentaire['Nom_Utilisateur']."</a>\n";
				// affiche auteur publication avec lien vers son profil
			echo "<small>a commenté <span class='date' title='le ".date("d/m/Y à H:i",strtotime($un_commentaire['Date_Commentaire']))."'>".trad_duree_temps( $un_commentaire['Date_Commentaire'] )."</span></small></h6>";
			echo $un_commentaire['Texte_Commentaire']."\n";
			echo "</div></div>";
		
	}
	
		//pour chaque publication on affiche les commentaires associées
		echo "<br><br></div></div>";

	}
		
?>
	
	</div>
	
<?php include('footer.php'); ?>
		
	<script>
	function toggle_reponse(nb) {
		var x = document.getElementById("emplacement_reponse"+nb);
		if (window.getComputedStyle(x).display == "none") {
			x.style.display = "flex";
		} else {
			x.style.display = "none";
		}
	}
	</script>
		
