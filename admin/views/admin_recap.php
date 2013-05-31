<?php 
/**
*
* @package LIGHT PUBLICATOR
* @copyright (c) 2013 BOUDRY Julien - Born : 22/10/1988 - France
* @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License / Licence publique générale limitée GNU
*
*/ 
?>

<div class="content" id="recap">

<h2><?php echo $lang_admin_recap_title ; ?></h2>

<div id="recap_blocks" >

		<div class="recap_tables_box" id="admin_table_1" >
		
			<h3><?php echo $lang_admin_recap_stats_title_post ; ?></h3>

			<table>
			
				<tr>
					<td><?php echo $lang_admin_recap_stats_post_nbrposts ; ?></td>
					<td><?php echo calc_nombre_articles() ; ?></td>
				</tr>
				
				<tr>
					<td><?php echo $lang_admin_recap_stats_post_nbrcomments ; ?></td>
					<td><?php echo calc_nombre_comments() ; ?></td>
				</tr>
				
				<tr>
					<td><?php echo $lang_admin_recap_stats_post_moycomments ; ?></td>
					<td><?php echo stats_comments_by_article () ; ?></td>
				</tr>

			</table>
			
		</div>
		
		<div class="recap_tables_box" id="admin_table_2" >
		
		<h3><?php echo $lang_admin_recap_stats_title_users ; ?></h3>

			<table>
			
				<tr>
					<td><?php echo $lang_admin_recap_stats_users_nbr ; ?></td>
					<td><?php echo calc_nombre_users() ; ?></td>
				</tr>
	
				<tr>
					<td><?php echo $lang_admin_recap_stats_users_nbrlevel2 ; ?></td>
					<td><?php echo calc_nombre_users('= 2') ; ?></td>
				</tr>
				<tr>
					<td><?php echo $lang_admin_recap_stats_users_nbrlevel3 ; ?></td>
					<td><?php echo calc_nombre_users('= 3') ; ?></td>
				</tr>
				<tr>
					<td><?php echo $lang_admin_recap_inscription ; ?></td>
					<td><?php inscription_activation(TRUE) ?></td>
				</tr>

			</table>
			
		</div>
		
		<div class="recap_tables_box" id="admin_table_3" >
		
		<h3><?php echo $lang_admin_recap_stats_title_server ; ?></h3>

			<table>
			
				<tr>
					<td><?php echo $lang_admin_recap_stats_server_php ; ?></td>
					<td><a href="index.php?module=phpinfos" ><?php echo phpversion() ; ?></a></td>
				</tr>
				
				<tr>
					<td><a href="index.php?optimisation=on"><?php echo $lang_admin_optimisation ; ?></a></td>
				</tr>
				
				<tr>
					<td><?php echo $lang_admin_publicator_version ; ?></td>
					<td><?php echo $Lpublicator_version ; ?></td>
				</tr>

			</table>
			
			
		</div>
	
</div>

</div>