<?php

if (Session::online()) {
    // récupération des informations de l'utilisateur afin de les afficher dans la vue
    $user = Session::Me();
    if ($user->GetAttr('active') != "1") {
        $error[] = "vous devez d'abord activer votre e-mail";
        // renvoyer vers mail d'activation
    }

    if (isset($_GET['search_product'])) {
        $search_product = $_GET['search_product'];
        $results = product::searchProduct($_GET['search_product']);
    } else {
        $search_product = '';
        $results = array();
    }

    // pagination
    $NB_ART_PAGE = 5;
    $p = @$_GET['p'];

    if ($p >= 1) {
        $p--;
    }
    $offset = $p * $NB_ART_PAGE;
    $p++;
    // fin pagination

    $btn_edit = Site::obtain_post('btn_edit');
    $btnconfirm = Site::obtain_post('btnconfirm');
    $btncancel = Site::obtain_post('btncancel');
    $article_id = Site::obtain_post('article_id');

    $cat = category_article::returnCategoryForSearch($s_a_cat);
    $name = category_article::returnNameForSearch($s_a_name);
    $location_coords = Site::GetCoords($s_a_loc);
    $myId = Session::Me()->getAttr('id');

    // Requêtes + Menu
    $tab_art_search = article::GetUsersArticleResults($cat, $name, $location_coords, $offset, $NB_ART_PAGE, $myId, 0);
    $tab_art_unavailable = article::GetUsersArticleResults(
        $cat,
        $name,
        $location_coords,
        $offset,
        $NB_ART_PAGE,
        $myId,
        1
    );
    $number_art_unavailable = sizeof($tab_art_unavailable);


    $tab_art_available = article::GetUsersArticleResults(
        $cat,
        $name,
        $location_coords,
        $offset,
        $NB_ART_PAGE,
        $myId,
        2
    );
    $number_art_available = sizeof($tab_art_available);


    // Pagination
    $number_art_search = product::getNumberProducts(Session::Me()->getAttr('id'));

    $url_address = urlencode($s_a_loc);


    if ($btn_edit != '') {
        $activeArticle = article::getCurrentArticle($article_id);
        include(Site::include_view('edit'));
    } else {
        if ($btnconfirm != '') {
            //recup donnée post

            $name = Site::obtain_post('art_name');
            $catId = (\Site::obtain_post('art_cat_id3')) ?:
                (\Site::obtain_post('art_cat_id2')) ?:
                    (\Site::obtain_post('art_cat_id1'));

            $duree = Site::obtain_post('art_length');
            $prix = Site::obtain_post('art_price');
            $full_address = Site::obtain_post('full_address_1');

            if (\Site::obtain_post('image_1') || \Site::obtain_post('image_2') || \Site::obtain_post('image_3')) {
                $pictures = array(
                    \Site::obtain_post('image_1'),
                    \Site::obtain_post('image_2'),
                    \Site::obtain_post('image_3'),
                );
            }

            $state = Site::obtain_post('arti_state');
            $desc = Site::obtain_post('art_desc');

            $dates = \Site::obtain_post('art_dates');
            $dates = explode(', ', $dates);
            $arti_dates = json_encode($dates);

            $caution = Site::obtain_post('art_caution');

            $error = array();
            if ($name == "" || strlen($name) < 2) {
                $error = "veuillez remplir le nom de l'objet";
            }
            if ($prix == "") {
                $error = "veuillez saisir le prix de l'objet";
            }
            $coords = Site::GetCoords($full_address);
            if ($coords[0] == 0 && $coords[1] == 0) {
                $error[] = "localisation introuvable, veuillez la modifier.";
            }
            if ($full_address == "") {
                $error[] = "veuillez remplir votre adresse";
            }
            if ($desc == "") {
                $error = "veuillez remplir la description de l'objet";
            }

            if (sizeof($error) > 0) {
                Site::message_info($error, 'ERROR');
                include(Site::include_view('edit'));
            } else {
                $article = DB::SqlToObj(
                    array('article', 'product'),
                    "
                        SELECT *
                        FROM article a
                        LEFT JOIN product p ON p.prod_id=a.arti_prod_id
                        WHERE arti_prod_id = '" . \Site::obtain_post('arti_prod_id') . "'"
                );
                if (!count($article)) {
                    throw new \Exception(sprintf("no product for id: '%s'", Site::obtain_post('arti_prod_id')));
                }
                $article = $article[0][0];
                $article->prod_name = \Site::obtain_post('art_name');
                $article->prod_desc = addslashes(\Site::obtain_post('art_desc'));

                $article->arti_pictures = json_encode($pictures);
                $catId = (\Site::obtain_post('art_cat_id3')) ?:
                    (\Site::obtain_post('art_cat_id2')) ?:
                        (\Site::obtain_post('art_cat_id1'));
                $article->arti_cat = $catId;
                $article->art_desc = \Site::obtain_post('art_desc');
                $article->arti_price = \Site::obtain_post('art_price');
                $article->arti_length = \Site::obtain_post('arti_length');
                $article->arti_caution = \Site::obtain_post('art_caution');
                $article->art_address = \Site::obtain_post('full_address_1');
                $article->arti_state = \Site::obtain_post('arti_state');

                $dates = \Site::obtain_post('art_dates');
                $dates = explode(', ', $dates);
                $article->arti_dates = json_encode($dates);


                $address = new address;
                $addressId = $address->checkAddr(Site::obtain_post('full_address_1'));
                if (!$addressId) {
                    $address->initWithString(Site::obtain_post('full_address_1'));
                    $addressId = $address->Insert();
                    $locatedProduct = new located_product;
                    $locatedProduct->locp_addr_id = $addressId;
                    $locatedProduct->locp_prod_id = $article->arti_prod_id;
                    $locatedProduct->Insert();
                }
//var_dump($article); die;
                $article->Update();


            }
        }
        include(Site::include_view('items'));

    }
} else {
    Site::message_info('cette page requiert la connexion à un compte', 'ERROR');
    Site::setNextUrl();
    Site::redirect(WEBDIR . 'login');
    exit();
}


?>