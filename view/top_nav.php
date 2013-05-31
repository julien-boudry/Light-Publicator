<?php 
/**
*
* @package LIGHT PUBLICATOR
* @copyright (c) 2013 BOUDRY Julien - Born : 22/10/1988 - France
* @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License / Licence publique générale limitée GNU
*
*/ 
?>

<nav>

	<div class="blocs-nav" id="bloc-nav-post"><?php IF ( etat() == TRUE AND $member_infos['level'] > 1 ) { echo '<a href="#null" onclick="javascript:open_infos(\'post.php\');" >' . $lang_new_post . '</a>' ; } ?></div>
	<div class="blocs-nav" id="bloc-nav-inscription"><?php IF ( etat() == FALSE AND inscription_activation() ) { echo '<a href="index.php?inscription=on">' . $lang_inscription . '</a>' ; } ?></div>
	<div class="blocs-nav" id="bloc-nav-home"><a href="index.php"><?php echo $lang_home ; ?></a></div>
	
	<div class="blocs-nav blocs-nav-users" id="bloc-nav-ucp"><?php IF ( etat() == TRUE ) { echo $lang_hello .' '. $member_infos['pseudo'] . ' <span id="fonctions_users_nav" >( <a href="index.php?module=ucp">' . $lang_ucp . '</a> | '.$contenu_bouton_connexion.' )</span>' ; } ?></div>
	<div class="blocs-nav blocs-nav-users" id="bloc-nav-connect"><?php IF ( etat() == FALSE ) { echo $contenu_bouton_connexion ; } ?></div>
	
</nav>