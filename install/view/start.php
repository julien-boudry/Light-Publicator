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

<h2><?php echo $lang_start_title ; ?></h2>

	<div class="align">
		<span class="error"><?php echo $show_error_message ; ?></span>
		<table>
			<?php check_config(TRUE) ?>
		</table>
		<form method="post" action="index.php">
			<input type="submit" name="etape_candidate-1" value="<?php echo $lang_start_button ; ?>"  <?php echo $button_start ; ?> >
		</form>
	</div>

</div>