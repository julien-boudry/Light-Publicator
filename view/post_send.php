<?php 
/**
*
* @package LIGHT PUBLICATOR
* @copyright (c) 2013 BOUDRY Julien - Born : 22/10/1988 - France
* @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License / Licence publique g�n�rale limit�e GNU
*
*/ 
?>

<div id="post_send" >
<?php 
IF ( isset($_GET['editmode']) )
{
	echo $lang_edit_sucess ; 
}
ELSE
{
	echo $lang_post_sucess ; 
}
?>
</div>

