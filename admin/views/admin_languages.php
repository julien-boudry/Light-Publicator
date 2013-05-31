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

	<h2><?php echo $lang_admin_lang_title1 ; ?></h2>
	
	<div id="style_default" >
		<table>
			<tr>
				<th>ID :</th>
				<th><?php echo $lang_admin_style_name ?></th>
				<th><?php echo $lang_admin_style_use ?></th>
				<th><?php echo $lang_admin_style_state ?></th>
			</tr>
			<?php admin_list_langs() ?>
		</table>
	</div>
	
<h2><?php echo $lang_admin_lang_title2 ; ?></h2>

<div class="error" id="lang_errors">
	<?php IF (isset($erreur_posting_lang_candidate)) { error_show($erreur_posting_lang_candidate) ; } ?>
</div>
	
	<div id="formulaire_language" >
	
		<form method="post" action="index.php?module=languages&amp;action=new_lang" enctype="multipart/form-data"> 
			<input type="hidden" name="new_lang_candidate" value="on">  
			<input type="hidden" name="MAX_FILE_SIZE" value="50000">  
			<table>
				<tr>
					<td>
						<label for="new_lang_ISOname"><?php echo $lang_admin_style_newslangname.' ' ; ?></label>
						<input type="text" id="new_lang_ISOname" name="new_lang_ISOname" maxlength="3" size="3" />
					</td>
				</tr>
				<tr>
					<td> <input type="file" name="fichier_langue">   </td>
				</tr>
				<tr>
					<td><input type="submit" value="<?php echo $lang_send ; ?>" /></td>
				</tr>
			</table>
		
		</form>
	
	</div>	


</div>