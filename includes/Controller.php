<?php
if(!empty($_GET['page']) && is_file('controller/'.$_GET['page'].'.php'))
	include 'controller/'.$_GET['page'].'.php';
elseif(empty($_GET['page']))
  include 'controller/accueil.php';
else
	include(Site::include_global('404'));
?>