<form action="" method="post">


    <div>
        mes demandes
    </div>

    <?php

    foreach (wishlist::voirLesdemandes(session::me()->getAttr('id')) as $unedemandes)
    {

    echo"<div style='width:200px;height:200px;margin:25px;border: 1px solid; border-radius:10px;'>";
    echo $unedemandes[0]->getAttr('date'); echo "<br>";
    echo ("-");
    echo $unedemandes[1]->getAttr('name');echo "<br>";
    echo ("-");
    echo $unedemandes[4]->getAttr('city');echo "<br>";
    echo ("-");
    echo $unedemandes[4]->getAttr('zip');echo "<br>";
    echo ("-");
    echo $unedemandes[4]->getAttr('address');echo "<br>";

    ?>
    <br />
    <button type="submit" name="SupprimeUneDemande"  value="<?=$unedemandes[0]->getAttr('id') ?>">supprimer cette demande </button>
    <button type="date" name="ProlongerDemander" value="<?=$unedemandes[0]->getAttr('id') ?>">prolonger</button>
</form>
<?}?>
