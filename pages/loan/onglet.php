<ul>
    <li class="onglet_1<?php if($_SERVER['REQUEST_URI']=='/loan/emprunt') echo " actif" ?>"><a href="<?=WEBDIR?>loan/emprunt" class="first" style="left: 2%;">objets empruntés</a></li>
    <li class="onglet_2<?php if($_SERVER['REQUEST_URI']=='/loan/pret') echo " actif" ?>"><a href="<?=WEBDIR?>loan/pret" class="second" style="left: 22%;">objets prêtés</a></li>
    <li class="onglet_3<?php if($_SERVER['REQUEST_URI']=='/loan/archive') echo " actif" ?>"><a href="<?=WEBDIR?>loan/archive" class="third" style="left: 42%;">archives</a></li>
</ul>
