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
		
		<title><?php echo $lang_administration.' '.get_site_title() ; ?></title>

		<meta name="author" content="LIGHT PUBLICATOR" />

		<link rel="stylesheet" type="text/css" href="admin.css" />


</head>

<body>

	<header>

		<h1><?php echo $lang_administration.' '.get_site_title() ; ?></h1>
		
		<div id="nav" >
			<div class="nav_element" id="nav1" >
				<a href="index.php">
					<?php 
					IF ( isset($_GET['module']) == FALSE )
					{echo '<span class="bold">'.$lang_admin_menu_recap.'</span>' ;}
					ELSE {echo $lang_admin_menu_recap ;}
					?>
				</a>
			</div>
			<div class="nav_element" id="nav2" >
				<a href="index.php?module=members">
					<?php 
					IF ( isset($_GET['module']) AND $_GET['module'] == 'members' )
					{echo '<span class="bold">'.$lang_admin_menu_members.'</span>' ;}
					ELSE {echo $lang_admin_menu_members ;}
					?>
				</a>
			</div>
			<div class="nav_element" id="nav3" >
				<a href="index.php?module=siteconfig">
					<?php 
					IF ( isset($_GET['module']) AND $_GET['module'] == 'siteconfig' )
					{echo '<span class="bold">'.$lang_admin_menu_siteconfig.'</span>' ;}
					ELSE {echo $lang_admin_menu_siteconfig ;}
					?>
				</a>
			</div>
			<div class="nav_element" id="nav4" >
				<a href="index.php?module=styles">
					<?php 
					IF ( isset($_GET['module']) AND $_GET['module'] == 'styles' )
					{echo '<span class="bold">'.$lang_admin_menu_styles.'</span>' ;}
					ELSE {echo $lang_admin_menu_styles ;}
					?>
				</a>
			</div>
			<div class="nav_element" id="nav5" >
				<a href="index.php?module=languages">
					<?php 
					IF ( isset($_GET['module']) AND $_GET['module'] == 'languages' )
					{echo '<span class="bold">'.$lang_admin_menu_langs.'</span>' ;}
					ELSE {echo $lang_admin_menu_langs ;}
					?>
				</a>
			</div>
		</div>

	</header>