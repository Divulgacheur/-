<!--=========================================================================================================
	page à inclure permettant d'afficher l'en-tête du site qui comporte le menu de naviguation
	=========================================================================================================-->
	


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<!-- Utilisation des bibliothèques CSS & JS de Bootstrap cf: https://getbootstrap.com/docs/4.0/getting-started/introduction/ -->

<nav class="navbar navbar-expand-lg navbar-dark bg-darkblue">
	<a class="navbar-brand" href="fil.php">Réseau</a>
	<form class="form-inline my-2 my-lg-0" method='get' autocomplete="off" action='./recherche.php'>
		<div class='input-group'>
			<input id='barre_recherche' class="form-control mr-sm-2" size=14 type="text" name="r" placeholder="Recherche.." required>
			<div class='input-group-prepend'>
				<button class="btn btn-outline-success my-2 my-sm-0" type="submit">
				<img height=20 src="./icones/loupe.png" alt="symbole d'une loupe" >
				</button>
			</div>
		</div>
	</form>
	<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarSupportedContent">
	<ul class="navbar-nav mr-auto">
		<li class='img_profil nav-item active' >
			<img class="img_profil_s" src="./Images_Profil/<?php echo url_photo_profil($_SESSION['id_compte'], "Images_Profil"); ?>" alt>
		</li>
		<li class='img_profil nav-item active'>
			<a class="nav-link" href="profil.php">
			<?php echo $_SESSION["prenom_compte"] ?>
			</a>
		</li>
		<li class="nav-item active">
			<a class="nav-link" href="galerie.php">Galerie</a>
		</li>
		<li class="nav-item active">
			<a class="nav-link" href="messenger.php">Messagerie</a>
		</li>
		<li class="nav-item active">
			<a class="nav-link" href="amis.php">Amis
			<span class='badge badge-light'><?php
			$nb_demande=  requete_SQL("SELECT COUNT(`id_relation`) FROM RELATIONS WHERE `membre_omega`={$_SESSION['id_compte']} AND `Etat_Relation`=1");
			if ($nb_demande[0]['COUNT(`id_relation`)']>0) echo $nb_demande[0]['COUNT(`id_relation`)']; //on affiche un badge avec le nombre de requêtes d'amis reçues
			?></span></a> 
		</li>

		<li class="nav-item active">
			<a class="nav-link" href="parametres.php">Paramètres</a>
		</li>
		<li class="nav-item active">
			<a class="nav-link" href="deconnex.php">Déconnexion</a>
		</li>
	</ul>
	</div>
</nav>
