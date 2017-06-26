<div class="row2">
    <div class="col-md-18 title">
        <h1>mon porte mutum</h1>
    </div>
    <div class="col-md-18 menu_onglet" style="padding-left: 0;padding-right: 0;">
        <?php include_once('header.php') ?>
    </div>

    <div class="col-md-18 wallet">
        <div class="col-md-6">
            <div id="donutchart" style="width:316px; height:350px;">

            </div>

        </div>

    <div class="col-md-1 hr">
        <img src="<?=WEBDIR?>img/verticalbar.png" alt="" height="400px"/>
    </div>

        <div class="col-md-12">
            <div class="scrollbar" style="margin-top: 40px; height: 500px;overflow: auto;">
                <div class="col-md-18 row_rank" style="background-color: #e1e1e1;height: 90px;">
                    <div class="col-md-5"  style="margin-top: 3%;">
                        <h2>vos mutums :</h2>
                    </div>
                    <div class="col-md-13 credit_wallet" style="margin-top: 3%;text-align: right;">
                        <div class="col-md-16" style="  margin-top: 10px; padding: 0;">
                            <?php echo \Session::Me()->user_credit ?>
                        </div>
                        <div class="col-md-2">
                            <span><img src="<?=WEBDIR?>img/wallet/piecejaune.png" alt=""/></span>
                        </div>
                    </div>
                    <?php
                        $e = Session::Me()->getHistoryWithCat();
                        if(count($e)){
                    ?>
                        <div class="col-md-5">
                            opérations en cours :
                        </div>
                        <div class="col-md-13">
                            <div class="col-md-5">
                                <?php
                                    echo $e[0][1]->prod_name;
                                ?>
                            </div>
                            <div class="col-md-13" style="text-align: right;position: absolute;right: 0;">
                                <div class="col-md-15" style="  margin-top: 10px; padding: 0;">
                                    <?php
                                        echo $e[0][0]->move_amount;
                                    ?>
                                </div>
                                <div class="col-md-3">
                                    <span><img src="<?=WEBDIR?>img/wallet/piecejaune.png" alt=""/></span>
                                </div>
                            </div>
                        </div>
                    <?php }else{  ?>
                        <div class="col-md-18">

                        </div>
                    <?php } ?>
                </div>
                <?php foreach (\Session::Me()->getHistoryWithCat() as $elm) : ?>
                    <div class="col-md-18 row_rank">

                        <div class="col-md-3 col-md-offset-2" style="margin-top: 2%">
                            <span>
                                <?php echo date('d/m/Y', strtotime($elm[0]->move_date_creation)) ?>
                            </span>
                        </div>
                        <div class="col-md-3" style="margin-top: 2%;">
                            <span>
                                <?php echo $elm[2]->cata_name ?>
                            </span>
                        </div>
                        <div class="col-md-2 row_rank-img" style="margin-top: 1%;">
                            <span>
                                <?php echo $elm[1]->print_picture(30,'photo') ?>
                            </span>
                        </div>
                        <div class="col-md-7" style="margin-top:2%;">
                            <span>
                                <?php echo $elm[0]->move_type ?>
                            </span>
                        </div>
                        <div class="col-md-1" style="margin-top: 1%;">
                            <span style="font-size: 25px;float: right;"><?php echo $elm[0]->move_amount ?></span>
                        </div>
                        <div class="col-md-2" style="margin-top: 1%;    ">
                            <span><img src="<?=WEBDIR?>img/wallet/piecejaune.png" alt=""/></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div style="clear:both;"></div>
    <div class="col-md-18 title">
        <h1 style="margin: 10px;">acheter des mutums</h1>
    </div>
    <div class="col-md-18 gain">
        <div class="col-md-1"></div>
        <div class="col-md-3 money" style="margin-top: 165px;" id="money1">
        <img src="<?=WEBDIR?>img/wallet/pile-money-05.png" alt=""/><br />
            <div class="col-md-18 achat" >
                <a href="<?php echo WEBDIR ?>buy/offre-1">pack 50</a>
                <img src="<?= WEBDIR ?>img/wallet/pieceblanche.png" class="blanche" alt="" width="20" height="20"/>
            </div>
            <div class="col-md-18 prix" id="prix1">
                5€
            </div>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-3 money" style="margin-top: 12%" id="money2">
            <img src="<?=WEBDIR?>img/wallet/pile-money-04.png" alt="" style="  margin-left: 6%;"/><br />
            <div class="col-md-18 achat">
                <a href="<?php echo WEBDIR ?>buy/offre-2">pack 100</a>
                <img src="<?=WEBDIR?>img/wallet/pieceblanche.png" class="blanche" alt="" width="20" height="20"/>
            </div>
            <div class="col-md-18 prix" id="prix2" style="display: none;">
                10€
            </div>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-3 money" style="margin-top: 8%;" id="money3">
            <img src="<?=WEBDIR?>img/wallet/pile-money-03.png" alt=""/><br />
            <div class="col-md-18 achat">
                <a href="<?php echo WEBDIR ?>buy/offre-3">pack 200</a>
                <img src="<?=WEBDIR?>img/wallet/pieceblanche.png" class="blanche" alt="" width="20" height="20"/>
            </div>
            <div class="col-md-18 prix" id="prix3" style="display: none;">
                20€
            </div>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-4 money" style="margin-top: 5%;" id="money4">
            <img src="<?=WEBDIR?>img/wallet/pile-money-01.png" alt=""/><br />
            <div class="col-md-18 achat">
                <a href="<?php echo WEBDIR ?>buy/offre-4">pack 500</a>
                <img src="<?=WEBDIR?>img/wallet/pieceblanche.png" class="blanche" alt="" width="20" height="20"/>
            </div>
            <div class="col-md-18 prix" id="prix4" style="display: none;">
                50€
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>

</div>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
    $(document).ready(function() {
       $('#money1').mouseenter(function(){
           $('#prix1').slideToggle();
       });
       $('#money2').mouseenter(function(){
           $('#prix2').slideToggle();
       });
       $('#money3').mouseenter(function(){
           $('#prix3').slideToggle();
       });
       $('#money4').mouseenter(function(){
           $('#prix4').slideToggle();
       });
    });

    /*$(document).ready(function () {
        var s1 = [
            <?php foreach ($history as $elm) : ?>
            ['<?php echo $elm['cata_name']?>', <?php echo $elm['count'] ?>],
            <?php endforeach; ?>
        ];

        var plot = $.jqplot('jqplot', [s1], {
            title: ' ',
            seriesColors: ['#83ddda', '#00a2b0', '#edbe3a', '#90db83', '#00a2b0'],
            seriesDefaults: {
                shadow: false,
                renderer: jQuery.jqplot.DonutRenderer,
                rendererOptions: {
                    sliceMargin: 1,
                    showDataLabels: true,
                    dataLabels: 'label', //'percent'
                    dataLabelCenterOn: true
                }
            },
            legend: {
                show: true,
                location: 's'
            },
            grid: {
                background: '#f3f3f3',
                borderColor: '#f3f3f3',
                borderWidth: 0,
                shadow: false
            }

        });
    });*/

    $(function () {
        google.load("visualization", "1", {packages: ["corechart"], "callback": drawChart});
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Categorie', 'Mutum'],
                <?php foreach ($history as $elm) : ?>
                ['<?php echo $elm['cata_name']?>', <?php echo $elm['count'] ?>],
                <?php endforeach; ?>
            ]);

            var options = {
                title: '',
                pieHole: 0.5,
                tooltip: {text: 'percentage'},
                legend: {position: 'bottom', alignement: 'start', maxLines: 5},
                colors: ['#83ddda', '#00a2b0', '#edbe3a', '#90db83'],
                pieSliceText: 'none',
                width:316,
                height:300,
                backgroundColor: '#f3f3f3',
                chartArea:{left:30,top:50,width:'75%',height:'75%'}
            };

            var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
            chart.draw(data, options);
        }
    });

</script>


