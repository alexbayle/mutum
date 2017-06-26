<?php if (count($lastArticles) == 5):?> <div class="row col-md-18 lstBoxProduct"> <?php endif; ?>
	<?php foreach($lastArticles as $klastArticles => $art):?>
		<div class="boxProduct <?php if (count($lastArticles) == 3){echo "col-md-6";}?>" style="">
			<a class ="userProductRest" href="<?=WEBDIR."view/". $art->arti_prod_id ?>"><?= $art->print_picture('180','boxshadow');?></a>
		</div>
	<?php endforeach ?>
<?php if (count($lastArticles) == 5):?></div> <?php endif; ?>