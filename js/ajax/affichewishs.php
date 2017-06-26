<?php

header('Content-type: application/json');

try {
    $offset = Site::obtain_post('offset') ?: 0;
    if (($addr = Site::obtain_post('myAddress'))) {
        $coords = Site::GetCoords($addr);
        if (!$coords[0] || !$coords[1]) {
            throw new Exception(sprintf("No coords found for address '%s'", $addr));
        }
        $_POST['lat'] = $coords[0];
        $_POST['lng'] = $coords[1];

    }
    $latitude = Site::obtain_post('lat');
    $longitude = Site::obtain_post('lng');
    if (!$latitude || !$longitude) {
        if (Session::myLoc()) {
            $latitude = Session::myLoc()->getAttr('latitude');
            $longitude = Session::myLoc()->getAttr('longitude');
        }
        if (!$latitude || !$longitude) {
            throw new Exception('You should provide valid geoloc coord.');
        }
    }
} catch (Exception $e) {
    die(json_encode(array('success' => false, 'message' => $e->getMessage())));
}


if (Site::obtain_post('nom')
    || Site::obtain_post('category1')
    || Site::obtain_post('myAddress')
) {
    $wishList = wishlist::getNearWishWithFilters(array(
            'offset' => $offset,
            'lat' => $latitude,
            'lng' => $longitude,
            'productName' => Site::obtain_post('nom'),
            'cat1' => Site::obtain_post('category1'),
            'cat2' => Site::obtain_post('category2'),
            'cat3' => Site::obtain_post('category3'),
            'address' => Site::obtain_post('myAddress'),
            'demandeContact' => Site::obtain_post('check_demandecontact') ? true : false,
            'demandeCible' => Site::obtain_post('check_demandecible') ? true : false,
            'demande' => Site::obtain_post('check_demande') ? true : false
        )
    );
} else {
    $wishList = wishlist::near5wish($offset, $latitude, $longitude);
}


$tab = array();
$html = '';


ob_start();
foreach ($wishList as $j => $wish) {

    $cpt = $offset + $j + 1;
    $coord = array(
        wishlist::getWishAddr($wish[0]->getAttr('id'))[0][0]->getAttr('latitude'),
        wishlist::getWishAddr($wish[0]->getAttr('id'))[0][0]->getAttr('longitude'),
        $wish[0]->post_text
    );
    array_push($tab, $coord);
    ?>
    <div class='col-md-18 listwish'>
        <form>
            <div class='col-md-4'>
                <div class='listimg'>
                    <img src='../../img/musique.png' alt=''/>
                </div>
            </div>
            <div class='col-md-9'>
                <div class='name'>
                    <?php echo $cpt ?> . <span class="product_name"><?php echo wishlist::getWishName(
                            $wish[0]->getAttr('id')
                        ); ?></span>
                </div>
                <div class="description">
                    <h3>description :</h3>
                    <p><?php echo $wish[0]->getAttr('desc'); ?></p>
                </div>
                <div class="btn_wish">
                    <input type='submit' value='Jai ça' id="btnJai_<?php echo $cpt ?>" class='btnGot' data-id="<?php echo $wish[0]->getAttr('id') ?>">
                    <input type='button' value='Je le veux aussi' id="btnIwant_<?php echo $cpt ?>" class='btnI'>
                </div>
            </div>
            <div class='col-md-4'>
                <div class="date_wish">
                    <h3>Pour le :</h3>
                    <p><?php echo $wish[0]->getAttr('date'); ?></p>
                </div>
                <div class="caution">
                    <p>caution :</p>
                </div>
                <div class="ville">
                    <p style="width: 175px;">ville : <span class="blue"><?php echo wishlist::getWishAddr($wish[0]->getAttr('id'))[0][0]->getAttr('city');?></span></p>
                </div>
            </div>
        </form>
    </div>

<?php
}
$html = ob_get_contents();
ob_end_clean();

die(JSON_encode(
    array(
        'searchPos' => array(
            'lat' => $latitude,
            'lng' => $longitude
        ),
        'pos' => $tab,
        'html' => $html
    )
));
?>