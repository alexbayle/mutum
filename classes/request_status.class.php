<?php

class request_status extends root
{

    //Attributs
    public $reqs_id;
    public $reqs_name;
    public $reqs_borrower_info;
    public $reqs_lender_info;

    public static $pref = 'reqs_';


    // STATUS GENERAUX
    const STATUS_ASK = 6;
    const STATUS_REFUSED = 5;
    const STATUS_CANCEL_LENDER = 3;
    const STATUS_CANCEL_BORROWER = 4;
    const STATUS_VALID = 2;
    const STATUS_BLOCKED = 1;

    // STATUS EN FONCTION DU TEMPS
    const STATUS_CAUTION = 7; // demande de caution transmise à l'emprunteur
    const STATUS_ENDED_TODAY = 8; // echange fini aujourd'hui
    const STATUS_ENDED = 9; // echange terminé
    const STATUS_START_TODAY = 10; // échange aujourd'hui
    const STATUS_IN_PROGRESS = 11; // en cours
    const STATUS_OBSOLETE = 12; // demande périmée


    public static function get(\request $request)
    {
        $status = null;
        $code = null;
        if(strtotime($request->getAttr('date_to')) <= time()
            && $request->getAttr('code') == -1 && $request->getAttr('caution') > 0
            && $request->getAttr('caution_reported') == 0
            && $request->getAttr('status') == \request_status::STATUS_VALID
            && ($request->getAttr('caution_ask_date') == '0000-00-00'
                || $request->getAttr('caution_ask_date') != '0000-00-00'
                && strtotime($request->getAttr('caution_ask_date') + 604800 >time()))
            && $request->getAttr('caution_ask') > 0) {
            $status = "demande de caution transmise à l'emprunteur.";
            $code = self::STATUS_CAUTION;
        }
        else if($request->getAttr('status') == \request_status::STATUS_VALID && $request->getAttr('date_to') == date('Y-m-d')) {
            $status = "échange terminé aujourd'hui";
            $code = self::STATUS_ENDED_TODAY;
        }
        else if($request->getAttr('status') == \request_status::STATUS_VALID && $request->getAttr('date_to') < date('Y-m-d')) {
            $status = "échange terminé";
            $code = self::STATUS_ENDED;
        }
        else if($request->getAttr('status') == \request_status::STATUS_VALID && $request->getAttr('date_from') == date('Y-m-d')) {
            $status = "échange aujourd'hui !";
            $code = self::STATUS_START_TODAY;
        }
        else if($request->getAttr('status') == \request_status::STATUS_VALID && $request->getAttr('date_from') < date('Y-m-d')) {
            $status = "échange en cours";
            $code = self::STATUS_IN_PROGRESS;
        }
        else if($request->getAttr('status') == \request_status::STATUS_ASK && strtotime($request->getAttr('date_from'))<time()) {
            $status = "demande périmée";
            $code = self::STATUS_OBSOLETE;
        }
//        else
//            print $requeststatus_preteur;

//        if (null === $status) {
//            $requestStatus = \request_status::getById($request->getAttr('status'));
//            if (!count($requestStatus)) {
//                return false;
//            }
//
//            return $requestStatus[0][0]->getAttr('borrower_info');
//        }

        if (!$status)
        {
            $request_status = \request_status::getById($request->getAttr('status'));
            if (count($request_status)) {
                $status = $request_status[0][0]->getAttr('name');
            }
        }

        return array(
            'text' => $status,
            'code' => $code ? : $request->getAttr('status'),
        );
    }
}