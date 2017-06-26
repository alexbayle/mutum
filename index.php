<?php
header('Content-type:text/html; charset=utf-8');
 
require_once("includes/Params.ini.php");
require_once("includes/Autoload.php");
 
Session::Login();
if (@$_GET['page'] == 'logout' && Session::Online()) {
    Session::Logout();
}
Session::LoginAfterRegister();

//Initialisation de Facebook
define('FACEBOOK_SDK_V4_SRC_DIR', 'lib/Facebook/');
require_once('lib/Facebook/fb_autoload.php');
use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;
use Facebook\FacebookException;
use Facebook\FacebookRedirectLoginHelper;

FacebookSession::setDefaultApplication(FB_ID, FB_KEY);

//Création de l'objet de connexion Facebook
$helper = new FacebookRedirectLoginHelper(WEBDIR);

//On récupère une session Facebook
try {
    $session = $helper->getSessionFromRedirect();
} catch (FacebookRequestException $e) {
    echo "Exception occured, code: " . $e->getCode() . "with message: " . $e->getMessage();
} catch (\Exception $e) {
    echo "Exception occured, code: " . $e->getCode() . "with message: " . $e->getMessage();
}

//On vérifie si la session est valide
if (isset($session)) {
    try {
        $user_profile = (new FacebookRequest($session, 'GET', '/me?scope=public_profile,email'))->execute(
        )->getGraphObject(
            GraphUser::className()
        );
//        var_dump($user_profile); die;
        $_SESSION['fb_action'] = 'link';
        $user_id = user::getUserByFacebookId($user_profile->getId());
        $_SESSION['fb_id'] = $user_profile->getId();
        $_SESSION['fb_name'] = $user_profile->getName();

        $request = new FacebookRequest(
            $session,
            'GET',
            '/me/picture',
            array('redirect' => false, 'height' => '80', 'type' => 'normal', 'width' => '80',)
        );
        $response = $request->execute();
        $graphObject = $response->getGraphObject();
        $_SESSION['fb_profile_picture'] = $graphObject->getProperty('url');


        if ($user_id != '') {
            Session::FacebookConnect($user_id);
        } else {
            $user = new \user();
            $user->createOrLinkFromFacebook($user_profile);
            //Proposer de créer un compte ou de lier un compte
//            echo "<a href='" . WEBDIR . "login'>connectez vous</a> ou <a href='" . WEBDIR . "register'>créer un compte</a>";
        }
    } catch (FacebookRequestException $e) {
        echo "Exception occured, code: " . $e->getCode() . "with message: " . $e->getMessage();
    }
}
//else {
//Session non valide, on crée une URL de connexion qu'on mettra en lien plus tard dans une view.
$FacebookLoginUrl = $helper->getLoginUrl(array('email', 'user_birthday', 'user_location'));
//}


//Initialisation de Mangopay
require_once('lib/mangopay/mangoPayApi.inc');


//En cas de requete AJAX, supprimer les affichages
if (!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'))
{
?>
<!doctype html>
<html lang="fr">
<head>
    <!-- Title -->
    <title>Mutum</title>

    <!-- Meta -->
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="description" content="Prêt et emprunt d'articles en ligne parmi une large sélection : matériel de sport, produits culturels, high-tech, jouets, articles de mode et pour la maison..."/>
    <meta name="keywords" content="mutum, mutums, emprunt, prêt, emprunt d'objet, prêt d'objet, échange de bien, location entre particuliers, prêt entre particulier, emprunt entre particulier, partage, partager des objets, partage d'objets, emprunter un livre, emprunter un vélo, emprunter des ski, emprunter un appareil à raclette, emprunter un appareil à fondue, emprunter des chaises, emprunter un guide, emprunter un marteau, emprunter une guitare, emprunter un sac de couchage, emprunter une tente, emprunter un sac, emprunter un manteau, emprunter des outils, emprunter une tondeuse, emprunter une perceuse, emprunter une raquette"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>

    <!-- Icon -->
    <link rel="shortcut icon" href="<?= WEBDIR ?>img/iconmutum.png" type="image/png" />
    <link rel="icon" href="<?= WEBDIR ?>img/iconmutum.png" type="image/png" />
    <link rel="apple-touch-icon" href="<?= WEBDIR ?>img/iconmutum.png" />

    <!-- Inclusions CSS -->
    <link rel="stylesheet" type="text/css" href="<?= WEBDIR ?>css/style.css"/>
    <link rel="stylesheet" type="text/css" href="<?= WEBDIR ?>css/responsive.css"/>
    <link rel="stylesheet" type="text/css" href="<?= WEBDIR ?>css/jquery-ui.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?= WEBDIR ?>js/tag/tagmanager.css"/>
    <link rel="stylesheet" type="text/css" href="<?= WEBDIR ?>css/jquery.multiselect.css"/>
    <link rel="stylesheet" type="text/css" href="<?= WEBDIR ?>css/jquery.multiselect.filter.css"/>
    <link rel="stylesheet" type="text/css" href="<?= WEBDIR ?>css/sumoselect.css"/>
    <link rel="stylesheet" type="text/css" href="<?= WEBDIR ?>css/jquery.datetimepicker.css"/>

    <!-- Inclusions JS -->
    <script type="text/javascript" src="<?= WEBDIR ?>js/jquery-2.1.1.js"></script>
    <script type="text/javascript" src="<?= WEBDIR ?>js/global.js"></script>
    <script src="http://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
    <script type="text/javascript" src="<?= WEBDIR ?>js/jquery.scrollTo.js"></script>
    <script type="text/javascript" src="<?= WEBDIR ?>js/cookie.js"></script>
    <script type="text/javascript" src="<?= WEBDIR ?>js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?= WEBDIR ?>js/jquery.cookie.js"></script>
    <script type="text/javascript" src="<?= WEBDIR ?>js/jquery-ui.multidatespicker.js"></script>
    <script type="text/javascript" src="<?= WEBDIR ?>js/jquery.multiselect.filter.js"></script>
    <script type="text/javascript" src="<?= WEBDIR ?>js/jquery.multiselect.js"></script>
    <script type="text/javascript" src="<?= WEBDIR ?>js/jquery.sumoselect.js"></script>
    <script type="text/javascript" src="<?= WEBDIR ?>js/jquery.datetimepicker.js"></script>

    <script type="text/javascript" src="<?= WEBDIR ?>js/tag/tagmanager.js"></script>

    <link rel="stylesheet" type="text/css" src="<?php echo WEBDIR ?>js/jqplot/jquery.jqplot.css"></script>
    <script type="text/javascript" src="<?php echo WEBDIR ?>js/jqplot/jquery.jqplot.js"></script>
    <script type="text/javascript" src="<?php echo WEBDIR ?>js/jqplot/plugins/jqplot.donutRenderer.min.js"></script>
    <script type="text/javascript" src="<?php echo WEBDIR ?>js/jqplot/plugins/jqplot.pieRenderer.min.js"></script>

</head>
<body>

<?php include(Site::include_global('header')); ?>

<div id="message_error" class="message error"></div>
<div id="message_warning" class="message warning"></div>
<div id="message_info" class="message info"></div>
<div id="message_success" class="message success"></div>

<div class="content">

    <?php
    }

    require_once('includes/Controller.php');

    if (!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower(
            $_SERVER['HTTP_X_REQUESTED_WITH']
        ) == 'xmlhttprequest'))
    {
    ?>

</div>

<?php
if (Site::messages()) {
    Site::liste_message();
}
?>

<?php include(Site::include_global('footer')); ?>
</body>
</html>

    <script type="text/javascript">
        if (window.location.hash && window.location.hash == '#_=_') {
            if (window.history && history.pushState) {
                window.history.pushState("", document.title, window.location.pathname);
            } else {
                // Prevent scrolling by storing the page's current scroll offset
                var scroll = {
                    top: document.body.scrollTop,
                    left: document.body.scrollLeft
                };
                window.location.hash = '';
                // Restore the scroll offset, should be flicker free
                document.body.scrollTop = scroll.top;
                document.body.scrollLeft = scroll.left;
            }
        }
    </script>
 
<?php
}
?>
