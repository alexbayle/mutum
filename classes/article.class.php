<?php
class article extends product {
	
	// Attributs
	public $arti_prod_id;
    public $arti_cat;
    public $arti_state;
    public $arti_price;
	public $arti_length;
	public $arti_caution;
	public $arti_dates;
	public $arti_pictures;
    public $arti_dispo;

	public static $pref = 'arti_';
	
	// Fonctions
	public static function getActiveArticle($id) {
		return DB::SqlLine ( "SELECT * FROM article A, product P, user U, address, located_product L
        Where U.user_id = P.prod_user_id
        AND P.prod_id = L.locp_prod_id
        AND L.locp_addr_id = addr_id
        AND arti_prod_id = ".$id."
        And prod_id = ".$id." AND prod_deleted <> 1" );
	}

    public static function getCurrentArticle($id)
    {
        return DB::SqlToObj(array('product','article','user','address','category_article','article_state'),"
        SELECT *
        FROM product, article, user, address, located_product L,category_article,article_state
        WHERE product.prod_id = article.arti_prod_id
        AND user.user_id = product.prod_user_id
        AND product.prod_id = L.locp_prod_id
        AND L.locp_addr_id = address.addr_id
        AND article.arti_cat = category_article.cata_id
        AND arti_state = arts_id
        AND prod_id = '".$id."'");
    }

    public static function getGallery()
    {
        $article = DB::SqlToObj(array('product','article'),"SELECT * FROM product,article WHERE prod_id = arti_prod_id AND arti_pictures != '[]' ORDER BY RAND() LIMIT 19 ");
        return $article;
    }

	public function getCatName() {
		return DB::SqlOne ( "select cata_name from category_article where cata_id='" . $this->getAttr ( 'cat' ) . "'" );
	}
	public function getAddress() {
		return DB::SqlToArray ( "select * from address, located_product where locp_prod_id='" . $this->getAttr ( 'id' ) . "' and locp_addr_id=addr_id" );
	}
	public static function getNoteMoy($id) {
		$art = article::Get ( article::getActiveArticle ( $id ) );
		
		$i = 0;
		$sum = 0;
		$notMoy = 0;
		
		foreach ( $art->getNotation () as $notation ) {
			$sum += $notation [0]->getAttr ( 'note' );
			$i ++;
		}
		
		if ($i !== 0) {
			$notMoy = round ( $sum / $i, 2 );
		}
		
		$empty = "<img alt='empty star' class='star' src='".WEBDIR."img/empty_star.png'>";
		$half = "<img alt='half star' class='star' src='".WEBDIR."img/half_star.png'>";
		$full = "<img alt='star' class='star' src='".WEBDIR."img/star.png'>";
		
		if ($notMoy < 0.25) {
			$notStars = $empty . $empty . $empty . $empty . $empty;
		} else if ($notMoy < 0.75) {
			$notStars = $half . $empty . $empty . $empty . $empty;
		} else if ($notMoy < 1.25) {
			$notStars = $full . $empty . $empty . $empty . $empty;
		} else if ($notMoy < 1.75) {
			$notStars = $full . $half . $empty . $empty . $empty;
		} else if ($notMoy < 2.25) {
			$notStars = $full . $full . $empty . $empty . $empty;
		} else if ($notMoy < 2.75) {
			$notStars = $full . $full . $half . $empty . $empty;
		} else if ($notMoy < 3.25) {
			$notStars = $full . $full . $full . $empty . $empty;
		} else if ($notMoy < 3.75) {
			$notStars = $full . $full . $full . $half . $empty;
		} else if ($notMoy < 4.25) {
			$notStars = $full . $full . $full . $full . $empty;
		} else if ($notMoy < 4.75) {
			$notStars = $full . $full . $full . $full . $half;
		} else {
			$notStars = $full . $full . $full . $full . $full;
		}
		
		return ($notStars);
	}
	public static function getArticleSearch() {
		if (@$_GET ['a_s'] != '') {
			$_SESSION ['s_a_loc'] = @$_GET ['s_a_loc'];
			$_SESSION ['s_a_cat'] = @$_GET ['s_a_cat'];
			$_SESSION ['s_a_name'] = @$_GET ['s_a_name'];
		}
		if (Session::Online ()) {
			if (@$_SESSION ['s_a_loc'] == '') {
				$_SESSION ['s_a_loc'] = Session::Myloc ()->getAddress ();
				// Site::redirect(WEBDIR.'search?s_a_cat='.$_SESSION['s_a_cat'].'&s_a_name='.$_SESSION['s_a_name'].'&s_a_loc='.$_SESSION['s_a_loc'].'&k='.time());
			}
		}
		
		return array (
				@$_SESSION ['s_a_cat'],
				@$_SESSION ['s_a_name'],
				@$_SESSION ['s_a_loc'] 
		);
	}
	public function GetSearchResults($sql_cat, $liste_name, $loc, $offset, $nb, $count = false) {
		// Simplification des coordonnées de localisation
		$lat = $loc [0];
		$lon = $loc [1];
		
		if ($count) {
			$sql = "SELECT count(*) FROM ";
		} else {
			$sql = "SELECT * FROM ";
		}
		
		// Base de la requête de recherche, sélection des tables et des dépendances entre tables
		$sql .= "product p
		LEFT JOIN share_community sc ON sc.shac_prod_id=p.prod_id
		LEFT JOIN article a ON a.arti_prod_id=p.prod_id
		LEFT JOIN user u ON u.user_id=p.prod_user_id
		LEFT JOIN article_state arts ON arts.arts_id=a.arti_state
		LEFT JOIN category_article ca ON ca.cata_id=a.arti_cat
		LEFT JOIN located_product lp ON lp.locp_prod_id=p.prod_id
		LEFT JOIN address addr ON addr.addr_id=lp.locp_addr_id";

        $sql .= $liste_name ? " WHERE $liste_name" : "";
		$sql .= $liste_name && $sql_cat ? " AND" : "";
		$sql .= !$liste_name && $sql_cat ? " WHERE" : "";
		$sql .= $sql_cat ? " cata_id = $sql_cat" : "";
//		 sc.shac_comm_id IN (" . implode(',', Session::Me()->getMyCommunityIds()). ")";


//var_dump($sql); die;

//		"where p.prod_id=arti_prod_id
//		and shac_comm_id IN (" . implode(',', \Session::Me()->getMyCommunityIds()). ")
//		and arti_cat=cata_id
//		and prod_id=locp_prod_id and locp_addr_id=addr_id and prod_user_id=user_id
//    and arti_state=arts_id " . (($lat != 0) || ($lon != 0) ? "
//    and addr_id=(SELECT addr_id FROM address,located_product
//    WHERE locp_addr_id=addr_id and locp_prod_id=prod_id
//    ORDER BY acos(sin(radians(addr_latitude))*sin(radians($lat))+cos(radians(addr_latitude))*cos(radians($lat))*cos(radians(addr_longitude)-radians($lon))
//    ) ASC LIMIT 1)" : "and addr_id=(SELECT addr_id from address LIMIT 1)") . 		// Ne considérer que l'adresse la plus proche
//
//		($liste_name != '' ? "and $liste_name" : "") . 		// Gestion des noms des produits
//		($sql_cat != '' ? "and arti_cat in (" . $sql_cat . ") " : "") . 		// Gestion des catégories
//		" ";


		if (($lat) || ($lon)) {
			// Ordonner par le plus près
			$sql .= " order by acos(sin(radians(addr_latitude))*sin(radians($lat))" . "+cos(radians(addr_latitude))*cos(radians($lat))" . "*cos(radians(addr_longitude)-radians($lon)))";
		} else {
			$sql .= " order by prod_name";
		}

//        echo $sql; die;
		if ($count) {
			return DB::SqlOne ( $sql );
		} else {
			$sql .= " LIMIT $nb OFFSET $offset";
			return DB::SqlToObj ( array (
					'article',
					'user',
					'article_state',
					'category_article',
					'address',
					'located_product' 
			), $sql );
		}
	}
	
	public function GetUsersArticleResults($sql_cat, $liste_name, $loc, $offset, $nb, $userID, $currentUsersArticle, $count = false) {
		// Simplification des coordonnées de localisation
		
		if ($count) {
			$sql = "SELECT count(*) FROM ";
		} else {
			$sql = "SELECT * FROM ";
		}
	
		
		//for getting the product and articles related to the current user
		if($currentUsersArticle == 0)//for all articles
		{
			$sql .= "product,article
						where prod_user_id = " . $userID . 
						" and arti_prod_id = prod_id";
			
		}
		else
		{
			if($currentUsersArticle == 1)//for lent articles
			{
				$sql .= "product,article
						where prod_user_id = " . $userID .
							" and arti_prod_id = prod_id
							and arti_dispo = 0";
				
			}
			else 
			{
				if($currentUsersArticle == 2)//for dispo articles
				{
					$sql .= "product,article
						where prod_user_id = " . $userID .
							" and arti_prod_id = prod_id
								and arti_dispo = 1";
					
				}
			}
		}
		//echo "<pre>"; var_dump($sql); die;
		if ($count) {
			return DB::SqlOne ( $sql );
		} else {
			$sql .= " LIMIT $nb OFFSET $offset";
			return DB::SqlToObj ( array (
					'product',
					'article'
			), $sql );
		}
	}
	
	public function getMutumByDay() {
		$mutumByDay = ceil ( Site::getpts ( $this->getAttr ( 'price' ) ) / $this->getAttr ( 'length' ) );
		return $mutumByDay;
	}
	function get_first_picture() {
//		$temp = explode ( ',', $this->getAttr ( 'pictures' ) );
//		return $temp [0];

        $pictures = json_decode($this->getAttr('pictures'));
        if (count($pictures)) {
            return array_shift($pictures);
        }
        else{
            return $pictures;
        }
	}

    function get_picture($offset = 0) {

        $pictures = json_decode($this->getAttr('pictures'));
        if (!is_array($pictures)) {
            return false;
        }

        if (!array_key_exists($offset, $pictures)) {
            return false;
        }

        return $pictures[$offset];
    }

	function dirof() {
        $dir = '';
//		$dir = 100 * floor ( $this->getAttr ( 'id' ) / 100 );
		@mkdir ( "img/art/$dir" );
		@chmod ( "img/art/$dir", 0770 );
		return "img/art/$dir";
	}
	function print_picture($size = 160, $class = "", $id = "", $offset = 0) {
		// Progression: afficher l'image de la catégorie correspondante
		$src_path = "img/cat/missing.png";


        $picture = $this->get_picture($offset);
        if ($picture != "" /*&& (file_exists($this->dirof() . "/" . $picture))*/) {
            $src_path = $this->dirof() . "/" . $picture;
        }


		if (!preg_match("#\%#", $size))
		{
			$size =  $size.'px';
		}

		
		return "<img src='" . WEBDIR . "$src_path'" . ($id != "" ? " id='$id'" : "") .
										($size != "" ? " style='height:" . $size . ";width:" . $size .
											"; '"
												: " style='width:100%; border-bottom-left-radius: 10px;border-top-right-radius: 20px;border-top-left-radius: 20px;'")
										. ($class != "" ? " class='$class'" : "") . ">";
	}

	public function getValue($field) {
		if (isset ( $this->$field )) {
			return $this->$field;
		}
		
		return false;
	}

    public function isValid()
    {
        $class = new \ReflectionClass ($this);
        $properties = $class->getProperties();

        $optionalFields = array(
            'arti_caution',
            'arti_prod_id',
            'arti_pictures',
            'pref',
            'prod_id',
            'prod_user_id',
            'prod_nb_notation',
            'prod_date_creation',
            'prod_deleted',
            'prod_limitation',
            'prod_win',
            'prod_notation'
        );

        $errors = array();
        foreach ($properties as $property) {
            if (in_array($property->getName(), $optionalFields)) {
                continue;
            }
            if (!$this->getValue($property->getName())) {
                $errors [$property->getName()] = sprintf("'%s' shouldn't be null.", $property->getName());
            }
        }

        if ($errors) {
          Site::message_info($errors,'ERROR');
            return false;
        }

        return true;
    }

    public function save()
    {
        $this->arti_pictures = json_encode($this->arti_pictures);
//        $dates = explode(', ', $this->arti_dates);
        if (false === strpos($this->arti_dates, '[')) {
            $this->arti_dates = json_encode($this->arti_dates);
        }
        try {
            $address = new address;
            $addressId = $address->checkAddr($this->art_address);
            if ($addressId) {

            } else {
                $address->initWithString($this->art_address);
                $addressId = $address->Insert();
            }
            $this->arti_prod_id = $this->Insert();

            $locatedProduct = new located_product;
            $locatedProduct->locp_addr_id = $addressId;
            $locatedProduct->locp_prod_id = $this->arti_prod_id;
            $locatedProduct->Insert();
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            throw $e;
        }
    }

    public static function getLesPlusEmpruntés(){
        return DB::SqlToObj(array('request','product','article'),"SELECT * ,count('requ_id') as nb
FROM `request`,`product`,`article`
WHERE requ_prod_id = prod_id
AND prod_id = arti_prod_id
GROUP BY requ_prod_id
ORDER BY nb DESC
");
    }

    public static function getLesMieuxNotés(){
        return DB::SqlToObj(array('product','article'),"select * from product,article where prod_id = arti_prod_id and prod_notation BETWEEN 4 and 5 ");
    }

    public static function getMesObjets(){
        return DB::SqlToObj(array('product','article'),"select *
from product,article
where prod_id = arti_prod_id
and prod_user_id = '".Session::Me()->getAttr('id')."'
");
    }
}