<?php 

// Empêche les erreurs de s'afficher à l'écran, mais toujours dans error_log ini_set('display_errors','Off'); ini_set('error_reporting', E_ALL ); define('WP_DEBUG', false); define('WP_DEBUG_DISPLAY', false);
// DB credentials.
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','root');
define('DB_NAME','library');
// Establish database connection.
try
{
// Instancier la classe PDO
$dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS);

}
catch (PDOException $e)
{
    exit("Error: " . $e->getMessage());
}


function validation($data) {

    //Supprime les espaces (ou d'autres caractères) en début et fin de chaîne
    $data = trim($data);
    //Supprime les antislashs d'une chaîne
    $data = stripslashes($data);
    //Convertit les caractères spéciaux en entités HTML
    $data = htmlspecialchars($data);
    return $data;}
    ?>