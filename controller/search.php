<?php
  $NB_ART_PAGE = 5 ;
  
  $p = @$_GET['p'];
  if($p>=1) {
      $p--;
  }
  $offset = $p*$NB_ART_PAGE;

  $p++;
  $location_coords = Site::GetCoords($s_a_loc);
  $cat = category_article::returnCategoryForSearch(@$_GET['s_a_cat']);
  $name = category_article::returnNameForSearch($s_a_name);
  $url_address = urlencode($s_a_loc) ;


  
  $number_art_search = article::GetSearchResults($cat,$name,$location_coords,'','',true);

  $max_page = ceil($number_art_search / $NB_ART_PAGE);
  $tab_art_search = article::GetSearchResults($cat,$name,$location_coords,$offset,$NB_ART_PAGE);


  include(Site::include_view('search'));
?>