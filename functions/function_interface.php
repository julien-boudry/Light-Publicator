<?php
/**
*
* @package LIGHT PUBLICATOR
* @copyright (c) 2013 BOUDRY Julien - Born : 22/10/1988 - France
* @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License / Licence publique générale limitée GNU
*
*/


// HEAD HTML

	// Fonction permettant de nommer la page (header html)
		// A FAIRE, ACCOMPLISSEMENT 0%
		function titre_page ()
		{
		
			$bdd = $GLOBALS['bdd'] ;
			$bdd_tables = $GLOBALS['bdd_tables'] ;
			
			$result = $GLOBALS['site_config']['site_title'] ;
			
			IF ( isset($_GET['article']) AND ctype_digit($_GET['article']) )
			{
				$query = $bdd->prepare('SELECT `titre` FROM ' . $bdd_tables['billets'] . ' WHERE `id` = ? ;') ;
				$query->execute(array($_GET['article'])) ;
				
				$array = $query->fetch(PDO::FETCH_NUM) ;
				
				$result = $array['0'] ;			
			}
			
			IF ( isset($_GET['module']) AND $_GET['module'] == 'ucp' )
			{
				$result = 'UCP | '.$result ;
			}
			
			return $result ;
			
		}
		
	// Fonction permettant de remplir les keywords du head html
		// ETAT 100%
		function keyword_head ()
		{
			return $GLOBALS['site_config']['mots_cles'] ;
		}
		
		
		
// AFFICHAGE DE PARAMETRES D'IDENTITE DU SITE
		
		
	// Fonction permettant d'obtenir le titre du site
		// ETAT : PLEINEMENT FONCTIONNELLE
		function get_site_title ()
		{
			return $GLOBALS['site_config']['site_title'] ;
		}
		
		
	// Fonction permettant d'obtenir la note de copyright
		// ETAT : PLEINEMENT FONCTIONNELLE
		function get_site_copyright ()
		{		
			return $GLOBALS['site_config']['copyright'] ;			
		}
		
		
	// Fonction permettant d'obtenir le code html perso du footer
		// ETAT : PLEINEMENT FONCTIONNELLE
		function get_footer_custom_html()
		{
			return $GLOBALS['site_config']['footer_html'] ;		
		}
		

		
// FONCTIONS DE PERSONALISATION DE L'INTERFACE ET DE LA LANGUE PAR UTILISATEUR

	// Fonction permettant d'afficher le style personalisé de l'utilisateur
	// Si (TRUE), retourne l'id du style par défault.
		// ACCOMPLISSEMENT 100%
		function user_style ($default_only = FALSE)
		{
			$bdd = $GLOBALS['bdd'] ;
			$bdd_tables = $GLOBALS['bdd_tables'] ;
		
			IF (etat() == FALSE OR $default_only == TRUE) // On va affichier le style par défault.
			{
				
				$style_default = $GLOBALS['site_config']['default_style'] ;	
				
				IF ($default_only == TRUE)
				{ return $style_default ; }
				
				$style_detail_query = $bdd->query('SELECT `fichier_css`, `nom` FROM ' . $bdd_tables['styles'] . '  WHERE `id` = \'' . $style_default . '\' ;') ;
				
				$style_detail_array = $style_detail_query->fetch(PDO::FETCH_NUM) ;
				
				$result = $style_detail_array['0'] ;
			}
			ELSEIF ( etat() )
			{
				$user_array = $GLOBALS['member_infos']['id_style'] ;
				
				$style_perso_query = $bdd->query('SELECT `fichier_css` FROM ' . $bdd_tables['styles'] . ' WHERE `id` = ' . $user_array . ' ;') ;
				
				$style_perso_array = $style_perso_query->fetch(PDO::FETCH_NUM) ;
				
				$result = $style_perso_array['0'] ;
				
			}
			
			return $result ;
				
			}
			
	// Fonction permettant de déterminer le language approprié
		// ACCOMPLISSEMENT 100%
		function what_language ()
		{		
		$bdd = $GLOBALS['bdd'] ;
		$bdd_tables = $GLOBALS['bdd_tables'] ;
		
		
			// Cas où l'on veut le language par défault
				IF (etat() == FALSE) // Cas où l'utilisateur n'est pas connecté
				{
					
					$langue_default = tell_default_lang() ;
					
					$language_detail_query = $bdd->prepare('SELECT `nom` FROM ' . $bdd_tables['languages'] . '  WHERE `id` = \'' . $langue_default . '\' ;') ;
					$language_detail_query->execute() ;
					
					$language_detail_array = $language_detail_query->fetch(PDO::FETCH_NUM) ;
					
					$result = $language_detail_array['0'] ;
					
				}
				ELSE // Cas où l'utilisateur est connecté
				{
				
					global $member_infos ;
					
					$user_array = $member_infos['id_language'] ;
					
					$language_perso_query = $bdd->query('SELECT `nom` FROM ' . $bdd_tables['languages'] . ' WHERE `id` = ' . $user_array . ' ;') ;
					
					$language_perso_array = $language_perso_query->fetch(PDO::FETCH_NUM) ;
					
					$result = $language_perso_array['0'] ;
				
				}
				
			return $result ;
			
		}

?>