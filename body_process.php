<?php 
/**
*
* @package LIGHT PUBLICATOR
* @copyright (c) 2013 BOUDRY Julien - Born : 22/10/1988 - France
* @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License / Licence publique générale limitée GNU
*
*/ 
?>


<body>

	<div id="wrapper">
	
		<?php 
		
			// Pour faire jolie
			include("view/top.php") ;

			// Mais que va-t-on bien pouvoir afficher au millieu ...

					IF (	
							(	
								array_key_exists('connect', $_GET) AND
								isset($_GET) AND
								$_GET['connect'] == 'on' AND
								etat() == FALSE
							)
							OR
							(
								isset($_POST['id_identifiant']) AND 
								isset($_POST['id_password']) AND
								etat() == FALSE
							)
						)
					{
						include("view/content_connect.php") ;	
					}
					
					ELSEIF (
								(
									isset($_POST['id_identifiant']) AND 
									isset($_POST['id_password']) AND
									etat() == TRUE
								)
								OR
								(
									array_key_exists('connect', $_GET) AND
									isset($_GET) AND
									$_GET['connect'] == 'off' AND
									etat() == FALSE
								)
								OR
								(
									$show_message == TRUE OR array_key_exists('message', $_GET)
								)

							)
					{
						include("view/content_message.php") ;
					}
					
					ELSEIF 	(	inscription_activation() AND
								(( array_key_exists('inscription', $_GET) AND isset($_GET) AND $_GET['inscription'] == 'on' AND etat() == FALSE ) OR 
								( isset($profilage_fails_list) AND array_key_exists('edit_ucp_candidate', $_POST) == FALSE ))
							)
					{
						include("view/content_inscription.php") ;
					}
					
					ELSEIF ( array_key_exists('article', $_GET) AND isset($_GET) AND ctype_digit($_GET['article']) )
					{
						include("view/content_article.php") ;
					}	
					
					ELSEIF ( isset($_GET) AND array_key_exists('module', $_GET) AND $_GET['module'] == 'ucp' AND etat() == TRUE )
					{
						include("view/content_ucp.php") ;
					}
					
					ELSE
					{
						include("view/content_index.php") ;
					}
	
	

			// C'était dur, on en revient à la ligne principale :
			include("view/footer.php") ; 
			
		?>
	
	
	</div>	
	

</body>