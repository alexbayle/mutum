<div class="row2">
    <div class="col-md-18 title">
        <h1>résolution de bug</h1>
    </div>
    <div class="col-md-18 menu_onglet"style="padding-left: 0;padding-right: 0">
        <?php include_once('header.php') ?>
    </div>

    <div class="col-md-18 faq">
        <div class="col-md-6">
            <img src="<?=WEBDIR?>img/bug.png" style="margin-left: -20px;"/>
        </div>
        <div class="col-md-12 texte" style="padding: 41px 0px">
            <form action="" method="post" enctype="multipart/form-data">
                <h2>remplissez notre formulaire si vous avez rencontré un bug :</h2>
                <br/>
                <div class="demande_item">
                    <label for="sujet"></label>
                    <input type="text" id="sujet" name="sujet" placeholder="sujet"/>
                </div>
                <div class="demande_item" style="margin-top: 10px">
                    <label for="email"></label>
                    <input type="email" id="email" name="mail" placeholder="votre email"/>
                </div>
                <div class="demande_item" style="margin-top: 10px;">
                    <label for="file"></label>
                    <input type="file" id="pj1" name="pj1"/>
                </div>
                <div class="demande_item" style="margin-top: 10px;">
                    <label for="file"></label>
                    <input type="file" id="pj2" name="pj2"/>
                </div>
                <div class="demande_item" style="margin-top: 10px;">
                    <textarea name="msg" id="" cols="30" rows="10" placeholder="votre message" style="resize: none;"></textarea>
                </div>
                <div>
                    <input type="submit" name="valid" class="btnbluev2" value="envoyer" style="float: right;width: 120px;margin-right: 66px;margin-top: 10px;"/>
                </div>
            </form>
        </div>
        <div class="col-md-18">
            <h1 style="color: #9bd2d7;text-align: center;font-size: 37.5px;margin-bottom: 20px;">Merci pour votre aide !</h1>
        </div>
    </div>
</div>