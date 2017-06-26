<div>
<h1>
<?=$art->getAttr('name')?>
</h1>
<?=@article::getNoteMoy($art->getAttr('id'))?>/5
</div>
<div  style='position:relative'>
<div class='caroussel' style='float:left;width:200px;height:200px;border: 1px solid; border-radius:10px;'>
<?=$art->get_first_picture()?>
</div>
<div class='owner' style='float:left;width:200px;height:200px;border: 1px solid; border-radius:10px;'>
<div  style='width:140px;'><?=$owner->print_user()?></div>
<div>
<?=$owner->printName()?>
<?=$owner->printNote()?>
</div>

</div>
<div class='obj' style='float:left;width:600px;height:200px;border: 1px solid; border-radius:10px'>
<?$art->getAttr('date_creation')?>&nbsp <br/>
categorie :<?=$art->getCatName()?>&nbsp <br/>
prix : <?=$art->getMutumByDay()?>mutum/jour&nbsp <br/>
caution : <?=$art->getAttr('caution')?>&nbsp <br/>
decription : <?=$art->getAttr('desc')?>&nbsp <br/>
<?=$art->getAttr('dates')?>&nbsp
<?=$art->getAttr('dates')?>
<?if ($btnCase==1){?>
<a href='../new/<?=$module?>'><input type='submit' name='btnEddit' value='éditer'></a>
<?}else if (request::isAvailable($art->getAttr('id'))){?>
<a href='../view/<?=$module?>'><input type='button' name='btnEmprunt' value='Emprunter'></a>
<?}?>
<input type='submit' name='btnSignal' value='Signaler'>
</div>
</div>
<div align='center' class='comm'>
Commentaires :
<br/>
<?php
foreach ($art->getNotation() as $note){
?>
<div align='center' style='width:800px;height:200px;margin:5px;border: 1px solid; border-radius:10px; padding: 35px'>
<?=$note[0]->getAttr('message')?>
<br/>
from :<?=user::getUser($note[0]->getAttr('user_id'))[0][0]->getAttr('firstname')?>
<br/>
le :<?=$note[0]->getAttr('date_creation')?>
</div>


<?}?>
</div>
</div>

