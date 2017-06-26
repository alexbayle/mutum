<?php


define("REGEXP_MAIL", '/^[a-zA-Z0-9]+([\.\-\_][a-zA-Z0-9]+)*\@[a-zA-Z0-9]+([\.\-\_][a-zA-Z0-9]+)*$/');
define("REGEXP_DATE", '/^[0-3][0-9]\/((0[1-9])|(1[0-2]))\/[0-9]{4}$/');

	
class Site {
		/**
		* affiche la trace d'exécution courante
		*
		* $backtrace : retour d'un debug_backtrace lors de l'appel à debug
		* si NULL, inclus l'appel de debug dans la trace d'exécution
		*/
		static function trace($backtrace)
		{
			$chaine='';
			if($backtrace)
				$trace=array_reverse($backtrace);
			else
				$trace=array_reverse(debug_backtrace());
			$fonction=NULL;
			$decalage='';
			foreach($trace as $appel)
			{
				$chaine.= $decalage.$appel['file'].', ligne '.$appel['line'];
				if($fonction)
				{
					$chaine.=" : $fonction()\n";
					$decalage="  ".$decalage;
				}
				else
				{
					$decalage="  +--";
					$chaine.= "\n";
				}
				$fonction=$appel['function'];
			}
			return $chaine;
		}


		//envoie un header de redirection au navigateur
		//et quitte le script
		public static function redirect($url)
    {
      if (!headers_sent())
        header('Location: ' . $url);
      else
        echo '<script language="JavaScript">window.location=\'' . $url . '\'</script>';
    }
    
        public static function redirect5Sec($url)
        {
            if (!headers_sent()){
                header( "refresh:3;url=".$url."" );
            }else{
                echo '<script type="text/javascript">
                setTimeout(function(){
                window.location.replace("'.$url.'");
                },3000);
                </script>';
            }
        }
    
    
		 		 
		/*
		* affiche les éventuels messages d'infos stockés
		* et les supprime
		*/
		static function liste_message()
		{
			
			if(empty($_SESSION["messages"]))
				return;

			foreach($_SESSION["messages"] as $message=>$type)
			{

				self::message($message,$type);
			}
			self::effacer_message_info();
		}
		 
		 
		/**
		* 
		*/
		static function messages()
		{
			if(isset($_SESSION["messages"]))
				return true;
			else
				return false;
		}
		
		static function message_info($message,$type='INFO')
		{
      if(is_array($message))
      {
        if(sizeof($message)>0)
        {
          foreach($message as $m)
          {
            $_SESSION["messages"][$m]=$type;
          }
        }
      }
      else
      {
        $_SESSION["messages"][$message]=$type;
      }
		}
		 
		/**
		* 
		*/
		static function effacer_message_info()
		{
			unset($_SESSION["messages"]);
		}
		 
		
		
		/**
		* affiche un message de debug, avec la trace d'exécution
		*
		* $message : chaine, tableau, etc...
		*/
		static function debug($message)
		{
			echo "<pre class='debug'>";
			echo "<b>";
			print_r($message);
			echo "</b>\n";
			echo self::trace(debug_backtrace()); 
			echo "</pre>";
		}
		 

		static function message($message, $type='INFO') {
			switch($type) {
				case 'INFO' : { $div = "#message_info"; break;}
				case 'ERROR' : { $div = "#message_error"; break;}
				case 'SUCCESS' : { $div = "#message_success"; break;}
				case 'WARNING' : { $div = "#message_warning"; break;}
			}			
			
			echo(
					"<script type=\"text/javascript\">
						
					if($(\"$div\").html() != \"\")
						$(\"$div\").append(\"<h3>$message</h3>\").css('height','+=40').delay(4000).fadeOut();
					else
						$(\"$div\").show().append(\"<h3>$message</h3><div style='clear: both'></div>\").delay(8000).fadeOut();
					</script>"
			);
		}
	
	static function affiche_erreur($tab){
		$error = false;
		
		foreach ($tab as $t) {
			if ($t != "") {
				site::message_info($t);
				$error = true;
			}		
		}
		return ($error);
	}
  
  static function crypt_pwd($text){
    $salt_before = "reno_";
    $salt_after = "_vali";
    return "r".sha1($salt_before.$text.$salt_after)."n";
  }
	
	static function ai_ci($text){
    $text = htmlentities($text, ENT_NOQUOTES, 'utf-8');
    $text = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $text);
    $text = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $text);
    $text = preg_replace('#&[^;]+;#', '', $text);
		$text = strtolower($text);
		return $text;
	}
  
  static function include_view($name){
    return 'pages/'.$_GET['page'].'/'.$name.'.php';
  }
  
  static function include_global($name){
    return 'pages/global/'.$name.'.php'; 
  }
  
  static function obtain_post($field)
  {
      if (!isset($_POST[$field])) {
          return false;
      }

      @$field = $_POST[$field];
      $field = stripslashes($field);
      $field = str_replace("\"", "&quot;", $field);
      $field = str_replace("\"", "\"\"", $field);
      $field = trim($field);

      return $field;
  }
  
  static function check_name($name)
  {
    return preg_match('/[A-Za-z]+([\-]?[A-Za-z])*/',$name);
  }
  
  static function generate_uniquid($length){
    $code = "";
    $chaine = "abcdefghijklmnpqrstuvwxyABCDEFGHIJKLMNOPGRSTUVWXYZ0123456789";
    for($i=0; $i<$length; $i++)
    {
      $code .= $chaine[rand()%strlen($chaine)];
    }
    return $code;
  }
  
  static function now()
  {
    return @strftime("%Y-%m-%d %H:%M:%S", mktime());
  }
  
  static function dow()
  {
    return @strftime("%Y-%m-%d", mktime());
  }
  
  static function tow()
  {
    return @strftime("%H:%M:%S", mktime());
  }
  
  static function GetInfoByAddress($address){
    $geocoder = "http://maps.googleapis.com/maps/api/geocode/json?address=%s&sensor=false&language=fr";
    $url_address = urlencode($address);
    $query = sprintf($geocoder,$url_address);
    return json_decode(file_get_contents($query));
  }
  
  static function GetCoords($address){
    @$rs = self::GetInfoByAddress($address);
    @$coord = $rs->{'results'}[0]->{'geometry'}->{'location'};
    return array(@$coord->{'lat'},@$coord->{'lng'});
  }
  
  static function GetFullAddress($address){
    @$rs = self::GetInfoByAddress($address);
    @$full_address = $rs->{'results'}[0]->{'formatted_address'};
    @$tab_address = explode(',',$full_address);
    @$adr = $tab_address[0];
    @$zip = substr($tab_address[1],1,5);
    @$city_name = substr($tab_address[1],7);
    return array($adr,$zip,$city_name);
  }
  
  static function  add_score_to_user($user_id,$pts){
    $sql = "update user set"
      ." user_score = user_score + \"$pts\""
      ." where user_id = \"$user_id\"";
    DB::SqlExec($sql);
  }

  static function add_credit_to_user($user_id, $pts, $type){
    $sql = "update user set"
      ." user_credit = user_credit + \"$pts\""
      ." where user_id = \"$user_id\""
    ;
    DB::SqlExec($sql);
    $sql = "insert into move (move_date_creation, move_user_id, move_amount, move_type)"
      ." values (now(), \"$user_id\", \"$pts\", \"$type\")"
    ;
    DB::SqlExec($sql);
  }
    static function apres_credit_to_user($user_id, $pts, $type){
    $sql = "update user set"
      ." user_credit = user_credit - \"$pts\""
      ." where user_id = \"$user_id\""
    ;
    DB::SqlExec($sql);
    $sql = "insert into move (move_date_creation, move_user_id, move_amount, move_type)"
      ." values (now(), \"$user_id\", \"$pts\", \"$type\")"
    ;
    DB::SqlExec($sql);
  }
  
  static function check_words($string){
    $result='';
    $sql="select * from words";
    $rs = DB::SqlToArray($sql);
    foreach($rs as $word)
    {
      if(!strpos($string,$word['text'])==false){
        message_info("votre mot n'est pas conforme",'ERREUR');
        $result='false';
      }
      else
      {
        $result='true';
      }
    }
    return $result;
  }
  
	static function fd2md($d){
    if ($d!="")
      return substr($d,6,4)."-".substr($d,3,2)."-".substr($d,0,2);
    else
      return "";
  }
  
  static function md2fd2($d, $fmt){
    $res = "";
    if ($d != "")
    {
		  $res = $fmt;
		  $res = str_replace("YYYY", substr($d,0,4), $res);
		  $res = str_replace("YY", substr($d,2,2), $res);
		  $res = str_replace("MM", substr($d,5,2), $res);
		  $res = str_replace("DD", substr($d,8,2), $res);
		  $res = str_replace("HH", substr($d,11,2), $res);
		  $res = str_replace("II", substr($d,14,2), $res);
		  $res = str_replace("SS", substr($d,17,2), $res);
    }	
    return $res;
  }

    static function combo_contents($tab, $aid, $value, $display)
    {
        $res = '';
        foreach ($tab as $name) {
            $res .= sprintf(
                "<option value='%s' %s>%s</option>",
                $name[$value], // value
                $name[$value] == $aid ? "selected" : "", // selected?
                $name[$display] // label
            );
        }

        return $res;
    }

  static function md2php($d){
    if ($d!="")
    {
      return @mktime(substr($d, 11, 2)
        , substr($d, 14, 2)
        , substr($d, 17, 2)
        , substr($d, 5, 2)
        , substr($d, 8, 2)
        , substr($d, 0, 4));
    }
    else
    {
      return "";
    }
  }
  
  static function setNextUrl(){
    $_SESSION['next_url'] = WEBDIR.substr($_SERVER['REQUEST_URI'],1);
  }
  
  static function goToNextUrl(){
    Site::redirect($_SESSION['next_url']);
    unset($_SESSION['next_url']);
    exit();
  }
  
  static function isNextUrl(){
    if(isset($_SESSION['next_url']) && $_SESSION['next_url']!='')
      return true;
    else
      return false;
  }
  
  static function multiexplode ($delimiters,$string) {
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
  }
  
  static function getLevenshteinCoeff($str){
     return floor(strlen($str)/2);
  }
  
  static function getpts($price){
    /*
      =ARRONDI(
        SI(G6<=$A$2; G6*$D$2+$E$2;
        SI(G6<=$A$3; G6*$D$3+$E$3;
        SI(G6<=$A$4; G6*$D$4+$E$4;
        SI(G6<=$A$5; G6*$D$5+$E$5;
        SI(G6<=$A$6; G6*$D$6+$E$6;
        SI(G6<=$A$7; G6*$D$7+$E$7;
          "valeur hors domaine"))))));0)
    */
    $pts = 0;
    $ratio = 0;
    $origin = 0;
    if (($price > 0) && ($price <= 10))
    {
      $ratio = 1; $origin = 0;
    }
    else if (($price > 10) && ($price <= 50))
    {
      $ratio = 0.875; $origin = 1.25;
    }
    else if (($price > 50) && ($price <= 100))
    {
      $ratio = 0.7; $origin = 10;
    }
    else if (($price > 100) && ($price <= 200))
    {
      $ratio = 0.5; $origin = 30;
    }
    else if (($price > 200) && ($price <= 1000))
    {
      $ratio = 0.2125; $origin = 87.5;
    }
    else if (($price > 1000)/* && ($price <= 1000)*/)
    {
      $ratio = 0.125; $origin = 175;
    }
    $pts = round(($price * $ratio) + $origin);
    return $pts;
  }

  static function getWidget($name,$params=array()){
		$widget_id = self::generate_uniquid(10);
    echo "<div class='widget'>";
    $GLOBALS['params']= $params;
    if(!empty($name) && is_file('widget/'.$name.'.php'))
      include 'widget/'.$name.'.php';
    else
      return "Widget $name not Found.";
    echo "</div>";
  }
  
	static function getWidgetParams($key,$default){
		$params=$GLOBALS['params'];
		if(@$params[$key]!='')
			return $params[$key];
		else
			return $default;
	}
  
	static function send_mailjet($dest,$subject,$text){
		require_once('lib/mailjet/mailjet.class.php');
		$mj = new Mailjet();
		$params = array(
			"method" => "POST",
			"from" => "mutum.fr <noreply@mutum.fr>",
			"to" => $dest,
			"subject" => $subject,
			"html" => $text
		);
		//"inlineattachment" => array("@http://".$SITEURL."/mails/ressources/mailjet_img1.png","@http://".$SITEURL."/mails/ressources/mailjet_img2.png"),
		$result = $mj->sendEmail($params);

		if ($mj->_response_code == 200)
			echo "";
		else
			$error = "Error - ".$mj->_response_code;

		return $result;
	}


	/*static function createAssociationTabMail($tab1,$tab2){
		$tab = array();
		for($i=0;$i<sizeof($tab1);$i++)
		{
			array_push($tab,array('code'=>$tab1[$i],'variable'=>$tab2[$i]));
		}
		return $tab;
	}*/
	
	static function sendSiteMail($mail,$tab1,$tab2,$dest,$subject,$user='false'){
		if($user=='false' && Session::Online())
		{
			$user = Session::Me();
		}
		if($user!='false')
		{
			if(notification_mail::shouldSendMail($mail,$user->getAttr('id')))
			{
				$text = file_get_contents("mails/".$mail.".html");
				for($i=0;$i<sizeof($tab1);$i++)
				{
					$text = str_replace($tab1[$i],$tab2[$i] ,$text);
				}
				$text = str_replace('[url]',WEBDIR ,$text);
				Site::send_mailjet($dest,$subject,$text);
			}
		}
	}
	
	static function check_errors($tab){   // WIP NE FONCTIONNE PAS
		/*
		array(
			array(
				"value" => "",
				"name" => "",
				"type" => "",
				"data" => "",
				"group" => ""
			),
			array(
				"expr" => "",
				"error" => ""
			)
		)
		
		*/
		//value;name;type;data
		$error = 0;
		$tab_error = array();
		foreach($tab as $t)
		{
			//not_null
			$former_error = $error;
			$former_order = 0;
			switch(@$t['type'])
			{
				case 'not_null':
					if($t['value']=='')
					{
						$error++;
						$msg = "Le champs ".$t["name"]." doit être complété.";
					}
				break;
				//min (caracteres)
				case 'min':
					if(strlen($t['value'])<$t['data'])
					{
						$error++;
						$msg = "Le champs ".$t["name"]." doit posséder plus de ".$t["data"]." caractères.";
					}
				break;
				//max (caracteres)
				case 'max':
					if(strlen($t['value'])>$t['data'])
					{
						$error++;
						$msg = "Le champs ".$t["name"]." doit posséder moins de ".$t["data"]." caractères.";
					}
				break;
				//email
				case 'email':
					if(!preg_match(REGEXP_EMAIL,$t["value"]))
					{
						$error++;
						$msg = "Le champs ".$t["name"]." ne satisfait pas à l'expression régulière d'un email.";
					}
				break;
				//date
				case 'date':
					if(!preg_match(REGEXP_DATE,$t["value"]))
					{
						$error++;
						$msg = "Le champs ".$t["name"]." ne satisfait pas au format d'une date (jj/mm/yyyy).";
					}
				break;
				default:
					if(eval($t['expr']))
					{
						$error++;
						$msg = $t["error"];
					}
				break;
			}
			if($former_error!=$error)
			{
				if(isset($t['name']))
					array_push($tab_error,$t['name'].'_error');
				if($former_order <= $t['order'])
				{
					Site::message_info($msg,"ERROR");
					$former_order = $t['order'];
				}
				$former_error = $error;
			}
		}
		if($error>0)
			return $tab_error;
		else
			return false;
	}
	
	static function fill_null_union_sql($tab_table){
		$tab = array();
		foreach($tab_table as $t)
			array_push($tab,DB::SqlToArray("show columns from ".$t));
		$liste = '';
		foreach($tab as $ta)
		{
			foreach($ta as $t)
				$liste.="null as ".$t['Field'].",";
		}
		return $liste;
	}

    static function  swat_hash($text)
    {
        $salt_before = "reno_";
        $salt_after = "_vali";
        return "r".sha1($salt_before.$text.$salt_after)."n";
    }

    static function ResizeImageCenterCrop($aImage, $aWidth, $aHeight)
    {
        if (substr($aImage, -4) == ".png" || substr($aImage, -4) == ".PNG")
        {
            $src_img = imagecreatefrompng($aImage);
        }
        else if(substr($aImage, -4) == ".gif" || substr($aImage, -4) == ".GIF")
        {
            $src_img = imagecreatefromgif($aImage);
        }
        else
        {
            $src_img = imagecreatefromjpeg($aImage);
        }
        $dst_img = imagecreatetruecolor($aWidth, $aHeight);
        $_xx = imagesx($src_img);
        $_yy = imagesy($src_img);
        // Center from the original picture
        if ($_xx >= $_yy * ($aWidth / $aHeight))
        {
            $_y = 0;
            $_h = $_yy;
            $_x = round(($_xx - $_yy * ($aWidth / $aHeight)) / 2);
            $_w = $_yy * ($aWidth / $aHeight);
        }
        else
        {
            $_x = 0;
            $_w = $_xx;
            $_y = round(($_yy - $_xx / ($aWidth / $aHeight)) / 2);
            $_h = $_xx / ($aWidth / $aHeight);
        }
        // Write picture
        imagecopyresampled($dst_img, $src_img, 0, 0, $_x, $_y
            , $aWidth, $aHeight, $_w, $_h);
        imagejpeg($dst_img, $aImage, 100);
        imagedestroy($src_img);
        imagedestroy($dst_img);
    }

};
?>