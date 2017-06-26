<div class="row2">
    <div class="col-md-18 title">
        <h1>archives</h1>
    </div>
    <div class="col-md-18 menu_onglet" style="padding: 0;">
        <?php include_once('onglet.php');?>
    </div>
    <div class="col-md-18 lend" style="min-height: 500px;">
        <?php if($req_archive != array()){ ?>
        <?php foreach ($req_archive as $offset => $r) : ?>
        <?php //var_dump($r); ?>
        <div class="col-md-16 col-md-offset-1 req_pret">
            <div>

            </div>
            <div class="col-md-2 photo" style="padding: 0">
                <div>
                    <?= $r[3]->print_picture(100, 'pictures') ?>
                </div>
            </div>
            <div class="col-md-12 desc">
                <div class="dol-md-18 title">
                    <span><?= $r[2]->getAttr('name'); ?></span>
                    <?= $r[3]->getNoteMoy($r[2]->getAttr('id')) ?>(<?=$r[3]->getNbNotation($r[2]->getAttr('id'))?>)
                </div>
                <div class="col-md-18 owner">
                    <div style='float:left;margin-top:2px;'>
                        <?=$r[5]->print_user(16,'profile')?>
                    </div>
                    <div class="name">
                        <a class='blue' href="<?=WEBDIR?>user?module=<?=$r[5]->getAttr('id');?>"><?=$r[5]->printName()?></a>
                    </div>
                    <div>
                        <?= $r[5]->printNote()?>
                    </div>
                    <div style='background-color:rgb(222,76,115);border-radius:5px 5px 0 5px;color:white;float:left;font-size:0.8em;margin-left:10px;margin-top:2px;padding:2px 8px;'>
                        <?=$r[6]->getSmallAddress();?>
                    </div>
                </div>
                <div class="col-md-18 duree">
                    <div class="col-md-4 pret">
                        durée du prêt :
                    </div>
                    <div class="col-md-8 date">
                            <span class="blue"><?= $r[0]->getAttr('date_from') ?> au <?= $r[0]->getAttr('date_to') ?><span>
                    </div>
                </div>
                <div class="col-md-18 txt">
                    <div class="col-md-4 description">
                        message :
                    </div>
                    <div>
                        <?php echo request::getMessageById($r[0]->getAttr('discussion'))[0][0]->getAttr('text'); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4" style="padding: 0;">
                <div class='col-md-18' style="margin-left: 32%;">
                    <div class="col-md-3" style="padding: 0;font-family: bariolBold;color: #515151;">
                        <span style='font-size:25px;'><?=$r[3]->getMutumByDay();?></span>
                    </div>
                    <div class="col-md-1" style="padding-left:4px;width: 30px;top: -3px;">
                        <img alt='number_mutum' src='<?=WEBDIR?>/img/wallet/piecejaune.png' style='width:30px;'>
                    </div>
                    <div class="col-md-10" style="padding-left: 4px;font-family: bariolBold;color:#515151;">
                        <span style='font-size:25px;'>/ jour</span>
                    </div>
                </div>
                <div class="col-md-18" style="padding: 0;">
                    <span class="blueclair"style="float: right;"><?php echo $r[0]->getStatus()['text'] ?></span>
                </div>
            </div>
            <hr>
            </div>
            <?php endforeach ?>
            <?php }else{ ?>
                <p class="nopret">vous n'avez aucune archive.</p>
            <?php } ?>
        </div>
    </div>