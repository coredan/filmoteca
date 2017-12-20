<?php
	/* @var $this SiteController */

	$this->pageTitle=Yii::app()->name;
	$this->breadcrumbs=array(
		'Películas',
	);
?>
<div class="colpanel-title">
		Listado de películas
	</div>
<div class="colpanel6x6 col-md-12 col-sm-12 col-xs-12">
	<?php foreach ($filmMods as $filmMod) { 
		//list($folder, $fileNm) = explode(":", $filmMod->image, 2);
	?>
		<div class="panel-cell col-lg-2 col-md-3 col-sm-3 col-xs-4">			
			<a href="/films/item/<?php echo $filmMod->id; ?>">
				<?php echo cl_image_tag($filmMod->image, array(
					"width" => 98, 
					"height" => 140, 
					"crop" => "fill", 					
					"quality" => "auto",
					"data-toggle" => "popover",
					"data-popover-content" => "#popover_content_".$filmMod->id										
				)); ?>
			</a>
			<div id="popover_content_<?php echo $filmMod->id ?>" class="popover-place hidden">
				<div class="arrow"></div><h3 class="popover-header"><i class="fa fa-film" aria-hidden="true"></i> <?php echo $filmMod->title." (".$filmMod->year.")"; ?></h3>
				<div class="popover-body">
					<?php echo Yii::app()->CustomHelper->cutText($filmMod->synopsis, 200); ?>
					<hr />					
					<?php 
					$genres = $filmMod->genres;					
					foreach ($genres as $genre) { ?>
						<span class="bubble"><?= $genre->name; ?></span>
					<?php } ?>
				</div>
			</div>
		</div>	
	<?php } ?>	
</div>
