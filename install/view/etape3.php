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

<h2><?php echo $lang_etape3_title ; ?></h2>

	<div class="align">
	<span class="error"><?php echo $show_error_message; ?></span>
		<form method="post" action="index.php">
			<table>
				<tr>
					<td><?php echo $lang_etape3_pseudo ; ?></td>
					<td><strong>admin</strong></td>
				</tr>
				<tr>
					<td><?php echo $lang_etape3_password ; ?></td>
					<td><input type="password" name="admin_password" maxlength="30" required></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" name="etape_candidate-4" value="<?php echo $lang_etape3_button ; ?>" ></td>
				</tr>
			</table>
		</form>
	</div>

</div>