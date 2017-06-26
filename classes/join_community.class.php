<?php

/**
 * Class join_community
 */
class join_community extends root
{

    //Attributs
    /**
     * @var
     */
    public $join_comm_id;
    /**
     * @var
     */
    public $join_user_id;
    /**
     * @var
     */
    public $join_rank;
    /**
     * @var
     */
    public $join_status;
    /**
     * @var
     */
    public $join_desc;

    /**
     * @var string
     */
    public static $pref = 'join_';

    /**
     * @param user $user
     * @param $communityIds
     */
    public static function setUserCommunities(user $user, $communityIds)
    {
        $userCommunityIds = $user->getMyCommunityIds();
        $communityIdsToUnlink = array_diff($userCommunityIds, $communityIds);
        $communityIdsToLink = array_diff($communityIds, $userCommunityIds);
        self::unlinkUserCommunities($user, $communityIdsToUnlink);

        foreach ($communityIdsToLink as $communityId) {
            self::addUserCommunity($user, $communityId);
        }
    }

    public function addUserCommunity(user $user, $communityId)
    {
        $community = community::getById($communityId);
        if ($community) {
            $community = $community[0][0];
            $join = new join_community();
            $join->join_comm_id = $community->getAttr('id');
            $join->join_user_id = $user->getAttr('id');
            $join->join_rank = 1;
            $join->join_status = 'V';
            $join->join_desc = '';
            $join->Insert();

            post::createFromUserJoinCommunity($user, $community);
        }
    }

    /**
     * @param user $user
     */
    public static function removeByUser(user $user)
    {
        self::unlinkUserCommunities($user, $user->getMyCommunityIds());
    }

    public static function unlinkUserCommunities(user $user, $communitiesIds)
    {
        foreach ($communitiesIds as $communityId) {
            self::unlinkUserCommunity($user, $communityId);
        }
    }


    public static function unlinkUserCommunity(user $user, $communityId)
    {
        $community = community::getById($communityId);
        if ($community) {
            $community = $community[0][0];
            $query = sprintf(
                "DELETE FROM join_community WHERE join_comm_id='%s' AND join_user_id='%s';",
                $community->getAttr('id'),
                $user->getAttr('id')
            );
            DB::SqlExec($query);

            post::createFromUserLeaveCommunity($user, $community);
        }

    }
}