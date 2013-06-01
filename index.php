<?php 
/**
*
* @package LIGHT PUBLICATOR
* @copyright (c) 2013 BOUDRY Julien - Born : 22/10/1988 - France
* @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License / Licence publique générale limitée GNU
*
*/ 


	// -------------------------------- MISE EN PLACE DES FONDAMENTAUX --------------------------------------------------
		
		
		// Chargement des variables de connexion à la BDD, se sécrité et de la clé de Session
		include("config.php") ;	
		
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
		include("functions/function_config.php") ;
		include("functions/function_interface.php") ;
		include("functions/function_view.php") ;
		include("functions/function_ucp.php") ;
		include("functions/function_post.php") ;

		// On gère le système d'identification en appellant les fonctions définies. Il generera des variables de session.
			// Le cas échant, la variable $identification contient l'analyse des erreurs de mots de passe / identifiant.
		IF ( isset($_POST['id_identifiant']) AND isset($_POST['id_password']) )
		{
		$identification = identification_ask($_POST['id_identifiant'], $_POST['id_password']) ;
		}
		ELSE
		{
		$identification = identification_ask() ;
		}
		
	
		
		// -------------------------------- ON MET EN PLACE QUELQUES VARIABLES (amélioration des performances et limitation du nombre de requêtes face à des fonctions récurrement usées --------------------------------------------------
		
			// On pré-charge la configuaration du site pour s'éviter ensuite nombre de requêtes inutiles
			
				$site_config = site_config() ;
				
			// ON S'INFORME UNE BONNE FOIS POUR TOUTE SUR L'UTILISATEUR
			
				$admin = FALSE ; // Normalement un membre n'est pas administrateur.
			
				IF ( etat() == TRUE ) 
				{
					$member_infos = member_infos($_SESSION['user_id']) ;
					IF ( $member_infos['level'] == 3 ) { $admin = TRUE ; }
				}
				
			
			// Obtentions des variables de language
			
				include('language/' . what_language() . '.php') ;	
		
			
			// Nombre total de pages sur l'index
			$nbr_total_pages = show_index_articles(NULL , FALSE) ; 
				
			
			
			// Porte dérobée pour afficher facilement content_message.php
			$show_message = FALSE ; 
			
			// Mise par défault des formulaires
			
				// Valeurs par défault pour GENRE
				$return_profil['genre']['unknow'] = 'checked="checked"' ; 
				$return_profil['genre']['male'] = ' ' ;
				$return_profil['genre']['female'] = ' ' ;
				
			
			// En principe, le site n'est pas vide
				$site_empty = FALSE ;
		
		
		
	
		// -------------------------------- Quelques calculs utiles --------------------------------------------------
		
		
			// Sur quel page nous trouvons nous (utile lor de l'appel au module "content_index")
			IF (
				isset($_GET['p']) AND 
				$_GET['p'] != 0 AND 
				$_GET['p'] <= $nbr_total_pages AND 
				ctype_digit($_GET['p'])
			) 
			{
				$page = $_GET['p'] ;
			} 
			ELSE 
			{
				$page = '1' ;
			}
			
			
			
			
			// Mise en place des notifications d'erreur d'identification.
			IF ( $identification == 'id_OK' )
			{
				$wrong_id = NULL ;
				$wrong_password = $lang_pass_fail ;
			}
			ELSEIF ( $identification == 'id_NOT_OK' )
			{
				$wrong_id = $lang_id_fail ;
				$wrong_password = NULL ;
			}
			ELSE
			{
				$wrong_id = NULL ;
				$wrong_password = NULL ;
			}
		
		
			// Contenu de la page message
			IF ( isset($_POST['id_identifiant']) AND isset($_POST['id_password']) AND etat() == TRUE )
			{ $message = $lang_message_connexion ;	}
			ELSEIF ( array_key_exists('connect', $_GET) AND	isset($_GET) AND $_GET['connect'] == 'off' AND	etat() == FALSE )
			{ $message = $lang_message_deconnexion ; }
			ELSEIF ( calc_nombre_articles() == 0 )
			{ $message = $lang_message_site_empty ; $site_empty = TRUE ; }
			ELSE
			{ $message = NULL ;	}
			
			
	// INSCRIVONS NOS JOYEUX MEMBRES, (et tenons le siège de l'affreux Foubart) 
	
		
		IF ( isset($_POST['inscription_candidate']) AND $_POST['inscription_candidate'] == 'on' AND etat() == FALSE AND inscription_activation() )
		{
			IF ( profilage_candidate_ckeck() == 'OK' )
			{
				inscription() ;
				$message = $lang_message_inscription.'.' ;
				$show_message = TRUE ;
				$member_infos = member_infos($_SESSION['user_id']) ;
			}
			ELSE
			{
				$profilage_fails_list = profilage_candidate_ckeck() ;
				$return_profil = convert_return_profil_options() ;
			}
		}
	
	// Traitement des MODIFS DE PROFIL 

	
	IF ( isset($_POST['edit_ucp_candidate']) AND $_POST['edit_ucp_candidate'] == 'on' AND etat() == TRUE )
	{
		IF ( profilage_candidate_ckeck(TRUE, $member_infos) == 'OK' )
		{
			update_profil($_SESSION['user_id']) ;
			$message = $lang_message_edit_profil.'.' ;
			$show_message = TRUE ;
		}
		ELSE
		{
			$profilage_fails_list = profilage_candidate_ckeck(TRUE, $member_infos) ;
			$return_profil = convert_return_profil_options() ;
		}
	}
	
	// Traitement de la suppression des messages
	
	IF ( isset($_GET['delete_post']) AND ctype_digit($_GET['delete_post']) )
	{ $article_infos = show_article($_GET['delete_post'], TRUE ) ; }
	
	IF 	(	( isset($_GET['delete_post']) AND ctype_digit($_GET['delete_post']) ) AND
			( isset($member_infos['level']) AND $member_infos['level'] > 1 ) AND
			( isset($_SESSION['user_id']) AND ( $article_infos['id_auteur'] == $_SESSION['user_id'] OR $member_infos['level'] > 2 ) )
		)
	{
		delete_post($_GET['delete_post']) ;
	}
	
	
	// Traitement des nouveaux commentaires
	
	IF 	( 	( isset($_GET['article']) AND ctype_digit($_GET['article']) AND entry_exist($bdd_tables['billets'], 'id', $_GET['article']) ) AND
			( isset($_POST['post_comment']) AND $_POST['post_comment'] == 'new' ) AND
			( etat() == TRUE AND $member_infos['level'] > 0 )	
		)
	{
		IF ( comment_candidate_check() == 'OK' )
		{
			new_comment($_SESSION['user_id'], $_GET['article'], $_POST['comment_content'] ) ;
		}
		ELSE
		{
			$comment_fails_list = comment_candidate_check() ;
			
		}
	}
	
	// Traitement de la suppression des commentaires
	
	IF ( isset($_GET['delete_comment']) AND ctype_digit($_GET['delete_comment']) )
	{ $comment_infos = comment_infos($_GET['delete_comment']) ; }
	
	IF 	(	( isset($_GET['delete_comment']) AND ctype_digit($_GET['delete_comment']) ) AND
			( isset($member_infos['level']) AND $member_infos['level'] > 0 ) AND
			( isset($_SESSION['user_id']) AND ( $comment_infos['id_auteur'] == $_SESSION['user_id'] OR $member_infos['level'] > 2 ) )
		)
	{
		delete_comment($_GET['delete_comment']) ;
	}
		
	
	
	
	// -------------------------------- ON SE LANCE DANS UN LABYRINTH ORGANISE (comme tous les labyrinths) --------------------------------------------------
	
			// On va définir le lien vers lequel renvoi le bouton de connexion/deconnexion, et son contenu.
			IF ( etat() == FALSE )
			{
				$contenu_bouton_connexion = '<a href="index.php?connect=on">' . $lang_connect . '</a>' ;
			}
			ELSE
			{
				$contenu_bouton_connexion = '<a href="index.php?connect=off">' . $lang_disconnect . '</a>'  ;
			}	
		
			
		// On charge les differentes wiews

		include("view/head_html.php") ;
		include("body_process.php") ;
		echo '</html>' ;

?>