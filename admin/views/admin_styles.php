<?php 
/**
*
* @package LIGHT PUBLICATOR
* @copyright (c) 2013 BOUDRY Julien - Born : 22/10/1988 - France
* @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License / Licence publique générale limitée GNU
*
*/ 
?>

<div class="content" id="member_rank">

	<h2><?php echo $lang_admin_style_title1 ; ?></h2>
	
	<div id="style_default" >
		<table>
			<tr>
				<th>ID :</th>
				<th><?php echo $lang_admin_style_name ?></th>
				<th><?php echo $lang_admin_style_file ?></th>
				<th><?php echo $lang_admin_style_use ?></th>
				<th><?php echo $lang_admin_style_state ?></th>
			</tr>
			<?php admin_list_style() ?>
		</table>
	</div>
	
	

	<h2><?php echo $lang_admin_style_title2 ; ?></h2>
	
	<div id="formulaire_style" >
	
		<form method="post" action="index.php?module=styles&amp;action=new_style" enctype="multipart/form-data"> 

			<table>
				<tr>
					<td><label for="new_style_title"><?php echo $lang_admin_style_newstyletitle.' ' ; ?></label><input type="text" id="new_style_title" name="new_style_title" /></td>
				</tr>
				<tr>
					<td><textarea name="new_style_content" rows="25" cols="100"></textarea></td>
				</tr>
				<tr>
					<td><input type="submit" value="<?php echo $lang_send ; ?>" /></td>
				</tr>
			</table>
		
		</form>
	
	</div>

</div>