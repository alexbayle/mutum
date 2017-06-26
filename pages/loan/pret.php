<div class="row2">
    <div class="col-md-18 title">
        <h1>mes prêts</h1>
    </div>
    <div class="col-md-18 menu_onglet" style="padding: 0;">
        <?php include_once('onglet.php');?>
    </div>
    <div class="col-md-18 lend" style="min-height: 500px;">
        <?php if($req_pret != array()){ ?>
        <?php foreach ($req_pret as $offset => $r) : ?>
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
                            <?= $r[5]->printNote($r[5]->getAttr('nb_notation'),round($r[5]->getAttr('notation')))?>
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
                        <div class="col-md-4 description" style="height: 15px;">
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


                    <?php switch ($r[0]->getStatus()['code']) :
                        case \request_status::STATUS_ASK : ?>
                            <form action="<?php echo WEBDIR ?>loan/pret/cancel" method="post">
                                <input type="hidden" id="requ_id" name="requ_id" value="<?php echo $r[0]->getAttr('id') ?>">
                                <div class="col-md-18" style="padding: 0;">
                                    <input type="submit" value="annuler" name="btn_annul_pret" id="btn_annuler"/>
                                </div>
                            </form>
                            <form action="<?php echo WEBDIR ?>loan/pret/valid" method="post">
                                <input type="hidden" id="requ_id" name="requ_id" value="<?php echo $r[0]->getAttr('id') ?>">
                                <input type="submit" value="valider" name="btn_valid_pret" id="btn_valid"/>
                            </form>
                            <?php break;
                        case \request_status::STATUS_REFUSED :
                        case \request_status::STATUS_CANCEL_BORROWER:
                        case \request_status::STATUS_CANCEL_LENDER : ?>
                            <form action="<?php echo WEBDIR ?>loan/pret/delete" method="post">
                                <input type="hidden" id="requ_id" name="requ_id" value="<?php echo $r[0]->getAttr('id') ?>">
                                <input type="submit" value="supprimer" name="btn_delete_pret" id="btn_delete"/>
                            </form>
                            <?php break;
                        case \request_status::STATUS_VALID :
                        case \request_status::STATUS_BLOCKED :
                        case \request_status::STATUS_CAUTION :
                        case \request_status::STATUS_ENDED_TODAY :
                        case \request_status::STATUS_START_TODAY :
                        case \request_status::STATUS_IN_PROGRESS : ?>
                            <?php break;
                        case \request_status::STATUS_OBSOLETE : ?>
                            <form action="<?php echo WEBDIR ?>loan/pret/delete" method="post">
                                <input type="hidden" id="requ_id" name="requ_id" value="<?php echo $r[0]->getAttr('id') ?>">
                                <input type="submit" value="supprimer" name="btn_delete_pret" id="btn_delete"/>
                            </form>
                            <?php break;
                        case \request_status::STATUS_ENDED : ?>
                            <?php if($r[0]->getAttr('lender_nota_id') == null){ ?>
                                <?php if( $r[0]->getAttr('borrower_nota_id') != null) ?>
                                <input type="button" value="noter" name="btn_grade_pret" class="buttonAction" data-target="grade_emprunt_<?php echo $offset ?>"/>
                            <?php }elseif($r[0]->getAttr('lender_archive') == 0 && $r[0]->getAttr('borrower_nota_id') != null){ ?>
                                <form action="<?php echo WEBDIR ?>loan/pret/archive" method="post">
                                    <input type="hidden" id="requ_id" name="requ_id" value="<?php echo $r[0]->getAttr('id') ?>">
                                    <input type="submit" value="archiver" name="btn_archive" id="btn_archive"/>
                                </form>
                            <?php }else{  ?>

                            <?php } ?>

                            <?php break;
                        default : ?>
                            status = <?php echo $r[1]->getAttr('lender_info') ?>
                            <?php case \request_status::STATUS_VALID :
                            if ($r[0]->getAttr('dateTo') < date('Y-m-d')) : ?>
                                <!--<input type="button" value="noter" name="btn_grade_pret" class="buttonAction" data-target="grade_emprunt_<?php echo $offset ?>"/>-->
                            <?php else : ?>
                                vous pourrez attribuer une note à la fin de la période de location
                            <?php endif; ?>
                            <?php break;
                     endswitch; ?>
                    </div>
                    <div class="moderation" id="signal_<?php echo $offset ?>">
                        <div class="signal">
                            <form action="<?php echo WEBDIR ?>loan/pret/signal" method="post">
                                <input type="hidden" id="requ_id" name="requ_id" value="<?php echo $r[0]->getAttr('id') ?>">
                                <input type="submit" value="signaler" id="btn_signal"/>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-18" style="padding: 0;">
                    <div style="display: none;" id="grade_emprunt_<?php echo $offset ?>">
                        <form action="<?php echo WEBDIR ?>loan/pret/grade" method="post">
                            <input type="hidden" id="requ_id" name="requ_id" value="<?php echo $r[0]->getAttr('id') ?>">
                            <div class="col-md-18">
                                <div class="col-md-5 demande_item" style="padding: 0;">
                                    <label for="rank">note de l'emprunteur :</label>
                                </div>
                                <div class="col-md-13">
                                    <span class="star-rating" style="margin-left: 35%">
                                        <input type="radio" name="note_emprunteur" value="1"><i></i>
                                        <input type="radio" name="note_emprunteur" value="2"><i></i>
                                        <input type="radio" name="note_emprunteur" value="3"><i></i>
                                        <input type="radio" name="note_emprunteur" value="4"><i></i>
                                        <input type="radio" name="note_emprunteur" value="5"><i></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-18 demande_item">
                                <label for="title">titre :</label>
                                <input type="text" id="title" name="title" value="Pret <?php echo $r[2]->getAttr('name') ?>"/>
                            </div>
                            <div class="col-md-18 demande_item">
                                <label for="txtemprunt">message :</label>
                                <textarea name="txtemprunt" id="txtemprunt" cols="30" rows="10"></textarea>
                            </div>
                            <div class="col-md-18 envoie" style="padding: 0;float: right;">
                                <input type="submit" value="confirmer"/>
                            </div>
                        </form>
                    </div>
                </div>
                <hr>
            </div>
            <div class="col-md-1">
                <a href="#" class="buttonAction" data-target="signal_<?php echo $offset ?>">
                    <img src="<?= WEBDIR ?>img/menu_arrow_bottom.png" alt="modération" width="12" height="7" style="margin-top: 30px;"/>
                </a>
            </div>
        <?php endforeach ?>
        <?php }else{ ?>
            <p class="nopret">Vous ne prêtez actuellement aucun objet.</p>
        <?php } ?>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        $('.buttonAction').on('click', function(e) {
            e.preventDefault();
            var target = $(this).data('target');
            $("#"+target).slideToggle();
        });
    });
</script>