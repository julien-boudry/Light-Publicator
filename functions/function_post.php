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

		
// POST


	// OK CHECK le contenu du POST
		// ETAT 100%
		function posting_candidate_check ()
		{
		
			$error = FALSE ;
			
			// On check le titre
			IF 	( 	isset($_POST['edit_titre']) == TRUE AND
					strlen($_POST['edit_titre']) >= 4 AND
					strlen($_POST['edit_titre']) <= 300
				)				
			{}
			ELSE
			{
				$error = TRUE ;
			
				$edit_fails_list['titre'] = $GLOBALS['lang_edit_error_titre'] ;				
			} 
			
			// On check le content
			IF 	( 	isset($_POST['edit_content']) == TRUE AND
					strlen($_POST['edit_content']) <= 100000
				)				
			{}
			ELSE
			{
				$error = TRUE ;
			
				$edit_fails_list['titre'] = $GLOBALS['lang_edit_error_content'] ;				
			}
			
			
			
			IF ( $error == TRUE )
			{
				return $edit_fails_list ;
			}
			ELSE
			{
				return 'OK' ;
			}
			
			
		}
	
	
	// Enregistrement d'un nouveau billet
		// ETAT 100%
		function new_post()
		{
			$bdd = $GLOBALS['bdd'] ;
			$bdd_tables = $GLOBALS['bdd_tables'] ;
			
			$new_post_query = $bdd->prepare('
			INSERT INTO ' . $bdd_tables['billets'] . ' (`id_auteur`,`titre`,`contenu`)
			VALUES (:idauteur, :titre, :contenu)
			 ;') ;
			 
			$new_post_query->execute(
			array 	(	'idauteur' => $_SESSION['user_id'],
						'titre' => htmlspecialchars($_POST['edit_titre'], ENT_HTML5),
						'contenu' => $_POST['edit_content'] )
					) ;
		}
		
		
	// Edition d'un billet
		// ETAT 100%
		function edit_post ($post_id)
		{
			$bdd = $GLOBALS['bdd'] ;
			$bdd_tables = $GLOBALS['bdd_tables'] ;
			
			$update_query = $bdd->prepare('
			UPDATE ' . $bdd_tables['billets'] . ' SET
			`edit` = `edit`+1 ,
			`date_edit` = CURRENT_TIMESTAMP ,
			`titre` = :titre,
			`contenu` = :contenu
			WHERE `id` = :postid
			 ;') ;
			 
			$update_query->execute(
			array 	(	'titre' => htmlspecialchars($_POST['edit_titre'], ENT_HTML5),
						'contenu' => $_POST['edit_content'],
						'postid' => $post_id
					)
					
			) ;
			
		}


	// Suppression d'un billet
		// ETAT 100%
		function delete_post ($billet_id, $delete_comments = TRUE)
		{
			$bdd = $GLOBALS['bdd'] ;
			$bdd_tables = $GLOBALS['bdd_tables'] ;
			
			$delete_query = $bdd->prepare('
			DELETE FROM '. $bdd_tables['billets'] .' WHERE `id` = :billetid ;') ;
			
			$delete_query->execute(
			array	(	
						'billetid' => $billet_id
					)
			) ;
			
			// On supprime les commentaires qui vont avec.
			IF ( $delete_comments == TRUE ) { delete_billet_comments($billet_id) ; }
			
		}
	
	
		
// COMMENTS


	// CHECK le contenu du commentaire
		// ETAT 100%
		function comment_candidate_check ()
		{
		
			$error = FALSE ;
			
			// On check le contenu
			IF 	( 	isset($_POST['comment_content']) == TRUE AND
					strlen($_POST['comment_content']) >= 8 AND
					strlen($_POST['comment_content']) <= 30000
				)				
			{}
			ELSE
			{
				$error = TRUE ;
			
				$comment_fails_list['content'] = $GLOBALS['lang_post_comment_content_error'] ;				
			} 
			
			
			
			
			IF ( $error == TRUE )
			{
				return $comment_fails_list ;
			}
			ELSE
			{
				return 'OK' ;
			}
			
			
		}
		
	// Inscrit un nouveau commentaire
		// ETAT 100%
		function new_comment ($userid, $billetid, $contenu)
		{		
			$bdd = $GLOBALS['bdd'] ;
			$bdd_tables = $GLOBALS['bdd_tables'] ;
			
			$new_comment_query = $bdd->prepare('
			INSERT INTO ' . $bdd_tables['comments'] . ' (`id_billet`,`id_auteur`,`contenu`)
			VALUES (:billetid, :auteurid, :contenu)
			 ;') ;
			 
			$new_comment_query->execute(
			array 	(	'billetid' => $billetid,
						'auteurid' => $userid,
						'contenu' => htmlspecialchars($contenu, ENT_HTML5) )
					) ;
			
		}

		
	// Supprime un commentaire
		// ETAT 100%
	function delete_comment ($comment_id)
	{
		$bdd = $GLOBALS['bdd'] ;
		$bdd_tables = $GLOBALS['bdd_tables'] ;
		
		$delete_comment_query = $bdd->prepare('DELETE FROM  ' . $bdd_tables['comments'] . ' WHERE `id` = :idcomment ;') ;
			
		$delete_comment_query->execute( array	(
													'idcomment' => $comment_id
												)
										) ;
	}
		
		
	// Supression groupée de commentaires (liés à un billet)
		// ETAT 100%
		function delete_billet_comments ($billet_id)
		{
			$bdd = $GLOBALS['bdd'] ;
			$bdd_tables = $GLOBALS['bdd_tables'] ;
		
			$show_comments_query = $bdd->prepare('DELETE FROM  ' . $bdd_tables['comments'] . ' WHERE `id_billet` = :idbillet ;') ;
			
			$show_comments_query->execute( array	(
														'idbillet' => $billet_id
													)
											) ;
		}


?>