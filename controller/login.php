<?php
  if(Session::Online())
  {
    Site::message_info('vous ne pouvez pas accéder à cette page en étant connecté, vous l\'êtes déjà.','WARNING');
    Site::redirect(WEBDIR);
    exit();
  }
  else
  {
    include(Site::include_view('login'));
  }
?>