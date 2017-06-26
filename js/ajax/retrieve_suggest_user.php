<?php
  $users = user::retrieveUser(Site::obtain_post('name'));
  foreach($users as $u)
  {
    echo "<div data-id='".$u['user_id']."' class='returnSuggUser'>";
    echo $u['user_firstname'].' '.$u['user_lastname'];
    echo "</div>";
    
  }
?>