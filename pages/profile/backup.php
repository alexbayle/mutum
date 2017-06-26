<?php 
//print_r($user);
print_r($user->getUserArticlePret(Session::Me()->GetAttr('id')));

//print_r(request::isAvailable($user_id));
//echo  Session::Me()->GetAttr('date_creation')."<br/>";


//print_r($user->getUserArticle(Session::Me()->GetAttr('id')));


//print_r(get_class_methods($user));
/*echo  Session::Me()->GetAttr('firstname')." ".Session::Me()->GetAttr('lastname')."<br/>";
echo  "Sexe : ".Session::Me()->GetAttr('sex')."<br/>";
echo  "Addresse : ".Session::Me()->GetAttr('address')." ".Session::Me()->GetAttr('zip')." ".Session::Me()->GetAttr('city');
echo  "<br/>";
echo "E-mail : ".Session::Me()->GetAttr('email')."<br/>";
echo  "Date de naissance : ".Session::Me()->GetAttr('birthdate')."<br/>";

echo  "Numero de telephone : ".Session::Me()->GetAttr('phone')."<br/>";
if(Session::Me()->GetAttr('phone_hide')==1)
{
	echo  "votre numéro de telephone n'est pas visible par les autres utilisateurs<br/>";
}else
	echo "Votre numéro de téléphone est publique<br/>";

echo  "Code de parainage : ".Session::Me()->GetAttr('sponsor_code')."<br/>";
echo  "Titre :".Session::Me()->GetAttr('title')."<br/>";

echo  "Nombre de mutum : ".Session::Me()->GetAttr('credit')."<br/>";
echo  "Classment : ".Session::Me()->GetAttr('rank')."<br/>";
echo  "Note : ".Session::Me()->GetAttr('notation')."<br/>";
echo  "Score : ".Session::Me()->GetAttr('score')."<br/>";

prin
*/?>
<h1>Mon profil</h1>

<!--form method='POST'>
<input type='submit' name='btneddit' value='éditer'>
</form-->
			<div class="row userAccountBanner">
				<div class="AccountBannerContent">
				
					<section class="col-md-4">
						<img src="img/bonhomme.png" alt="mutum" title="Mon profil Mutum"/>
					</section>
					<section class="col-md-4">
						<p class="userStatut"><strong><?php echo Session::Me()->GetAttr('title');?></strong></p>
						<span class="userLevel">niveau maximum</span>
						<p class="rsfollowTitle"><strong>Vos derniers succès</strong></p>

						<ul class="rsFollow">
							<li>et dolore magna aliqua. </li>
							<li>et dolore magna aliqua. </li>
							<li>et dolore magna aliqua. </li>
							<li>et dolore magna aliqua. </li>
							<li>et dolore magna aliqua. </li>
						</ul> 
					</section>
					<section class="col-md-8 col-md-offset-2 "><?php echo($user->printNote()); ?>
					
						<p class="userName"><?php echo Session::Me()->GetAttr('firstname')." ".Session::Me()->GetAttr('lastname')."<br/>";?></p>
						<p class="userData text-right" >ajouté le: <span class="labelUserInfo"><?php echo Session::Me()->GetAttr('date_creation');?></span></p>
						<p class="userData text-right" >adresse complète: <span class="labelUserInfo"><?php echo Session::Me()->GetAttr('address')." ".Session::Me()->GetAttr('zip')." ".Session::Me()->GetAttr('city'); ?></span></p>
						<p class="userData text-right" >email: <span class="labelUserInfo"><?php echo Session::Me()->GetAttr('email');?></span></p>
						


					</section>
				</div>
			</div>
            <div class="row rowUserProfile2">
				<div class="col-md-9" >
                    <div class=" mutumInfos row">
						<div class="mutumInfosContainer">
						<div class = "row col-md-18">
								<section class="col-md-9">
									<img src="img/pile_mutum.png" alt="mutum" title="Vos Mutums"/>
								</section>
								<section class="col-md-9">
									<div class="row">
										<p class="userStatut"><strong>Vos mutums</strong></p>
										<p><span class="nbMutums"><?php echo Session::Me()->GetAttr('credit'); ?></span><span style=""><img  class="mutum-icon" src="img/petit_mutum.png"/></span></p></br>
										<p> <button class="btn btn-success btn-lg">Tous vos mutums</button></p><br/>
									</div>
										
									<hr class="infoSeparator">
									<div class="row">
										<p class="mutumInfoTitle">Relevé de mutums</p>
										<ul class="">
											<li>et dolore magna aliqua.<span ><strong>-1260 </strong></span><img  class="mutum-icon" src="img/petit_mutum.png"/> </li>
											<li>et dolore magna aliqua.<span ><strong>-1260 </strong></span><img  class="mutum-icon" src="img/petit_mutum.png"/> </li>
											<li>et dolore magna aliqua.<span ><strong>-1260 </strong></span><img  class="mutum-icon" src="img/petit_mutum.png"/> </li>
										</ul>
									</div>
								</section>
						</div>
						</div>
                    </div>
                </div>
                <div class="col-md-9" >
                    <div class=" mutumInfosPret row">
						<div class="lastMutumActions">
							<div class = "row col-md-18">
								<div class="dernierPret col-md-18">
									<p class="labelDernierPret ">mon dernier pret</p>
									<p class="contenuDernierPret">Tefal crepes party</p>
									Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer euismod vitae eros quis elementum.
									Maecenas convallis, augue sit amet porta luctus, elit velit accumsan turpis, vel blandit quam lacus et dui.
									Ut ultrices gravida nulla, at pharetra nunc gravida sit amet. Suspendisse luctus porttitor dolor ac bibendum. 
									Aliquam erat volutpat.
								</div>

								<div class="col-md-18">
									<hr class="infoLastInfo ">
								</div>
								<div class=" dernierEmprunt col-md-18  ">
									<p class="labeldernierEmprunt"> mon dernier emprunt</p>
									<p class="contenuDernierPret">Tefal crepes party</p>
									 Nullam scelerisque lorem et lorem ornare, id consequat leo aliquam. Phasellus a ultricies enim,
									at placerat sem. Praesent mattis lectus sit amet libero porta auctor. Vestibulum lobortis lectus eget mauris tincidunt,
									quis condimentum mi luctus.
								</div>
							</div>
						</div>
                    </div>
                </div>
			</div>
			<div class="row rowUserProfile3">
			    <div class="col-md-9" >
                    <div class="row mutumInfos">
						<div class="lastMutumActions">

								<div class="dernierPret">
									<div class="row ">
										<div class="col-md-18">
											<p class="labelDernierPret ">mes objets</p>								
											<p class="">Vous avez encore <?php echo count($user->getUserArticlePret(Session::Me()->GetAttr('id')));?> objet(s) à échanger</p>
										</div>
									</div>

									<div class="row">
										<div >
											<?php foreach( $user->getUserArticlePret(Session::Me()->GetAttr('id')) as $key=>$value): ?>
												<a class="userProductRest col-md-2" href="">
												<img src="img/<?php echo $value->arti_pictures;?>" alt="<?php echo $value->prod_name;?>" title="<?php echo $value->prod_desc;?>"/>
												</a>
												<p class="contenuDernierPret"><?php print_r($value->prod_name); ?></p>
												<?php print_r($value->prod_desc); ?>
											<?php endforeach ?>
										</div>
									</div>
									<hr class="infoLastInfo">
									<div class="row ">
										<div class="col-md-8 col-md-offset-1" >voir mes objets</div>
										<button class="btn col-md-8 col-md-offset-1" href="">voir mes objets</button>
									</div>
								</div>

						</div>
                    </div>
                </div>
			

			</div>

