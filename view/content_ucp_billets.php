<?php 
/**
*
* @package LIGHT PUBLICATOR
* @copyright (c) 2013 BOUDRY Julien - Born : 22/10/1988 - France
* @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License / Licence publique générale limitée GNU
*
*/ 
?>

<div id="ucp_billets_title">
	<?php echo $lang_ucp_billet_title_1 . compteur_member_stats('billets', $_SESSION['user_id']) . $lang_ucp_billet_title_2  ; ?>
</div>

	<div id="ucp_billets" >
	
		<table>
			<tr>
				<th>ID :</th>
				<th><?php echo $lang_ucp_table_billets_title ; ?></th>
				<th><?php echo $lang_ucp_table_billets_create ; ?></th>
				<th><?php echo $lang_ucp_table_billets_edit ; ?></th>
				<th><?php echo $lang_ucp_table_billets_edit_date ; ?></th>
				<th><?php echo $lang_ucp_table_billets_comments ; ?></th>
				<th><?php echo $lang_ucp_table_billets_action ; ?></th>
			</tr>
				<?php show_in_ucp('billets', $_SESSION['user_id']) ; ?>
		</table>
	
	</div>
	
	