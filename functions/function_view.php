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

// AFFICHAGE EN INDEX

	// Fonction permettant d'obtenir le nombre d'articles à afficher en index
		// ETAT : PLEINEMENT FONCTIONNELLE
		function show_site_nbr_articles ()
		{		
			return $GLOBALS['site_config']['index_nbr_articles'] ;
		}


		
	// Fonction permettant d'afficher les articles sur l'index si $affichage=TRUE.
	// Autrement, il renvoie le nombre de pages maximale.
		// ETAT : 100%
		function show_index_articles ($page = 1, $affichage = TRUE)
		{	
		
			$bdd = $GLOBALS['bdd'] ;
			$bdd_tables = $GLOBALS['bdd_tables'] ;
			
	
			IF ( ctype_digit($page) OR $page == NULL ) { } ELSE { echo 'MERCI DE NA PAS TRAFIQUER CE MAGNIFIQUE CODE SALE NOOB' ; RETURN FALSE ; }
			
			$site_nbr_articles = show_site_nbr_articles() ;
			$start = $page * $site_nbr_articles - $site_nbr_articles ;
			
			IF ( $affichage == TRUE ) 
			{			
				$show_index_articles_query = $bdd->query('SELECT * FROM  ' . $bdd_tables['billets'] . ' ORDER BY `date` DESC LIMIT ' . $start . ',' . $site_nbr_articles . ';') ;
			

				while ( $show_index_articles_array = $show_index_articles_query->fetch(PDO::FETCH_ASSOC) )
				{
				
					$comment = nbr_comments($show_index_articles_array['id']) ;
					
					IF ( $comment['nbr'] > 0 ) 
					{ 
						$lien_comments1 = '<a href="index.php?article=' . $show_index_articles_array['id'] . '#comments">' ; 
						$lien_comments2 = '</a>' ;
					} 
					ELSE
					{ 
						$lien_comments1 = NULL ;
						$lien_comments2 = NULL ;
					}
					
					
					 echo	'<article>' . 
							'<header class="article_header">
								<h2>
									<a href="index.php?article=' . $show_index_articles_array['id'] . '">' . $show_index_articles_array['titre'] . '</a>
								</h2>' .
								'<div class="articles_infos articles_infos_date" >' . 
									$show_index_articles_array['date'] . 
								'</div>' .
								'<div class="articles_infos articles_infos_auteur" >' . 
									id_auteur_translation($show_index_articles_array['id_auteur']) . '<br/><br/>' . '
								</div>
							</header>
							<div class="index_article_content" >' .
							$show_index_articles_array['contenu'] . 
							'</div>
							<div class="index_article_edit" >&nbsp;
							<div class="index_article_comments" >'.
									$lien_comments1.
									$comment['affichage'].$lien_comments2.'
							</div>'
							;
							
						IF 	( 
								( isset($_SESSION['user_id']) AND $show_index_articles_array['id_auteur'] == $_SESSION['user_id'] ) OR
								( etat() AND $GLOBALS['member_infos']['level'] == 3 )
							)
						{
							echo 	'
										<div class="index_article_edit_detail index_article_edit_detail_delete" >
											<a href="index.php?delete_post='.$show_index_articles_array['id'].'" onclick="return(confirm(\''.$GLOBALS['lang_delete_confirm_billet'].'\'))" > '.
												$GLOBALS['lang_delete'].'
											</a></div>
										<div class="index_article_edit_detail index_article_edit_detail_edit" >
											<a href="#null" onclick="javascript:open_infos(\'post.php?edit='.$show_index_articles_array['id'].'\');">'.
												$GLOBALS['lang_edit'].'
											</a>
										</div>									
									
									' ;
						}
						
					echo '</div></article>' ;
							
				}

			}
			ELSE
			{
			 
			 $result = ceil( calc_nombre_articles() / $site_nbr_articles ) ;
			 
			 return $result ;
			 
			}
			
		}
		
		
	// Outil déterminant la page suivante, ou précédente
		// ETAT : PLEINEMENT FONCTIONNELLE
		function repond_ama_page_position ($nbr_total_pages, $page)
		{
			IF ( $nbr_total_pages > 1 AND $nbr_total_pages == $page )
			{
				$proxim_page = array(
					'suivante' => NULL,
					'precedente' => '<a href="index.php?p=' . ($page - 1) . '"> &lsaquo; </a>',
					'debut' => '<a href="index.php?p=1">' . $GLOBALS['lang_first_page'] . '</a>',
					'fin' =>  NULL
				) ;
				
				return $proxim_page ;
			}
			ELSEIF ( $nbr_total_pages > $page AND $page > 1 )
			{
					$proxim_page = array(
					'suivante' => '<a href="index.php?p=' . ($page + 1) . '"> &rsaquo; </a>',
					'precedente' => '<a href="index.php?p=' . ($page - 1) . '"> &lsaquo; </a>',
					'debut' => '<a href="index.php?p=1">' . $GLOBALS['lang_first_page'] . '</a>',
					'fin' =>  '<a href="index.php?p=' . $nbr_total_pages . '">' . $GLOBALS['lang_last_page'] . '</a>'
				) ;
				
				return $proxim_page ;
			}
			ELSEIF ( $nbr_total_pages > $page AND $page == 1 )
			{
				$proxim_page = array(
					'suivante' => '<a href="index.php?p=' . ($page + 1) . '"> &rsaquo; </a>',
					'precedente' => NULL,
					'debut' => NULL,
					'fin' =>  '<a href="index.php?p=' . $nbr_total_pages . '">' . $GLOBALS['lang_last_page'] . '</a>'
				) ;
				
				return $proxim_page ;
			}
			ELSEIF ( $nbr_total_pages == 1 )
			{
				$proxim_page = array(
					'suivante' => NULL,
					'precedente' => NULL,
					'debut' => NULL,
					'fin' => NULL
				) ;
				
				return $proxim_page ;
			}
			ELSE
			{
				$et_merde = 'WHAT THE FUCK ON repond_ama_page_position ???' ;
				echo $et_merde ;
				return $et_merde ;
			}
		}
		
		
		
// PAGE D'ARTICLE	
		
		
	// Outil d'affichage d'un article
		// ETAT : 100%
		function show_article ($article_id, $infos_only = FALSE )
		{
			$bdd = $GLOBALS['bdd'] ;
			$bdd_tables = $GLOBALS['bdd_tables'] ;
			

			
			$show_article_query = $bdd->prepare('SELECT * FROM ' . $bdd_tables['billets'] . ' WHERE `id` = ? ;') ;
			$show_article_query->execute(array($article_id)) ;
			
			$show_article_array = $show_article_query->fetch(PDO::FETCH_ASSOC) ;
				
				
			IF ( $infos_only == FALSE )
			{
				echo	'<article>' . 
								'<h3>' . $show_article_array['titre'] . '</h3>' .
								'<div class="articles_infos" id="articles_infos_date">' . $show_article_array['date'] . '</div>' .
								'<div class="articles_infos" id="articles_infos_auteur">' . id_auteur_translation($show_article_array['id_auteur']) .
								'<br/><br/>' . '</div>' .
								'<div class="index_article_content" >' . $show_article_array['contenu'] . '</div>' .
						'</article>'
							;
			}			
			ELSEIF ( $infos_only = TRUE )
			{
			
				return $show_article_array ;

			}					
			

		}
		
	// Affichage des commentaires dans la page d'un article
		// ETAT 100%	
		function show_comments ($id_article)
		{
		
			$bdd = $GLOBALS['bdd'] ;
			$bdd_tables = $GLOBALS['bdd_tables'] ;
			
		
			$show_comments_query = $bdd->prepare('SELECT * FROM  ' . $bdd_tables['comments'] . ' WHERE `id_billet` = :idarticle ORDER BY `date` ASC ;') ;
			$show_comments_query->execute( array	(
														'idarticle' => $id_article
													)
											) ;

			while ( $show_comments_array = $show_comments_query->fetch(PDO::FETCH_ASSOC) )
			{
			
				// Affichage par défault des fonctions d'édition du commentaire.
				IF ( isset($_SESSION['user_id']) AND $show_comments_array['id_auteur'] == $_SESSION['user_id'] )
				{ 
					$action = '<a href="index.php?article='.$show_comments_array['id_billet'].'&delete_comment='.$show_comments_array['id'].'" onclick="return(confirm(\''.$GLOBALS['lang_delete_confirm_comment'].'\'))" >'.$GLOBALS['lang_delete'].'</a>' ;
				}
				ELSE
				{ $action = NULL ; }
			
			
				echo	'
						<div class="comment_box" >
							<div class="comment_content">
								'.$show_comments_array['contenu'].'
							</div>
							<div class="comment_infos">
								<div class="comment_infos_auteur">
									<a href="index.php?member='.$show_comments_array['id_auteur'].'" >
									'.id_auteur_translation($show_comments_array['id_auteur']).'
									</a></div>
								<div class="comment_infos_date">
									'.$show_comments_array['date'].'
								</div>
								<div class="comment_action">
									'.$action.'
								</div>
							</div>
						</div>
						' ;
			}
			

		
		}
		
		
		
		
// OUTILS

		// Affiche la liste des erreurs à partir d'un tableau, sert aussi bien aux forrmulaires d'inscription/edition que d'article / commentaire.
		// ETAT 100%
		function error_show ($errors)
		{
			FOREACH ($errors as $element)
			{
				echo $element . '<br/>' ;
			}
			
		}

?>