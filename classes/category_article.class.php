<?php

class category_article extends root{

  //Attributs
  public $cata_id;
  public $cata_parent_id;
  public $cata_name;
  public $cata_desc;
  public $cata_order;
  public $cata_pictogramme;
  public $cata_length;

  public static $pref='cata_';



  //Fonctions

  static function returnNameForSearch($name){
    $tab_name = Site::multiexplode(array(' ',',',"'",'"','-','_','(',')','=','+'),$name);
    $liste_name = '';
    $nb_mot_pass=0;
    for($i=0;$i<sizeof($tab_name);$i++)
    {
      if(!in_array($tab_name[$i],array('à','et','ou','où','a','un','une','de','la','le','mais','donc','or','ni','car')))
      {
        if($nb_mot_pass>0)
          $liste_name.='and ';
        $liste_name .= "prod_name like '%".$tab_name[$i]."%' ";
        $nb_mot_pass++;
      }
    }
    return $liste_name;
  }

  static function retrieveCategory($cat){
    //On coupe le champs récupéré en tableau de catégorie
    $tab_cat = explode(' < ',$cat);

    //On vérifie si on a déjà une arborescence ou juste un mot
    if(sizeof($cat)==1)
    {
      //On a juste un mot, on va alors le rechercher dans la table Catégorie
      $result = self::Get_Tab(DB::SqlToArray("SELECT * FROM category_article WHERE cata_name='$cat'"));

      //On vérifie si on a trouvé un résultat.
      if(sizeof($result)==0)
      {
        //On a pas trouvé de résultats, on fait une recherche approximative
        $max = Site::getLevenshteinCoeff($cat);
        $autocomp = '';
        if(strlen($cat)>=3)
        {
          $autocomp = "or cata_name LIKE '".$cat."%'";
        }
        $result = self::Get_Tab(DB::SqlToArray("SELECT * FROM category_article WHERE (levenshtein(cata_name,'$cat')=(SELECT min(levenshtein(cata_name,'$cat')) FROM category_article) and levenshtein(cata_name,'$cat')<'$max') ".$autocomp));
        if($result=='')
        {
          //On a rien trouvé, on retourne false.
          return false;
        }
      }

      //Ce code s'exécute si on a des résultats
      return $result;
    }
    else
    {
      return array();
    }
  }

  static function returnCategoryForSearch($cat){
    if($cat == '')
    {
      return '';
    }
    else
    {
      $tab_cat = explode(' > ',$cat);
     //var_dump($tab_cat);
      $init = true;
      foreach($tab_cat as $t)
      {
        if($init)
        {
          $parent_obj = category_article::retrieveCategory($t);
          //var_dump($parent_obj);
          if(sizeof($parent_obj)==0)
          {
            Site::message_info("La catégorie entrée n'a pas été reconnue et a donc été ignorée.","WARNING");
            return '';
          }
          else if(sizeof($parent_obj)==1)
          {
            $sql_cat = $parent_obj[0]->getAttr('id');
          }
          else
          {
            $sql_cat = '';
            foreach($parent_obj as $p)
            {
              $sql_cat.=$p->getAttr('id').',';
            }
            return substr($sql_cat,0,strlen($sql_cat)-1);
          }
          $init=false;
        }
        else
        {
          $current_obj = category_article::retrieveCategory($t);
          if(sizeof($current_obj)==0)
          {
            Site::message_info("La catégorie entrée n'a pas été reconnue et a donc été ignorée.","WARNING");
            return '';
          }
          else if(sizeof($current_obj)==1)
          {
            $parent_obj = $current_obj;
            $sql_cat = $parent_obj[0]->getAttr('id');
          }
          else
          {
            foreach($current_obj as $obj)
            {
              if($obj->getAttr('parent_id')==$parent_obj[0]->getAttr('id'))
              {
                $parent_obj = $obj;
                return $parent_obj->getAttr('id');

              }
            }
          }
        }
      }
      return $sql_cat;
    }
  }

    public static function getById($id) {
        return DB::SqlToObj(array('category_article'), sprintf("SELECT * FROM category_article WHERE cata_id='%s'", $id));
    }

    function getTrueParent()
    {
        return self::Get(
            DB::SqlLine(sprintf("SELECT * FROM category_article WHERE cata_id='%s'", $this->getAttr('parent_id')))
        );
    }

    public static function getMainList($order = 'ASC')
    {
        return DB::SqlToArray(
            "SELECT * FROM category_article WHERE cata_parent_id IS NULL ORDER BY cata_order {$order};"
        );
    }

    function getTree()
    {

        if ($this->getAttr('parent_id') == null) {
            return array($this);
        } else {
            $parent = $this->getTrueParent();
            $tree = $parent->getTree();
        }
        array_push($tree, $this);

        return $tree;
    }

    function getChilds()
    {
        return self::Get_Tab(
            DB::SqlToArray(sprintf("select * from category_article where cata_parent_id='%s'", $this->getAttr('parent_id')))
        );
    }

    public function getChildren()
    {
        return self::Get_Tab(
            DB::SqlToArray(sprintf("select * from category_article where cata_parent_id='%s'", $this->getAttr('id')))
        );
    }

    public static function getCountByUser($userId)
    {
        return DB::SqlToArray(
            "SELECT cata_id, cata_name, count(*) as count
        FROM category_article ca
        LEFT JOIN article a ON ca.cata_id=a.arti_cat
        LEFT JOIN move m ON  m.move_article_id=a.arti_prod_id
        WHERE m.move_user_id={$userId}
        GROUP BY ca.cata_id
        ");
    }

    public static function getNameParent($parent_id){
        return DB::SqlOne("SELECT cata_name FROM category_article where cata_id = '".$parent_id."' ");
    }

    public static function getChidlren($id)
    {
        return DB::SqlToArray(
            "SELECT * FROM category_article WHERE cata_parent_id=$id;"
        );
    }
}