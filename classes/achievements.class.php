<?php

class achievements extends root
{

    //Attributs
    public $achi_id;
    public $achi_name;
    public $achi_desc;
    public $achi_title;
    public $achi_cat;
    public $achi_order;
    public $achi_win;
    public $achi_condition;

    public static $pref = 'achi_';

    //Fonctions

    public static function getMyOwnAchievements($user_id)
    {
        return DB::SqlToArray(
            "select achi_title from achievements A, success_achievements S where A.achi_id=S.suca_achi_id and suca_user_id='$user_id';"
        );
    }

    public static function getMyOwnAchievementsByCat($user_id)
    {
        return DB::SqlToArray(
            "select achi_title
             from achievements A, success_achievements S
             where A.achi_id = S.suca_achi_id
             and S.suca_user_id =  '".$user_id."'
             and A.achi_cat = (Select user_rank
                               FROM user
                               WHERE user_id = '".Session::Me()->getAttr('id')."')"
        );
    }

    public static function getAllByUser($user_id, $order = 'desc', $start = 0, $max = 5)
    {
        return DB::SqlToArray(
            sprintf(
                "SELECT achi_title, achi_desc, achi_win
                FROM achievements A, success_achievements S
                WHERE A.achi_id=S.suca_achi_id
                AND suca_user_id='%s'
                ORDER BY S.created_at %s
                LIMIT %s, %s;",
                $user_id,
                $order,
                $start,
                $max
            )
        );
    }

    public static function getAllWithUserStatus($user_id, $max = 10)
    {
        $achievements = DB::SqlToArray("SELECT *
FROM achievements
Where achi_cat = (Select user_rank
                 FROM user
                 WHERE user_id = '".Session::Me()->getAttr('id')."'
                 )
ORDER BY achi_order");
        foreach ($achievements as $offset => $achievement) {
            $achievements[$offset]['done'] = self::userHasAchievement(\Session::Me()->user_id, $achievement['achi_id']);
        }

        return $achievements;
    }

    public static function getEasterEggs()
    {
        $achievements = DB::SqlToArray("SELECT *
FROM achievements
Where achi_cat = 4000
ORDER BY achi_order");
        foreach ($achievements as $offset => $achievement) {
            $achievements[$offset]['done'] = self::userHasAchievement(\Session::Me()->user_id, $achievement['achi_id']);
        }

        return $achievements;
    }


    public static function countAchievements()
    {
        return DB::SqlToArray("SELECT COUNT(achi_id) AS count FROM achievements;");
    }
    public static function countAchievementsByCat(){
        return DB::SqlOne("SELECT count(*)
FROM achievements
Where achi_cat = (Select user_rank
                 FROM user
                 WHERE user_id = '".Session::Me()->getAttr('id')."'
                 )
ORDER BY achi_order");
    }


    public static function userHasAchievement($userId, $achiId)
    {
        return DB::SqlLine("SELECT * FROM achievements a LEFT JOIN success_achievements sa ON a.achi_id=sa.suca_achi_id WHERE sa.suca_user_id={$userId} AND a.achi_id={$achiId};") ? true : false;
    }

    public function isAlreadyDoneByUser($userId)
    {
        return self::userHasAchievement($userId, $this->achi_id);
    }

    public static function triggerEvent($code)
    {

    }

    public static function getPourcentAchievements(){
        $userAchievements = count(\achievements::getMyOwnAchievementsByCat(\Session::Me()->user_id));
        $nbAchievements = \achievements::countAchievementsByCat();
        if($nbAchievements>0) $pourcentAchievements = ($userAchievements/$nbAchievements)*100;
        else $pourcentAchievements = 100;
        return $pourcentAchievements;
    }

    public static function getMutumAchievements($user_id){
        return DB::SqlOne(
            "select SUM(achi_win) from achievements A, success_achievements S where A.achi_id=S.suca_achi_id and suca_user_id='$user_id';"
        );
    }

}
