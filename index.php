<?php include('base_html.php'); 

	//=========================================================================================================
	//page utilisée pour tout utilisateur souhaitant entrer sur le site, pour qu'il s'inscrive ou se connecte
	//=========================================================================================================


?>
		
		<header>Bienvenue sur Trombinobouc</header>
			<?php
			
			if ($_GET['msg'] == 'inv' ) echo "<div class='py-1 alert-warning alert'>Merci de vous reconnecter.</div>" ;
			if ($_GET['msg'] == 'deco' ) echo "<div class='py-1 alert-info alert'>Vous avez bien été déconnecté.</div>" ;
			if ($_GET['msg'] == 'err' ) echo "<div class='py-1 alert-danger alert '>Identifiants invalides.</div>" ;
			if ($_GET['msg'] == 'verif_mail_succes' ) echo "<div class='py-1 alert-info alert '>Votre adresse mail a bien été vérifiée.</div>" ;
			if ($_GET['msg'] == 'verif_mail_echec' ) echo "<div class='py-1 alert-danger alert '>Echec de la vérification de votre adresse mail.</div>" ;
			?>
		<div class='row py-3'>
			<div class="col-md-6" >	
				<h2>Si vous avez un compte</h2>
				<p>Veuillez vous identifier</p>
				
				<form method="POST" action="./connex.php">
					<p>	<label for="login">Adresse e-mail</label>
						<input id="login" name="login" type="email" required autofocus />
					</p>
					<p>
						<label for="mdp">Mot de passe</label>
						<input id="mdp" name="mdp" type="password" required />
					</p>
					<p>	
						<button id="envoi" class='btn btn-primary btn-block' name="envoi" type="submit" value="envoi">Connnexion</button> 
					</p>
				</form>
			</div>
			<div class="col-md-6">
				<h2>Si vous n'avez pas encore de compte</h2>
				<p>Inscrivez-vous ici</p>
				
				<form method="POST" action="./inscrip.php">
					<p>
						<label for="mail_inscription">Adresse e-mail</label>
						<input id="mail_inscription" name="mail_inscription" type="email" required/>
					</p>
					<p>
						<label for="nom_inscription">Nom</label>
						<input id="nom_inscription" name="nom_inscription" type="text" required/>
					</p>
					<p>
						<label for="prenom_inscription">Prénom</label>
						<input id="prenom_inscription" name="prenom_inscription" type="text" required/>
					</p>
					<p>
						<label for="jour_naiss_inscription">Date de naissance</label>
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
					</p>
					<p>
						<label for="mdp_inscription">Mot de passe</label>
						<input id="mdp_inscription" name="mdp_inscription" type="password" required />
					</p>
					
					<p>
						<label for="mdp_confirm">Confirmez le mot de passe</label>
						<input id="mdp_confirm" name="mdp_confirm" type="password" required />
					</p>
					<p>
						<button id="envoi_inscrip" class='btn btn-primary btn-block' name="envoi_inscrip" type="submit" value="envoi">Inscription</button> 
					</p>
				</form>
				</div>
				<p class='lead' >Pourquoi vous inscrire sur Trombinobouc ?<br>
				Tout d'abord parce que c'est très simple ! Deux minutes vous suffisent.<br>
				Ensuite parce que notre réseau social respecte la vie privée de ses utilisateurs.<br>
				</p>
			</div>
		</div>
			
			
		
	</body>
</html>