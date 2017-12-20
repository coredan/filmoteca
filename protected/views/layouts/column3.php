<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<?php $this->widget('PhotoSlider'); ?>
<div clas="row">
	<div class="sidecol col-lg-3 col-md-3 col-sm-12 col-xs-12">
		<div class="sidebar">
			<?php $this->widget('SearchPanel'); ?>
		</div><!-- sidebar -->
	</div>
	<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
		<div id="content">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
	<div class="sidecol col-lg-2 col-md-2 col-sm-12 col-xs-12 last">
		<div class="sidebar">	
		
		</div><!-- sidebar -->
	</div>
</div>
<?php $this->endContent(); ?>