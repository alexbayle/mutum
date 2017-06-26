
<?php foreach ($pages as $kPage=>$page): ?>		
			<div class="pageProducts col-md-18 " >
				<div class=""><h3>Page <?php echo " <span class='userData'>".($kPage+1)."</span> / ".count($pages); ?></h3></div>				
				<?php foreach( $page as $art): ?>
					<div class="col-md-18 divProduct" >
						<div class="col-md-2 row imgProduct">
							<a class ="userProductRest" href="<?=WEBDIR."view/". $art->arti_prod_id ?>"><?= $art->print_picture('100%');?></a>
						</div>
						<div class="col-md-10 productData">
							<p class="userData">
								<a class="blue" href="<?=WEBDIR."view/". $art->arti_prod_id ?>"><?= $art->getAttr('name') ?>
								</a>
							</p><span class="moyUser"><?=article::getNoteMoy($art->arti_prod_id );?></span>
							<!--p class="labelUserInfo userData"><?//= $art->getAttr('notation')?>/5</p-->
						

							<p><?= $art->getAttr('desc') ?></p>
	
							<a class="btn btnViewProduct col-md-4 col-xs-18 pull-right" href="<?=WEBDIR."view/". $art->arti_prod_id ?>">Voir l'objet</a>
						</div>
						<div class='orange mutumByDay col-md-6 '>
							<span><?=$art->getMutumByDay();?></span>
							<img alt='number_mutum' src='<?=WEBDIR?>/img/search_mutum_day.png' style='width:30px;'>
							<span>/ jour</span>
						</div>
						<br/>

					</div>
				<?php endforeach ?>
			</div>
		<?php endforeach ?>
		