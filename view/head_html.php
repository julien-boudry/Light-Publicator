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
	<title><?php echo titre_page() ; ?></title>

	<meta name="keywords" content="<?php echo keyword_head() ; ?>" />

	<link rel="stylesheet" type="text/css" href="style/<?php echo user_style() ; ?>" />
	
	<script type="text/javascript">
                <!--
                        function open_infos(url)
                        {
                                url = url;
								width = 930;
                                height = 720;
                                if(window.innerWidth)
                                {
                                        var left = (window.innerWidth-width)/2;
                                        var top = (window.innerHeight-height)/2;
                                }
                                else
                                {
                                        var left = (document.body.clientWidth-width)/2;
                                        var top = (document.body.clientHeight-height)/2;
                                }
                                window.open(url,'nom_de_ma_popup','menubar=no, scrollbars=no, top='+top+', left='+left+', width='+width+', height='+height+'');
                        }
                -->
	</script>


</head>