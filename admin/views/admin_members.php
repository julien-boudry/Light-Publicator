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

	<h2><?php echo $lang_admin_members_title ; ?></h2>

		<form method="post" action="index.php?module=members_mass_edit" enctype="multipart/form-data"> 
	<table>
		<tr>
			<th></th>
			<th><a href="index.php?module=members&amp;tri=id">ID</a></th>
			<th><a href="index.php?module=members&amp;tri=pseudo"><?php echo $lang_admin_members_pseudo ?></a></th>
			<th><a href="index.php?module=members&amp;tri=prenom"><?php echo $lang_admin_members_prenom ?></a></th>
			<th><a href="index.php?module=members&amp;tri=nom"><?php echo $lang_admin_members_nom ?></a></th>
			<th><a href="index.php?module=members&amp;tri=genre"><?php echo $lang_admin_members_genre ?></a></th>
			<th><a href="index.php?module=members&amp;tri=email"><?php echo $lang_admin_members_email ?></a></th>
			<th><a href="index.php?module=members&amp;tri=date_inscription"><?php echo $lang_admin_members_inscription ?></a></th>
			<th><a href="index.php?module=members&amp;tri=id_style"><?php echo $lang_admin_members_style ?></a></th>
			<th><a href="index.php?module=members&amp;tri=id_language"><?php echo $lang_admin_members_language ; ?></a></th>
			<th><?php echo $lang_admin_members_comments ; ?></th>
			<th><?php echo $lang_admin_members_billets ; ?></th>
			<th><a href="index.php?module=members&amp;tri=level"><?php echo $lang_admin_members_rang ; ?></a></th>
			<th></th>
			<th></th>
		</tr>
		<?php echo show_members($tri) ; ?>
	</table>
		<select name="action_for_selected" id="select_members">
			<option  value="rank1"><?php echo $lang_admin_select_member_option_rank1 ; ?></option>
			<option  value="rank2"><?php echo $lang_admin_select_member_option_rank2 ; ?></option>
			<option  value="rank3"><?php echo $lang_admin_select_member_option_rank3 ; ?></option>
			<option  value="delete"><?php echo $lang_admin_select_member_option_delete ; ?></option>
		</select>
		<input id="inscription_submit" type="submit" onclick="return(confirm('<?php echo $lang_admin_members_bouton_confirm ; ?>'))" value="<?php echo $lang_edit_save ; ?>" />   
	</form>
	
	<div id="activate_inscription" >
		<?php 
			IF ( $site_config['inscription'] == 0 ) 
			{
				echo '<a href="index.php?module=siteconfig&amp;inscription=on">'.$lang_admin_members_siteconfig_activate.'</a>' ;
			} 
			ELSEIF ( $site_config['inscription'] == 1 ) 
			{
				echo '<a href="index.php?module=siteconfig&amp;inscription=off">'.$lang_admin_members_siteconfig_unactivate.'</a>' ;
			}
		?>
	</div>

</div>