<?php 
/**
*
* @package LIGHT PUBLICATOR
* @copyright (c) 2013 BOUDRY Julien - Born : 22/10/1988 - France
* @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License / Licence publique générale limitée GNU
*
*/ 


// OUTILS DIVERS

	
	// Site configuration
		// ETAT 100%
		function site_config ()
		{
			$bdd = $GLOBALS['bdd'] ;
			$bdd_tables = $GLOBALS['bdd_tables'] ;
			
			$query = $bdd->prepare ('SELECT * FROM ' . $bdd_tables['config'] . ' ;') ;
			$query->execute() ;
			
			$traitement = $query->fetchAll() ;
			
			foreach ( $traitement as $cle => $element )
			{
				$parametre = $element['parametre'] ;
				
				$site_config[$parametre] = $element['valeur'] ;
			}
			
			return $site_config ;
		}
	
	// Fonction permettant de déterminer l'état de la session. TRUE = CONNECTE / FALSE = DECONNECTE
		// FAIT 100%
		function etat ()
		{
			if ( array_key_exists('user_id', $_SESSION) )
			{
				return TRUE ;
			}
			ELSE
			{
				return FALSE ;
			}
		}
		
		
	// Retourne TRUE si l'inscription est activé, sinon FALSE
		// ETAT 100%
		function inscription_activation ($talk = FALSE)
		{
		
			IF ( $talk == TRUE )
			{
				IF ( $GLOBALS['site_config']['inscription'] == 0 )
				{ echo $GLOBALS['lang_admin_recap_inscription_no'] ; }
				ELSEIF ( $GLOBALS['site_config']['inscription'] == 1 )
				{ echo $GLOBALS['lang_admin_recap_inscription_yes'] ; }
			}
			
			IF ( $talk == FALSE )
			{
				IF ( $GLOBALS['site_config']['inscription'] == 0 )
				{ return FALSE ; }
				ELSEIF ( $GLOBALS['site_config']['inscription'] == 1 )
				{ return TRUE ; }
			}
		}
		
		
	// Fonction permettant de calculer le nombre d'articles total du site
		// ETAT 100%
		function calc_nombre_articles ()
		{
			$bdd = $GLOBALS['bdd'] ;
			$bdd_tables = $GLOBALS['bdd_tables'] ;
		
			$count_article_query = $bdd->query('SELECT COUNT(`id`) FROM ' . $bdd_tables['billets'] . ';') ;
			 
			$count_article_array = $count_article_query->fetch(PDO::FETCH_NUM) ;
			
			return $count_article_array['0'] ;
		}
		
	// Fonction permettant de calculer le nombre de commentaire total du site
		// ETAT 100%
		function calc_nombre_comments ()
		{
			$bdd = $GLOBALS['bdd'] ;
			$bdd_tables = $GLOBALS['bdd_tables'] ;
		
			$count_comments_query = $bdd->query('SELECT COUNT(`id`) FROM ' . $bdd_tables['comments'] . ';') ;
			 
			$count_comments_array = $count_comments_query->fetch(PDO::FETCH_NUM) ;
			
			return $count_comments_array['0'] ;
		}
			
	// Outil de translation id_auteur vers nom réel (return)
		// ETAT : PLEINEMENT FONCTIONNELLE
		function id_auteur_translation ($id_auteur)
		{
			$bdd = $GLOBALS['bdd'] ;
			$bdd_tables = $GLOBALS['bdd_tables'] ;
		
			IF ( ctype_digit($id_auteur) )
			{			
				$user_search_query = $bdd->prepare('SELECT `pseudo` FROM ' . $bdd_tables['users'] . '  WHERE `id` = ? ;') ;
				$user_search_query->execute	(
												array($id_auteur)
											) ;
				
				$user_search_array = $user_search_query->fetch(PDO::FETCH_NUM) ;
				
				
				return $user_search_array['0'] ; ;
			}
		}
		
	// Outil de translation id_billet vers titre de l'article (return)
		// ETAT : PLEINEMENT FONCTIONNELLE
		function id_article_translation ($id_article)
		{
			$bdd = $GLOBALS['bdd'] ;
			$bdd_tables = $GLOBALS['bdd_tables'] ;
		
			IF ( ctype_digit($id_article) )
			{			
				$query = $bdd->prepare('SELECT `titre` FROM ' . $bdd_tables['billets'] . '  WHERE `id` = \'' . $id_article . '\' ;') ;
				$query->execute() ;
				
				$array = $query->fetch(PDO::FETCH_NUM) ;
				
				
				return $array['0'] ;
			}
		}
		
		
	// Renvoie un array avec tous les parametres d'un membre		
		// ETAT 100%
		function member_infos ($member_id)
		{
			$bdd = $GLOBALS['bdd'] ;
			$bdd_tables = $GLOBALS['bdd_tables'] ;
		
		
			IF ( ctype_digit($member_id) )
			{
			$member_infos_query = $bdd->prepare('
			SELECT `id`,`pseudo`,`prenom`,`nom`,`genre`,`email`,`level`,`date_inscription`,`id_style`,`id_language` FROM ' . $bdd_tables['users'] . ' WHERE `id` = ' . $member_id . ' ;
			') ;
			$member_infos_query->execute() ;
			
			$member_infos_array = $member_infos_query->fetch(PDO::FETCH_ASSOC) ;
			
			return $member_infos_array ;
			
			}
		}
		
	// Une entrée existe-t-elle ?
		// ETAT 100%
		function entry_exist ($table, $champ, $value)
		{
		$bdd = $GLOBALS['bdd'] ;
		
			$entry_exist_query = $bdd->prepare('SELECT ' . $champ . ' FROM ' . $table . ' WHERE ' . $champ . ' = ? ;') ;
			$entry_exist_query->execute(array($value)) ;
			
			$entry_exist_array = $entry_exist_query->fetch(PDO::FETCH_NUM) ;
			
			$result = $entry_exist_array['0'] ;
			
			IF ( $result == $value ) {return TRUE ;}
			ELSE {return FALSE ;}			
			
		}
	
	
// QUELQUES COMPTEURS pour articles / commentaires

		
	// Compte le nombre d'article & commentaires pour un membre.
		// ETAT 100%
		function compteur_member_stats ($parametre, $member_id)
		{
			$bdd = $GLOBALS['bdd'] ;
			$bdd_tables = $GLOBALS['bdd_tables'] ;
			
			
			IF ( $parametre == 'billets' AND ctype_digit($member_id) )
			{
		
			$stats_billets_query = $bdd->prepare('SELECT COUNT(`id`) FROM ' . $bdd_tables['billets'] . ' WHERE `id_auteur` = :memberid ;') ;
			$stats_billets_query->execute (array ( 'memberid' => $member_id ) ) ;
			
			$stats_billets_array = $stats_billets_query->fetch(PDO::FETCH_NUM) ;
			
			return $stats_billets_array['0'] ;
			}
			
			
			IF ( $parametre == 'comments' AND ctype_digit($member_id) )
			{
			$stats_comments_query = $bdd->prepare('SELECT COUNT(`id`) FROM ' . $bdd_tables['comments'] . ' WHERE `id_auteur` = :memberid ;') ;
			$stats_comments_query->execute (array ( 'memberid' => $member_id ) ) ;
			
			$stats_comments_array = $stats_comments_query->fetch(PDO::FETCH_NUM) ;
			
			return $stats_comments_array['0'] ;

			}
			
		}
		
		
	// Compte le nombre de commentaires pour un article
		// ETAT 100%
		function nbr_comments ($article_id)
		{
			$bdd = $GLOBALS['bdd'] ;
			$bdd_tables = $GLOBALS['bdd_tables'] ;
			
			$nbr_comments_query = $bdd->prepare('SELECT COUNT(`id`) FROM ' . $bdd_tables['comments'] . ' WHERE `id_billet` = :billetid ;') ;
			$nbr_comments_query->execute(array ( 'billetid' => $article_id ) ) ;
			
			$nbr_comments_array = $nbr_comments_query->fetch(PDO::FETCH_NUM) ;
			
			IF ( $nbr_comments_array['0'] <= 1 ) 
			{	$result['affichage'] = $nbr_comments_array['0'].' '.$GLOBALS['lang_nbr_comment_singulier'] ;	}
			
			IF ( $nbr_comments_array['0'] > 1 ) 
			{	$result['affichage'] =  $nbr_comments_array['0'].' '.$GLOBALS['lang_nbr_comments_pluriel'] ;	}
			
			$result['nbr'] = $nbr_comments_array['0'] ;
			
			return $result ;
			
		}
		
	// Renvoi des informations sur un commentaire
		// ETAT 100%
		function comment_infos ($comment_id)
		{
			$bdd = $GLOBALS['bdd'] ;
			$bdd_tables = $GLOBALS['bdd_tables'] ;
			
			
			$comment_infos_query = $bdd->prepare('SELECT * FROM ' . $bdd_tables['comments'] . ' WHERE `id` = ? ;') ;
			$comment_infos_query->execute(array($comment_id)) ;
			
			$comment_infos_array = $comment_infos_query->fetch(PDO::FETCH_ASSOC) ;
			
			return $comment_infos_array ;
		}
		
		
	

	
// CONCERNANT L'IDENTIFICATION



	// Traitement des demandes d'identifications
		// ETAT 100%
		function identification_ask ($identifiant = NULL, $password = NULL)
		{		
			$bdd = $GLOBALS['bdd'] ;
			$bdd_tables = $GLOBALS['bdd_tables'] ;
			
						
		
			// En cas de tentative de connexion, interroge identification_check, si valeurs saisie correct => création des variables de session correspondantes.
						
			IF ( isset($identifiant) AND isset($password) AND ctype_alnum($password) )
			{
			$tentative = identification_check($identifiant, $password) ;
			
				IF ( $tentative != FALSE AND ctype_digit($tentative) )
				{		
					$_SESSION['user_id'] = $tentative ;
				
				}
				ELSEIF ( id_exist($identifiant) )
				{
					return 'id_OK' ;
				}
				ELSEIF ( id_exist($identifiant) == FALSE )
				{
					return 'id_NOT_OK' ;
				}
				ELSE
				{
					echo 'BIG BUG' ;
				}
			}
			
			// Gestion de la déconnexion
			IF ( isset($_GET['connect']) AND $_GET['connect'] == 'off' )
			{
			session_destroy() ;	
			unset($_SESSION['user_id']) ;
			}

		}
	
	// Check-UP de l'identification
		// ETAT 100%
		// Retourne soit l'id du membre si les pseudo, mail & mot de passe sont corrects.
		// Autrement, Renvoie la valeur FALSE.
		function identification_check ($user_identifiant_request, $user_pass_request)
		{		
			$bdd = $GLOBALS['bdd'] ;
			$bdd_tables = $GLOBALS['bdd_tables'] ;
		
		
			$identification_check_query = $bdd->prepare('SELECT `id`, `password` FROM ' . $bdd_tables['users'] . '  WHERE (`pseudo` = :identifiant OR `email` = :identifiant) ;') ;
			$identification_check_query->execute(array(
														'identifiant' => $user_identifiant_request
														)) ;
														
			$identification_check_array = $identification_check_query->fetch(PDO::FETCH_ASSOC) ;
			
			IF ( is_null($identification_check_array) )
			{
				return FALSE ;
			}
			ELSE
			{
				$user_successfull_id = $identification_check_array['id'] ;
			}
			
			$password_check = password($user_pass_request, $identification_check_array['password']) ;
			IF ( $password_check == 2 )
			{
				entry_password ($user_successfull_id, $user_pass_request) ;
				$password_check = 1 ;
			}
			
			IF ( !$password_check )
			{
				return FALSE ;
			}
			ELSEIF ( $password_check == 1 )
			{
			return $user_successfull_id ;
			}
		}
		
		
		
	// On repère le niveau d'erreur de l'identification
		// ETAT 100%
		// Renvoi TRUE si le pseudo ou le mail existe ; sinon, renvoi FALSE.
		function id_exist ($user_id_request)
		{		
			$bdd = $GLOBALS['bdd'] ;
			$bdd_tables = $GLOBALS['bdd_tables'] ;
		
		
			$identification_exist_query = $bdd->prepare('SELECT `id` FROM ' . $bdd_tables['users'] . '  WHERE `pseudo` = :identifiant OR `email` = :identifiant ;') ;
			$identification_exist_query->execute(array(	'identifiant' => $user_id_request )) ;
														
			$identification_exist_array = $identification_exist_query->fetch(PDO::FETCH_NUM) ;
			
			IF ( is_null($identification_exist_array['0']) )
			{
				return FALSE ;
			}
			ELSE
			{
				return TRUE ;
			}

		}
		
	// Hash Password
	function password ($password, $hash = 'need_hash')
	{
	// PHP Inférieur à 5.5.0
	IF (version_compare(PHP_VERSION, '5.5.0') < 0)
	{
		IF ( !isset($GLOBALS['admin_mode']) )
		{
			include_once 'functions/password_old_php_compatibility.php' ;
		}
		ELSEIF ( $GLOBALS['admin_mode'] ) // Correction du chemin lors de la verif MDP admin
		{
			include_once '../functions/password_old_php_compatibility.php' ;
		}
	}
	
		$cost = $GLOBALS['bcrypt_cost'] ;
	
		$password = $GLOBALS['security_key'].$password ;
		
		// Generation de Hash
		IF ( $hash == 'need_hash' )
		{
			return password_hash($password, PASSWORD_DEFAULT, array( 'cost' => $cost ) ) ;			
		}
		
		// On continue ... on vérifie le mot de passe
		$verify = password_verify($password, $hash) ;
		
		IF ( !$verify ) { return FALSE ; }
		
		
		// Faut-il re-hash ?
		IF ( password_needs_rehash($hash, PASSWORD_DEFAULT, array( 'cost' => $cost ) ) && $verify )
		{
			return 2 ;
		}
		ELSE
		{
			return 1 ;
		}
		// 1 = Ok / 2 = Ok + rehash
		
	}

?>