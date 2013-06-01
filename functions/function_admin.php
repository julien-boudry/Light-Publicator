<?php 
/**
*
* @package LIGHT PUBLICATOR
* @copyright (c) 2013 BOUDRY Julien - Born : 22/10/1988 - France
* @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License / Licence publique générale limitée GNU
*
*/ 


// RECAP

	// Calcul du nombre moyen de commentaires par billet
		// ETAT 100%
		function stats_comments_by_article ()
		{
			IF (calc_nombre_articles() == 0) 
			{ 
				return 0 ;
			}
			
			return calc_nombre_comments() / calc_nombre_articles() ;
		}
		


	// Calcul du nombre de membres
		// ETAT 100%
		function calc_nombre_users ( $level = '<10' )
		{
			$bdd = $GLOBALS['bdd'] ;
			$bdd_tables = $GLOBALS['bdd_tables'] ;
		
			$count_users_query = $bdd->prepare('SELECT COUNT(`id`) FROM ' . $bdd_tables['users'] . ' WHERE `level` '.$level.' ;') ;
			$count_users_query->execute() ;
			 
			$count_users_array = $count_users_query->fetch(PDO::FETCH_NUM) ;
			
			return $count_users_array['0'] ;
		}
		
	// Optimisation des tables
	function bdd_optimisation ()
	{
		$bdd = $GLOBALS['bdd'] ;
		$bdd_tables = $GLOBALS['bdd_tables'] ;
		
		$query = $bdd->query('
		OPTIMIZE TABLE ' . $bdd_tables['billets'] . ', ' . $bdd_tables['comments'] . ', ' . $bdd_tables['config'] . ', ' . $bdd_tables['languages'] . ', ' . $bdd_tables['styles'] . ', ' . $bdd_tables['users'] . '
		') ;
	}
	
	
// MEMBERS

	// Affichage de la liste des membres
	function show_members ($order = 'pseudo')
	{
		$bdd = $GLOBALS['bdd'] ;
		$bdd_tables = $GLOBALS['bdd_tables'] ;
		
		$query = $bdd->prepare 	('
								SELECT `id`,`pseudo`,`prenom`,`nom`,`genre`,`email`,`level`,`date_inscription`,`id_style`,`id_language`
								FROM ' .
								$bdd_tables['users'] . ' ORDER BY `'.$order.'` ;
								') ;
		$query->execute	() ;
						
		$array = $query->fetchAll() ;
		
		foreach ( $array as $cle => $element )
		{
		
			IF ( $element['level'] == 1 ) { $rang = $GLOBALS['lang_rang_1'] ; }
			ELSEIF ( $element['level'] == 2 ) { $rang = $GLOBALS['lang_rang_2'] ; }
			ELSEIF ( $element['level'] == 3 ) { $rang = $GLOBALS['lang_rang_3'] ; }
			ELSE { $rang = 'Specialement bizzare' ;}
		
			echo 	'<tr>
						<td><input type="checkbox" name="selection[]" value="'.$element['id'].'"></td>
						
						<td>'.$element['id'].'</td>
						<td>'.$element['pseudo'].'</td>
						<td>'.$element['prenom'].'</td>
						<td>'.$element['nom'].'</td>
						<td>'.$element['genre'].'</td>
						<td>'.$element['email'].'</td>
						<td>'.$element['date_inscription'].'</td>
						<td>'.$element['id_style'].'</td>
						<td>'.$element['id_language'].'</td>
						<td>'.compteur_member_stats('comments', $element['id']).'</td>
						<td>'.compteur_member_stats('billets', $element['id']).'</td>
						<td>'.$rang.'</td>
						
						<td><a href="index.php?module=editmember&amp;id='.$element['id'].'" >'.$GLOBALS['lang_admin_members_edit'].'</a></td>
						<td><a href="index.php?module=editmember_rank&amp;id='.$element['id'].'" >'.$GLOBALS['lang_admin_members_editrank'].'</a></td>
						<td><a onclick="return(confirm(\''.$GLOBALS['lang_admin_style_action_delete_user_confirm'].'\'))" href="index.php?module=editmember_rank&amp;delete_user='.$element['id'].'" >'.$GLOBALS['lang_admin_members_delete_user'].'</a></td>
					</tr>' ;
		}
						
						
	}
	
	
	// Affichage du select html du rank
	function rank_select ( $memberid )
	{
	
		$infos = member_infos($memberid) ;
		$level = $infos['level'] ;
		
		$l1 = NULL ; $l2 = NULL ; $l3 = NULL ;
		
		IF ( $level == 1 ) { $l1 = 'selected' ; }
		IF ( $level == 2 ) { $l2 = 'selected' ; }
		IF ( $level == 3 ) { $l3 = 'selected' ; }
	
	
	
		echo 	'<option value="1" '.$l1.'>'.$GLOBALS['lang_rang_1'].'</option>
				<option value="2" '.$l2.'>'.$GLOBALS['lang_rang_2'].'</option>
				<option value="3" '.$l3.'>'.$GLOBALS['lang_rang_3'].'</option>' ;
	}
	
	// Met à jour le rang de l'utilisateur
	function update_rank ($userid, $rank)
	{
		$bdd = $GLOBALS['bdd'] ;
		$bdd_tables = $GLOBALS['bdd_tables'] ;
		
		$update_query = $bdd->prepare('
			UPDATE ' . $bdd_tables['users'] . ' SET
			`level` = :level 
			WHERE `id` = :userid
			 ;') ;
			 
			$update_query->execute(
			array 	(	'level' => $rank,
						'userid' => $userid
					)
					
			) ;
	}
	
	// Supression d'un utilisateur
	function delete_user ($user_id)
	{
		$bdd = $GLOBALS['bdd'] ;
		$bdd_tables = $GLOBALS['bdd_tables'] ;
		
		$query = $bdd->prepare	('
									DELETE FROM ' . $bdd_tables['users'] . ' 
									WHERE `id` = :iduser ;
									DELETE FROM ' . $bdd_tables['billets'] . ' 
									WHERE `id_auteur` = :iduser ;
									DELETE FROM ' . $bdd_tables['comments'] . ' 
									WHERE `id_auteur` = :iduser ;										
								') ;
		$query->execute ( array( 'iduser' => $user_id) ) ;
	}
	
	
	// Activation / Désactivation de l'inscription
	function set_inscription ($etat)
	{	
		$bdd = $GLOBALS['bdd'] ;
		$bdd_tables = $GLOBALS['bdd_tables'] ;
		
	
		$query = $bdd->prepare	('
									UPDATE ' . $bdd_tables['config'] . ' SET
									`valeur` = ? 
									WHERE `parametre` = \'inscription\' ;
								') ;
		$query->execute	(array($etat)) ;
	}
	
	
// Style

	function generate_new_style ()
	{
		$fichier = rand() ;
	
		$new_css = fopen('../style/'.$fichier.'.css', 'a+');
		fputs($new_css, $_POST['new_style_content']);
		
		activate_new_style($_POST['new_style_title'], $fichier.'.css') ;
	}
	
	function activate_new_style ($titre, $fichier)
	{
		$bdd = $GLOBALS['bdd'] ;
		$bdd_tables = $GLOBALS['bdd_tables'] ;
		
		$query = $bdd->prepare	('
									INSERT INTO ' . $bdd_tables['styles'] . ' (`nom`,`fichier_css`)
									VALUES (:titre, :fichier) ;
								') ;
		$query->execute	( array 	(
										'titre' => $titre,
										'fichier' => $fichier
									)
						) ;
	}
	
	
	// Affiche la liste des style dans l'administration
	function admin_list_style ($parametre = 'all')
	{
		$bdd = $GLOBALS['bdd'] ;
		$bdd_tables = $GLOBALS['bdd_tables'] ;

		$query_list_style = $bdd->query	('
									SELECT * FROM ' . $bdd_tables['styles'] . ' ORDER BY `nom` ;
								') ;
								
		$query_list_array = $query_list_style->fetchAll() ;
		
		foreach ($query_list_array as $cle => $element)
		{
			IF ( user_style(TRUE) == $element['id'] )
			{
				$etat = $GLOBALS['lang_admin_style_etat_default'] ;
				$action = NULL ;
				
			}
			ELSE 
			{
				$etat = $GLOBALS['lang_admin_style_etat_other'] ;
				$action = '<a href="index.php?module=styles&amp;set_default_style='.$element['id'].'">'.$GLOBALS['lang_admin_style_action_setdefault'].'</a> | 
				<a onclick="return(confirm(\''.$GLOBALS['lang_admin_style_action_delete_confirm'].'\'))" href="index.php?module=styles&amp;delete_style='.$element['id'].'">'.$GLOBALS['lang_admin_style_action_delete'].'</a>' ;
			}
			
			$use = popularity($element['id'], 'style') ;
			
			echo	'
					<tr>
						<td>'.$element['id'].'</td>
						<td>'.$element['nom'].'</td>
						<td>'.$element['fichier_css'].'</td>
						<td>'.$use.'</td>
						<td>'.$etat.'</td>
						<td>'.$action.'</td>
					</tr>
					' ;
		}
		
	}
	
	
	// Calcule la popularité d'un style ou d'un language
	function popularity ($elementid, $module)
	{
		$bdd = $GLOBALS['bdd'] ;
		$bdd_tables = $GLOBALS['bdd_tables'] ;
		
		IF ( $module == 'style' ) { $champ = '`id_style`' ;}
		IF ( $module == 'lang' ) { $champ = '`id_language`' ;}
		
		$query = $bdd->prepare	('
									SELECT COUNT(`id`) FROM ' . $bdd_tables['users'] . ' WHERE '.$champ.' = ? ;
								') ;
		$query->execute	( array($elementid) ) ;
		
		$result = $query->fetch(PDO::FETCH_NUM) ;
		
		return $result['0'] ;
	}
	
	// Change le style par défault
	function set_style_default ($id_style)
	{
		$bdd = $GLOBALS['bdd'] ;
		$bdd_tables = $GLOBALS['bdd_tables'] ;
		
		$query = $bdd->prepare	('
									UPDATE ' . $bdd_tables['config'] . ' SET
									`valeur` = ? 
									WHERE `parametre` = \'default_style\' ;
								') ;
		$query->execute	(
							array	($id_style)
						) ;


	}
	
	// Supression d'un style
	function delete_style ($id_style)
	{
		$bdd = $GLOBALS['bdd'] ;
		$bdd_tables = $GLOBALS['bdd_tables'] ;
		

		
		$query = $bdd->prepare	('
									DELETE FROM ' . $bdd_tables['styles'] . ' 
									WHERE `id` = :idstyle ;
									UPDATE ' . $bdd_tables['users'] . ' SET
									`id_style` = :defaultstyle
									WHERE `id_style` = :idstyle ;
								') ;
		$query->execute	(
							array	( 	'idstyle' => $id_style,
										'defaultstyle' => $GLOBALS['site_config']['default_style']
									)
						) ;


	}
	


	
// LANGUES

	// Affiche la liste des langues dans l'administration
	function admin_list_langs ($parametre = 'all')
	{
		$bdd = $GLOBALS['bdd'] ;
		$bdd_tables = $GLOBALS['bdd_tables'] ;

		$query_list_lang = $bdd->query	('
									SELECT * FROM ' . $bdd_tables['languages'] . ' ORDER BY `nom` ;
								') ;
								
		$query_list_lang = $query_list_lang->fetchAll() ;
		
		foreach ($query_list_lang as $cle => $element)
		{
			IF ( $GLOBALS['site_config']['default_language'] == $element['id'] )
			{
				$etat = $GLOBALS['lang_admin_lang_etat_default'] ;
				$action = NULL ;
				
			}
			ELSE 
			{
				$etat = $GLOBALS['lang_admin_lang_etat_other'] ;
				$action = '<a href="index.php?module=languages&amp;set_default_lang='.$element['id'].'">'.$GLOBALS['lang_admin_lang_action_setdefault'].'</a> | 
				<a onclick="return(confirm(\''.$GLOBALS['lang_admin_lang_action_delete_confirm'].'\'))" href="index.php?module=languages&amp;delete_lang='.$element['id'].'">'.$GLOBALS['lang_admin_lang_action_delete'].'</a>' ;
			}
			
			$use = popularity($element['id'], 'lang') ;
			
			echo	'
					<tr>
						<td>'.$element['id'].'</td>
						<td>'.$element['nom'].'</td>
						<td>'.$use.'</td>
						<td>'.$etat.'</td>
						<td>'.$action.'</td>
					</tr>
					' ;
		}
		
	}
	
	
	// Supression d'une langue
	function delete_lang ($id_lang)
	{
		$bdd = $GLOBALS['bdd'] ;
		$bdd_tables = $GLOBALS['bdd_tables'] ;
		
		
		
		// Suppression du fichier
		
		$delete_file_query = $bdd->prepare	('SELECT `nom` FROM '.$bdd_tables['languages'].' WHERE `id` = ? ') ;
		$delete_file_query->execute	( array($id_lang) ) ;
		
		$delete_file_array = $delete_file_query->fetch(PDO::FETCH_NUM) ;
		
		$ISO = $delete_file_array['0'] ;		
		
		unlink('../language/'.$ISO.'.php') ;
		
		
		
		// Suppression de la base
		
		$query = $bdd->prepare	('
									DELETE FROM ' . $bdd_tables['languages'] . ' 
									WHERE `id` = :idlang ;
									UPDATE ' . $bdd_tables['users'] . ' SET
									`id_language` = :defaultlang 
									WHERE `id_language` = :idlang ;
								') ;
		$query->execute	(
							array	( 	'idlang' => $id_lang,
										'defaultlang' => $GLOBALS['site_config']['default_language']
									)
						) ;


	}
	
	
	// Change la langue par défault
	function set_lang_default ($id_lang)
	{
		$bdd = $GLOBALS['bdd'] ;
		$bdd_tables = $GLOBALS['bdd_tables'] ;
		
		$query = $bdd->prepare	('
									UPDATE ' . $bdd_tables['config'] . ' SET
									`valeur` = ? 
									WHERE `parametre` = \'default_language\' ;
								') ;
		$query->execute	(
							array	($id_lang)
						) ;


	}
	
	// Vérifie la validité d'une nouvelle langue candidate
	function new_lang_candidate_check ( $talk = FALSE )
	{
		$error = FALSE ;
		$error_talk = NULL ;
		
		IF (
				array_key_exists('new_lang_ISOname', $_POST) AND
				ctype_alpha($_POST['new_lang_ISOname']) AND
				strlen($_POST['new_lang_ISOname']) <= 3 AND strlen($_POST['new_lang_ISOname']) >= 2
			)
		{}
		ELSE 
		{
			$error = TRUE ; 
			$error_talk['ISO'] = $GLOBALS['lang_admin_style_newslangname_fail'] ;
		}

		IF (
				isset($_FILES['fichier_langue']) AND
				$_FILES['fichier_langue']['error'] == 0 AND
				$_FILES['fichier_langue']['size'] <= 50000
			)
		{}
		ELSE 
		{
			$error = TRUE ; 
			$error_talk['FILE'] = $GLOBALS['lang_admin_style_newslangfile_fail'] ;
		}
		
		
		// Résolution
		
		IF ( $error == FALSE )
		{ return TRUE ; }
		ELSEIF ( $error == TRUE AND $talk == FALSE )
		{
			return FALSE ;
		}
		ELSEIF ( $error == TRUE AND $talk == TRUE )
		{
			return $error_talk ;
		}
		
	}
	
	// Inscription d'une nouvelle langue
	function new_lang ($ISO)
	{
	
		$bdd = $GLOBALS['bdd'] ;
		$bdd_tables = $GLOBALS['bdd_tables'] ;
		
		move_uploaded_file($_FILES['fichier_langue']['tmp_name'], '../language/'.$ISO.'.php') ;
		
		$query = $bdd->prepare	('
									INSERT INTO ' . $bdd_tables['languages'] . ' (`nom`)
									VALUES (?) ;
								') ;
		$query->execute	( array($ISO) ) ;
		
	}



// SITE CONFIG


	// On valide ... ou non la candidature de la nouvelle configuration du site
		// ETAT 100% -> Vérification minimal, l'administrateur n'est pas censé xss son propre site de façon malveillante.
		function set_config_candidate ($talk = FALSE)
		{
				$error = FALSE ;
				
				// Vérification du titre
				IF ( strlen($_POST['set_title']) <= 60 )
				{}
				ELSE
				{
					$error = TRUE ;
					$siteconfig_fails_list['title'] = $GLOBALS['lang_admin_sitecongig_faillist_title'] ;
				}
				
				// Vérification du nombre de messages affichés
				IF ( strlen($_POST['set_nbrarticle']) <= 3 AND ctype_digit($_POST['set_nbrarticle']) )
				{}
				ELSE
				{
					$error = TRUE ;
					$siteconfig_fails_list['nbrarticles'] = $GLOBALS['lang_admin_sitecongig_faillist_nbrarticle'] ;
				}
				
				// Vérification des mots clés
				IF ( strlen($_POST['set_motscles']) <= 50 )
				{}
				ELSE
				{
					$error = TRUE ;
					$siteconfig_fails_list['motscles'] = $GLOBALS['lang_admin_sitecongig_faillist_motcles'] ;
				}
				
				// Vérification du copyright
				IF ( strlen($_POST['set_copyright']) <= 255 )
				{}
				ELSE
				{
					$error = TRUE ;
					$siteconfig_fails_list['copyright'] = $GLOBALS['lang_admin_sitecongig_faillist_copyright'] ;
				}
				

				
			IF ( $error == TRUE )
			{
				IF ( $talk == TRUE )
				{
					return $siteconfig_fails_list ;
				}
				ELSEIF ( $talk == FALSE )
				{
					return FALSE ;
				}
			}
			ELSEIF ( $error == FALSE )
			{
				return TRUE ;
			}
			
		}
		
	// On change la configuration du site
		function set_config ()
		{
			$bdd = $GLOBALS['bdd'] ;
			$bdd_tables = $GLOBALS['bdd_tables'] ;
			
			
			$query = $bdd->prepare	('
										UPDATE ' . $bdd_tables['config'] . ' SET
										`valeur` = :copyright 
										WHERE `parametre` = \'copyright\' ;
										
										UPDATE ' . $bdd_tables['config'] . ' SET
										`valeur` = :nbrarticle
										WHERE `parametre` = \'index_nbr_articles\' ;
										
										UPDATE ' . $bdd_tables['config'] . ' SET
										`valeur` = :motscles 
										WHERE `parametre` = \'mots_cles\' ;
										
										UPDATE ' . $bdd_tables['config'] . ' SET
										`valeur` = :sitetitle
										WHERE `parametre` = \'site_title\' ;
									') ;
									
			$query->execute	(
								array	(
											'copyright' => $_POST['set_copyright'],
											'nbrarticle' => $_POST['set_nbrarticle'],
											'motscles' => $_POST['set_motscles'],
											'sitetitle' => $_POST['set_title']
										)
							) ;
		}

?>