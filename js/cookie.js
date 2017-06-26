function pos_ok(position)
{
    var my_location = position.coords.latitude + ' ' + position.coords.longitude;
    $.cookie('my_location',my_location);
    document.getElementById('location_search').value = my_location;
}

function pos_ko(msg)
{
    $.cookie('my_location',' ');
}

$(document).ready(function(){

    if($.cookie('cookie_bar') === undefined) {

        $('body').append('<div class="cookie_bar" id="cookie_bar">  En poursuivant votre navigation sur ce site, vous acceptez l\'utilisation de Cookies pour vous proposer des objets proches de chez vous et réaliser des statistiques de visites. <a href="/page/terms#cookie">En savoir plus.</a>  <div class="btn btn-primary cookie_btn" id="cookie_btn">Ok</div></div>');
        $('#cookie_btn').click(function(e){
            e.preventDefault();
            $.cookie('cookie_bar',"viewed",{ expires: 365 , path:'/'});
            $('#cookie_bar').fadeOut();
        });

    }
    /*
     if($.cookie('my_location') === undefined) {
     if (navigator.geolocation)
     {
     navigator.geolocation.getCurrentPosition(pos_ok, pos_ko);
     }
     }*/



});