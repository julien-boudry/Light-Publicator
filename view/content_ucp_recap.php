<?php 
/**
*
* @package LIGHT PUBLICATOR
* @copyright (c) 2013 BOUDRY Julien - Born : 22/10/1988 - France
* @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License / Licence publique générale limitée GNU
*
*/ 
?>

<div id="ucp_hello">
	<?php echo $lang_ucp_hello . ' ' . $member_infos['pseudo'].',' ; ?>
</div>

<div id="ucp_stats">
	<div id="ucp_stats_billets" >
		<table id="tableau-stats">
			<tr>
				<td><?php echo $lang_ucp_stats_billets ; ?></td>
				<td><?php echo compteur_member_stats('billets', $_SESSION['user_id']) ; ?></td>
			</tr>
			<tr>
				<td><?php echo $lang_ucp_stats_comment ; ?></td>
				<td><?php echo compteur_member_stats('comments', $_SESSION['user_id']) ; ?></td>
			</tr>
			<tr>
				<td><?php echo $lang_ucp_stats_level ; ?></td>
				<td><?php show_level_details($member_infos['level']) ; ?></td>
			</tr>
		</table>
	</div>
</div>