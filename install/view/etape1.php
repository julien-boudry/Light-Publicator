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

<h2><?php echo $lang_etape1_title ; ?></h2>

	<div class="align">
	<span class="error"><?php echo $show_error_message; ?></span>
		<form method="post" action="index.php">
			<table>
				<tr>
					<td><?php echo $lang_etape1_bdtype ; ?></td>
					<td>
						<select name="dbtype">
							<option value="mysql" >MariaDB / MySQL</option>
							<option value="pgsql" >PostGreSQL</option>
							<option value="odbc" >Oracle</option>
							<option value="sqlite" >SQLite</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><label for="dbserveur"><?php echo $lang_etape1_server ; ?></label></td>
					<td><input type="text" name="dbserveur" id="dbserveur" required ></td>
				</tr>
				<tr>
					<td><label for="dbname"><?php echo $lang_etape1_dbname ; ?></label></td>
					<td><input type="text" name="dbname" id="dbname" required ></td>
				</tr>
				<tr>
					<td><label for="dbuser"><?php echo $lang_etape1_dbuser ; ?></label></td>
					<td><input type="text" name="dbuser" id="dbuser" required ></td>
				</tr>
				<tr>
					<td><label for="dbpassword"><?php echo $lang_etape1_dbpassword ; ?></label></td>
					<td><input type="password" name="dbpassword" id="dbpassword" ></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" name="etape_candidate-2" value="<?php echo $lang_etape1_button ; ?>" ></td>
				</tr>
			</table>
		</form>
	</div>

</div>