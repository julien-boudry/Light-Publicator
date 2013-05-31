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

	<h2><?php echo id_auteur_translation($_GET['id']) ; ?></h2>
	
	<div class="formulaire" >
	
		<form method="post" action="index.php?module=editmember_rank&amp;id=<?php echo $_GET['id'] ;?>">
		
			<table>
				<tr>
					<td><label for="rank"><?php echo $lang_admin_members_rang ; ?></label></td>
					<td>
						<select name="rank_set" id="rank">
							<?php rank_select($_GET['id']) ; ?>
						</select>
					</td>
				</tr>
			</table>
			
			<input type="submit" value="<?php echo $lang_edit_confirm ; ?>" />
		
		</form>
	
	</div>

</div>