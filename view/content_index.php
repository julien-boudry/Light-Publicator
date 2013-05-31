<?php 
/**
*
* @package LIGHT PUBLICATOR
* @copyright (c) 2013 BOUDRY Julien - Born : 22/10/1988 - France
* @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License / Licence publique générale limitée GNU
*
*/ 
?>


<?php // DEBUGGUAGE EXPRESS, SOLUTION PAS TRES JOLIE
IF ( $site_empty == TRUE ) { include("content_message.php") ; include("footer.php") ; exit() ;  } 
?>


<div id="content">


	<div id="contenu">
		<?php		
		
			show_index_articles($page) ;

		?>
	</div>
	
	<div id="choix_page">
		<?php
		
		// $proxim_page est un array contenant les variable de langue (ou pas) nécessaire à l'affichage de la pagination
		$proxim_page = repond_ama_page_position ($nbr_total_pages, $page) ;
		
		
		echo 
			'<div class="detail_num_page" id="debut_pagination">' . $proxim_page['debut'] . ' | </div>' .
			'<div class="detail_num_page" id="precedente_pagination">' . $proxim_page['precedente'].' | '.$lang_page.' </div>' .
			'<div class="detail_num_page" id="actuelle_pagination">'.$page . ' / </div>' .
			'<div class="detail_num_page" id="nbr_pagination">' . $nbr_total_pages . ' | </div>' .
			'<div class="detail_num_page" id="suivante_pagination">' . $proxim_page['suivante'] . ' | </div>' .
			'<div class="detail_num_page" id="fin_pagination">' . $proxim_page['fin'] . '</div>'
			;
		?>
	</div>
	
</div>