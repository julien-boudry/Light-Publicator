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

	// -------------------------------- MISE EN PLACE DES FONDAMENTAUX --------------------------------------------------
		
		
		// Chargement des variables de connexion à la BDD, se sécrité et de la clé de Session
		include("../config.php") ;	
		
				// Si tu ne reviens pas installer correctement ce CMS, j'arrête tous.
				IF ( isset($not_install) ) 
				{ 
					echo 'You must install first this CMS' ;
					exit() ;
				}
		
		// On initialise le système de sessions
		session_name($cle_session) ;
		session_start() ;
		
		// INCLUSION DES OBJETS ARCHAÏQUES
		include("../functions/function_config.php") ;
		include("../functions/function_interface.php") ;
		include("../functions/function_view.php") ;
		include("../functions/function_ucp.php") ;
		include("../functions/function_post.php") ;
		include("../functions/function_admin.php") ;
		
		
		// On met en cache les paramètres du site
		
		$site_config = site_config() ;
		
		// Activationj du mode admmin
		$admin_mode = TRUE ;
		
		
		// ON S'INFORME sur l'utisateur et le cas échéant ... on bloque le script.
		
		
			IF ( etat() == TRUE ) 
			{
				$member_infos = member_infos($_SESSION['user_id']) ;
				
				IF ( $member_infos['level'] == 3 )
				{ $admin = TRUE ; }
				ELSE
				{ exit() ; }
			}
			ELSE { exit() ; }
			
		


		// Obtentions des variables de language
		include('../language/' . what_language() . '.php') ;


// Dans tous les autres cas de figures, ON AFFICHE TOUJOURS LE HEADER

		include("views/header.php") ;
		
		
// ----------------------- MOTEUR ---------------------------------------------------------------------------


	// Mise en place de la vérification du mot de passe lors de la connexion à l'interface d'administration.
	
		// Si la sécurité est confirmée on peut continuer, autrement on demande une confirmation du mot de passe.
		IF 	( 	isset($_POST['verif_password']) AND
				($_SESSION['user_id'] == identification_check($member_infos['pseudo'], $_POST['verif_password']) )
			) // Vous remarquerez la géniale économie et concaténation de fonctions ... Mais oui, mais oui.
			{
				$_SESSION['admin_connect'] = TRUE ;
			}
		
		IF ( isset($_SESSION['admin_connect']) == FALSE )
		{
			include("views/admin_security.php") ;
			include("views/footer.php") ;
			exit() ;
		}
		
		
	// Aiguillage des affichages
	
	
		// Par défault, on affiche le récapitulatif
		
			IF ( isset($_SESSION['admin_connect']) == TRUE AND isset($_GET['module']) == FALSE )
			{
				include("views/admin_recap.php") ;
			}
			
				// Cas particulier où l'on demande PHP INFOS
				IF ( isset($_SESSION['admin_connect']) AND $_SESSION['admin_connect'] == TRUE AND isset($_GET['module']) AND $_GET['module'] == 'phpinfos' )
				{
				include("views/admin_phpinfos.php") ;
				}
				
				// Traitrement de la demande d'optimisation des tables
				IF ( isset($_GET['optimisation']) == TRUE AND $_GET['optimisation'] == 'on' )
				{ bdd_optimisation () ; }
			
		
		// Affichage de la gestion des membres
		
			IF 	( 	isset($_GET['tri']) AND
					( 	$_GET['tri'] == 'id' OR
						$_GET['tri'] == 'pseudo' OR 
						$_GET['tri'] == 'prenom' OR 
						$_GET['tri'] == 'nom' OR 
						$_GET['tri'] == 'genre' OR 
						$_GET['tri'] == 'email' OR 
						$_GET['tri'] == 'date_inscription' OR 
						$_GET['tri'] == 'id_style' OR 
						$_GET['tri'] == 'id_lang' OR 
						$_GET['tri'] == 'level'
					)
				)
			{ $tri = $_GET['tri'] ; } ELSE { $tri = 'id' ;}
			
			
			IF ( isset($_SESSION['admin_connect']) == TRUE AND isset($_GET['module']) AND $_GET['module'] == 'members' )
			{
				include("views/admin_members.php") ;
			}
			
			// Affichage & traitement de l'édition d'un membre
			
				$edit_member_state = FALSE ;
			
				// Traitement
				IF ( isset($_SESSION['admin_connect']) AND $_SESSION['admin_connect'] == TRUE AND isset($_POST['edit_adminmember_candidate']) AND $_POST['edit_adminmember_candidate'] == 'on' AND etat() == TRUE AND isset($_GET['id']) AND ctype_digit($_GET['id']) )
				{
					IF ( profilage_candidate_ckeck(TRUE, member_infos($_GET['id'])) == 'OK' )
					{
						$edit_member_state = TRUE ;
						update_profil($_GET['id']) ;
					}
					ELSE
					{
						$profilage_fails_list = profilage_candidate_ckeck(TRUE, member_infos($_GET['id'])) ;
						$return_profil = convert_return_profil_options() ;
					}
				}
			
			
				// Affichage
				IF ( isset($_SESSION['admin_connect']) == TRUE AND isset($_GET['module']) AND isset($_GET['id']) AND ctype_digit($_GET['id']) AND $_GET['module'] == 'editmember' AND $edit_member_state == FALSE )
				{ 
					$editmemberinfos = member_infos($_GET['id']) ;
					include("views/admin_member_edit.php") ;
				}
				IF ( $edit_member_state == TRUE )
				{
					$message = $lang_admin_members_success ;
					include("views/message.php") ;
				}
				
			
			// Affichage de l'édition du rang d'un membre
			
				$edit_member_rank_state = FALSE ;
				
				// Traitement
				IF ( 	( 
							isset($_SESSION['admin_connect']) AND $_SESSION['admin_connect'] == TRUE AND isset($_POST['rank_set']) AND etat() == TRUE AND isset($_GET['id']) AND ctype_digit($_GET['id'])
						) AND
						(
							$_POST['rank_set'] == 1 OR $_POST['rank_set'] == 2 OR $_POST['rank_set'] == 3
						)
					)
				{
					$edit_member_rank_state = TRUE ;
					update_rank($_GET['id'], $_POST['rank_set']) ;
				}
			
				
				
			// Supression d'un utilisateur
			
				IF	( 
						( isset($_SESSION['admin_connect']) AND $_SESSION['admin_connect'] == TRUE AND etat() == TRUE ) AND
						( isset($_GET['delete_user']) AND ctype_digit($_GET['delete_user']) )
					)
				{
					delete_user($_GET['delete_user']) ;
					$message = $lang_admin_delete_user_sucess ;
					include("views/message.php") ;
				}
				
					
					
				
			// Affichage
				IF ( isset($_SESSION['admin_connect']) == TRUE AND isset($_GET['module']) AND isset($_GET['id']) AND ctype_digit($_GET['id']) AND $_GET['module'] == 'editmember_rank' AND $edit_member_rank_state == FALSE )
				{ 
					$editmemberinfos = member_infos($_GET['id']) ;
					include("views/admin_member_edit_rank.php") ;
				}
				IF ( $edit_member_rank_state == TRUE )
				{
					$message = $lang_admin_members_success ;
					include("views/message.php") ;
				}
				
		
		// Affichage & Traitement de l'édition de masse
		
			$edit_mass_member_state = FALSE ;
		
			IF ( 
					( isset($_SESSION['admin_connect']) == TRUE AND isset($_GET['module']) ) AND
					( isset($_GET['module']) AND $_GET['module'] == 'members_mass_edit' )
					
				)
			{
			
			
				IF ( $_POST['action_for_selected'] == 'rank1' )
				{
					FOREACH ( $_POST['selection'] as $cle => $element )
					{ update_rank($element, 1) ; }
				}
				ELSEIF ( $_POST['action_for_selected'] == 'rank2' )
				{
					FOREACH ( $_POST['selection'] as $cle => $element )
					{ update_rank($element, 2) ; }
				}
				ELSEIF ( $_POST['action_for_selected'] == 'rank3' )
				{
					FOREACH ( $_POST['selection'] as $cle => $element )
					{ update_rank($element, 3) ; }
				}
				ELSEIF ( $_POST['action_for_selected'] == 'delete' )
				{
					FOREACH ( $_POST['selection'] as $cle => $element )
					{ delete_user($element) ; }
				}
				
			}
			
			
			
		// Affichage de l'édition des styles
		
			// Traitement			
			$edit_styles_state = FALSE ;
			
				// Nouveau style
				IF ( isset($_GET['action']) AND $_GET['action'] == 'new_style' )
				{
					$edit_styles_state = TRUE ;
					generate_new_style() ;
				}
				// Changement de style par défault
				IF ( isset($_GET['set_default_style']) AND ctype_digit($_GET['set_default_style']) AND entry_exist($bdd_tables['styles'], 'id', $_GET['set_default_style']) )
				{
					$edit_styles_state = TRUE ;
					set_style_default($_GET['set_default_style']) ;
				}
				// Suppression d'un style
				IF ( isset($_GET['delete_style']) AND ctype_digit($_GET['delete_style']) AND entry_exist($bdd_tables['styles'], 'id', $_GET['delete_style']) AND $_GET['delete_style'] != user_style(TRUE) )
				{
					$edit_styles_state = TRUE ;
					delete_style($_GET['delete_style']) ;
				}
				
			
			// Affichage
			IF ( isset($_SESSION['admin_connect']) == TRUE AND isset($_GET['module']) AND $_GET['module'] == 'styles' AND $edit_styles_state == FALSE )
			{
				include("views/admin_styles.php") ;
			}
			IF ( $edit_styles_state == TRUE )
			{
				$message = $lang_admin_style_success ;
				include("views/message.php") ;
			}
			
		
			
		
		
		// Affichage de l'édition des langues
		
			// Traitement
			$edit_lang_state = FALSE ;
			$erreur_posting_lang_candidate = NULL ;
			
				// Changement de langue par défault
				IF ( isset($_GET['set_default_lang']) AND ctype_digit($_GET['set_default_lang']) AND entry_exist($bdd_tables['languages'], 'id', $_GET['set_default_lang']) )
				{
					$edit_lang_state = TRUE ;
					set_lang_default($_GET['set_default_lang']) ;
				}
				
				// Suppression d'une langue
				IF ( isset($_GET['delete_lang']) AND ctype_digit($_GET['delete_lang']) AND entry_exist($bdd_tables['languages'], 'id', $_GET['delete_lang']) AND $_GET['delete_lang'] != $GLOBALS['site_config']['default_language'] )
				{
					$edit_lang_state = TRUE ;
					delete_lang($_GET['delete_lang']) ;
				}
				
				// Nouvelle langue
				IF ( isset($_POST['new_lang_candidate']) AND $_POST['new_lang_candidate'] == 'on' )
				{
					IF ( new_lang_candidate_check() )
					{
						$edit_lang_state = TRUE ;
						new_lang($_POST['new_lang_ISOname']) ;
					}
					ELSE
					{
						$erreur_posting_lang_candidate = new_lang_candidate_check(TRUE) ;
					}
				}
		
		
		
			// Affichage
			IF ( isset($_SESSION['admin_connect']) == TRUE AND isset($_GET['module']) AND $_GET['module'] == 'languages' AND $edit_lang_state == FALSE )
			{
				include("views/admin_languages.php") ;
			}
			IF ( $edit_lang_state == TRUE )
			{
				$message = $lang_admin_style_success ;
				include("views/message.php") ;
			}
			
			
			
		// SITE CONFIG
		
			$edit_config_state = FALSE ;
		
			// TRAITEMENT
				// Configuration de l'inscription des membres
			
				IF	( 
						( isset($_SESSION['admin_connect']) AND $_SESSION['admin_connect'] == TRUE AND etat() == TRUE ) AND
						( isset($_GET['inscription']) AND isset($_GET['module']) AND $_GET['module'] == 'siteconfig' )
					)
				{
					IF ( $_GET['inscription'] == 'on' )
					{
						$edit_config_state = TRUE ;
						set_inscription(1) ;
						
					}
					ELSEIF ( $_GET['inscription'] == 'off' )
					{
						$edit_config_state = TRUE ;
						set_inscription(0) ;
						
					}				
				}
				
				// Configuration générale
				
					// Retour des champs erronés 
					IF ( isset($_POST['set_config']) == FALSE ) 
					{ $content_site_edit = $site_config ; }
					ELSEIF ( $_POST['set_config'] == 'on' )
					{
						$content_site_edit['copyright'] = $_POST['set_copyright'] ;
						$content_site_edit['index_nbr_articles'] = $_POST['set_nbrarticle'] ;
						$content_site_edit['mots_cles'] = $_POST['set_motscles'] ;
						$content_site_edit['site_title'] = $_POST['set_title'] ;
					}
				
				IF 	( 	( isset($_SESSION['admin_connect']) AND $_SESSION['admin_connect'] == TRUE AND 			etat() == TRUE ) AND
						( isset($_POST['set_config']) AND $_POST['set_config'] == 'on' )
					)
				{
					IF ( set_config_candidate() == FALSE )
					{
						$siteconfig_fails_list = set_config_candidate(TRUE) ;
					}
					ELSEIF ( set_config_candidate() == TRUE )
					{
						$edit_config_state = TRUE ;
						set_config() ;
					}
				}
				
			// AFFICHAGE
			
				// Affichage
				IF ( isset($_SESSION['admin_connect']) == TRUE AND isset($_GET['module']) AND $_GET['module'] == 'siteconfig' AND $edit_config_state == FALSE )
				{
					include("views/admin_siteconfig.php") ;
				}
				IF ( $edit_config_state == TRUE )
				{
					$message = $lang_admin_style_success ;
					include("views/message.php") ;
				}
				
				
	
// Dans tous les cas, on finira pas le footer


		include("views/footer.php") ;
	
	





		 

		
?>