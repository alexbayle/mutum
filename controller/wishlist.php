<?php
if (!Session::Online()) {
    Site::redirect(WEBDIR);
}




@$addr = Site::obtain_post("myAddress");
$newWish = Site::obtain_post("newWish");
$btnNewAddr = Site::obtain_post("btnsearchAsk");
$btnGot = Site::obtain_post("btnGot");
$btnIwant = Site::obtain_post("btnIwant");
$error = array();
if ($addr == "") {
    @$latitude = Session::Myloc()->getAttr('latitude');
    @$longitude = Session::Myloc()->getAttr('longitude');

} else {
    if ($btnNewAddr != "") {
        @$latitude = Site::GetCoords($addr)[0];
        @$longitude = Site::GetCoords($addr)[1];
    }
}
//include(Site::include_view('mesdemandes'));

if ($newWish != "") {
    $name = Site::obtain_post("nom");
    $addr = Site::obtain_post("adresse");
    $date = Site::obtain_post("wish_date");
    $cat1 = Site::obtain_post("cat1");
    $cat2 = Site::obtain_post("cat2");
    $cat3 = Site::obtain_post("cat3");
    if ($cat3) {
        $cat_id = $cat3;
    } elseif ($cat2) {
        $cat_id = $cat2;
    } elseif ($cat1) {
        $cat_id = $cat1;
    }

    if ($name == '' || Site::check_words($name) == 'false') {
        $error[] = "votre mot n'est pas conforme";
    }

    if ($addr == "") {
        $error[] = "veuillez saisir une adresse";
    }

    if ($date == "") {
        $error[] = "veuillez choisir une date";
    }

    if ($cat1 == "") {
        $error[] = "veuillez sélectionner une catégorie";
    }

    $coords = Site::GetCoords($addr);
    if ($coords[0] == 0 && $coords[1] == 0) {
        $error[] = "localisation introuvable, veuillez la changer.";
    }


    if (sizeof($error) > 0) {
        Site::message_info($error, 'ERROR');
    } else {
        $new_wish = new wishlist();
        $new_addr = new address();
        $new_vira = new virtual_article();
        $new_wish->setAttr('user_id', Session::Me()->getAttr('id'));
        $new_wish->setAttr('text', sprintf("recherche %s pour le %s", $name, $date));
        $new_wish->setAttr('cat', 1);
        $new_wish->setAttr('desc', Site::obtain_post('desc'));
        $new_wish->setAttr('date_creation', Site::now());
        $new_wish->setAttr('deleted', 0);
        if (address::checkAddr($addr) == "") {
            @$coords = Site::GetCoords($addr);
            $geoloc = Site::GetFullAddress($addr);
            @$new_addr->setAttr('address', $geoloc[0]);
            @$new_addr->setAttr('zip', $geoloc[1]);
            @$new_addr->setAttr('city', $geoloc[2]);
            @$new_addr->setAttr('latitude', $coords[0]);
            @$new_addr->setAttr('longitude', $coords[1]);

            $insertAddrId = $new_addr->Insert();
            $new_wish->setAttr('address', $insertAddrId);
        } else {
            $new_wish->setAttr('address', address::checkAddr($addr));
        }
        $new_vira->setAttr('name', $name);
        $new_vira->setAttr('cat', $cat_id);
        $insertVirpId = $new_vira->Insert();


        $limitation = new limitation();
        $limitationId = $limitation->Insert();
        $new_wish->setAttr('prod_user_id', Session::Me()->getAttr('id'));
        $new_wish->setAttr('prod_limitation', $limitationId);
        $new_wish->setAttr('prod_text', sprintf("recherche %s pour le %s", $name, $date));
        $new_wish->setAttr('prod_cat', 1);
        $new_wish->setAttr('prod_date_creation', date('Y-m-d H:i:s'));
        $new_wish->setAttr('prod_deleted', false);
        $new_wish->setAttr('virp_id', $insertVirpId);
        $new_wish->setAttr('date', $date);
        $new_wish->Insert();
    }

}

$catList = category_article::getMainList();
array_unshift($catList, array('cata_id' => null, 'cata_name' => 'catégories'));
if ($btnGot != "") {
    include_view('new');
}

include(Site::include_view('wishlist'));

?>