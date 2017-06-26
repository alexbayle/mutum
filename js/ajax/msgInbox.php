<?php
    $discId = Site::obtain_post('disc_id') ;
    $discName = Site::obtain_post('disc_name') ;
    $myId = Site::obtain_post('my_id') ;

    // Mise à jour du moment de la dernière lecture
    speakers::messageSeen($discId, $myId) ;

    // Affichage des messages de la discussion
    foreach(discussion::msgFromDiscuss($discId) as $m) {
        $msgText = $m[0]->getAttr('text') ;
        $userName = user::getUser($m[0]->getAttr('user_id'))[0][0]->printName() ;
        $date = $m[0]->getAttr('date_creation') ;
?>
        <div class='discussionMsg col-md-18'>
            <?php if($m[0]->mess_user_id == Session::Me()->getAttr('id')){ ?>
            <div class="col-md-2" style="float: right;margin-top: 10px;">
                <?php echo $m[1]->print_user(40,'radius5'); ?>
            </div>
            <div class="myMessage col-md-16" style="float: right;">
                <?php echo $msgText; ?>
            </div>
            <?php }else{ ?>
            <div class="col-md-2" style="margin-top: 10px;">
                <?php echo $m[1]->print_user(40,'radius5'); ?>
            </div>
            <div class="destMessage col-md-16">
                <?php echo $msgText; ?>
            </div>
           
            <?php } ?>
        </div>
<?php
    }
?>
<div id="lastmessage" class="col-md-18"></div>

<script>
    //$("#sent").scrollTo(document.getElementById('lastmessage').offsetTop);
    //alert($('#sent div').height());
    var bas_fenetre = document.getElementById('lastmessage').offsetTop;
    if($('#sent').scrollTop()>bas_fenetre-1000||$('#sent').scrollTop()==0)$("#sent").scrollTo(bas_fenetre);//en gros ca redescent si t'es tout en bas ou tout en haut...
</script>
<?php

    // Suis-je l'admin de la discussion ?
    if(speakers::etreAdmin($myId, $discId)) {
        $isAdmin = 1 ;
    } else {
        $isAdmin = 0 ;
    }
    
    // all_grant_invit = 1 ?
    if(discussion::getAllgrantinvit($discId)) {
        $allGrantInvit = 1 ;
    } else {
        $allGrantInvit = 0 ;
    }
    
    // Récupération des participants à une discussion
    $participants = speakers::getSpeakers($discId) ;

?>
    <script>
        // Réinitialiser les div Speakers et NewAdmin
        $('#speakers').empty();
        $('#newAdmin').empty();
    </script>
<?php
    foreach($participants as $p) {
        $pId = $p[0]->getAttr('id');
        if($pId == $myId) {
            $pName = $p[0]->getAttr('firstname') . ' ' . $p[0]->getAttr('lastname') ;
        } else {
            $pName = $p[0]->printName() ;
        }
        if($pId != $myId) {
?>
            <script>
                // New admin
                $("<input class='participants' id='<?=$pId?>' name='newAdmin' type='radio' value='<?=$pId?>' /><label for='<?=$pId?>'><?=$pName?></label>").appendTo('#newAdmin') ;
            </script>
<?php
        }
?>
        <script>
            // Participants
            $("<span style='margin-right:20px;'><?=$pName?></span>").appendTo('#speakers') ;
        </script>
<?php
    }
?>
<script>
    $('#discuTitle').empty();
</script>
<?php
    $title = discussion::getDiscuTitle($discId);
    $title = $title[0]['disc_name'];
?>
<input id="title" type="hidden" value="<?php echo $title ?>"></input>

<script>

    $('#discuTitle').append($('#title').val());



    // Affichage du bouton Nouvel Admin
    $('#newAdminButton').show() ;
    
    // Panel d'administration
    if(<?=$isAdmin?> === 1) {
        $('#administrationPanel').show() ;
    } else {
        $('#administrationPanel').hide() ;
    }
    
    // Invitations à une discussion
    if(<?=$isAdmin?> === 1 || <?=$allGrantInvit?> === 1) {
        $('#inviteContacts').show() ;
    } else {
        $('#inviteContacts').hide() ;
    }

    $('#discuPhoto').empty();
</script>

<?php

$discuDest = discussion::discuDest($discId);
$discuDest = $discuDest[0][2]->print_user(40,'radius20');

?>
<script>
    $("<?=$discuDest?>").appendTo('#discuPhoto') ;
</script>
