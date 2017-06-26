<?php
  $result = category_article::retrieveCategory(Site::obtain_post('cat'));
  if(sizeof($result)>0)
  {
    foreach($result as $r)
    {
      $tree = $r->getTree();
      echo "<div class='returnCat'>";
      for($i=0;$i<sizeof($tree);$i++)
      {
        echo $tree[$i]->getAttr('name');
        if($i<sizeof($tree)-1)
          echo ' > ';
      }
      echo "</div>";
    }
  }
?>
