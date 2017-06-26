<?php

class address extends root{

  //Attributs
  public $addr_id;
  public $addr_address;
  public $addr_zip;
  public $addr_city;
  public $addr_latitude;
  public $addr_longitude;


  public static $pref='addr_';


  //Fonctions
  public function checkAddr($addr){
    $new_addr=Site::GetFullAddress($addr);
    $new_addr = str_replace("'","\'",$new_addr);
    $id_addr=DB::SqlOne("select addr_id from address where addr_address='".$new_addr[0]."' and addr_zip='".$new_addr[1]."' and addr_city='".$new_addr[2]."'");
    return $id_addr;
  }

  public function getAddress(){
    return $this->getAttr('address').', '.$this->getAttr('zip').' '.$this->getAttr('city');
  }

  public static function getAddressId($id){
        return DB::SqlOne("select addr_address,addr_city from address where addr_id =".$id." ");
  }

  public static function getAddressById($id){
      return DB::SqlOne("select addr_address,addr_zip,addr_city from address where addr_id =".$id." ");
  }

  public function getSmallAddress(){
    $mini_zip = substr($this->getAttr('zip'),0,2);
    if(in_array($this->getAttr('city'),array('Paris','Lyon','Marseille')))
    {
      $arr = intval(substr($this->getAttr('zip'),3,2));
      if($arr==1)
        return $this->getAttr('city')." (".$arr."er Arr)";
      else
        return $this->getAttr('city')." (".$arr."ème Arr)";
    }
    else
      return $this->getAttr('city')." (".$mini_zip.")";
  }

  public function getDistance($adrObj, $cooUse){
      // Récupération des coordonnées de l'objet
      $cooObj = Site::GetCoords($adrObj) ;

      // Paramètres pour l'API Google Maps
      $paramOrigin = $cooUse[0] . ',' . $cooUse[1] ;
      $paramDestination = $cooObj[0] . ',' . $cooObj[1] ;
      $parameters = 'origins=' . $paramOrigin . '&destinations=' . $paramDestination ;

      // Récupération des données de l'API
      // Ici, la distance est calculée pour un trajet à pieds
      $reqUrl = 'https://maps.googleapis.com/maps/api/distancematrix/json?' . $parameters . '&mode=walking' ;
      $rs = json_decode(file_get_contents($reqUrl)) ;
      @$dist = $rs->{'rows'}[0]->{'elements'}[0]->{'distance'}->{'value'} ;

      if (@$dist < 1000) {
          return @$dist . ' m' ;
      } else {
          return round(@$dist/1000,1) . ' km' ;
      }
  }

    public function initWithString($address)
    {
        $gmapInfo = Site::GetInfoByAddress($address);
        if ('OK' !== $gmapInfo->status) {
            throw new \Exception(sprintf("Unable to geoloc '%s'", $address));
        }

        $this->addr_address = array();
        foreach ($gmapInfo->results[0]->address_components as $component) {
            foreach ($component->types as $type) {
                switch ($type) {
                    case 'street_number':
                        $this->addr_address[0] = $component->long_name;
                        break;
                    case 'route':
                        $this->addr_address[1] = $component->long_name;
                       break;
                    case 'locality':
                        $this->addr_city = $component->long_name;
                        break;
                    case 'postal_code':
                        $this->addr_zip = $component->short_name;
                        break;
                    case 'political':
                        break;
                    case 'administrative_area_level_2':
                        if (!$this->addr_zip) {
                            $this->addr_zip = $component->short_name;
                        }
                        break;
                    case preg_match("/^administrative_area_level_[.*]/", $type):
                        break;
                    default:
                        throw new \Exception(sprintf("You should implement '%s'", $type));
                }
            }
        }

        $this->addr_address = implode(' ', $this->addr_address);
        $this->addr_latitude = $gmapInfo->results[0]->geometry->location->lat;
        $this->addr_longitude = $gmapInfo->results[0]->geometry->location->lng;
    }


}
