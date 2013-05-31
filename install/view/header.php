<?php 
/**
*
* @package LIGHT PUBLICATOR
* @copyright (c) 2013 BOUDRY Julien - Born : 22/10/1988 - France
* @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License / Licence publique générale limitée GNU
*
*/ 
?>

<!DOCTYPE HTML>
<html>

<head>

		<meta charset="utf-8">
		
		<title>LIGHT PUBLICATOR 0.1 RC // Install module</title>

		<meta name="author" content="LIGHT PUBLICATOR" />

		<link rel="stylesheet" type="text/css" href="install.css" />


</head>

<body>

	<header>

		<h1><?php echo $lang_titre_welcome ; ?></h1>
		<div>
			<?php 
			IF ( isset($_SESSION['etape']) == FALSE )
			{
			echo	'<form method="get" action="index.php">
						<select name="lang">' ;
							generate_langs_list() ;
			echo			'</select>
						<input type="submit" value="'.$lang_change_lang_button.'" >
					</form>' ;
			}
			?>
			
		</div>
		

	</header>