<?php 
/**
*
* @package LIGHT PUBLICATOR
* @copyright (c) 2013 BOUDRY Julien - Born : 22/10/1988 - France
* @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License / Licence publique générale limitée GNU
*
*/ 
?>

<div class="content" id="security">


	<div id="admin_connect" >
	
		<?php echo $lang_admin_connect ?>

		<form method="post" action="index.php">

			<input type="password" name="verif_password" id="admin_verif_password" maxlength="300" required />
			<br/>
			<input type="submit" value="<?php echo $lang_send ; ?>" />

		</form>
		
	</div>

</div>