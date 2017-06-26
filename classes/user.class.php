<?php

class user extends root
{

    //Attributs
    public $user_id;
    public $user_address;
    public $user_rank;
    public $user_email;
    public $user_firstname;
    public $user_lastname;
    public $user_password;
    public $user_admin;
    public $user_birthdate;
    public $user_sex;
    public $user_phone;
    public $user_phone_hide;
    public $user_sponsor_code;
//    public $user_title;
    public $user_godfather;
    public $user_mangopay_id;
    public $user_facebook_id;
    public $user_credit;
    public $user_nb_notation;
    public $user_notation;
    public $user_date_creation;
    public $user_active;
    public $user_online;
    public $user_score;
    public $user_token;
    public $user_codepromo;
    public $user_avatar;

    public static $pref = 'user_';


    //Fonctions

    public static function getIdwithGodfatherCode($code)
    {
        return DB::SqlOne("select user_id from " . DBPRE . "user where user_sponsor_code='$code'");
    }

    public static function getGodfatherExist($code)
    {
        return DB::SqlOne("select user_sponsor_code from " . DBPRE . "user where user_sponsor_code='$code'");
    }

    public static function getByEmail($email)
    {
        return DB::SqlOne("select user_id from " . DBPRE . "user where user_email='$email'");
    }

    public static function findByEmail($email)
    {
        $user = DB::SqlToObj(array('user'), "select * from " . DBPRE . "user where user_email='$email'");
        if (count($user)) {
            return $user[0][0];
        }

        return false;
    }

    public static function getUserArticle($user_id,$filter =null,$limit=null)
    {
		$query = "select * from  article, product where arti_prod_id=prod_id and prod_user_id= '$user_id' and prod_deleted <>1";

		if(!empty($filter)){
			//echo "<br>Le critere est: $filter";
			$query.=" $filter";
		}
	
		if(!empty($limit)){
			$query.=" limit $limit";
			//echo "<br>La limite est: $limit<br>";
		}
		
        //echo "$query";

        return article::Get_Tab( DB::SqlToArray($query));
    }



    public function getArticles($filter = null, $limit = null)
    {
        return self::getUserArticle($this->user_id, $filter, $limit);
    }


    public static function getLastUserArticle($user_id)
    {
        return article::Get_Tab(
            DB::SqlToArray("select * from  article, product where arti_prod_id=prod_id and prod_user_id= '$user_id' and prod_deleted <>1 limit(5) order by prod_date_creation limit 5")
        );
    }


    /*
    * methode:  getUserArticlePret
    * parametre:  id de l'utilisateur
    * role: recupère les articles non prétés
    */
    public static function getUserArticleDispo($user_id)
    {
        return DB::SqlToObj(array('product','article'),"select *
from article, product
where arti_prod_id=prod_id
and prod_user_id = '$user_id'
and prod_deleted <> 1
and arti_dispo = 1
limit 4");


        //return article::Get_Tab(DB::SqlToArray("select * from  article, product where arti_prod_id=prod_id and prod_user_id= '$user_id' and prod_deleted <>1"));
    }

    public static function getNumberArticleDispo($user_id)
    {
        return DB::SqlToObj(array('product','article'),"select *
from article, product
where arti_prod_id=prod_id
and prod_user_id = '$user_id'
and prod_deleted <> 1
and arti_dispo = 1
");


        //return article::Get_Tab(DB::SqlToArray("select * from  article, product where arti_prod_id=prod_id and prod_user_id= '$user_id' and prod_deleted <>1"));
    }

    public function getNotePreteur()
    {
        return DB::SqlToObj(
            array('notation'),
            "select * from notation where nota_dest_user_id='" . $this->getAttr('id') . "' and nota_type='P'"
        );
    }

    public function getNoteEmpreinteur()
    {
        return DB::SqlToObj(
            array('notation'),
            "select * from notation where nota_dest_user_id='" . $this->getAttr('id') . "' and nota_type='E'"
        );
    }

    public static function getUserByFacebookId($fb_id)
    {
        return DB::SqlOne("select user_id from " . DBPRE . "user where user_facebook_id='$fb_id'");
    }

    public static function getEmailPass($user_id)
    {
        return DB::SqlLine("select user_email,user_password from " . DBPRE . "user where user_id='$user_id'");
    }

    public static function getCredit($user_id)
    {
        return DB::SqlOne("select user_credit from " . DBPRE . "user where user_id='$user_id'");
    }

    public static function getList($max = 15)
    {
        return DB::SqlToArray("SELECT user_id, user_firstname, user_lastname, user_rank, user_nb_notation, user_notation, user_score FROM user WHERE user_active=1 ORDER BY user_score DESC LIMIT {$max};");
    }

    public static function getListUser()
    {
        return DB::SqlToObj(array('user'),"select * from user where user_active = 1 order by user_score desc ");
    }


    public function getScoreRanks()
    {


        /**
         * LOOOOOOOL!!!!
         */
        $city = self::getCity($this->user_address);
        $communityIds = implode(', ', \community::getMyListeComm());


        $ranks = array(
            'general' => DB::SqlToArray(
                "SELECT COUNT(*) + 1 as pos FROM user WHERE user_score > (SELECT user_score FROM user where user_id={$this->user_id}) AND user_active=1;"
            )[0]['pos'],
            'city' => DB::SqlToArray(
                "SELECT COUNT(*) + 1 as pos FROM user u LEFT JOIN address a ON a.addr_id=u.user_address WHERE a.addr_city='{$city}' AND user_score > (SELECT user_score FROM user where user_id={$this->user_id}) AND user_active=1;"
            )[0]['pos'],
            'contact' => DB::SqlToArray(
                "SELECT COUNT(*) + 1 as pos FROM user u INNER JOIN contact c ON c.cont_user_id_a=u.user_id WHERE user_score > (SELECT user_score FROM user where user_id={$this->user_id}) AND user_active=1;"
            )[0]['pos'],
            'community' => $communityIds ? DB::SqlToArray(
                "SELECT COUNT(*) + 1 as pos
FROM user u
LEFT JOIN join_community jc ON jc.join_user_id=u.user_id
LEFT JOIN community c ON c.comm_id=jc.join_comm_id
WHERE c.comm_id IN ({$communityIds})
AND user_score > (SELECT user_score FROM user where user_id={$this->user_id}) AND user_active=1;"
            )[0]['pos'] : false,
        );

        return $ranks;
    }

    public function addCredit($credit = 0)
    {
        $this->user_credit += $credit;
    }

    public function addScore($score = 0)
    {
        $this->user_score += $score;
    }

    public static function LinkFacebook($login)
    {
        DB::SqlExec(
            "update " . DBPRE . "user set user_facebook_id='" . $_SESSION['fb_id'] . "' where user_email='$login'"
        );
        Site::message_info('Votre compte mutum a bien été lié à votre compte Facebook', 'SUCCESS');
        unset($_SESSION['fb_action']);
        unset($_SESSION['fb_id']);
        unset($_SESSION['fb_name']);
        unset($_SESSION['fb_profile_picture']);
    }

    public static function getUser($id)
    {
        return DB::SqlToObj(array('user'), "select * from user where user_id='$id'");
    }

    public static function retrieveUser($name)
    {
        return DB::SqlToArray(
            "select user_id,user_firstname,user_lastname from user where CONCAT(user_firstname,' ',user_lastname) like '" . $name . "%' or CONCAT(user_lastname,' ',user_firstname) like '" . $name . "%'"
        );
    }

    public static function getCity($id)
    {
        return DB::SqlOne("select addr_city from address where addr_id=" . $id . "");
    }

    function print_user($size = 40, $class = "")
    {
        $id = Site::crypt_pwd($this->getAttr('id'));
        $src_path = "img/no-avatar-male.png";
        if ($this->getAttr('sex') == 'F') {
            $src_path = "img/no-avatar-female.png";
        }
        if (file_exists("img/user/$id.jpg")) {
            $src_path = "img/user/$id.jpg";
        } else {
            if (file_exists("img/user/$id.jpeg")) {
                $src_path = "img/user/$id.jpeg";
            } else {
                if (file_exists("img/user/$id.png")) {
                    $src_path = "img/user/$id.png";
                } else {
                    if (file_exists("img/user/$id.gif")) {
                        $src_path = "img/user/$id.gif";
                    }
                }
            }
        }

        return "<img src='" . WEBDIR . "$src_path' " . ($size != "" ? " style='height:" . $size . "px;width:" . $size . "px; '" : "") . " class='$class img-responsive'  >";
    }

    function printName()
    {
        if (Session::Online()) {
            if (contact::isContact($this->getAttr('id'))) {
                return $this->getAttr('firstname') . ' ' . $this->getAttr('lastname');
            }
        }

        return $this->getAttr('firstname') . ' ' . substr($this->getAttr('lastname'), 0, 1);
    }

    public function getFullname()
    {
        return sprintf("%s %s", ucfirst($this->getAttr('firstname')), strtoupper($this->getAttr('lastname')));
    }

    function printNote($userNBNotation = null, $userNotation = null)
    {
    	//(isset($userNBNotation)? $userNBNotation : $this->getAttr('nb_notation'))
        return "<div style='margin-left:10px;margin-top:3px;float:left;position:relative;height:20px;'><img src='" . WEBDIR
        		. "img/" . (((isset($userNBNotation)? $userNBNotation : 0)) == 0 ?
        				 "badge_gris" : "badge_jaune") . ".png' /><div style='position:absolute;font-size:11px;top:1px;left:6px;color:" .
        (((isset($userNBNotation)? $userNBNotation : 0)) == 0 ?
        		 "#818181" : "#EBAD15") . "'>" . (isset($userNotation)? $userNotation : 0) . "</div></div>";
    }

    function isUserActive()
    {
        $active = DB::SqlOne("select user_active from user where user_id='" . $this->getAttr('id') . "'");
        if ($active == 1) {
            return true;
        } else {
            return false;
        }
    }

    public static function userActive(){
        $active = DB::SqlOne("select user_active from user where user_id='" .Session::Me()->getAttr('id'). "'");
        return $active;
    }

    public static function activate($active)
    {
        $query = sprintf("UPDATE user SET user_active='1' WHERE user_active= '".$active."'");
        $res = DB::SqlExec($query);
    }

    /*
    *	methode: printRank
    *	role: recupere l'image en fonction du niveau et du rank de l'utilisateur
    *	paramètretre:aucun*
    *	auteur Josué
    */
    function printRank()
    {
        return DB::SqlToArray("select rank_img, rank_name from rank where rank_id='" . $this->user_rank . "'");
    }

    public static function printNextRank($rank)
    {
        $myrank = $rank;
        $nextrank = '';
        if($myrank == 'Niv 1 - Novice'){
            $nextrank = 'Niv 2 - Apprenti(e)';
        }else if($myrank == 'Niv 2 - Apprenti(e)'){
            $nextrank = 'Niv 3 - Spécialiste';
        }else if($myrank == 'Niv 3 - Spécialiste'){
            $nextrank = 'Niv 4 - Expert';
        }else if($myrank == 'Niv 4 - Expert'){
            $nextrank = 'Niv 5 - Virtuose';
        }else{
            $nextrank = 'niveau maximum';
        }

        return $nextrank;
    }


    public function getValue($field)
    {
        if (isset($this->$field)) {
            return $this->$field;
        }

        return false;
    }


    public function isValid()
    {
        $class = new \ReflectionClass ($this);
        $properties = $class->getProperties();

        $optionalFields = array(
            'user_id',
            'user_sponsor_code',
            'user_facebook_id',
            'user_mangopay_id',
            'user_credit',
            'user_godfather',
            'pref',
            'user_token'
        );


        $errors = array();
        foreach ($properties as $property) {
            if (in_array($property->getName(), $optionalFields)) {
                continue;
            }
            if (false === $this->getValue($property->getName())) {
                $errors [$property->getName()] = sprintf("'%s' ne doit pas être null.", $property->getName());
            }
        }

        // valdiate password
        $passwd = Site::obtain_post('register_password1');
        $passwdConfirm = Site::obtain_post('register_password2');
        if ($passwd !== $passwdConfirm) {
            $errors['user_password'] = "Les mots de passes ne correspondent pas";
        }
        if (strlen($passwd) < 6) {
            $errors['user_password'] = "Le mot de passe doit etre supérieur à 6 caractères";
        }
        $this->user_password = $passwd;

        //validate godfather


        // validate email
        if (!filter_var($this->user_email, FILTER_VALIDATE_EMAIL)) {
            $errors['user_email'] = "L'email n'est pas valide";
        }
        if (self::getByEmail($this->user_email)) {
            $errors['user_email'] = "Cet email est déjà enregistré.";
        }

        //valid cgu
        $check = Site::obtain_post('check_cgu');
        if('' == $check){
            $errors[] = "Veuillez valider les CGU";
        }

        // validate godfather
        $code = $this->user_godfather;
        if (self::getGodfatherExist($code)) {
            $godFather = self::getIdwithGodfatherCode($code);
            if (!$godFather) {
                $errors['user_godfather'] = "Le code parrain que vous avez renseigné est erroné. Corrigez le ou supprimez le.";
            }

            $this->user_godfather = $godFather->user_id;
        } else {
            $this->user_godfather = null;
        }

        if ($errors) {
            return $errors;
        }
    }

    public function save()
    {
        if (isset($_SESSION['fb_id']) && $_SESSION['fb_id']) {
            $this->user_facebook_id = $_SESSION['fb_id'];
        }
                //Gestion Mangopay

                try {
                    require_once(__DIR__ . '/../lib/mangopay/mangoPayApi.inc');
                    $api_mango = new \MangoPay\MangoPayApi();
                    $api_mango->Config->TemporaryFolder = MANGOPAYTMP;
                    $api_mango->Config->ClientId = \DB::SqlOne(
                        "select mang_name from " . DBPRE . "mangopay where mang_id='2'"
                    );
                    $api_mango->Config->ClientPassword = \DB::SqlOne(
                        "select mang_pass from " . DBPRE . "mangopay where mang_id='2'"
                    );
                    $api_mango->Config->BaseUrl = MANGOPAYAPI;

                    $naturalUser = new \MangoPay\UserNatural();
                    $naturalUser->FirstName = $this->user_firstname;
                    $naturalUser->LastName = $this->user_lastname;
                    $naturalUser->Address = $this->user_address;
                    $naturalUser->Birthday = $this->user_birthdate->getTimestamp();
                    $naturalUser->Nationality = 'FR';
                    $naturalUser->CountryOfResidence = 'FR';
                    $naturalUser->Email = $this->user_email;
                    $naturalUserResult = $api_mango->Users->Create($naturalUser);


                    $wallet = new \MangoPay\Wallet();
                    $wallet->Owners = array($naturalUserResult->Id);
                    $wallet->Description = "Private Wallet";
                    $wallet->Currency = "EUR";
                    $walletResult = $api_mango->Wallets->Create($wallet);

                } catch (\MangoPay\ResponseException $e) {
                    \MangoPay\Logs::Debug('MangoPay\ResponseException Code', $e->GetCode());
                    \MangoPay\Logs::Debug('Message', $e->GetMessage());
                    \MangoPay\Logs::Debug('Details', $e->GetErrorDetails());
                } catch (\MangoPay\Exception $e) {
                    \MangoPay\Logs::Debug('MangoPay\Exception Message', $e->GetMessage());
                }


                $address = new address();
                $address->initWithString($this->user_address);
                $this->user_address = $address->Insert();

                $this->user_mangopay_id = $naturalUserResult->Id;
                $this->user_birthdate = $this->user_birthdate->format('Y-m-d');
                $this->user_sponsor_code = Site::generate_uniquid(8);
                $this->user_active = Site::generate_uniquid(32);
                $this->user_password = Site::crypt_pwd($this->user_password);


                if ($this->user_godfather) {
                    $this->addCredit(10);
                }
                $this->addCredit(30);
                $this->addScore(30);

                $code_promo = $this->user_codepromo;

                if ($code_promo  == "CAMPUSDAUPHINE" || $code_promo == "campusdauphine")
                {
                    $this->addCredit(20);
                }
                if ($code_promo == "CAMPUSESSEC" || $code_promo == "campusessec")
                {
                    $this->addCredit(20);
                }
                if ($code_promo == "CAMPUSESCP" || $code_promo == "campusescp")
                {
                    $this->addCredit(20);
                }
                if ($code_promo == "SCIENCEPO2015" || $code_promo == "sciencepo2015")
                {
                    $this->addCredit(20);
                }

                if ($code_promo == "ESCEMYRAGE" || $code_promo == "escemirage")
                {
                    $this->addCredit(20);
                }

                if ($code_promo == "CAMPUSIPAG" || $code_promo == "campusipag")
                {
                    $this->addCredit(20);
                }

                if ($code_promo == "JEUNEPOUSSE" || $code_promo == "jeunepousse")
                {
                    $this->addCredit(20);
                }

                if ($code_promo == "FORUMDAUPHINE" || $code_promo == "forumdauphine")
                {
                    $this->addCredit(20);
                }

                if ($code_promo == "ANTROPIA" || $code_promo == "antropia")
                {
                    $this->addCredit(20);
                }

                if ($code_promo == "you're up" || $code_promo == "YOU'RE UP" || $code_promo == "you'reup" || $code_promo == "You're Up")
                {
                    $this->addCredit(20);
                }
                if ($code_promo == "leforumdauphine" || $code_promo == "LEFORUMDAUPHINE" || $code_promo == "le forum dauphine")
                {
                    $this->addCredit(20);
                }




                $this->user_id = $this->Insert();
            }

    public function createOrLinkFromFacebook(\Facebook\GraphUser $user)
    {
        if ($registeredUser = self::findByEmail($user->getEmail())) {
            $registeredUser->user_facebook_id = $user->getId();
            $registeredUser->Update();
        } else {
            $this->user_facebook_id = $user->getId();
            $this->user_firstname = $user->getFirstName();
            $this->user_lastname = $user->getLastname();
            $this->user_sex = $user->getGender() === 'male' ? 'M' : 'F';
            $this->user_email = $user->getEmail();
            $this->user_phone = '';
            $this->user_phone_hide = 0;
            $this->user_active = true;
            $this->user_rank = 1;
            $this->user_notation = 0;
            $this->user_nb_notation = 0;
            $this->user_admin = 0;
            $this->user_date_creation = date('Y-m-d H:i:s');
            $this->user_online = date('Y-m-d H:i:s');
            $this->user_birthdate = $user->getBirthday();
            $this->user_avatar = $user->user_avatar;
//            $this->user_title = 'Nouveau Mutumus';

            $this->user_address = $user->getLocation()->getProperty('name');
            if ($this->isValid()) {
                $this->save();
            }
        }
    }


    public static function searchUser($name,$cPage,$perPage){
        return DB::SqlToObj(array('user'),"select * from user where user_lastname LIKE '%".$name."%' OR user_firstname LIKE '%".$name."%' LIMIT ".(($cPage-1)*$perPage).",$perPage ");
    }

    public function getHistory()
    {
        return \move::getByUserId($this->user_id);
    }

    public function getHistoryWithCat()
    {
        return \move::getWithCatByUserId($this->user_id);
    }

    public function getHistoryWithCat3()
    {
        return \move::getWithCatByUserId3($this->user_id);
    }

    public function getCountCategoriesByUserId()
    {
        return \move::getCountCategoriesByUserId($this->user_id);
    }

    public static function getPeopleByCity()
    {
        return DB::SqlOne("Select count(*) FROM user u LEFT JOIN address a ON a.addr_id=u.user_address where addr_city = '".Session::myLoc()->getAttr('city')."'");
    }

    public static function getAllUser()
    {
        return DB::SqlOne("Select count(user_id) from user where user_active = 1");
    }

    public static function getFormatDate($date)
    {
        sscanf($date, "%4s-%2s-%2s %2s:%2s", $annee, $mois, $jour, $heure, $minute);
        echo $jour.'/'.$mois.'/'.$annee.' ';
    }

    public static function totalUser($name = null)
    {
        $where = '';
        if($name)
        {
            $where = "where user_lastname LIKE '%".$name."%' OR user_firstname LIKE '%".$name."%' ";
        }
        return DB::SqlOne("Select count(user_id) as 'nbContact' from user ".$where);
    }

    public function getMyCommunities()
    {
        return community::getAllMyCommunity();
    }

    public function getMyCommunityIds()
    {
        return community::getMyListeComm();
    }

    public function getAvatarNb($userId)
    {
        return DB::SqlOne("Select user_avatar from user where user_id=".$userId);
    }

    public function linkAvatarImg($userId,$rank)
    {
        //Session::Me()->user_rank;
        $avatarNb = \user::getAvatarNb($userId);

        return WEBDIR.'img/personnageRangs/niv_'.$rank.'/'.$avatarNb.'.png';
    }

    public function printNoteUser($note)
    {
        for($i=1;$i<=5;$i++){
            if($note<$i) echo "<img src='".WEBDIR."img/note_userB.png' style='padding: 0 2px;'/>";
            else echo "<img src='".WEBDIR."img/note_user.png' style='padding: 0 2px;'/>";
        }
    }

    public function printNoteUserMin($note)
    {
             echo ceil($note)."  <img src='".WEBDIR."img/note_user.png' style='padding: 0 2px;'/>";
    }

    public function printNoteObj($note)
    {
        for($i=1;$i<=5;$i++){
            if($note<$i) echo "<img src='".WEBDIR."img/empty_star.png' style='padding: 0 2px;'/>";
            else echo "<img src='".WEBDIR."img/star.png' style='padding: 0 2px;'/>";
        }
    }


}

