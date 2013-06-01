<?php 
/**
*
* @package LIGHT PUBLICATOR
* @copyright (c) 2013 BOUDRY Julien - Born : 22/10/1988 - France
* @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License / Licence publique générale limitée GNU
*
*/ 
?>

<?php

// ON VA GENERER DES LISTES DE CHOIX POUR L'INSCRIPTION & LA PREFERENCES PERSO
	
	// Génère les listes des styles disponibles.
		// ETAT 100%
		function list_styles ($referent = FALSE)
		{
				$bdd = $GLOBALS['bdd'] ;
				$bdd_tables = $GLOBALS['bdd_tables'] ;

				$query = $bdd->prepare	('
											SELECT `id`, `nom` FROM '.$bdd_tables['styles'].' ORDER BY `nom` ASC 
										;') ;
				$query->execute() ;
				
				$result = $query->fetchAll() ;
				
				$default = user_style(TRUE) ;
				
				FOREACH ( $result as $cle => $element )
				{
				
					IF ( $referent == FALSE )
					{
						IF ( $element['id'] == $default ) { $selected = 'selected' ; } ELSE { $selected = NULL ; }
					}
					ELSEIF ( ctype_digit($referent) )
					{
						IF ( $element['id'] == $referent ) { $selected = 'selected' ; } ELSE { $selected = NULL ; }
					}
					
					echo '<option value="' . $element['id'] . '" '.$selected.' >' . $element['nom'] . '</option>' ;
				}
		}

		
		/* FONCTIONS OBSELETTES
			// Si parametre FALSE, return le numero du style par défault.
			 // Si parametre TRUE, il va en plus du html pour générer l'option de tête.
				// ETAT 100%
				function tell_default_style ($talk)
				{
					$bdd = $GLOBALS['bdd'] ;
					$bdd_tables = $GLOBALS['bdd_tables'] ;
					
					
					$style_default_query = $bdd->query('
					SELECT `id`, `nom` FROM ' . $bdd_tables['styles'] . '
					LEFT JOIN ' . $bdd_tables['config'] . ' ON ' . $bdd_tables['config'] . '.`valeur_int` = ' . $bdd_tables['styles'] . '.`id`
					WHERE ' . $bdd_tables['config'] . '.`parametre` = \'default_style\' AND ' . $bdd_tables['config'] . '.`valeur_int` =   ' . $bdd_tables['styles'] . '.`id`
					') ;
					
					$style_default_array = $style_default_query->fetch(PDO::FETCH_ASSOC) ;
					
					
					IF ( isset($talk) AND $talk == TRUE )
					{
						echo '<option value="' . $style_default_array['id'] . '" >' . $style_default_array['nom'] . ' (' . $GLOBALS['lang_default'] . ')</option>' ;
						
						return $style_default_array['id'] ;
					}
					ELSE
					{
						return $style_default_array['id'] ;
					}
				}
				

			// On calcule la liste restante des styles, par ordre alphabétique.
				// ETAT 100%
				function list_styles_without_default ($default_style)
				{
					$bdd = $GLOBALS['bdd'] ;
					$bdd_tables = $GLOBALS['bdd_tables'] ;
				
					$list_style_query = $bdd->query(' SELECT `id`, `nom` FROM ' . $bdd_tables['styles'] . ' WHERE `id` <> ' . $default_style . ' ORDER BY `nom` ASC
					;') ;
				
					while ( $list_style_array = $list_style_query->fetch(PDO::FETCH_ASSOC) )
					{
						echo '<option value="' . $list_style_array['id'] . '" >' . $list_style_array['nom'] . '</option>' ;
					}
					
					
				}
		*/
		
			
	// Génère les listes des langues disponibles.
		// ETAT 100%
		function list_langs ($referent = FALSE)
		{
				$bdd = $GLOBALS['bdd'] ;
				$bdd_tables = $GLOBALS['bdd_tables'] ;

				$query = $bdd->prepare	('
											SELECT `id`, `nom` FROM '.$bdd_tables['languages'].' ORDER BY `nom` ASC 
										;') ;
				$query->execute() ;
				
				$result = $query->fetchAll() ;
				
				$default = tell_default_lang() ;
				
				FOREACH ( $result as $cle => $element )
				{
				
					IF ( $referent == FALSE )
					{
						IF ( $element['id'] == $default ) { $selected = 'selected' ; } ELSE { $selected = NULL ; }
					}
					ELSEIF ( ctype_digit($referent) )
					{
						IF ( $element['id'] == $referent ) { $selected = 'selected' ; } ELSE { $selected = NULL ; }
					}
					
					echo '<option value="' . $element['id'] . '" '.$selected.' >' . $element['nom'] . '</option>' ;
				}
		}

		
		 // Si parametre FALSE, return le numero du language par défault.
		 // Si parametre TRUE, il va en plus du html pour générer l'option de tête.
			// ETAT 100%
			function tell_default_lang ()
			{			
				return $GLOBALS['site_config']['default_language'] ;
			}
			

	/* CODE OBSSELET

		// On calcule la liste restante des langues, par ordre alphabétique.
				// ETAT 100%
				function list_langs_without_default ($default_lang)
				{
					$bdd = $GLOBALS['bdd'] ;
					$bdd_tables = $GLOBALS['bdd_tables'] ;
				
					$list_lang_query = $bdd->query(' SELECT `id`, `nom` FROM ' . $bdd_tables['languages'] . ' WHERE `id` <> ' . $default_lang . ' ORDER BY `nom` ASC
					;') ;
				
					while ( $list_lang_array = $list_lang_query->fetch(PDO::FETCH_ASSOC) )
					{
						echo '<option value="' . $list_lang_array['id'] . '" >' . $list_lang_array['nom'] . '</option>' ;
					}
					
					
				} 
	*/
			
			

// INSCRIPTION 

	//On va vérifier si Kévin sait remplir son formulaire, et si Foubart ne fait pas joujou.
		// ETAT 100%
		function profilage_candidate_ckeck ($edit = FALSE, $memberinfos = NULL)
		{
		$bdd_tables = $GLOBALS['bdd_tables'] ;
		
			$error = FALSE ;
			
				// CHECK PSEUDO
				
			
				IF ( $edit == FALSE )
				{
					IF ( isset($_POST['pseudo']) AND
						strlen($_POST['pseudo']) <= 20 AND
						strlen($_POST['pseudo']) >= 4 AND
						ctype_alnum($_POST['pseudo']) AND
						entry_exist($bdd_tables['users'], 'pseudo', $_POST['pseudo']) == FALSE			
						)						
					{}
					ELSE
					{
						$error = TRUE ;
						
						
							IF ( entry_exist($bdd_tables['users'], 'pseudo', $_POST['pseudo']) == TRUE )
							{
								$profilage_fails_list['pseudo'] = $GLOBALS['lang_profilage_error_pseudo_use'] ;
							}
							ELSE
							{
								$profilage_fails_list['pseudo'] = $GLOBALS['lang_profilage_error_pseudo'] ;
							}
					}
				}
				ELSEIF ( $edit == TRUE )
				{
					IF ( isset($_POST['pseudo']) AND
						strlen($_POST['pseudo']) <= 20 AND
						strlen($_POST['pseudo']) >= 4 AND
						ctype_alnum($_POST['pseudo']) AND
						( entry_exist($bdd_tables['users'], 'pseudo', $_POST['pseudo']) == FALSE OR $_POST['pseudo'] == $memberinfos['pseudo'] )			
						)						
					{}
					ELSE
					{
						$error = TRUE ;
						
						
							IF ( entry_exist($bdd_tables['users'], 'pseudo', $_POST['pseudo']) == TRUE )
							{
								$profilage_fails_list['pseudo'] = $GLOBALS['lang_profilage_error_pseudo_use'] ;
							}
							ELSE
							{
								$profilage_fails_list['pseudo'] = $GLOBALS['lang_profilage_error_pseudo'] ;
							}
					}
				}
				
				// CHECK PRENOM
				IF ( empty($_POST['prenom']) == TRUE OR
					( strlen($_POST['prenom']) <= 25 AND
					ctype_alpha($_POST['prenom']) )
					)
				{}
				ELSE
				{
					$error = TRUE ;
				
					$profilage_fails_list['prenom'] = $GLOBALS['lang_profilage_error_prenom'] ;				
				}
				
				// CHECK NOM
				IF ( empty($_POST['nom']) OR
					( strlen($_POST['nom']) <= 25 AND
					ctype_alpha($_POST['nom']) )
					)
				{}
				ELSE
				{
					$error = TRUE ;
				
					$profilage_fails_list['nom'] = $GLOBALS['lang_profilage_error_nom'] ;
				}
				
				// CHECK email //
				
				IF ( $edit == FALSE )
				{
					IF ( isset($_POST['email']) AND
						strlen($_POST['email']) <= 50 AND
						strlen($_POST['email']) >= 6 AND
						filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) AND	
						entry_exist($bdd_tables['users'], 'email', $_POST['email']) == FALSE
						)
					{}
					ELSE
					{
						$error = TRUE ;
						
						IF ( entry_exist($bdd_tables['users'], 'email', $_POST['email']) == TRUE )
						{
							$profilage_fails_list['email'] = $GLOBALS['lang_profilage_error_email_use'] ;
						}
						ELSE
						{				
							$profilage_fails_list['email'] = $GLOBALS['lang_profilage_error_email'] ;
						}
					}
				}
				ELSEIF ( $edit == TRUE )	
				{
					IF ( isset($_POST['email']) AND
						strlen($_POST['email']) <= 50 AND
						strlen($_POST['email']) >= 6 AND
						filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) AND	
						( entry_exist($bdd_tables['users'], 'email', $_POST['email']) == FALSE OR $_POST['email'] == $memberinfos['email'] )
						)
					{}
					ELSE
					{
						$error = TRUE ;
						
						IF ( entry_exist($bdd_tables['users'], 'email', $_POST['email']) == TRUE )
						{
							$profilage_fails_list['email'] = $GLOBALS['lang_profilage_error_email_use'] ;
						}
						ELSE
						{				
							$profilage_fails_list['email'] = $GLOBALS['lang_profilage_error_email'] ;
						}
					}
				}
					
				// CHECK GENRE
				IF ( isset($_POST['genre']) AND 
					( $_POST['genre'] == 'unknow' OR $_POST['genre'] == 'male' OR $_POST['genre'] == 'female' )
					)
				{}
				ELSE
				{
					$error = TRUE ;
				
					$profilage_fails_list['genre'] = $GLOBALS['lang_profilage_error_hack'] ;
				}
				
				// CHECK STYLE
				IF ( isset($_POST['style']) AND
					ctype_digit($_POST['style']) AND
					entry_exist($bdd_tables['styles'], 'id', $_POST['style']) )
				{}
				ELSE
				{
					$error = TRUE ;
				
					$profilage_fails_list['style'] = $GLOBALS['lang_profilage_error_hack'] ;
				}
				
				// CHECK LANGUAGE
				IF (  isset($_POST['lang']) AND
					ctype_digit($_POST['lang']) AND
					entry_exist($bdd_tables['languages'], 'id', $_POST['lang'])  )
				{}
				ELSE
				{
					$error = TRUE ;
				
					$profilage_fails_list['lang'] = $GLOBALS['lang_profilage_error_hack'] ;
				}
				
				// CHECK Password
				IF ( $edit == FALSE )
				{
					IF ( isset($_POST['password']) AND
						strlen($_POST['password']) <= 30 AND
						strlen($_POST['password']) >= 6 AND
						ctype_alnum($_POST['password']) AND
						$_POST['password'] == $_POST['password_confirm']
						)					
					{}
					ELSE
					{
						$error = TRUE ;
						
							IF ( $_POST['password'] <> $_POST['password_confirm'] )
							{
								$profilage_fails_list['password'] = $GLOBALS['lang_profilage_error_password_confirm'] ;
							}
							ELSE
							{
								$profilage_fails_list['pseudo'] = $GLOBALS['lang_profilage_error_password'] ;
							}
					}
				}
				ELSEIF ( $edit == TRUE )
				{
					IF ( ( isset($_POST['password']) AND
						strlen($_POST['password']) <= 30 AND
						strlen($_POST['password']) >= 6 AND
						ctype_alnum($_POST['password']) AND
						$_POST['password'] == $_POST['password_confirm'] ) OR
						( etat() == TRUE AND empty($_POST['password']) )
						)					
					{}
					ELSE
					{
						$error = TRUE ;
						
							IF ( $_POST['password'] <> $_POST['password_confirm'] )
							{
								$profilage_fails_list['password'] = $GLOBALS['lang_profilage_error_password_confirm'] ;
							}
							ELSE
							{
								$profilage_fails_list['pseudo'] = $GLOBALS['lang_profilage_error_password'] ;
							}
					}
				}
				
				
			IF ( $error == TRUE )
			{
				return $profilage_fails_list ;
			}
			ELSE
			{
				return 'OK' ;
			}
				
		}
		
		
		
	// On arrange le html pour preselectionner les checksbox et autres menus déroulant
	function convert_return_profil_options($edit = FALSE)
	{
		
		IF ( $edit == FALSE )
		{
			// GENRE
			
			IF ( $_POST['genre'] == 'unknow' )
			{$return_profil['genre']['unknow'] = 'checked="checked"' ; } ELSE {$return_profil['genre']['unknow'] = ' ' ; }
			
			IF ( $_POST['genre'] == 'male' )
			{$return_profil['genre']['male'] = 'checked="checked"' ; } ELSE {$return_profil['genre']['male'] = ' ' ; }
			
			IF ( $_POST['genre'] == 'female' )
			{$return_profil['genre']['female'] = 'checked="checked"' ; } ELSE {$return_profil['genre']['female'] = ' ' ; }
			
			return $return_profil ;
		}
		ELSEIF ( $edit == TRUE )
		{
			IF ( $_POST['genre'] == 'unknow' )
			{$return_profil['genre']['unknow'] = 'checked="checked"' ; } ELSE {$return_profil['genre']['unknow'] = ' ' ; }
			
			IF ( $_POST['genre'] == 'male' )
			{$return_profil['genre']['male'] = 'checked="checked"' ; } ELSE {$return_profil['genre']['male'] = ' ' ; }
			
			IF ( $_POST['genre'] == 'female' )
			{$return_profil['genre']['female'] = 'checked="checked"' ; } ELSE {$return_profil['genre']['female'] = ' ' ; }
			
			// Je ne sais plus pourquoi je n'ai pas finit ... pourtant c'est stable ... "je crois que je me suis perdu moi-même" (Golaud, Acte I, scène I)
		}
	
	}
		
		

	// OK, on inscrit
		// ETAT 100%
		function inscription()
		{
			$bdd = $GLOBALS['bdd'] ;
			$bdd_tables = $GLOBALS['bdd_tables'] ;
			
			$inscription_query = $bdd->prepare('
			INSERT INTO ' . $bdd_tables['users'] . ' (`pseudo`,`prenom`,`nom`,`genre`,`email`,`id_style`,`id_language`)
			VALUES (:pseudo,:prenom,:nom,:genre,:email,:style,:lang)
			 ;') ;
			 
			$inscription_query->execute(
			array 	(	'pseudo' => $_POST['pseudo'],
						'prenom' => $_POST['prenom'],
						'nom' => $_POST['nom'],
						'genre' => $_POST['genre'],
						'email' => $_POST['email'],
						'style' => $_POST['style'],
						'lang' => $_POST['lang']
					)
					
			) ;
			
			// On lui donne son mot de passe
			entry_password($_POST['pseudo'], $_POST['password']) ;
			
			// Et on connecte
			identification_ask($_POST['pseudo'], $_POST['password']) ;
			
			
			
		}
		
	// On inscrit un nouveau password pour l'utilisateur
	function entry_password ($user_id, $user_password)
	{
		$bdd = $GLOBALS['bdd'] ;
		$bdd_tables = $GLOBALS['bdd_tables'] ;
		
		$password_query = $bdd->prepare('
		UPDATE ' . $bdd_tables['users'] . ' SET
		`password` = :password
		WHERE ( `id` = :userid ) OR ( `pseudo` = :userid )
		 ;') ;
		 
		$password_query->execute(
		array 	(	'password' => password($user_password),
					'userid' => $user_id
				)
				
		) ;
		
	}

	

	

// UCP à proprement parler


	// Parle en HTML pour expliquer les autorisation de l'utilisateur.
		// ETAT 100% ;
		function show_level_details ($level)
		{
			IF ( $level == 1 )
			{
				echo 
					'<ul>
						<li>' . $GLOBALS['lang_level_1_comment'] . '</li>
						<li>' . $GLOBALS['lang_level_1_billet'] . '</li>
					</ul>' 
				 ;
			}
			
			IF ( $level == 2 )
			{
				echo 
					'<ul>
						<li>' . $GLOBALS['lang_level_2_comment'] . '</li>
						<li>' . $GLOBALS['lang_level_2_billet'] . '</li>
					</ul>' 
				 ;
			}
			
			IF ( $level == 3 )
			{
				echo 
					'<ul>
						<li>' . $GLOBALS['lang_level_2_comment'] . '</li>
						<li>' . $GLOBALS['lang_level_2_billet'] . '</li>
						<li>' . $GLOBALS['lang_level_3_admin'] . '</li>
					</ul>' 
				 ;
			}
		}
	
	
	
	// OK, edit les caractèristiques de profil
		// ETAT 100%
		function update_profil ( $userid )
		{
			$bdd = $GLOBALS['bdd'] ;
			$bdd_tables = $GLOBALS['bdd_tables'] ;
			
			$update_query = $bdd->prepare('
			UPDATE ' . $bdd_tables['users'] . ' SET
			`pseudo` = :pseudo,
			`prenom` = :prenom,
			`nom` = :nom,
			`genre` = :genre,
			`email` = :email,
			`id_style` = :style,
			`id_language` = :lang 
			WHERE `id` = :userid
			 ;') ;
			 
			$update_query->execute(
			array 	(	'pseudo' => $_POST['pseudo'],
						'prenom' => $_POST['prenom'],
						'nom' => $_POST['nom'],
						'genre' => $_POST['genre'],
						'email' => $_POST['email'],
						'style' => $_POST['style'],
						'lang' => $_POST['lang'],
						'userid' => $userid
					)
					
			) ;
			
			// Si besoin, on modifie le mot de passe
			IF ( empty($_POST['password']) == FALSE )
			{
				entry_password($userid, $_POST['password']) ;
				
			}
			
		}
		
		

	
		// Fonction permettant d'afficher des listes de données d'un membre dans l'UCP
			// ETAT : 100%
			function show_in_ucp ($parametre, $user_id)
			{
				$bdd = $GLOBALS['bdd'] ;
				$bdd_tables = $GLOBALS['bdd_tables'] ;
				
				
				// Affichage de la liste de billets
				IF ( $parametre == 'billets' AND ctype_digit($user_id) ) 
				{
				
					$show_billet_query = $bdd->prepare('SELECT * FROM  ' . $bdd_tables['billets'] . ' WHERE `id_auteur` = ' . $user_id . ' ORDER BY `date` DESC ;') ;		
					$show_billet_query->execute() ;
					
					while ( $show_billet_array = $show_billet_query->fetch(PDO::FETCH_ASSOC) )
					{
					$comment = nbr_comments($show_billet_array['id']) ;
					
						echo 	'<tr>
									<td>'.$show_billet_array['id'].'</td>
									<td><a href="index.php?article='.$show_billet_array['id'].'" >'.$show_billet_array['titre'].'</a></td>
									<td>'.$show_billet_array['date'].'</td>
									<td>'.$show_billet_array['edit'].'</td>
									<td>'.$show_billet_array['date_edit'].'</td>
									<td><a href="index.php?article='.$show_billet_array['id'].'#comments" >'.$comment['nbr'].'</a></td>
									<td>
										<a href="#null" onclick="javascript:open_infos(\'post.php?edit='.$show_billet_array['id'].'\');" >'
											.$GLOBALS['lang_edit'].'</a> 
											 |
											<a href="index.php?module=ucp&amp;page=billets&amp;delete_post='.$show_billet_array['id'].'" onclick="return(confirm(\''.$GLOBALS['lang_delete_confirm_billet'].'\'))" >'.
												$GLOBALS['lang_delete'].'</a>
									</td>
								</tr>' ;
					}
					
				}
				
				// Affichage de la liste de commentaires
				IF ( $parametre == 'comments' AND ctype_digit($user_id) )
				{
				
					$show_comments_query = $bdd->prepare('SELECT * FROM  ' . $bdd_tables['comments'] . ' WHERE `id_auteur` = ' . $user_id . ' ORDER BY `date` DESC ;') ;		
					$show_comments_query->execute() ;
					
					while ( $show_comments_array = $show_comments_query->fetch(PDO::FETCH_ASSOC) )
					{
						echo 	'<tr>
									<td>'.$show_comments_array['id'].'</td>
									<td>'.$show_comments_array['date'].'</td>
									<td>'.id_article_translation($show_comments_array['id_billet']).'</td>
									<td><a href=index.php?module=ucp&amp;page=comments&amp;delete_comment='.$show_comments_array['id'].' onclick="return(confirm(\''.$GLOBALS['lang_delete_confirm_comment'].'\'))" >'.$GLOBALS['lang_delete'].'</a></td>
								</tr>' ;
					}
					
				}
				
			}	
	
	
	
	
	
	

?>