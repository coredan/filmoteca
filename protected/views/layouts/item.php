<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div clas="row">
	<div class="col-lg-9 col-md-12 col-sm-12">
		<div class="container-fluid">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>

	<div class="col-lg-3 col-md-12 col-sm-12 last">
		<div id="sidebar">
			<?php $this->widget('SearchPanel'); ?>
		</div><!-- sidebar -->
	</div>
</div>
<?php $this->endContent(); ?>