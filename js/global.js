$(document).ready(function(){


  /*$('#btnlogin').mouseover(function(){
   $('#login_lock_img').attr('src','login_lock_hover.png');
   });

   $('#btnlogin').mouseout(function(){
   $('#login_lock_img').attr('src','login_lock.png');
   });*/

  $('#cell_menu').mouseenter(function(){
    $('#menu_user').show();
  });

  $('#menu_user').mouseleave(function(){
    $('#menu_user').hide();
  });



  $('#btnlogin').mouseenter(function(){
    $('#menu_login').show();
    $('#btnlogin').css('background','#8AD3D9');
    $('#btnlogin').css('color','white');
    $('#login_lock_img').attr('src','img/login_lock_hover.png');
  });

  $('#detect_menu_login').mouseleave(function(){
    $('#menu_login').hide();
    $('#btnlogin').css('background','white');
    $('#btnlogin').css('color','#8AD3D9');
    $('#login_lock_img').attr('src','img/login_lock.png');
  });

  /* *********************
   ****** Easter Eggs *****
   ***********************/

  //Phrase du Logo
  var nb_rotate=0;
  var nb_too_much=0;
  var timer=false;
  $('.header_logo').on('mouseenter',function(){
    timer = setTimeout(function(){
      nb_rotate++;
      if(nb_rotate=='5')
      {
        nb_too_much++;
        if(nb_too_much==1)
        {
          var text = "Héééé, arrête j’ai le tournis !";
        }
        else if(nb_too_much==2)
        {
          var text = "Ah ouais, tu veux jouer à ça ?";
        }
        else if(nb_too_much==3)
        {
          var text = "Ok, tu l’auras voulu !";
        }
        $('#identity').append("<div id='easter_egg_1' class='easter_egg_1'>"+text+"</div>");
        if(nb_too_much==3)
        {
          $('#header_logo').removeClass('header_logo');


          $('.footer').fadeOut(6000,function(){
            $('.footer').css('display','block');
            $('.footer').css('visibility','hidden');
          });

          setTimeout(function(){
            $("#easter_egg_1").html("Ça y est, ça commence…");
            $('.content').fadeOut(6000,function(){
              $('.content').css('display','block');
              $('.content').css('visibility','hidden');
            });
          },6000);


          setTimeout(function(){
            $("#easter_egg_1").html("Tu ne pourras plus aller sur mutum…");
            $('.cover').fadeOut(5000,function(){
              $('.cover').css('display','block');
              $('.cover').css('visibility','hidden');
            });
          },12000);

          setTimeout(function(){
            $("#easter_egg_1").html("Tu seras… BANNI(E).");
            $('.menu').fadeOut(7000,function(){
              $('.menu').css('display','block');
              $('.menu').css('visibility','hidden');
            });
          },17000);
          setTimeout(function(){
            $("#easter_egg_1").html("Mouahahahah !!");
          },24000);
          easterEgg(1);
        }
        else
        {
          nb_rotate=0;
          setTimeout(function(){$('#easter_egg_1').fadeOut('slow',function(){
            $('#easter_egg_1').remove();
          });},4000);
        }
      }
    },2000);
  });

  $('.header_logo').on('mouseleave',function(){
    clearTimeout(timer);
  });




  //Code Konami
  if ( window.addEventListener ) {
    var kkeys = [], konami = "38,38,40,40,37,39,37,39,66,65";
    window.addEventListener("keydown", function(e){
      kkeys.push( e.keyCode );
      if ( kkeys.toString().indexOf( konami ) >= 0 ) {
        easterEgg(2);
      }
    }, true);
  }



  //CAROUSSEL BY Thibault Brocheton
  //nb_move correspond au déplacement à réaliser (considérer la taille d'un slide, et le padding du container)
  //nb_slide correspond au nombre de slides - 1 !!
  //current correspond au slide de départ (de 0 à nb_slide)
  //time_automove correspond au temps entre deux mouvements automatiques, en ms
  //Div nécessaires: slide_contain, slide_moving
  //ID nécessaires: slide_moving, slide_left, slide_right

  /*
   var nb_move = 250;
   var nb_slide = 3;
   var current = 0;
   var time_automove = 4000;
   var timer=false;

   function clear_timer(){
   if(timer!=false)
   {
   clearInterval(timer);
   }
   timer = setInterval(function(){ move(-1) }, time_automove);
   }

   function move(nb){
   if(nb<0 && current==-nb_slide)
   current=0;
   else if(nb>0 && current==0)
   current=-nb_slide;
   else
   current+=nb;
   $('#slide_moving').css('margin-left',current*nb_move);
   }

   $('#slide_right').on('click',function(){
   clear_timer();
   move(-1);
   });
   $('#slide_left').on('click',function(){
   clear_timer();
   move(1);
   });

   clear_timer();

   */

});


function easterEgg(easterEggIndex){
  if($("#message_success").html() != "")
    $("#message_success").append("<h3>Easter Egg Découvert !</h3>").css('height','+=40').delay(4000).fadeOut();
  else
    $("#message_success").show().append("<h3>Easter Egg Découvert !</h3><div style='clear: both'></div>").delay(8000).fadeOut();
  $.post(
      "/js/ajax/loader.php?fonction=easterEgg",
      {easterEggIndex : easterEggIndex},
      function(data){
        //console.log(data);
      }
  );
}


//*********************************************************************************//
//***********             FONCTION PAGES SLIDER               **********************//
//*********************************************************************************//



function initSlider(tableauParties){

    var nbParties = tableauParties.length;

    for(var i=0;i<nbParties;i++){
        if(i==0) $('#slider').append('<span class="sliderCategorie btnbluev2 active" id="slide'+i+'" style="margin-left: '+$('.slider').width()*40/100+'px;">'+tableauParties[i]+'</span>');
        else  $('#slider').append('<span class="sliderCategorie" id="slide'+i+'">'+tableauParties[i]+'</span>');
    }

    $('#sliderLeft').hide();
    $('.sliderPage').hide();
    $('.page_slide0').show();

    //Animation vers la gauche
    $('#sliderRight').click(function(){
        var section = $('.active');
        $('#slide0').animate({'margin-left' :  '-='+($('.active').width()+30)+'px'},1000);//vers la gauche
        section.next().addClass('btnbluev2 active');
        section.removeClass('btnbluev2 active');
        if($('.active').attr('id') == 'slide'+(nbParties-1))  $('#sliderRight').hide();
        else $('#sliderRight').show();
        $('#sliderLeft').show();
        $('#sliderLeft').show();
        $('.sliderPage').hide();
        $('.page_'+$('.active').attr('id')).fadeIn(1000);
    });

    //Animation vers la droite
    $('#sliderLeft').click(function(){
        var section = $('.active');
        $('#slide0').animate({'margin-left' :  '+='+($('.active').width()+30)+'px'},1000);//vers la droite
        section.prev().addClass('btnbluev2 active');
        section.removeClass('btnbluev2 active');
        if($('.active').attr('id') == 'slide0')  $('#sliderLeft').hide();
        else $('#sliderLeft').show();
        $('#sliderRight').show();
        $('.sliderPage').hide();
        $('.page_'+$('.active').attr('id')).fadeIn(1000);
    });
}
