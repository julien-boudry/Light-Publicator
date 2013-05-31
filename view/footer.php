<?php 
/**
*
* @package LIGHT PUBLICATOR
* @copyright (c) 2013 BOUDRY Julien - Born : 22/10/1988 - France
* @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License / Licence publique générale limitée GNU
*
*/ 
?>


<footer>
	

		<?php echo get_site_copyright() ; ?>

	<?php IF ( $admin == TRUE )
	{
	echo '
	<div id="admin_link">
		<a target="blank" href="admin/" >'.$lang_admin.'</a>  
	</div> ' ;
	}
	?>
	
</footer>