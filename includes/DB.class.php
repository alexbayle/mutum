<?php
 
class DB
{
  private $PDOInstance = null;
  private static $instance = null;
 
  private function __construct()
  {
    $this->PDOInstance = new PDO('mysql:host='.DB_HOST.';dbname='.DB_BASE, DB_USER, DB_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')); 
  }

  public static function getInstance()
  {  
    if(is_null(self::$instance))
    {
      self::$instance = new DB();
    }
    return self::$instance;
  }
  
  function getPDO(){
    return $this->PDOInstance;
  }
  
    //retourne directement les enregistrements de la requête sous la forme d'un tableau asociatif
    public static function SqlToArray($requete)
    {
        $pdo = self::getInstance()->getPDO();
        $tab = array();
        $result = $pdo->query($requete);
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $tab[] = str_replace("&quot;", "", $row);
        }
        $result->closeCursor();

        return $tab;
    }
  
  public static function SqlToObj($tab_name_obj,$requete){
    $pdo = self::getInstance()->getPDO();
    $result = $pdo->query($requete);
    $ret_tab = array();
		while( $row = $result->fetch(PDO::FETCH_ASSOC) )
    {
      $tab_obj = array();
      foreach($tab_name_obj as $name_obj)
      {
        $obj = new $name_obj;
        $obj->Create($row);
        array_push($tab_obj,$obj);
      }
      array_push($ret_tab,$tab_obj);
		}
    $result->closeCursor();
    return $ret_tab;
  }
  
  public static function SqlOne($requete){
    $pdo = self::getInstance()->getPDO();
    $result = $pdo->query($requete);
    $row = $result->fetch(PDO::FETCH_NUM);
    return $row[0];
	}
  
  public static function SqlLine($requete){
    $pdo = self::getInstance()->getPDO();
    $result = $pdo->query($requete);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    return $row;
	}
  
  public static function SqlExec($req){
    self::getInstance()->getPDO()->exec($req);
  }

	public static function ProtectData($data){
		//$pdo = self::getInstance()->getPDO();
		//return $pdo->real_escape_string(strip_tags($data));
    return $data;
	}
  
  public static function LastId(){
    $pdo = self::getInstance()->getPDO();
    return $pdo->lastInsertId();
  }
}

/*

DELIMITER $$
CREATE FUNCTION levenshtein( s1 VARCHAR(255), s2 VARCHAR(255) )
RETURNS INT
DETERMINISTIC
BEGIN
DECLARE s1_len, s2_len, i, j, c, c_temp, cost INT;
DECLARE s1_char CHAR;
-- max strlen=255
DECLARE cv0, cv1 VARBINARY(256);
SET s1_len = CHAR_LENGTH(s1), s2_len = CHAR_LENGTH(s2), cv1 = 0x00, j = 1, i = 1, c = 0;
IF s1 = s2 THEN
RETURN 0;
ELSEIF s1_len = 0 THEN
RETURN s2_len;
ELSEIF s2_len = 0 THEN
RETURN s1_len;
ELSE
WHILE j <= s2_len DO
SET cv1 = CONCAT(cv1, UNHEX(HEX(j))), j = j + 1;
END WHILE;
WHILE i <= s1_len DO
SET s1_char = SUBSTRING(s1, i, 1), c = i, cv0 = UNHEX(HEX(i)), j = 1;
WHILE j <= s2_len DO
SET c = c + 1;
IF s1_char = SUBSTRING(s2, j, 1) THEN
SET cost = 0; ELSE SET cost = 1;
END IF;
SET c_temp = CONV(HEX(SUBSTRING(cv1, j, 1)), 16, 10) + cost;
IF c > c_temp THEN SET c = c_temp; END IF;
SET c_temp = CONV(HEX(SUBSTRING(cv1, j+1, 1)), 16, 10) + 1;
IF c > c_temp THEN
SET c = c_temp;
END IF;
SET cv0 = CONCAT(cv0, UNHEX(HEX(c))), j = j + 1;
END WHILE;
SET cv1 = cv0, i = i + 1;
END WHILE;
END IF;
RETURN c;
END$$
DELIMITER ;

*/