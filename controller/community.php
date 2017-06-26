<?php
if(Session::Online() == true ) {

	$display_default = true;

	//Récupération des variables URL
	@$module = $_GET['module'];
	@$action = $_GET['action'];
	
    //Récuperations des actions

    @$publier = Site::obtain_post('publier');

    @$add_wish = Site::obtain_post('community_wish');

    if($add_wish){
        $error = false;
        $obj_wish = Site::obtain_post('obj_wish');
        $cat_wish = Site::obtain_post('cat_wish');
        $date_wish = Site::obtain_post('date_wish');
        $communities_wish = Site::obtain_post('communities_wish');
        $tab_lim_comm = array();

        if(!$obj_wish || $obj_wish == '')
        {
            Site::message_info('veuillez entrer le nom de l\'objet recherché','ERROR');
            $error = true;
        }

        if(!$cat_wish || $cat_wish == '')
        {
            Site::message_info('veuillez entrer le nom de l\'objet recherché','ERROR');
            $error = true;
        }

        if(!$date_wish || $date_wish == '')
        {
            Site::message_info('veuillez entrer une date','ERROR');
            $error = true;
        }

        if($communities_wish || $communities_wish == ''){
            $tab_lim_comm = explode(',',$communities_wish);
        }
        else {
            $error = true;
            Site::message_info('veuillez choisir une communauté','ERROR');
        }


        if(!$error)
        {
            $wishlist = new wishlist();
            $virtuArticle = new virtual_article();

            $wishlist->post_user_id = Session::Me()->getAttr('id');
            $wishlist->post_text = $obj_wish;
            $wishlist->post_cat = 1;
            $wishlist->post_date_creation  = Site::now();
            $wishlist->post_deleted = 0;


            $virtuArticle->virp_name = $obj_wish;
            $virtuArticle->vira_cat = 1;
            $insertVirpId = $virtuArticle->Insert();
            //var_dump($virtuArticle);


            $wishlist->wish_virp_id = $insertVirpId;
            $wishlist->wish_address = address::getAddressById(Session::Me()->getAttr('address'));
            $wishlist->wish_date = $date_wish;
            $wishlist->wish_desc = $obj_wish;
            $wishlistId = $wishlist->Insert();
            //var_dump($wishlist);

            foreach ($tab_lim_comm as $community) {
                $community = \community::getById($community);
                //var_dump($community);
                $limitation = new \limitation();
                $limitation->limi_post_id = $wishlistId;
                $limitation->limi_id = $limitation->Insert();
                //var_dump($limitation);
                $limitationField = new \limitation_field();
                $limitationField->limf_table_id = $community[0][0]->getAttr('id');
                $limitationField->limf_type = 2;
                $limitationField->limf_limi_id = $limitation->limi_id;
                //var_dump($limitationField);
                $limitationId = $limitationField->Insert();
            }



        }
        else{
            Site::message_info('erreur','ERROR');
        }
    }


    if($publier != '')
	 {
		 $error = false;
		 
        $publication = Site::obtain_post('commentaire');
        if($publication== '')
		  {
            Site::message_info('le texte est vide.','ERROR');
				$error = true;
        }
         if(!$comm=Site::obtain_post('communities_new_post'))
         {
             Site::message_info('veuillez sélectionner au moins une communauté','ERROR');
             $error = true;
         }


        if(!$error)
        {

            $post = new post();
            $post->setAttr('text',$publication);
            $post->setAttr('cat',9);
            $post->setAttr('date_creation',Site::now());
            $post->setAttr('user_id',Session::Me()->getAttr('id'));
            $post->setAttr('deleted',0);
            //$post->setAttr('limitation',$limi_id);

            $postId = $post->Insert();

            $tab_lim_comm = explode(',',$comm);//array(3); // id de la communauté dans laquelle poster le msg < à dynamiser

            foreach ($tab_lim_comm as $community) {
                $community = \community::getById($community);
                $limitation = new \limitation();
                $limitation->limi_post_id = $postId;
                $limitation->limi_id = $limitation->Insert();

                $limitationField = new \limitation_field();
                $limitationField->limf_table_id = $community[0][0]->getAttr('id');
                $limitationField->limf_type = 2;
                $limitationField->limf_limi_id = $limitation->limi_id;
                //var_dump($limitationField);
                $limitationField->Insert();
            }

        }
        else{
            Site::message_info('erreur','ERROR');
        }
    }
	 
	if($module=='fildactu')
	{
		if($action=='reload')
		{
			$name = Site::obtain_post('name');
			$listecomm = Site::obtain_post('listecomm');
			community::printFilDactu($listecomm,$name,10,0);

			$display_default = false;
		}
	}
	 
	if($module=='like')
	{
		if($action=='')
		{
			echo "error";
		}
		else
		{
			if(post::checkAllowed($action))
			{
				$post = new post();
				$post->setAttr("id",$action);
				$like = $post->switchlike();
				if($like=='like')
					echo "dislike (".$post->nblike().")";
				else
					echo "j'aime (".$post->nblike().")";
			}
			else
			{
				echo "error";
			}
		}
		$display_default = false;
	}
	
	if($module=='favorite')
	{
		if($action=='')
		{
			echo "error";
		}
		else
		{
			if(post::checkAllowed($action))
			{
				$post = new post();
				$post->setAttr("id",$action);
				$post->switchfavorite();
				echo $post->printFavorite();
			}
			else
			{
				echo "error";
			}
		}
		$display_default = false;
	}
	
	if($module=='comment')
	{
		if($action=='show')
		{
			$post_id = Site::obtain_post('post_id');
			if(post::checkAllowed($post_id))
			{
				comment_post::printCommentsFromPost($post_id);
			}
			$display_default = false;
		}
		elseif($action=='send')
		{
			$post_id = Site::obtain_post('post_id');
			$text = Site::obtain_post('text');
			/* TODO : gestion erreurs (renvoyer echo error) */
			$comment = new comment_post();
			$comment->setAttr('text',$text);
			$comment->setAttr('user_id',Session::Me()->getAttr('id'));
			$comment->setAttr('post_id',$post_id);
			$comment->Insert();
			
			$comment->setAttr('user_id',Session::Me());
			$comment->printComment();
			
			$display_default = false;
		}
	}

	if($display_default)
	{
	  include(Site::include_view('community'));
	}


}
else {

    Site::message_info('cette page requiert la connexion à un compte','ERROR');
    Site::setNextUrl();
    Site::redirect(WEBDIR.'login');
    exit();
}
?>