<?php
class Session
{
  private static $me = null ;
  private static $myloc = null;
  
  private function __construct (){
	}
  
  public function setMe($user){
    self::$me = $user;
  }
  
  public function setMyLoc($address){
    self::$myloc = $address;
  }

    /**
     * @return user
     */
  public static function Me(){
    return self::$me;
  }
  
  public static function myLoc(){
    return self::$myloc;
  }
  
	public static function Login(){
    if(@$_COOKIE['email']!='' || @$_POST['login']!='')
    {
      $new_connection=true;
      @$login = $_POST['login'];
      @$pass = Site::crypt_pwd($_POST['password']);
      @$keep = $_POST['keep'];
      if(@$_COOKIE['email']!='')
      {
        $new_connection=false;
        $login = $_COOKIE['email'];
        $pass = $_COOKIE['pass'];
      }

      $login = DB::ProtectData($login);
      //Récupération du mot de passe de la bdd lié au compte $login
      $pass_crypt = DB::SqlOne("select user_password from ".DBPRE."user where user_email='$login'");
      $user_active = DB::SqlOne("select user_active from ".DBPRE."user where user_email='$login'");
      //vérification des conditions de connexion (compte existant et mot de passe valide)
      if($pass_crypt!='' && $pass==$pass_crypt && $user_active == 1)
      {
        if($new_connection)
        {
          if($keep==1)
          {
            setcookie('email',$login,time()+31536000,'/');
            setcookie('pass',$pass,time()+31536000,'/');
          }
          else
          {
            setcookie('email',$login,0,'/');
            setcookie('pass',$pass,0,'/');
          }
          
          //Link du compte Facebook
          if(isset($_SESSION['fb_action']) && $_SESSION['fb_action']=='link')
          {
            user::LinkFacebook($login);
          }
          
          //Redirection vers la page qui nous amenait à nous connecter, ou sur l'accueil
          if(Site::isNextUrl())
            Site::goToNextUrl();
          else
            Site::redirect(WEBDIR);
            
          exit();
        }
        else
        {
          Session::setMe(user::Get(DB::SqlLine("select * from ".DBPRE."user where user_email='$login'")));
          Session::setMyLoc(address::Get(DB::SqlLine("select * from ".DBPRE."address where addr_id=".Session::Me()->getAttr('address'))));
        }
      }
      else
      {
        if($user_active != 1){
          Site::message_info("Veuillez activer votre compte via votre adresse e-mail","WARNING");
        }
        else if($new_connection)
        {
          Site::message_info("Les informations de connexion sont fausses. Vérifiez votre nom d'utilisateur et votre mot de passe. Avez vous bien créé un compte sur ce site ?",'ERROR');
        }
        else
        {
          setcookie('email','',0,'/');
          setcookie('pass','',0,'/');
          Site::message_info("Session expirée, vous avez été déconnecté.",'WARNING');
          Site::redirect(WEBDIR);
          exit();
        }
      }
    }
  }
  
  public static function Logout(){
    if(self::$me!=null)
    {
      setcookie('email','',0,'/');
      setcookie('pass','',0,'/');
        session_unset();
      Site::redirect(WEBDIR);
      exit();
    }
  }
  
  
  public static function Online(){
    if(self::$me==null)
      return false;
    else
      return true;
  }
  
  public static function IsAdmin(){
    if(self::$me->getAttr('admin')=='1')
      return true;
    else 
      return false;
  }
  
  public static function LoginAfterRegister(){
    if(@$_SESSION['register_email']!='' && @$_SESSION['register_pass']!='')
    {
      setcookie('email',$_SESSION['register_email'],0,'/');
      setcookie('pass',$_SESSION['register_pass'],0,'/');
      unset($_SESSION['register_email']);
      unset($_SESSION['register_pass']);
      Site::redirect(WEBDIR);
      exit();
    }
  }
  
  public static function FacebookConnect($user_id){
    $infos = user::getEmailPass($user_id);
    setcookie('email',$infos['user_email'],time()+31536000,'/');
    setcookie('pass',$infos['user_password'],time()+31536000,'/');
    unset($_SESSION['fb_action']);
    unset($_SESSION['fb_id']);
    unset($_SESSION['fb_name']);
    unset($_SESSION['fb_profile_picture']);
    Site::redirect(WEBDIR);
    exit();
  }
  
  
}
?>