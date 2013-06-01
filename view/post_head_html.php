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
<html lang="fr">

<head>
	<meta charset="utf-8">
	<title><?php echo titre_page() ; ?></title>

	<meta name="keywords" content="<?php echo keyword_head() ; ?>" />

	<link rel="stylesheet" type="text/css" href="style/<?php echo user_style() ; ?>" />
	<script type="text/javascript" src="javascript/editor/tiny_mce.js"></script>

	<script type="text/javascript">
	
		tinyMCE.init({
				theme : "advanced",
				mode : "textareas",
		});

	</script>

</head>

<body>