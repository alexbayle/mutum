<?php
$size = Site::getWidgetParams('size',6);
$text_title = Site::getWidgetParams('text_title',"<span class='blue'>les derniers ajouts</span>");
$class_title = Site::getWidgetParams('class_title','');



?>
<style type="text/css">
    .photo img{
        width:100px;
        height:100px;
        -webkit-border-radius: 5px;
        -webkit-border-bottom-right-radius: 0;
        -moz-border-radius: 5px;
        -moz-border-radius-bottomright: 0;
        border-radius: 5px;
        border-bottom-right-radius:0;
        -moz-box-shadow: 0px 5px 0px 0px #9bd2d6;
        -webkit-box-shadow: 0px 10px 0px 0px #9bd2d6;
        -o-box-shadow: 0px 5px 0px 0px #9bd2d6;
        box-shadow: 0px 5px 0px 0px #9bd2d6;
        filter:progid:DXImageTransform.Microsoft.Shadow(color=#e6e6e6, Direction=180, Strength=5);
    }


</style>

<div class='col-md-<?=$size?> object' style="padding: 0;">

    <div class='col-md-18'>
        <h1 class='<?=$class_title?>'><?=$text_title?></h1>
    </div>

    <div class='col-md-18' style="">
        <?php
        $article = DB::SqlToObj(array('product','article'),"SELECT * FROM product,article WHERE prod_id = arti_prod_id AND arti_pictures != '[]' ORDER BY RAND() LIMIT 20 ");
        for($i=0;$i<4;$i++)
        {
            ?>
            <a class='col-md-9 carr_link_class' style="padding: 5px;height: 140px;" id='carr_link_<?php echo $i?>' href='<?php WEBDIR ?>view/<?php echo $article[$i][0]->getAttr('id'); ?>'>
                <div class='col-md-18 photo' style='padding:0px;margin-bottom: 40px;'>
                    <div style='position:relative;width:100%;border-radius: 10px'>
                        <?php echo $article[$i][1]->print_picture(100,'','','0'); ?>
                        <div style='display: none; color:white;height:100px;width:100px;position:absolute;top:0px;left:0px;opacity:0.8;background-color:#00a2b0;-webkit-border-radius: 5px;-webkit-border-bottom-right-radius: 0;-moz-border-radius: 5px;-moz-border-radius-bottomright: 0;border-radius: 5px;border-bottom-right-radius: 0;' id='carr_hover_<?=$i?>'>
                            <div class='col-md-18' style='padding: 0;'>
                                <div class='col-md-18' id='carr_price_<?php echo $i ?>' style="padding: 0;">
                                    <div style=" position: absolute;top: 15px;left: 36px;font-size: 25px;z-index: 9999;font-family: bariolBold;">
                                        <?php echo $article[$i][1]->getAttr('price');?>
                                    </div>
                                    <div class="col-md-18">
                                        <img src="<?= WEBDIR ?>img/pile-money-02.png" alt="" style="width: 50px;height: 50px;box-shadow: none;margin-left: 15px;margin-top: 5px;"/>
                                    </div>
                                    <div class="col-md-18" style="margin-left: 20px;font-size: 20px;">
                                        /jour
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-18" style="padding:0;text-align: center;color:#01b8c8;font-size: 12px;font-family: bariolRegular;margin-top: 10px;overflow: hidden">
                            <?php echo $article[$i][0]->getAttr('name');?>
                        </div>
                    </div>
                </div>
            </a>
        <?php
        }
        ?>
    </div>

    <div class='col-md-18' style="margin-left: 5%;">
        <div class='col-md-2' style="padding-top: 20px;">
            <div class='arrow_left' id='<?=$widget_id?>_slide_left'>
                <img src='<?=WEBDIR?>img/arrow-left.png' style='text-align:center;height:100%'>
            </div>
        </div>

        <div class='col-md-12' style="margin-top:11px;">
            <button type='button' class='btnbluev2 btn'>Voir plus d'objets</button>
        </div>

        <div class='col-md-2' style="padding-top: 20px;">
            <div class='arrow_right' id='<?=$widget_id?>_slide_right'>
                <img src='<?=WEBDIR?>img/arrow-right.png' style='text-align:center;height:100%'>
            </div>
        </div>

    </div>

</div>

<script>

</script>