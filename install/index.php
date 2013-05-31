<?php 
/**
*
* @package LIGHT PUBLICATOR
* @copyright (c) 2013 BOUDRY Julien - Born : 22/10/1988 - France
* @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License / Licence publique générale limitée GNU
*
*/ 
?>


<?php

// Mise en place de la machinerie 0

	// Démarrage du système spécifique de session (distinct de celui du site fonctionnel)
	session_name('light-publicator-install') ;
	session_start() ;
	
	// Chargement des fonctions
	include('function_install.php') ;
	
	// Chargement du fichier de langue & Inscription de la langue dans la SESSION
	IF ( isset($_GET['lang']) == FALSE AND isset($_SESSION['lang']) == FALSE )	{ include('language/fr.php') ; }
	ELSEIF ( isset($_GET['lang']) AND strlen($_GET['lang']) <= 3 )				
	{ include('language/'.$_GET['lang'].'.php') ; $_SESSION['lang'] = $_GET['lang'] ; }
	ELSEIF ( isset($_SESSION['lang']) AND strlen($_SESSION['lang']) <= 3  )		{ include('language/'.$_SESSION['lang'].'.php') ; }
	
	// Chargement des variables contenant les requêtes SQL de création de la base
	include('create_db.php') ;

	
// Quelques variables

	$show_error_message = NULL ;
	$install_detroy = FALSE ;

	
// MOTEUR ---------------------------------------------------------------------------------------VrouM----------------------------------------------------------VrouM------------------------------

		
		// Niveau 0 - Check de la configuration
		IF ( isset($_SESSION['etape']) == FALSE OR $_SESSION['etape'] > 5 OR $_SESSION['etape'] < 1 )
		{	
			IF ( check_config() ) { $button_start = '' ; $error_start = '' ; }
			ELSEIF ( check_config() == FALSE ) { $button_start = 'disabled' ; $show_error_message = $lang_start_error ; }
		}	
		
		// (Candidature) Niveau 1
		IF ( isset($_POST['etape_candidate-1']) )
		{ $_SESSION['etape'] = 1 ; }
		
		
		// (Candidature) Niveau 2
		IF ( isset($_POST['etape_candidate-2']) )
		{ 
			IF ( db_test($_POST['dbtype'], $_POST['dbserveur'], $_POST['dbname'], $_POST['dbuser'], $_POST['dbpassword']) == TRUE )
			{ 
				$_SESSION['etape'] = 2 ;
				
				// Stockage provisoire, les données ayant vocation a être détruite lors du passage à l'étape 3, et la session détruite à la fin du script. Même si la solution est peu élagante, elle n'ouvre en principe à aucune faille de sécurité si le serveur est correctement configurée.				
				$_SESSION['dbstock']['dbtype'] = $_POST['dbtype'] ;
				$_SESSION['dbstock']['dbserveur'] = $_POST['dbserveur'] ;
				$_SESSION['dbstock']['dbname'] = $_POST['dbname'] ;
				$_SESSION['dbstock']['dbuser'] = $_POST['dbuser'] ;
				$_SESSION['dbstock']['dbpassword'] = $_POST['dbpassword'] ;
			}
			ELSE
			{
				$show_error_message = $lang_etape1_bddconnect_fail ;
			}
		}
		
		// (Candidature) Niveau 3
		IF ( isset($_POST['etape_candidate-3']) )
		{
			// Création de la BDD sur le serveur
			create_db
			($_SESSION['dbstock']['dbtype'], $_SESSION['dbstock']['dbserveur'], $_SESSION['dbstock']['dbname'], $_SESSION['dbstock']['dbuser'], $_SESSION['dbstock']['dbpassword'], $_POST['dbprefixe'], $db_structure, $db_data) ;
			
			// Création du fichier config
			create_config_file
			($_SESSION['dbstock']['dbtype'], $_SESSION['dbstock']['dbserveur'], $_SESSION['dbstock']['dbname'], $_SESSION['dbstock']['dbuser'], $_SESSION['dbstock']['dbpassword'], $_POST['dbprefixe']) ;
			
			// Sécurisation des contenus de la variable SESSION
			$_SESSION['dbstock'] = NULL ;
			
			// Etape suivante !
			$_SESSION['etape'] = 3 ;
		}
		
		
		// (Candidature) Niveau 4
		IF ( isset($_POST['etape_candidate-4']) )
		{
			include('../config.php') ;
			include('../functions/function_ucp.php') ;
			
			entry_password(1, $_POST['admin_password']) ;
			
			$_SESSION['etape'] = 4 ;
			
			$install_detroy = TRUE ;
		}


// AFFICHAGE

	include('view/header.php') ;

	// Détermination du contenu central
		IF ( isset($_SESSION['etape']) == FALSE OR $_SESSION['etape'] > 5 OR $_SESSION['etape'] < 1 )
		{include('view/start.php') ;}
		
		ELSEIF ( $_SESSION['etape'] == 1 )
		{include('view/etape1.php') ;}
		
		ELSEIF ( $_SESSION['etape'] == 2 )
		{include('view/etape2.php') ;}
		
		ELSEIF ( $_SESSION['etape'] == 3 )
		{include('view/etape3.php') ;}
		
		ELSEIF ( $_SESSION['etape'] == 4 )
		{include('view/end.php') ;}


	include('view/footer.php') ;
	
	
// APOCALYPSE Destruction de l'installeur, et de la SESSION

IF ( $install_detroy == TRUE )
{
			// Destruction de la session
			unset($_SESSION) ;
			session_destroy() ;	
			
			// Destruction de trois fichiers vitaux
			unlink('function_install.php') ;
			unlink('index.php') ;
			unlink('create_db.php') ;
			unlink('view/start.php') ;
			unlink('view/etape1.php') ;
			unlink('view/etape2.php') ;
			unlink('view/etape3.php') ;
			unlink('view/end.php') ;
			
}

?>