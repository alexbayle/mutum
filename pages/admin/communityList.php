<div class="row2">
    <div class="col-md-18 title">
        <h1>liste des communautés</h1>
    </div>
    <div class="col-md-18 ranking">
        <h2>rechercher une communautée :</h2>
        <div class="col-md-18" style="padding: 0;">
            <!--<form action="" method="get"> La recherche en Jqery c'est mieux-->
                <div class="col-md-9 searchcom">
                    <input type="search" id="com_search" name="search_community"  value="<?php echo $search_community;?>" placeholder="rechercher..."/>
                </div>
                <div class="search_com">
                    <input id="validerRecherche" type="button" value="ok !" style="padding: 0;margin-top: 10px;"/>
                </div>
            <!--</form>-->
        </div>
        <h2>selectionnez vos communautés :</h2>
        <form action="" method='POST' id="form1" >
            <div class="col-md-18 rank">
                <div class="scrollbar" style="margin-top: 40px; height: 500px;overflow: auto;">
                    <div class="col-md-18" id="debutTab">
                        <div class="col-md-4 item">
                            <span>nom</span>
                        </div>
                        <div class="col-md-5 item">
                            <span>description</span>
                        </div>
                        <div class="col-md-3 item">
                            <span>adresse</span>
                        </div>
                        <div class="col-md-3 item">
                            <span>utilisateurs</span>
                        </div>
                        <div class="col-md-3 item">
                            <span>objets</span>
                        </div>
                    </div>
                    <div id="debutTab2" style="display: none">
                        <span>Votre recherche n'a abouti à aucun résultat</span>
                    </div>
                    <div class="col-md-18" id="liste" style="padding: 0;display: block;">
                        <?php foreach (community::getAll() as $offset => $community) : ?>
                            <div class="col-md-18 row_rank" id="row_rank_<?php echo $community['comm_id'] ?>" >
                                <div class="col-md-4" style="margin-top: 1%;margin-bottom: 1%;">
                                    <input type="checkbox" class="check" id="community-<?php echo $offset ?>" name="community[]" value="<?php echo $community['comm_id'] ?>"
                                        <?php echo in_array($community['comm_id'], Session::Me()->getMyCommunityIds()) ? ' checked' : '' ?>>
                                    <label for="community-<?php echo $offset ?>" class="roundbox"></label>
                                    <label for="community-<?php echo $offset ?>" style="margin-left: 20px;"><?php echo $community['comm_name'] ?></label>
                                </div>
                                <div class="col-md-5" style="margin-top: 1%;margin-bottom: 1%;">
                                    <span><?php echo $community['comm_desc'] ?></span>
                                </div>
                                <div class="col-md-4" style="margin-top: 1%;margin-bottom: 1%;">
                                    <span><?php echo address::getAddressById($community['comm_address']) ?></span>
                                </div>
                                <div class="col-md-2" style="margin-top: 1%;margin-bottom: 1%;">
                                    <span><?php echo community::getTotalNumberByComm($community['comm_id'])?></span>
                                </div>
                                <div class="col-md-2" style="margin-top: 1%;margin-bottom: 1%;">
                                    <span><?=community::getTotalObjByComm($community['comm_id'])?></span>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
                <div class="valid">
                    <input type="submit" class="btnvalid">
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $(".row_rank").click(function(){
            var id = $(this).prop('id').replace('row_rank_','');
            //console.log(id);
            if(!$('#community-'+(id - 1)).prop("checked")){
                $('#community-'+(id - 1)).prop('checked', true);
                $('#row_rank_'+id).addClass('bgblue');
            }else{
                $('#community-'+(id - 1)).prop('checked', false);
                $('#row_rank_'+id).removeClass('bgblue');
            }
        });

        function hideall(){
            $('#liste_search').hide();
            $('#liste').hide();
        }

        var searchResult = $('#com_search').val();
        console.log(searchResult);
        if(searchResult == '') {
            hideall();
            $('#liste').show();
        } else {
            hideall();
            $('#liste_search').show();
        }
/*

        $(".row_rank_search").click(function(){
            //var id = $(this).prop('id').replace('row_rank_search_','');

            var checkbox = $(this).children().children('.check');
            var selectedBox = $(this);


            //console.log('#com-'+(id - 1));
            //console.log('#row_rank_search'+id);

            if(!checkbox.prop('checked')){
                checkbox.prop('checked', true);
                selectedBox.addClass('bgblue');
            }else{
                checkbox.prop('checked', false);
                selectedBox.removeClass('bgblue');
            }
        });*/



        /**Fonction de recherche **/

        $('#com_search').change(function(){
            recherche();
        });
        //quand on appuie sur ok, c'est pas forcément utile vu que y a un change au dessus mais bon on sait jamais
        $('#validerRecherche').click(function(){
            recherche();
        });

        function recherche(){
                var motRecherche = $('#com_search').val().toLowerCase();
                var compteur = 0;
                $('label').each(function( index ) {
                    if($( this ).html().toLowerCase().indexOf(motRecherche) == -1)
                        $( this).parent().parent().hide();
                    else {
                        $(this).parent().parent().show();
                        compteur++;
                    }
                });
                if(compteur>0) {
                    $('#debutTab').show();
                    $('#debutTab2').hide();
                }
                else {
                    $('#debutTab2').show();
                    $('#debutTab').hide();
                }
            }



    });
</script>