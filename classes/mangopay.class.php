<?php

class mangopay extends root{

  //Attributs
  public $mang_id;
  public $mang_name;
  public $mang_pass;
  public $mang_legal_user;
  public $mang_wallet;
  
  public static $pref='mang_';
  
  //Fonctions
  
    
  public static function createInstance(){
      $api_mango = new MangoPay\MangoPayApi();
      $api_mango->Config->TemporaryFolder = MANGOPAYTMP;
      $api_mango->Config->ClientId = 'mutumtest';
      $api_mango->Config->ClientPassword = 'Q1xzFqpVtna4BaFpCNeCzkkF5nshmmFvSTyuoYPe5pkUjr0Dx7';
      $api_mango->Config->BaseUrl = 'https://api.sandbox.mangopay.com';
      return $api_mango;
  }
  
  public static function get_mangopay_id($id){
    return DB::SqlOne("select user_mangopay_id from user where user_id='$id'");
  }
  
  public static function get_site_infos(){
    return DB::SqlLine("select * from mangopay where mang_id='1'");
  }
  
  public static function check_card_owner($card_id,$user_id){
    $exist = false;
    $Pagination = new \MangoPay\Pagination();
    $Pagination->Page = 1;
    $Pagination->ItemsPerPage = 100;
    $cards = self::createInstance()->Users->GetCards(self::get_mangopay_id($user_id),$Pagination);
    foreach($cards as $c)
    {
      if($c->Id==$card_id)
      {
        $exist=true;
        break;
      }
    }
    return $exist;
  }
  
  public static function return_valid_card($user_id){
    $user_mangopay_id = self::get_mangopay_id($user_id);
    $Pagination = new \MangoPay\Pagination();
    $Pagination->Page = 1;
    $Pagination->ItemsPerPage = 100;
    $cards = self::createInstance()->Users->GetCards($user_mangopay_id,$Pagination);
    $list_card = array();
    
    if(sizeof($cards)>0)
    {
      foreach($cards as $c)
      {
        if($c->Active=='1' && $c->Validity=='VALID')
        array_push($list_card,array($c->Id,$c->Alias));
      }
    }
    else
      return false;
    if(sizeof($list_card)>0)
      return $list_card;
    else
      return false;
  }
  
  public static function return_valid_bank($user_id){
    $user_mangopay_id = self::get_mangopay_id($user_id);
    $Pagination = new \MangoPay\Pagination();
    $Pagination->Page = 1;
    $Pagination->ItemsPerPage = 100;
    $banks = self::createInstance()->Users->GetBankAccounts($user_mangopay_id,$Pagination);
    $list_banks = array();
    
    if(sizeof($banks)>0)
    {
      foreach($banks as $b)
      {
        array_push($list_banks,array($b->Id,$b->Details->IBAN));
      }
    }
    else
      return false;
    if(sizeof($list_banks)>0)
      return $list_banks;
    else
      return false;
  }

};

?>