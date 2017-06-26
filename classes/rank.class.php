<?php

class rank extends root
{

    //Attributs
    public $rank_id;
    public $rank_name;
    public $rank_img;
    public $rank_amount;

    public static $pref = 'rank_';

    //Fonctions

    public static function getMyRankName($id)
    {
        return DB::SqlOne("select rank_name from rank,user where user.user_rank = rank.rank_id and user_id = ".$id."");
    }

    public static function getMyNextRankName($id)
    {
        return DB::SqlOne("select rank_name from rank,user where user.user_rank+1 = rank.rank_id and user_id = ".$id."");
    }


    public static  function getUserRank()
    {
        $rank = Session::Me()->user_rank;

        $empty = "<img alt='' class='bonhomme' src='".user::linkAvatarImg(Session::Me()->user_id,Session::Me()->user_rank)."'>";
        $half = "<img alt='' class='bonhomme' src='".WEBDIR."img/rank/bonhommebleuclair.png'>";
        $full = "<img alt='' class='bonhomme' src='".WEBDIR."img/rank/bonhommebleu.png'>";

        if ($rank == 1) {
            $notStars = $full . $half . $empty . $empty . $empty;
        } else if ($rank == 2) {
            $notStars = $full . $full . $half . $empty . $empty;
        } else if ($rank == 3) {
            $notStars = $full . $full . $full . $half . $empty;
        } else if ($rank == 4) {
            $notStars = $full . $full . $full . $full . $half;
        } else if ($rank == 5) {
            $notStars = $full . $full . $full . $full . $full;
        }
        else{
          $notStars = $empty . $empty .$empty .$empty .$empty;
        }

        return ($notStars);
    }
}
