<?php


//Paramètres de base
define("WEBDIR", $_SERVER["EBS_WEBDIR"]);
define("DBPRE","");
define("AJAXDIR","js/ajax/loader.php");
define("AJAXLOAD","js/ajax/loader.php?fonction=");
define("UPLOADDIR", "img");
// données pour la connexion à la base de données local
define("DB_HOST",getenv("RDS_ENDPOINT"));
define("DB_USER", getenv("RDS_USER"));
define("DB_PASS", getenv("RDS_PASSWORD"));
define("DB_BASE",getenv("RDS_DBNAME"));


// clés API et paramètres du serveur
//define("FB_ID","886305161409231");
//define("FB_KEY","97347c93948a4adaf25a93c6388a77e3");
define("FB_ID","1614151368838576");
define("FB_KEY","a149c28eac5edd392dd495c704f2b000");

define("GOOGLE_API_KEY", "783429008478-uh2nkobflflrc21ouvdedq0dvebvnhvr.apps.googleusercontent.com");
define("GOOGLE_API_SECRET", "0thpv1Ya5zwZvXLZVxdkwx5u");
define("GOOGLE_API_OAUTH2_REDIRECT", "http://localhost/mutum/v2/sponsor/gmail");

define("OUTLOOK_CLIENT_ID", "000000004C14C04C");
define("OUTLOOK_CLIENT_SECRET", "JvbahWivWG05WCIgSXjhEpGyv84U3WNy");

define("YAHOO_CONSUMER_KEY", "dj0yJmk9Z0wyV2pGWXFDODFiJmQ9WVdrOVFVZFFZMDlzTkdNbWNHbzlNQS0tJnM9Y29uc3VtZXJzZWNyZXQmeD05Mw--");
define("YAHOO_CONSUMER_SECRET", "6d919dfee8e1466ae81009c2cd954b548f8bea37");

/*define("MANGOPAYAPI", 'https://api.sandbox.mangopay.com');
define("MANGOPAYTMP", "tmp");
define("MANGOPAY_CLIENT_ID", "mutumv2");
define("MANGOPAY_PASSPHRASE", "Bwtj6hgeXRarTFSMwuatuvWrBv9y1jVUYCtJ1kQh1Zvy1FRd4n");*/

define("MANGOPAYAPI", 'https://api.mangopay.com');
define("MANGOPAYTMP", "tmp");
define("MANGOPAY_CLIENT_ID", "mutumfr");
define("MANGOPAY_PASSPHRASE", "61pvUOeovoY07V3u69at5PHV1gUpzXda2QCH7ZXu7i65xknz1i");


define("MAILJET_APIKEY", '22f21e57dc1630c548b5d636ea6a0819');
define("MAILJET_APISECRET", '1294d16c153dd92e90e3bf221cc8357c');
define("MAILER_FROM", "mutum.fr <noreply@mutum.fr>");

//Démarrer les sessions
session_start();

// affiche toutes les erreurs et warnings PHP
ini_set('display_errors',1);
ini_set('error_reporting', E_ALL & ~ E_STRICT);

define('CLASSES',dirname($_SERVER["SCRIPT_FILENAME"])."/classes/");
define('INCLUDES',dirname($_SERVER["SCRIPT_FILENAME"])."/includes/");
define('SCRIPTS',dirname($_SERVER["SCRIPT_FILENAME"])."/scripts/");

?>
