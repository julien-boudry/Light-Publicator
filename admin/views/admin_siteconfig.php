<?php 
/**
*
* @package LIGHT PUBLICATOR
* @copyright (c) 2013 BOUDRY Julien - Born : 22/10/1988 - France
* @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License / Licence publique générale limitée GNU
*
*/ 
?>

<div class="content" id="members">

		<h2><?php echo $lang_admin_siteconfig_title ; ?></h2>
		
<div id="siteconfig_parametre">

<div class="error" id="profilage_errors">
	<?php IF (isset($siteconfig_fails_list)) { error_show($siteconfig_fails_list) ; } ?>
</div>

	<form method="post" action="index.php?module=siteconfig">
	<input type="hidden" name="set_config" value="on">
	
<table>
	<tr>
		<td><label for="set_title"><?php echo $lang_admin_siteconfig_settitle.' ' ; ?></label></td>
		<td><input type="text" id="set_title" name="set_title" maxlength="60" size="60" value="<?php echo $content_site_edit['site_title'] ; ?>"></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td><label for="set_nbrarticle"><?php echo $lang_admin_siteconfig_setnbrarticle.' ' ; ?></label></td>
		<td><input type="text" id="set_nbrarticle" name="set_nbrarticle" maxlength="3" size="3" value="<?php echo $content_site_edit['index_nbr_articles'] ; ?>" required></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td><label for="set_motscles"><?php echo $lang_admin_siteconfig_setmotscles.' ' ; ?></label></td>
		<td><input type="text" id="set_motscles" name="set_motscles" maxlength="50" size="30" value="<?php echo $content_site_edit['mots_cles'] ; ?>"></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td><label for="set_copyright"><?php echo $lang_admin_siteconfig_setcopyright.' ' ; ?></label></td>
		<td><input type="text" id="set_copyright" name="set_copyright" maxlength="255" size="100" value="<?php echo htmlspecialchars($content_site_edit['copyright']) ; ?>" ></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td><input id="siteconfig_submit" type="submit" value="<?php echo $lang_edit_save ; ?>"></td>
	</tr>
</table>
	
	</form>

</div>

</div>