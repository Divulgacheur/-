<?php
	//=========================================================================================================
	//page utilisée pour afficher toutes les dernières publications de nos amis
	//=========================================================================================================
	
include('base_include.php');
include('base_html.php');
include('header.php');
?>

<br><br>
<div class="row"> 
 <div class="col-md-6">
<?php



//on affiche tous les publications des  personnes amis avec nous 

echo $sql = "SELECT * FROM PUBLICATIONS WHERE Visibilite_Publication >= 1 AND Id_Auteur IN ( SELECT membre_omega
		FROM `RELATIONS` WHERE `membre_alpha`=".$_SESSION['id_compte']." AND Etat_Relation=0 )";
 $req = $bdd->prepare($sql);
 $req->execute();
$publication_amis =$req->fetchall(PDO::FETCH_ASSOC);
$req->closeCursor();
 
 //echo "Publications de vos amis $publication_amis.";
	echo "<pre>";
 print_r ($publication_amis);
	echo "</pre>";
	
	
	foreach( $publication_amis as $num_publication => $une_publication ){ //pour chaque publication
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