<?php 
/**
*
* @package LIGHT PUBLICATOR
* @copyright (c) 2013 BOUDRY Julien - Born : 22/10/1988 - France
* @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License / Licence publique générale limitée GNU
*
*/ 


// Génération de la liste des langues pré-installées
function generate_langs_list ()
{
	$dir    = 'language/' ;
	$scan = scandir($dir) ;

	FOREACH ( $scan as $cle => $element )
	{
		IF ( $element != '.' AND $element != '..' )
		{
			$name_correct = str_replace(".php", "", $element) ;
			
			echo '<option value="'.$name_correct.'" >'.$name_correct.'</option>' ;
		}

	}
}




// Start

	// Check la config serveur
	function check_config ( $show = FALSE )
	{
	
			// réflexion
			$error = FALSE ;
			$error_detail['php_version'] = FALSE ;
			$error_detail['pdo'] = FALSE ;
			
			
			// PHP
			IF ( version_compare(PHP_VERSION, '5.4.0') >= 0 )
			{}
			ELSE
			{
				$error = TRUE ;
				$error_detail['php_version'] = TRUE ;			
			}
			
			
			// PDO
			IF ( phpversion('pdo_mysql') != FALSE OR phpversion('pdo_oci') != FALSE OR phpversion('pdo_pgsql') != FALSE )
			{}
			ELSE
			{
				$error = TRUE ;
				$error_detail['pdo'] = TRUE ;	
			}
		
		// Conclusion si $show = FALSE
		IF ( $error == FALSE AND $show == FALSE )
		{
			return TRUE ;
		}
		ELSEIF ( $error == TRUE AND $show == FALSE )
		{
			return FALSE ;
		}
		
		// Conclusion si $show = TRUE
		IF ( $show == TRUE )
		{
			IF ( $error_detail['php_version'] == TRUE )
			{
				$id_php_check = 'check_fail' ;
				$text_php_fail=	['lang_start_php_fails_infos'] ;
			}
			ELSEIF ( $error_detail['php_version'] == FALSE )
			{
				$id_php_check = 'check_sucess' ;
				$text_php_fail=	'' ;
			}
			
			IF ( $error_detail['pdo'] == TRUE )
			{
				$id_pdo_check = 'check_fail' ;
				$pdo_state	=	$GLOBALS['lang_start_pdo_fails_infos'] ;
			}
			ELSEIF ( $error_detail['pdo'] == FALSE )
			{
				$id_pdo_check = 'check_sucess' ;
				$pdo_state	=	$GLOBALS['lang_start_pdo_sucess_infos'] ;
			}
		
		
			echo 	'<tr>
						<td>'.$GLOBALS['lang_start_php_context'].'</td>
						<td class="'.$id_php_check.'">'.phpversion().'</td>
						<td>'.$text_php_fail.'</td>
					</tr>
					<tr>
						<td>'.$GLOBALS['lang_start_pdo_context'].'</td>
						<td class="'.$id_pdo_check.'">'.$pdo_state.'</td>
						</tr>' ;
		}
		
	}
	
	
// Etape 1 - Connection BDD

	function db_test ( $dbtype, $dbserveur, $dbname, $dbuser, $dbpassword )
	{
		$error = FALSE ;
		
		$base_host = $dbtype . ':host=' . $dbserveur . ';dbname=' . $dbname ;

		try
		{
			$bdd = new PDO($base_host, $dbuser, $dbpassword);	
		}
		catch (Exception $e)
		{
			$error = TRUE ;	
		}
		
		IF ( $error == TRUE )
		{ return FALSE ; }
		ELSEIF ( $error == FALSE )
		{ return TRUE ; }
	}
	
	
// Etape 2 

	// Création de la base !
	function create_db ( $dbtype, $dbserveur, $dbname, $dbuser, $dbpassword, $dbprefixe, $db_structure, $db_data )
	{
		
		// Informations de Connexion
		$base_host = $dbtype . ':host=' . $dbserveur . ';dbname=' . $dbname ;
		try
		{
			$bdd = new PDO($base_host, $dbuser, $dbpassword);	
		}
		catch (Exception $e)
		{
				die('Erreur : ' . $e->getMessage());
			
		}
		
		$db_structure = str_replace("prefixe_variable_", $dbprefixe, $db_structure) ;
		$db_data = str_replace("prefixe_variable_", $dbprefixe, $db_data) ;
			
		$bdd->query($db_structure) ;
		$bdd->query($db_data) ;
			
		
		
	}
	
	// Création du fichier config
	function create_config_file ( $dbtype, $dbserveur, $dbname, $dbuser, $dbpassword, $dbprefixe )
	{
	
		// Génération des clés de sécurité (abandon du support OpenSSL dans un premier temps => Charette busy)
		$security_number1 	= mt_rand(10000, mt_getrandmax()) ;
		$security_number2 	= mt_rand(10000, mt_getrandmax()) ;
		$security			= dechex($security_number1).dechex($security_number2) ;
		
		$cle_number1 		= mt_rand(10000,  mt_getrandmax()) ;
		$cle_number2 		= mt_rand(10000,  mt_getrandmax()) ;
		$session_name		= dechex($cle_number1).dechex($cle_number2) ;
		
			
	$config_file = 	"


<?php

// Informations sur le logiciel

\$Lpublicator_version = '0.1.0 RC2' ;

// On rempli ici les paramètres d'accès à la BDD

\$type_base		= '".$dbtype."' ; // RENSEIGNER LE TYPE DE BDD : MYSQL, MARIADB, PostgreSQL.
\$db_host		= '".$dbserveur."' ; // RENSEIGNER L'ADRESSE DU SERVEUR DE BDD
\$db_name		= '".$dbname."' ; // RENSEIGNER LE NOM DE LA BDD.
\$db_utilisateur	= '".$dbuser."' ; // RENSEIGNER L'IDENTIFIANT DE CONNEXION (UTILISATEUR)
\$db_password 	= '".$dbpassword."' ; // RENSEIGNER LE MOT DE PASSE DE LA BDD.

\$tables_prefixe = '".$dbprefixe."' ; // Pour utiliser un prefixe personalise pour vos tables.


// SCRIPT DE CONNECTION EN PDO

\$base_host = \$type_base . ':host=' . \$db_host . ';dbname=' . \$db_name ;

try
{
    \$bdd = new PDO(\$base_host, \$db_utilisateur, \$db_password);	
}
catch (Exception \$e)
{
        die('Erreur : ' . \$e->getMessage());
	
}

// Adressage des tables

\$bdd_tables = array (
'config' => '`' . \$tables_prefixe . 'config' . '`',
'billets' => '`' . \$tables_prefixe . 'billets' . '`',
'comments' => '`' . \$tables_prefixe . 'comments' . '`',
'users' => '`' . \$tables_prefixe . 'users' . '`',
'styles' => '`' . \$tables_prefixe . 'styles' . '`',
'languages' => '`' . \$tables_prefixe . 'languages' . '`',) ;


// SECURITE

	//Clé de hashage - 20 caractères max | NE JAMAIS MODIFIER après installation (réinitialise tous les mots de passe)
	
	\$security_key = '".$security."' ;
	
// SESSION

	// Clé unique en cas d'installation de plusieurs Light-Publicator sur un même domaine.
	
	\$cle_session = '".$session_name."' ;


?>
" ;

		
		$new_config_file = fopen('../config.php', 'w+');
		fputs($new_config_file, $config_file);
		
		
	}

?>