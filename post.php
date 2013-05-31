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

		
		
	// -------------------------------- ON MET EN PLACE QUELQUES VARIABLES (amélioration des performances et limitation du nombre de requêtes face à des fonctions récurrement usées --------------------------------------------------
		
		// On pré-charge la configuaration du site pour s'éviter ensuite nombre de requêtes inutiles
		
			$site_config = site_config() ;
			
		// ON S'INFORME UNE BONNE FOIS POUR TOUTE SUR L'UTILISATEUR
		
		
			IF ( etat() == TRUE ) 
			{
				$member_infos = member_infos($_SESSION['user_id']) ;
				IF ( $member_infos['level'] >= 2 ) {}
				ELSE { exit() ; }
			}
			
		
		// Obtentions des variables de language
		
			include('language/' . what_language() . '.php') ;	
				
				
				
	// -------------------------------- MOTEUR --------------------------------------------------

	
		
		$post_titre = NULL ; // Par default, le titre de l'article est vide.
		$post_content = NULL ; // Par default, le contenu de l'article est vide.
		


	// Chargement des informations par défault :  Nouveau message OU édition d'un message ??
		IF ( isset($_GET['edit']) AND ctype_digit($_GET['edit']) )
		{
			$send_type = 'article_edit' ;
			
			$article_infos = show_article ($_GET['edit'], TRUE ) ;
			
			$post_titre = $article_infos['titre'] ; 
			$post_content = $article_infos['contenu'] ; 
			
			$post_hidden_value = $_GET['edit'] ;
		}
		ELSE
		{
			$send_type = 'article_send' ;
			
			$post_hidden_value = 'on' ;
		}
		
		
		
		
		// On traite la réception du contenu d'un nouvel article
		
		IF ( isset($_POST['article_send']) AND $_POST['article_send'] == 'on' AND etat() == TRUE AND $member_infos['level'] > 1 )
		{
			IF ( posting_candidate_check() == 'OK' )
			{
				new_post() ;
			}
			ELSE
			{
				$edit_fails_list = posting_candidate_check () ;
				
				$post_titre = $_POST['edit_titre'] ; // Par default, le titre de l'article est vide.
				$post_content = $_POST['edit_content'] ; // Par default, le contenu de l'article est vide.
			}
		}
		
		// On traite la réception du contenu d'une édition d'article
		
		IF ( isset($_POST['article_edit']) AND ctype_digit($_POST['article_edit']) AND etat() == TRUE AND $member_infos['level'] > 1 )
		{
			$article_infos = show_article($_POST['article_edit'], TRUE ) ;
			
			IF ( 	posting_candidate_check() == 'OK' AND 
					( $article_infos['id_auteur'] == $_SESSION['user_id'] ) OR $member_infos['level'] == 3 )
			{
				edit_post($_POST['article_edit']) ;
			}
			ELSE
			{
				$edit_fails_list = posting_candidate_check () ;
				
				$post_titre = $_POST['edit_titre'] ; // Par default, le titre de l'article est vide.
				$post_content = $_POST['edit_content'] ; // Par default, le contenu de l'article est vide.
			}
		}
	
	
					
		// On CHARGE LES VIEWS

		include("view/post_head_html.php") ;
		
		
		IF ( etat() == TRUE AND $member_infos['level'] > 1 AND isset($_POST['article_send']) AND $_POST['article_send'] == 'on' AND	posting_candidate_check() == 'OK' )
		{
			include("view/post_send.php") ;
		}
		ELSEIF ( etat() == TRUE AND $member_infos['level'] > 1 AND isset($_POST['article_edit']) AND ctype_digit($_POST['article_edit']) AND posting_candidate_check() == 'OK' )
		{
			include("view/post_send.php") ;
		}
		ELSEIF (etat() == TRUE AND $member_infos['level'] > 1)
		{
			include("view/post_edit.php") ;
		}
		ELSE
		{
			echo $lang_post_forbid ;
		}
		
		echo '</body></html>' ;

?>