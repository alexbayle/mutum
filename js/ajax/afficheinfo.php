<?php
$id=$_POST['id'];
$art=article::Get(article::getActiveArticle($id));
?>
<div id='info_obj' style='float:left;width:100%;height:220px;margin:25px;border: 1px solid; border-radius:10px;'>
<div><?=$art->getAttr('name')?></div>
<div>prix : <?=$art->getAttr('price')?></div>
<div>caution : <?=$art->getAttr('caution')?></div>
<div>durée : <?=$art->getAttr('length')?></div>
<div>date indisponibilité : <?=$art->getAttr('dates')?></div>
<div>statut : <?=$art->getAttr('state')?></div>
<div>categorie : <?=$art->getAttr('cate_id')?></div>
<div>description : <?=$art->getAttr('desc')?></div>
<div>Note : <?=$art->getAttr('notation')?></div>
<div>nombre de note : <?=$art->getAttr('nb_notation')?></div>
<div>date de création : <?=$art->getAttr('date_creation')?></div>
</div>