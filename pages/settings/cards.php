<div class="row2">
    <div class="col-md-18 title">
        <h1>mes cartes bancaires</h1>
    </div>
    <div class="col-md-18 menu_onglet"style="padding-left: 0;padding-right: 0">
        <?php include_once('header.php') ?>
    </div>

    <div class="col-md-18 preter">
        <h2>liste des cartes :</h2>
        <div class="col-md-18">
            <?php foreach($cards as $c){ ?>
                <?php if($c->Active){ ?>
                    <div class="col-md-9 ajoutcard">
                        <?php //var_dump($c); ?>
                        <div>
                            <?php echo $c->Alias ?>
                        </div>
                        <div style='position:absolute;top:5px;right:5px;'>
                            <form method="post" action="delete_card">
                                <input type="hidden"  value="<?php echo $c->Id ?>" name="card_id">
                                <button class='likehref' type="submit" onclick="return window.confirm('confirmer la suppression de la carte ?')" value="Supprimer la carte" style="border: none;background-color: #e6e6e6"><img src='<?= WEBDIR ?>img/moinsbutton.png' style="cursor: pointer;border-radius: 10px;"></button>
                            </form>
                        </div>
                        <div><?php echo $c->Validity ?></div>
                        <div style='position:absolute;color:#000;bottom:6px;right:10px;'>
                            enregistrée le : <?php echo date('d/m/Y',$c->CreationDate) ?>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
            <div class="col-md-9 ajoutcard">
                <h2>ajouter une carte</h2>
                <a href="<?php echo WEBDIR ?>settings/new_card"><img src="<?php echo WEBDIR ?>img/plusbutton.png" alt="" style="border-radius: 10px;margin: 3% 43%;cursor: pointer;"/></a>
            </div>
        </div>
    </div>
</div>