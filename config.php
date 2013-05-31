


<?php

// Informations sur le logiciel

$Lpublicator_version = '0.1.0 RC2' ;

// On rempli ici les paramètres d'accès à la BDD

$type_base		= 'mysql' ; // RENSEIGNER LE TYPE DE BDD : MYSQL, MARIADB, PostgreSQL.
$db_host		= 'localhost' ; // RENSEIGNER L'ADRESSE DU SERVEUR DE BDD
$db_name		= 'light-publicator-dev' ; // RENSEIGNER LE NOM DE LA BDD.
$db_utilisateur	= 'root' ; // RENSEIGNER L'IDENTIFIANT DE CONNEXION (UTILISATEUR)
$db_password 	= '' ; // RENSEIGNER LE MOT DE PASSE DE LA BDD.

$tables_prefixe = 'dev_' ; // Pour utiliser un prefixe personalise pour vos tables.


// SCRIPT DE CONNECTION EN PDO

$base_host = $type_base . ':host=' . $db_host . ';dbname=' . $db_name ;

try
{
    $bdd = new PDO($base_host, $db_utilisateur, $db_password);	
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
	
}

// Adressage des tables

$bdd_tables = array (
'config' => '`' . $tables_prefixe . 'config' . '`',
'billets' => '`' . $tables_prefixe . 'billets' . '`',
'comments' => '`' . $tables_prefixe . 'comments' . '`',
'users' => '`' . $tables_prefixe . 'users' . '`',
'styles' => '`' . $tables_prefixe . 'styles' . '`',
'languages' => '`' . $tables_prefixe . 'languages' . '`',) ;


// SECURITE

	//Clé de hashage - 20 caractères max | NE JAMAIS MODIFIER après installation (réinitialise tous les mots de passe)
	
	$security_key = '4f8c42f42a87c42c' ;
	
// SESSION

	// Clé unique en cas d'installation de plusieurs Light-Publicator sur un même domaine.
	
	$cle_session = '73cc45d740f6153f' ;


?>
