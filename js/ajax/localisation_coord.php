<?php
  $geocoder = "https://maps.googleapis.com/maps/api/geocode/json?address=%s&sensor=false";
  $localisation = urlencode($_POST['localisation']);
  $query = sprintf($geocoder,$localisation);
  $rd = json_decode(file_get_contents($query));
  @$coord = $rd->{'results'}[0]->{'geometry'}->{'location'};
  @$user_latitude = $coord->{'lat'};
  @$user_longitude = $coord->{'lng'};
  print $user_latitude.",".$user_longitude;
?>