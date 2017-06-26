<div style='width:300px;float:left;'>
  <center>
    <div class=''><div id='nb_mutum'>0</div> mutum</div>
    <img src='img/logo.png' id='logo_click' style='margin-top:0px;transition:all linear 60ms;width:200px'>
  </center>
</div>
<div style='width:300px;float:left;'>
  <div  style='float:left;' >Auto-Click : </div><div id='nb_buy_autoclick' style='float:left;' > 0 </div><div  style='float:left;' > acheté </div><button type='button' style='margin-left:5px;float:left;' id='buy_autoclick'>Acheter</button><div style='margin-left:5px;float:left;' id='info_autoclick'></div><div  style='margin-left:5px;float:left;'> mutum ( donne 1 par seconde)</div>
</div>

<script>
$(document).ready(function(){
  var nb_buy_autoclick = 0;
  var price_autoclick = 10;
  var nb_mutum = 0;
  var nb_second_mutum=0;
  
  $('#info_autoclick').text(price_autoclick);
  
  setInterval(function(){
    nb_mutum+=nb_second_mutum;
    $('#nb_mutum').text(nb_mutum);
  },1000);
  
  $('#buy_autoclick').click(function(){
    if(nb_mutum>=price_autoclick)
    {
      nb_mutum-=price_autoclick;
      $('#nb_mutum').text(nb_mutum);
      nb_buy_autoclick++
      $('#nb_buy_autoclick').text(nb_buy_autoclick);
      nb_second_mutum++;
      price_autoclick = price_autoclick*2;
      $('#info_autoclick').text(price_autoclick);
    }
  });
  
  $('#logo_click').click(function(){
    $(this).css('width',180);
    $(this).css('marginTop',10);
    nb_mutum++;
    $('#nb_mutum').text(nb_mutum);
    setTimeout(function(){
      $('#logo_click').css('width',200);
      $('#logo_click').css('marginTop',0);
    },60);
  });
  


});
</script>