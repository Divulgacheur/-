<?php
	$title = "Amis";
	include('base_include.php');
	include('base_html.php');
	include('header.php');
?>

	<br><br>
	<div class="row"> 
		<div class="col-md-6">
<?php

			
		
		//on compte tous les amis que notre compte possède, et qui sont bien à l'état 0 (amis confirmés) 
		$sql="SELECT COUNT(id_relation) FROM `RELATIONS` WHERE `membre_alpha`=" . $_SESSION['id_compte']." AND Etat_Relation=0" ;
		$req = $bdd->prepare($sql);
		$req->execute();	//requete retournant le nombre d'amis de l'utilisateur actuellement connecté
		$nb_ami =$req->fetchall(PDO::FETCH_ASSOC);
		$req->closeCursor();
		$nb_ami=$nb_ami[0]['COUNT(id_relation)'];
		?>
		
		
		
		<?php 
		
		$sql='SELECT Prenom_Utilisateur, Nom_Utilisateur, Id_Utilisateur
		FROM `RELATIONS` INNER JOIN PERSONNES ON `membre_omega`=Id_Utilisateur 
		WHERE `membre_alpha`='.$_SESSION['id_compte'].' AND Etat_Relation=0';
		$req = $bdd->prepare($sql);
		$req->execute();	//requete retournant les noms de amis de l'utilisateur actuellement connecté
		$amis =$req->fetchall(PDO::FETCH_ASSOC);
		$req->closeCursor();
		?>
		Vous avez <?php echo count($amis) ?> amis.
		<?php
		foreach ($amis as $liste)
			echo "<br><a href='profil.php?id=".$liste['Id_Utilisateur']."'>".$liste['Prenom_Utilisateur']." ".$liste['Nom_Utilisateur']."</a><br>";


		echo "</div>";


		$sql="SELECT Prenom_Utilisateur, Nom_Utilisateur, Id_Utilisateur
		FROM `PERSONNES` WHERE Id_Utilisateur NOT IN 
		(SELECT `membre_alpha` FROM RELATIONS WHERE `membre_omega`=".$_SESSION['id_compte']." )
		AND Id_Utilisateur NOT IN 
		(SELECT `membre_omega` FROM RELATIONS WHERE `membre_alpha`=".$_SESSION['id_compte']." )
		AND NOT Id_Utilisateur=".$_SESSION['id_compte'];

		$req = $bdd->prepare($sql);
		$req->execute();	//requete retournant les noms des personnes avec lesquelles l'utilisateur actuellement connecté n'est pas ami
		$pas_amis =$req->fetchall(PDO::FETCH_ASSOC);
		$req->closeCursor();


		echo "<div class='col-md-6'>";
		
		echo "Invitations reçues<br><br>";
		
		$sql='SELECT id_relation, membre_alpha, Prenom_Utilisateur, Nom_Utilisateur, Id_Utilisateur
		FROM `RELATIONS` INNER JOIN PERSONNES ON `membre_alpha`=Id_Utilisateur 
		WHERE `membre_omega`='.$_SESSION['id_compte'].' AND Etat_Relation=1';

		$req = $bdd->prepare($sql);
		$req->execute();	//requete retournant les personnes dont l'utilisateur actuellement connecté a reçu des demandes d'ami
		$invitations =$req->fetchall(PDO::FETCH_ASSOC);
		$req->closeCursor();
		
		foreach($invitations as $une){
			echo "<form action='repondre_invitation.php' method='POST' >";
			echo "<a href='profil.php?id={$une['Id_Utilisateur']}' >".$une['Prenom_Utilisateur'] . " " . 
				$une['Nom_Utilisateur'] . "</a>" ;
			echo " <button name='oui' class='btn btn-success' value='oui'>accepter</button>";
			echo " <button name='non' class='btn btn-danger' value='non'>refuser</button>";
			echo "<input type='hidden' name='id_relation' value={$une['id_relation']} >";
			echo "<input type='hidden' name='membre_alpha' value={$une['membre_alpha']} ></form><br>";
		}
		
		
		
		
		
		
		
		
		
		
		echo "Connaisez-vous ? <br><br>Vous n'êtes pas ami avec :";
		
		echo "<br>\n<form method='POST' action='envoi_invitation.php'> ";
		
			foreach( $pas_amis as $n => $pas_ami){
				echo "<a href='profil.php?id=".$pas_ami['Id_Utilisateur']."'>".$pas_ami['Prenom_Utilisateur']." ".$pas_ami['Nom_Utilisateur']."</a><br>";
				echo "<button type='submit' name='".$pas_ami['Id_Utilisateur']."'>
				Ajouter ". $pas_ami['Prenom_Utilisateur']." ".$pas_ami['Nom_Utilisateur']." en ami</button><br><br>\n";
			}
			echo "</form><br><br>";	
			
		echo "Invitations envoyées ? <br><br>";
		
		$sql='SELECT Prenom_Utilisateur, Nom_Utilisateur, Id_Utilisateur
		FROM `RELATIONS` INNER JOIN PERSONNES ON `membre_omega`=Id_Utilisateur 
		WHERE `membre_alpha`='.$_SESSION['id_compte'].' AND Etat_Relation=1';
		$req = $bdd->prepare($sql);

		$req = $bdd->prepare($sql);
		$req->execute();	//requete retournant les noms des personnes à qui l'utilisateur actuellement connecté a envoyé des invitations
		$pas_amis =$req->fetchall(PDO::FETCH_ASSOC);
		$req->closeCursor();


		
			foreach( $pas_amis as $n => $pas_ami){
				echo "<a href='profil.php?id=".$pas_ami['Id_Utilisateur']."'>".$pas_ami['Prenom_Utilisateur']." ".$pas_ami['Nom_Utilisateur']."</a><br>";
				
				$pas_ami['Prenom_Utilisateur']." ".$pas_ami['Nom_Utilisateur']."<br><br>\n";
				echo "<button disabled type='button'>Invitation déjà envoyée</button><br><br>\n";
			}
			
		

		echo "</div></div>";
		include('footer.php');
		
?>