<?php
$geocoder = "https://maps.googleapis.com/maps/api/geocode/json?address=%s&sensor=false";
$localisation = urlencode($_POST['localisation']);
$query = sprintf($geocoder,$localisation);
$rd = json_decode(file_get_contents($query));
print ($rd->{'results'}[0]->{'formatted_address'});
?>
