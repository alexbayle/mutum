<?php
  $allow_communities = Site::getWidgetParams('allow_communities',true);
  $allow_contact = Site::getWidgetParams('allow_contact',true);
  $allow_user = Site::getWidgetParams('allow_user',true);
?>

  <div class='btn_limitation' id='btn_limitation'>
    <img src='<?=WEBDIR?>img/login_password.png' id='img_limitation' class='img_limitation'>
    <div class='menu_limitation' id='menu_limitation'>
    <?php
      if($allow_communities)
      {
        $communities = community::getAllMyCommunity();
        if(sizeof($communities)>0)
        {
          echo "Communautés:<br />";
          foreach($communities as $c)
          {
            echo "<div style='position:relative;'>" ;
            echo "  <input type='checkbox' id='community_".$c[0]->getAttr('id')."' name='community_".$c[0]->getAttr('id')."' value='1'>" ;
            echo "  <label class='box' for='community_".$c[0]->getAttr('id')."'></label>" ;
            echo "  <label style='margin-left:10px;' for='community_".$c[0]->getAttr('id')."'>" ;
            echo    $c[0]->getAttr('name') ;
            echo "  </label>" ;
            echo "</div>" ;
          }
          echo "<br />";
        }
      }

      if($allow_contact)
      {
        echo "Contacts:<br />";
        echo "<div style='position:relative;'>" ;
        echo "  <input type='checkbox' id='contact' name='contact' value='1'>" ;
        echo "  <label for='contact' class='box'></label>" ;
        echo "  <label for='contact' style='padding-top:10px;padding-left:15px;'>Limiter à mes contacts</label>" ;
        echo "</div>" ;
        echo "<br />";
      }
      
      
      if($allow_user)
      {
        echo "Utilisateurs:<br />";
        echo "<div style='position:relative;'>";
        echo "  <input type='text' name='limitation_user' id='limitation_user'>";
        echo "  <div id='user_suggest' class='s_a_cat_suggest'></div>";
        echo "</div>";
      }
    ?>
    </div>
    <input type='hidden' name='limitation_values' id='limitation_values' value=''>
  </div>
  
  <script>
    $(document).ready(function(){
      $('#img_limitation').click(function(e){
        $('#menu_limitation').toggle();
        e.stopPropagation();
      });
      
      $('#menu_limitation').click(function(e){
        e.stopPropagation();
      });
      
      $(document).click(function(){
        $('#menu_limitation').hide();
      });
      
      var xhr=false;
      var last_value='';

      function complete_user_limitation(){
        if(($(this).val()!='' && $(this).val()!=last_value))
        {
          if(xhr!=false)
          {
            xhr.abort();
            $('#user_suggest').hide();
          }
          xhr = $.post("<?=AJAXLOAD?>retrieve_suggest_user" ,{ name:$(this).val() } ,function(data){
            if(data!='\n')
            {
              $('#user_suggest').show();
              $('#user_suggest').html(data);
            }
            else
            {
              $('#user_suggest').hide();
            }
          });
        }
        last_value=$(this).val();
      }

      $('#limitation_user').focus(complete_user_limitation);
      $('#limitation_user').blur(complete_user_limitation);
      $('#limitation_user').keyup(complete_user_limitation);

      $('#user_suggest').on('click',function(e){
        var offset = $(this).offset();
        var relativeYPosition = (e.pageY - offset.top);
        
        var childNumber = parseInt(relativeYPosition / 16) + 1 ;
        var name = $('.returnSuggUser:nth-child(' + childNumber + ')').text() ;
        var tag = "<span class='userTag' style='color: red'>" + name + "</span>" ;
        $('#limitation_user').val(tag) ;
        $('#user_suggest').hide() ;
      });
      
      $('.userTag').on('click', function(){
        $('.userTag').hide() ;
      }) ;
    });
  </script>