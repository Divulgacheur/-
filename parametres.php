<?php
	//=========================================================================================================
	//page utilisée pour tout utilisateur souhaitant visualiser/modifier ses informations/paramètres
	//=========================================================================================================

	$title = "Trombinouc - Paramètres";
	include('base_include.php');
	include('base_html.php');
	include('header.php');

	
	?>
	<h1>Paramètres</h1>
	<div class='row'><div class="col-md-12">
	
	<?php if (key($_GET) == 'succes')
		echo "<div class='alert alert-success'>Vos paramètres ont bien été enregistrés</div>";
	?>

	
<?php if( key($_GET)=='img_echec' ) echo "<div class='py-1 alert-danger alert'>Echec du téléchargement de votre image</div>"; 
else if( key($_GET)=='img_succes' ) echo "<div class='py-1 alert-success alert'>Votre image de profil a bien été mise à jour</div>";
?>
<form action="upload.php" method="post" enctype="multipart/form-data">
    Sélectionner une image à télécharger comme photo de profil:
    <input type="file" name="Images_Profil" id="photo_profil">
    <button type="submit" value="Images_Profil" name="submit">Envoyer</button><br><br>


    Sélectionner une image à télécharger comme photo de couverture:
    <input type="file" name="Images_Couverture" id="photo_couverture">
    <button type="submit" value="Images_Couverture" name="submit">Envoyer</button>
</form>

<p>Mes informations :</p>

<form method='post' action='./modifier_infos.php' >

	<div class='row'>
	<div class='col-md-4'>
	
	<p id='champ_nom'><?php echo $_SESSION["prenom_compte"]. " " . $_SESSION["nom_compte"]; ?></p></div>
	<div class='col-md-4'>
	<button class='btn btn-primary' type='button' onclick="changer_nom('champ_nom','<?php echo $_SESSION["prenom_compte"]. " " . $_SESSION["nom_compte"]; ?>')" >modifier</button></div>
	</div>
	<div class='row'>
	<div class='col-md-4 mb-3 ' id='champ_date_naiss' >Date de naissance : <?php echo $_SESSION["date_naiss"]; ?></div>
	
	<div class='col-md-6 mb-3 '><button class='btn btn-primary' type='button' onclick="changer_date_naiss()" name='modif_date_naiss'>modifier</button>
	
	
	<span id='zone_naiss' class='valid_param'>
		<select id="jour_naiss_inscription" name="jour_naiss_inscription" required >
			<option value='' >Jour</option>
			<?php for( $i=1 ; $i<=31 ; $i++) echo"<option value='$i' >$i</option>\n"; ?>
		</select>
		<select id="mois_naiss_inscription" name="mois_naiss_inscription" required >
			<option value='' >Mois</option>
			<?php for( $i=1 ; $i<=12 ; $i++) echo"<option value='$i' >$i</option>\n"; ?>
		</select>
		<select id="annee_naiss_inscription" name="annee_naiss_inscription" required >
			<option value='' >Année</option>
			<?php for( $i=1905 ; $i<=date('Y') ; $i++) echo"<option value='$i' >$i</option>\n"; ?>
		</select>
		<button class='btn btn-outline-success'>✔</button>
	</span>
	</div>
	</div>
	

	Vos publications seront visibles pour <select name='Param_Visibilite_Publi' onchange='toggle_valider(3)'>
	<?php 
	$sql = "SELECT Param_Visibilite_Publi FROM PERSONNES WHERE Id_Utilisateur={$_SESSION['id_compte']}";
	$req = $bdd->prepare($sql);
	$req->execute();	//requete retournant le niveau actuel du paramètre visibilité des publications sur mon profil
	$resultat = $req->fetchall(PDO::FETCH_ASSOC);
	$req->closeCursor();
	
	foreach($tab_trad_visibilite as $un => $une ){
		if ( $un != $resultat[0]['Param_Visibilite_Publi'] )
			echo "<option value={$un} >$une</option>";
		else
			echo "<option value={$un} selected>$une</option>";
	}	?>
	</select>
	<button id=3 class='valid_param' >Valider</button>
	<br>
	Qui peut publier sur votre profil ?<select name='Param_Droit_Publier' onchange='toggle_valider(4)'>
	<?php 
	$sql = "SELECT Param_Droit_Publier FROM PERSONNES WHERE Id_Utilisateur={$_SESSION['id_compte']}";
	$req = $bdd->prepare($sql);
	$req->execute();	//requete retournant le niveau actuel du paramètre de qui peut publier sur mon profil
	$resultat = $req->fetchall(PDO::FETCH_ASSOC);
	$req->closeCursor();
	
	foreach($tab_trad_visibilite as $un => $une ){
		if ( $un != $resultat[0]['Param_Droit_Publier'] )
			echo "<option value={$un} >$une</option>";
		else
			echo "<option value={$un} selected>$une</option>";
	}	?>
	</select>
	<button id=4 class='valid_param' >Valider</button>
</form>


</div>
</div>
</div>
	<script>
		function toggle_valider(x) {
			document.getElementById(x).style.visibility = 'visible';
		}
		function changer_nom(x,nom){
			
			document.getElementById(x).innerHTML = "<input value='"+ nom + "'>" ;
			document.getElementById(x).innerHTML += "<button class='btn btn-outline-success'> ✔</button>";
		}
		
		function changer_date_naiss(){
			document.getElementById('zone_naiss').style.visibility = 'visible';
			
			
		}
	</script>