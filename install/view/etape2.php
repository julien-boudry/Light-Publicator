<?php 
/**
*
* @package LIGHT PUBLICATOR
* @copyright (c) 2013 BOUDRY Julien - Born : 22/10/1988 - France
* @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License / Licence publique générale limitée GNU
*
*/ 
?>

<div class="content" id="start">

<h2><?php echo $lang_etape2_title ; ?></h2>

	<div class="align">
	<span class="error"><?php echo $show_error_message; ?></span>
		<form method="post" action="index.php">
			<table>
				<tr>
					<td><label for="dbprefixe"><?php echo $lang_etape2_prefixe ; ?></label></td>
					<td><input type="text" name="dbprefixe" id="dbprefixe" value="light-publicator_" ></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" name="etape_candidate-3" value="<?php echo $lang_etape2_button ; ?>" ></td>
				</tr>
			</table>
		</form>
	</div>

</div>