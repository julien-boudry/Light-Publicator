<?php 
/**
*
* @package LIGHT PUBLICATOR
* @copyright (c) 2013 BOUDRY Julien - Born : 22/10/1988 - France
* @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License / Licence publique générale limitée GNU
*
*/ 
?>

<div id="content">
	
	<div id="menu_ucp" >
	
		<div class="blocs_menu_ucp<?php IF ( array_key_exists('page', $_GET) == FALSE ) {echo ' ucp_menu_select';} ?>" id="blocs_menu_recap" >
			<?php echo '<a href="index.php?module=ucp" >' . $lang_ucp_recap . '</a>' ?>
		</div>
		
		<div class="blocs_menu_ucp<?php IF ( isset($_GET['page']) AND $_GET['page'] == 'billets' ) {echo ' ucp_menu_select';} ?>" id="blocs_menu_messages" >
			<?php IF ( etat() == TRUE AND $member_infos['level'] > 1 ) { echo '<a href="index.php?module=ucp&amp;page=billets" >' . $lang_ucp_messages . '</a>' ; } ?>
		</div>
		
		<div class="blocs_menu_ucp<?php IF ( isset($_GET['page']) AND $_GET['page'] == 'comments' ) {echo ' ucp_menu_select';} ?>" id="blocs_menu_commentaires" >
			<?php echo '<a href="index.php?module=ucp&amp;page=comments" >' . $lang_ucp_commentaires . '</a>' ?>
		</div>
		
		<div class="blocs_menu_ucp<?php IF ( isset($_GET['page']) AND $_GET['page'] == 'profil' ) {echo ' ucp_menu_select';} ?>" id="blocs_menu_reglages" >
			<?php echo'<a href="index.php?module=ucp&amp;page=profil" >' . $lang_ucp_reglages . '</a>' ?>
		</div>
		
	</div>
	
	<div id="content_ucp" >
	<?php
		IF ( isset($_GET['page']) )
		{
			IF ( $_GET['page'] == 'billets' )
			{
				include("content_ucp_billets.php") ;
			}
			ELSEIF ( $_GET['page'] == 'comments' )
			{
				include("content_ucp_comments.php") ;
			}
			ELSEIF ( $_GET['page'] == 'profil' )
			{
				include("content_ucp_profil.php") ;
			}
		}
		ELSE
		{
			include("content_ucp_recap.php") ;
		}
	?>
		
	</div>
	
</div>