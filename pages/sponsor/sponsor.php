<div class="row2">
    <div class="col-md-18 title">
        <h1>parrainage</h1>
    </div>
    <div class="col-md-18 sponsor">
        <h2>parrainez vos amis, <br/>et gagnez gratuitement 10 mutums lors du référencement de leur 1er objet !</h2>
		<br/>
        <h3 class="text-center">importez directement vos contacts !</h3>
        <div class="col-md-2 col-md-offset-5 mail">
            <a href='<?php print $url['gmail']; ?>'>
                <div class='messagerie'>
                    <img src='/img/mail_gmail.png' width="100" height="100"><br/>
                    gmail
                </div>
            </a>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-2 mail">
            <a href='<?php print $url['yahoo']; ?>'>
                <div class='messagerie'>
                    <img src='/img/mail_yahoo.png' width="100" height="100"><br/>
                    yahoo! mail
                </div>
            </a>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-2 mail">
            <a href='<?php print $url['outlook']; ?>'>
                <div class='messagerie'>
                    <img src='/img/mail_outlook.jpg' width="100" height="100"><br/>
                    outlook
                </div>
            </a>
        </div>
        <div class="col-md-12 col-md-offset-6 menu_sponsor" style="display: none;">
            <ul>
                <li>a ajouter: <?php echo count($mails) ?></li>
                <li>déjà inscrits: <?php echo $alreadyRegistered ?></li>
                <li>déjà invités: <?php echo $alreadySponsored ?></li>
            </ul>
        </div>
        <div class="col-md-12 col-md-offset-3" style="margin-top: 20px;">
            <h3>ou rentrez directement leur e-mail</h3>
        </div>
        <div class="col-md-12 col-md-offset-4">
            <form action="<?php echo WEBDIR ?>sponsor/add" method="post">
                <div id="affich_tags"></div>
                <input type="text" name="tags" placeholder="adresse email..." class="tm-input well_transition" style="width:83%;" />
                <input type="hidden" name="liste_tags" id="liste_tags" />
                <input type="submit" value="inviter" class="send" style="margin-left: 33.5%"/>
            </form>
        </div>

    </div>
</div>
<script type="text/javascript">

    $(function () {

        function check_email(validMail) {
            var regMail = new RegExp(/^([a-zA-Z0-9]+(([\.\-\_]?[a-zA-Z0-9]+)+)?)\@(([a-zA-Z0-9]+[\.\-\_])+[a-zA-Z])/);
            return regMail.test(validMail);
        }

        jQuery(".tm-input").tagsManager({
            tagClass: 'tm-tag-success',
            validator: check_email,
            output: '#liste_tags',
            tagsContainer: '#affich_tags'
        });

        <?php if (isset($mails)) : ?>
        var mails_gmail = '<?php echo implode(',', $mails); ?>';
        var mails_yahoo = '<?php echo implode(',', $mails); ?>';
        var mails_outlook = '<?php echo implode(',', $mails); ?>';
        if (mails_gmail != '') {
            var tab_gmail = mails_gmail.split(',');
            for (i = 0; i < tab_gmail.length; i++)
                jQuery(".tm-input").tagsManager('pushTag', tab_gmail[i]);2
        }
        else if (mails_yahoo != '') {
            var tab_yahoo = mails_yahoo.split(',');
            for (i = 0; i < tab_yahoo.length; i++)
                jQuery(".tm-input").tagsManager('pushTag', tab_yahoo[i]);
        }
        else if (mails_outlook != '') {
            var tab_outlook = mails_outlook.split(',');
            for (i = 0; i < tab_outlook.length; i++)
                jQuery(".tm-input").tagsManager('pushTag', tab_outlook[i]);
        }
        <?php endif; ?>
    });
</script>
