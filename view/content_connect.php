<?php 
/**
*
* @package LIGHT PUBLICATOR
* @copyright (c) 2013 BOUDRY Julien - Born : 22/10/1988 - France
* @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License / Licence publique générale limitée GNU
*
*/ 
?>

<div id="content">
	
	<div id="connect">

		<form method="post" action="index.php">

			<div id="boite_id">
				<div class="id_fail" id="wrong-id"><?php echo $wrong_id ; ?></div>
				<label for="identifiant"><?php echo $lang_identifiant . ': ' ; ?></label>
				<input type="text" name="id_identifiant" id="identifiant" />
			</div>

			<div id="boite_pass">	
				<div class="id_fail" id="wrong-password"><?php echo $wrong_password ; ?></div>
				<label for="password"><?php echo $lang_password . ': ' ; ?></label>
				<input type="password" name="id_password" id="password" />
			</div>
			

			<div id="boite_pass">
				<input type="submit" value="<?php echo $lang_send ; ?>" />
			</div>
		
		</form>
	
	</div>
	
</div>