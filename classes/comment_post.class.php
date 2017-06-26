<?php

class comment_post extends root{

  //Attributs
  public $comp_id;
  public $comp_text;
  public $comp_post_id;
  public $comp_user_id;
  
  
  public static $pref='comp_';
  
  //Fonctions
  
	public static function printCommentsFromPost($post_id){
		$tab = DB::SqlToObj(array('comment_post','user'),"select * from comment_post,user where comp_post_id='$post_id' and comp_user_id=user_id order by comp_id ASC");
		foreach($tab as $t)
		{
			$t[0]->setAttr('user_id',$t[1]);
		   $t[0]->printComment();
		}
		echo "<div class='col-md-15 col-md-offset-3 comment_form' id='comment_form_".$post_id."'>";
		echo "  <input type='text' class='comment_text' name='comment_text' id='comment_text_".$post_id."' placeholder='commentez ici'>";
		echo "  <input type='submit' name='comment_send' class='comment_send btn btnbluev2' id='comment_send_".$post_id."' value='Envoyer'>";
		echo "</div>";
	}
 
	public function printComment(){
		echo "<div class='col-md-15 col-md-offset-3 comment_post' id='comment_post_".$this->getAttr('id')."'>";
		echo $this->getAttr('user_id')->print_user('20');
		echo "<span style='padding-left:5px;' class='blue'>".$this->getAttr('user_id')->printName()."</span> : ";
		echo $this->getAttr('text');
		echo "</div>";
	}

};