<div>
	<?php foreach($lastArticles as $klastArticles => $art):?>
		<div class="boxProduct col-md-6">
			<a class ="userProductRest" href="<?=WEBDIR."view/". $art->arti_prod_id ?>"><?= $art->print_picture('100%');?></a>
		</div>
	<?php endforeach ?>
</div>