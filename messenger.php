<?php
	//=========================================================================================================
	//page utilisée pour afficher toutes les conversations de l'utilisateur
	//=========================================================================================================

	$title="Conversations - Trombinouc";
	include('base_include.php');
	include('base_html.php');
	include('header.php');
	
	$messages = requete_SQL("SELECT * FROM MESSAGES WHERE Id_Expediteur=".$_SESSION['id_compte']." OR Id_Destinataire=".$_SESSION['id_compte'] );

	$contact = requete_SQL("SELECT * FROM `PERSONNES` WHERE `Id_Utilisateur` = {$_GET['id']} ");
	
	$contacts_en_conversation = requete_SQL("SELECT Prenom_Utilisateur,Nom_Utilisateur,Id_Utilisateur FROM MESSAGES INNER JOIN PERSONNES ON Id_Destinataire=Id_Utilisateur WHERE Id_Expediteur=".$_SESSION['id_compte']." UNION 
SELECT Prenom_Utilisateur,Nom_Utilisateur,Id_Utilisateur FROM MESSAGES INNER JOIN PERSONNES ON Id_Expediteur=Id_Utilisateur WHERE Id_Destinataire=".$_SESSION['id_compte'] . ";" );
	
	?>
	<h3 class=" text-center">Messagerie instantanée</h3>
	<div class="messaging">
		  <div class="inbox_msg">
			<div class="inbox_people">
			  <div class="headind_srch">
				<div class="recent_heading">
				  <h4>Messages récents</h4>
				</div>
				
			  </div>
			  <div class="inbox_chat">
				<?php if (empty($contacts_en_conversation)) echo "<div class='d-flex p-2'>Vous n'avez pas encore de conversations</div>";
				
				foreach( $contacts_en_conversation as $un_contact ){					//pour chaque utilisateur dont on a envoyé ou reçu un message
					$messages = requete_SQL("SELECT * FROM MESSAGES WHERE Id_Destinataire=".$_SESSION['id_compte']." AND Id_Expediteur=".$un_contact['Id_Utilisateur'] . " UNION SELECT * FROM MESSAGES WHERE Id_Destinataire=".$un_contact['Id_Utilisateur']." AND Id_Expediteur=".$_SESSION['id_compte'] . " ORDER BY Date_Message DESC");
					
					echo '<div class="chat_list active_chat"><a href="messenger.php?id='.$un_contact['Id_Utilisateur'].'">
					  <div class="chat_people">
						<div class="chat_img"> <img class="img_profil_s" src="Images_Profil/'.url_photo_profil($un_contact['Id_Utilisateur'],"Images_Profil").'" alt> </div>
						<div class="chat_ib">
						  <h5>'.$un_contact['Prenom_Utilisateur'].' '.$un_contact['Nom_Utilisateur'].'<span class="chat_date">'.trad_duree_temps($messages[0]['Date_Message']).'</span></h5>
						  <p>'.$messages[0]['Contenu_Message'].'</p>
						</div>
					  </div></a>
					</div>' ; 
				
				
				} ?>
				
			  </div>
			</div>
			<div class="mesgs">
				<?php echo "<h4>".$contact[0]['Prenom_Utilisateur'] . " " . $contact[0]['Nom_Utilisateur']."</h4>"; ?>
			  <div class="msg_history">
				<?php $messages_conv = requete_SQL("SELECT * FROM MESSAGES WHERE Id_Expediteur=".$_GET['id']." OR Id_Destinataire=".$_GET['id'] );
					foreach( $messages_conv as $un_message){
						if( $un_message['Id_Expediteur'] == $_SESSION['id_compte'] ) //si le message provient de moi
						
							echo' <div class="outgoing_msg">
						  <div class="sent_msg">
							<p>'.$un_message['Contenu_Message'].'</p>
							<span class="time_date">'.$un_message["Date_Message"].'</span>
						  </div>
						</div>';
						else if ( $un_message['Id_Destinataire'] == $_SESSION['id_compte'] ) //si le message provient de l'autre
							echo '<div class="incoming_msg">
              <div class="incoming_msg_img"> <img class="img_profil_s" src="Images_Profil/'.url_photo_profil($un_message['Id_Expediteur'],"Images_Profil").'" alt> </div>
              <div class="received_msg">
                <div class="received_withd_msg">
                  <p>'.$un_message['Contenu_Message'].'</p>
                  <span class="time_date">'.$un_message["Date_Message"].'</span>
				</div>
              </div>
					</div>' ; }
				?>
				
			 <div class="type_msg">
            <div class="input_msg_write"><form method='POST' action='envoi_msg.php' >
              <input type="text" class="write_msg" placeholder="Taper votre message..." name='contenu_msg' />
              <button type='submit' class="msg_send_btn"><img src='./icones/envoi.png' alt height=30></button>
			  <input type='hidden' name='destinataire' value='<?php echo $_GET['id'] ; ?>'/>
			</form></div>
          </div>
     
    </div>

			</div>
			