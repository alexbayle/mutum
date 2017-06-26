<div class="row2" xmlns="http://www.w3.org/1999/html">
    <div class="col-md-18 title">
        <h1>messagerie</h1>
    </div>
    <div class="col-md-3 menu_messagerie">
        <div class="col-md-18">
            <div class="reception">
                <div class="boite" id="boite">
                    <button type="button">boîte de réception</button>
                </div>
                <div class="nbmessagerec" id="nbmessagerec">
                    <span><?=$nbDiscu?></span> discussions
                </div>
            </div>
        </div>
        <div class="col-md-18">
            <div class="new" id="newDiscussionMenu">
                <button type="button">nouveau message</button>
            </div>
        </div>
        <div class="col-md-18">
            <div class="archive">
                <button type="button" style="display: none;">archive</button>
            </div>
        </div>
    </div>
    <div class='col-md-5 listediscussion' style='margin-left: 29px;margin-right: 28px;padding: 0;'>
        <div class="col-md-18" style="margin-bottom: 10px;">
            <form action="" method="get">
                <div class="col-md-18" style="padding-left: 0;">
                    <label for="search_bar"></label>
                    <input type="search" id="search_discussion" name="search_discussion" value="<?php echo $search_discussion ?>" class="search_bar"  placeholder="rechercher..."/>
                </div>
               <!-- <div class="col-md-18 check">
                    <div class="col-md-2" style="padding-left: 0;">
                        <label for="contact">contacts</label>
                    </div>
                    <div class="col-md-1">
                        <input type="checkbox" name="contact" id="contact" style="display: block;border: none;"/>
                    </div>
                    <div class="col-md-2">
                        <label for="objet">objets</label>
                    </div>
                    <div class="col-md-1">
                        <input type="checkbox" name="objet" class="" id="objet" style="display: block;border: none;"/>
                    </div>
                </div>-->
                <div>
                    <input type="submit" class="send" value="ok !"/>
                </div>
            </form>
        </div>
        <div class="col-md-18 discuss scrollbar" style="padding: 0;" id="listDiscu">
            <?php $i=0; ?>
            <?php foreach ($discussions as $d) { ?>
                <?php //var_dump($d); ?>
                <div class='col-md-18 nameDiscussionMenu discussMenu_<?php echo $i; ?> ' id="<?=$d[0]->getAttr('id')?> " style='padding: 0;'>
                    <div class="col-md-6" style="padding-left: 5px;padding-top: 10px;">
                        <?php echo $d[3]->print_user(80,'radius5'); ?>
                    </div>
                    <div class="col-md-11" style="padding: 0;color: #616161;padding-top: 10px;">
                        <div class="col-md-18" style="padding: 0;font-family: bariolBold">
                            <?php echo $d[3]->printName(); ?> -
                        </div>
                        <div class="col-md-18" style="padding: 0;">

                        </div>
                        <hr>
                        <div class="col-md-18" style="padding: 0;">
                            <span style="font-size: 15px"><?=$d[0]->getAttr('name')?></span><br />
                            <p style="font-size: 12px;  height: 23px;overflow: hidden; text-overflow: ellipsis;display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;"><?php echo message::getMessageById($d[0]->getAttr('id'))[0][0]->getAttr('text'); ?></p>
                        </div>
                    </div>
                </div>
                <?php $i++; ?>
            <?php } ?>
        </div>
        <div class="col-md-18 discuss scrollbar" id="searchDiscu" style="padding: 0;">
            <?php include(Site::include_view('searchDiscu')) ?>
        </div>
    </div>

    <div class='col-md-9' id='msg' style="padding: 0;">
        <div class='newDiscuss'>
            <form method='POST'>
                <div class="col-md-18">
                    <div class="col-md-2" style="padding: 0;" id="plusmoinsbutton">
                        <img src="<?= WEBDIR ?>img/plusbutton.png" alt="" id="plusmoins" width="40" height="40" class="block1" style="border-radius: 10px;margin-top: 20px"/>
                    </div>
                    <div class="col-md-8 demande_item">
                        <input id='discussionName' placeholder='titre de la discussion' style='margin:20px 0;' type='text' />
                        <div class="col-md-18" id="contactliste" style="padding: 0;margin-top: 10px;display: none;margin-bottom: 10px;">
                            <div id='contactsList' class="col-md-18 scrollbar listeContact" style="padding: 0;">
                                <?php
                                foreach ($contacts as $c) {
                                    if ($c[0]->getAttr('id') != $myId) {
                                        $cId = $c[0]->getAttr('id') ;
                                        ?>
                                        <div class="col-md-18" style="padding-top: 5px;">
                                            <input class='inputContact' data-id='<?=$cId?>' id='contact_<?=$cId?>' style='display:none;' type='checkbox' value='<?=$cId?>' />
                                            <label for="contact_<?=$cId?>" class="roundbox"></label>
                                            <label for='contact_<?=$cId?>' style=""><?=$c[0]->printName()?></label>
                                        </div>
                                    <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <hr style="width: 514px;margin-left: -10px;height: 1px;">
                </div>

                <div id='allGrantInvit' class="demande_item">
                    <label>tout le monde peut-il inviter des contacts ?</label>
                    <input id='grant' name='allGrantInvit' type='radio' value='1'style="width: 15px;" />
                    <label for='grant'>oui</label>
                    <input id='noGrant' checked name='allGrantInvit' type='radio' value='0' style="width: 15px;" />
                    <label for='noGrant'>non</label>
                </div>
                <div class="demande_item" style="margin-top: 20px;">
                    <textarea class='col-md-18' id='firstMsg' placeholder='tapez votre message' required rows='5'></textarea>
                </div>
                <div class="sendmessage">
                    <input type="submit" class="createDiscussion" value="envoyer"/>
                </div>
            </form>
        </div>
        <div class='sendMsg' id="sendMsg">
            <div class="col-md-18 headerDiscuss" style="padding: 0;">
                <div class="col-md-2" id="discuPhoto">

                </div>
                <div class="col-md-9" style="padding: 0;">
                    <div class="col-md-18" style="margin-top: 10px;">
                        <div class="col-md-3" style="padding: 0;">
                            <span class="blue" style="font-family: bariolBold">sujet :</span>
                        </div>
                        <div id="discuTitle" class="col-md-15" style="padding: 0;"></div>
                    </div>
                    <div class="col-md-18" style="margin-top: 5px;margin-bottom: 25px;">
                        <div class="col-md-3" style="padding: 0;">
                            <span class="blue" style="font-family: bariolBold">avec :</span>
                        </div>
                        <div id='speakers' class="col-md-15" style="padding: 0;"></div>
                    </div>
                </div>
                <div class="col-md-7" style="padding: 0;margin-top: 17px;">
                    <!--<div class="col-md-15" id="menu_inbox" style="padding-left:5px;font-size: 12px;display: none;border-left:2px solid #e6e6e6; ">
                        <ul>
                            <li><a id="inviteDiscuContacts">inviter des contacts</span></a>
                            <li><a id="renameDiscussion">renommer la discussion</a></li>
                            <li><a id="">supprimer la discussion</span></a>
                        </ul>
                    </div>
                    <div class="col-md-3" id="onoff" style="position: absolute;right: 16px;top: 10px;">
                        <img src="<?= WEBDIR?>img/off.png" class="off" alt=""/>
                        <img src="<?= WEBDIR?>img/on.png" class="on" alt="" style="display: none;"/>
                    </div>-->
                </div>

            </div>
            <hr style="width: 514px;height: 2px;margin: 0;">
            <div class='sent scrollbar' id="sent"></div>
            <hr style="width: 514px;height: 2px;margin: 0;">
            <div id="options" class="col-md-18" style="">
                <div id='administrationPanel'>
                    <div id="renameDiscu" class="demande_item" style="display: none;">
                        <form id='renameDiscuss'>
                            <input id='discussionNewName'  placeholder='renommer la discussion' type='text' />
                            <div class="send">
                                <input type="submit" value="renommer" id="renameDiscu"/>
                            </div>
                        </form>
                    </div>
                    <!--<div id="adminDiscu">
                        Transmettre droits d'administration
                        <form>
                            <div id='newAdmin'></div>
                            <button id='newAdminButton' type='submit'>Nouvel admin</button>
                        </form>
                    </div>-->
                    <div id="contactDiscu" style="display: none;">
                        <form id='inviteContacts'>
                            <div id='contactsList' class="col-md-18 scrollbar listeContact" style="padding: 0;">
                            <?php
                            foreach ($contacts as $c) {
                                if ($c[0]->getAttr('id') != $myId) {
                                    $cId = $c[0]->getAttr('id') ;
                                    ?>
                                    <div class="col-md-18" style="padding-top: 5px;">
                                        <input class='inputContact' data-id='<?=$cId?>' id='contact_<?=$cId?>' style='display:none;' type='checkbox' value='<?=$cId?>' />
                                        <label for="contact_<?=$cId?>" class="roundbox"></label>
                                        <label for='contact_<?=$cId?>' style=""><?=$c[0]->printName()?></label>
                                    </div>
                                <?php
                                }
                            }
                            ?>
                            </div>
                            <button class='inviteContactButton' type='submit'>Inviter</button>
                        </form>
                    </div>
                </div>
            </div>
            <div id='send' class="col-md-18">
                <form>
                    <div class="demande_item">
                        <textarea id='message' placeholder='votre message'></textarea>
                    </div>
                    <div class="sendMessage col-md-18">
                        <span style="position: absolute;left: 307px; top: -25px; height: 15px;color:#00A2B0">entrée = envoyer</span>
                        <input style="display:block;   left: 397px; top: -38px; height: 15px" type="checkbox" id="entreeEnvoyer" unchecked/>
                        <input type="submit" class="answerDiscussion" value="ok !"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>

    var  disc_id = null;
    var disc_name = null;
    function afficherConv(){
        $.post('<?=AJAXLOAD?>msgInbox', {
            'disc_id' : disc_id,
            'disc_name' : disc_name,
            'my_id' : <?=$myId?>
        }, function (a) {
            //console.log(a);
            $('.sent').html(a) ;

            //console.log('actualisation');
        },'html') ;
    }


    $(document).ready(function(){

        $('.nameDiscussionMenu').click(function(){
            var id = $(this).prop('id').replace('discussMenu_','');
            $('.nameDiscussionMenu').removeClass('bgblue');
            $(this).addClass('bgblue');
        });


        $(function() {
            $('#plusmoinsbutton').click(function(){
                $('#contactliste').slideToggle("slow",function(){
                    $("#plusmoins").attr('src',"img/moinsbutton.png");
                    return false;
                });
            });
        });

        $('#onoff').click(function(){
            $('#menu_inbox').slideToggle("slow",function(){

            });
        });

        $('#renameDiscussion').click(function(){
            $('#renameDiscu').slideToggle('slow',function(){

            });
        });

        $('#inviteDiscuContacts').click(function(){
           $('#contactDiscu').slideToggle('slow',function(){

           });
        });

        function hideAll() {
            $('.contacts').hide() ;
            $('#newAdminButton').hide() ;
            $('.newDiscuss').hide() ;
            $('.sendMsg').hide() ;
        }

        function hideAll2(){
            $('#listDiscu').hide();
            $('#searchDiscu').hide();
        }
        hideAll2();
        var search_discu = $('#search_discussion').val();
        console.log(search_discu);
        if(search_discu == "") {
            hideAll2();
            $('#listDiscu').show();
        } else {
            hideAll2();
            $('#searchDiscu').show();

        }

        $('#boite').click(function(){
            $('#nbmessagerec').slideToggle();
        });


        // Par défaut, on affiche le panneau Nouvelle Discussion
        hideAll() ;
        $('.newDiscuss').show() ;



        // Afficher une discussion existante




        $('.nameDiscussionMenu').click(function () {
            hideAll() ;
            $('.discussionMsg').show() ;
            $('.sendMsg').show() ;
            disc_id = $(this).attr('id') ;
            disc_name = $(this).text() ;
            afficherConv();
            setInterval("afficherConv();",2000) ;
        }) ;




        // Afficher le formulaire Nouvelle Discussion
        $('#newDiscussionMenu').click(function () {
            hideAll();
            $('.newDiscuss').show();
        });

        // Envoyer un message
        $('#message').keydown(function(event) {
            if (event.keyCode == 13 && $('#entreeEnvoyer').prop('checked')) { //quand on appuie sur entree
                if($('#message').val()!="") {
                    event.preventDefault();
                    message = $('#message').val();
                    $.post('<?=AJAXLOAD?>insertInbox', {
                        'id' : disc_id,
                        'message' : message,
                        'my_id' : <?=$myId?>
                    },function (data) {
                    });
                    $('#message').val("");
                    $.post('<?=AJAXLOAD?>msgInbox', {
                        'disc_id' : disc_id,
                        'disc_name' : disc_name,
                        'my_id' : <?=$myId?>
                    }, function (a) {
                        $('.sent').html(a);
                    });
                }

            }
        });


        $('.answerDiscussion').click(function (e) {
            if($('#message').val()!="") {
                e.preventDefault();
                message = $('#message').val();
                $.post('<?=AJAXLOAD?>insertInbox', {
                    'id': disc_id,
                    'message': message,
                    'my_id': <?=$myId?>
                }, function (data) {
                });
                $('#message').val("");
                $.post('<?=AJAXLOAD?>msgInbox', {
                    'disc_id': disc_id,
                    'disc_name': disc_name,
                    'my_id': <?=$myId?>
                }, function (a) {
                    $('.sent').html(a);
                });
            }
        });



        // Inviter un contact
        $('.inviteContactButton').click(function(e) {
            e.preventDefault() ;
            invites = '' ;
            $('#inviteContacts').children().each(function() {
                if($(this).prop('tagName') === 'INPUT') {
                    if($(this).prop('checked')) {
                        id = $(this).attr('data-id') ;
                        invites += id + '-' ;
                    }
                }
            }) ;
            if(invites === '') {
                alert('Pas de contact');
                return false ;
            } else {
                $.post('<?=AJAXLOAD?>invite', {
                    'disc_id' : disc_id,
                    'invites' : invites
                }) ;
            }
        }) ;

        // Renommer une discussion
        $('#renameDiscu').click(function(e) {
            e.preventDefault() ;
            disc_name = $('#discussionNewName').val() ;
            if(disc_name != '') {
                $.post('<?=AJAXLOAD?>renameDiscuss', {
                    'disc_id' : disc_id,
                    'disc_name' : disc_name
                }, function(data) {
                    $('#discuTitle').html(data);
                });
            } else {

            }

        }) ;

        // Transmettre droits d'admin
        $('#newAdminButton').click(function(e) {
            e.preventDefault() ;
            new_admin_id = '' ;
            $('#newAdmin').children().each(function() {
                if($(this).prop('tagName') === 'INPUT') {
                    if($(this).prop('checked')) {
                        new_admin_id = $(this).val() ;
                    }
                }
            }) ;
            if(new_admin_id === '') {
                alert('No new admin selected !') ;
                return false ;
            } else {
                $.post('<?=AJAXLOAD?>newAdmin', {
                    'disc_id' : disc_id,
                    'new_admin_id' : new_admin_id
                }) ;
            }
        }) ;

        // Créer une nouvelle discussion
        $('.createDiscussion').on('click', function (e) {
            e.preventDefault() ;
            disc_name = $('#discussionName').val() ;
            if (disc_name === '') {
                disc_name = 'Sans titre' ;
            }
            contacts = '' ;
            $("#contactsList").children().children().each(function() {
                if($(this).prop('tagName') === 'INPUT') {
                    if($(this).prop('checked')) {
                        id = $(this).attr('data-id') ;
                        contacts += id + '-' ;
                    }
                }
            }) ;
            $('#allGrantInvit').children().each(function() {
                if($(this).prop('tagName') === 'INPUT') {
                    if($(this).prop('checked')) {
                        all_grant_invit = $(this).val() ;
                    }
                }
            }) ;
            message = $('#firstMsg').val() ;
            if(contacts === '') {
                alert('Pas de contact') ;
                return false ;
            } else {
                contacts += <?=$myId?> ;
                $.post('<?=AJAXLOAD?>newDiscuss', {
                    'all_grant_invit' : all_grant_invit,
                    'contacts' : contacts,
                    'message' : message,
                    'myId' : <?=$myId?>,
                    'name' : disc_name
                });
            }
            hideAll();
            window.location = '<?=WEBDIR?>inbox';
        });
    });

</script>