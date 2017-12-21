<?php
/* @var $this FilmsController */
/* @var $model Films */
/* @var $form CActiveForm */
?>
<div class="panel panel-default panel-dark" style="max-width: 800px; margin-left: auto; margin-right: auto;">
  <div class="panel-heading">
    <p class="panel-title"><i class="fa fa-search" aria-hidden="true"></i> Nueva Película</p>
  </div>
  <div class="panel-body">
	<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'newfilmForm',
		'htmlOptions'=>array(
			'name'=>"newfilmForm",
			'enctype'=>'multipart/form-data',        	
    	),
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// See class documentation of CActiveForm for details on this,
		// you need to use the performAjaxValidation()-method described there.
		'enableAjaxValidation'=>false,
	)); ?>	    


		<p class="note">Fields with <span class="required">*</span> are required.</p>

		<?php echo $form->errorSummary($model); ?>

		<div class="row">
			<div class="col-md-6">
				<?php echo $form->labelEx($model,'title'); ?>
				<?php echo $form->textField($model,'title', array("class"=>"form-control", "placeholder"=>"Title in english")); ?>
				<?php echo $form->error($model,'title'); ?>		
			</div>
			<div class="col-md-6">
				<?php echo $form->labelEx($model,'title_es'); ?>
				<?php echo $form->textField($model,'title_es', array("class"=>"form-control", "placeholder"=>"Título en castellano")); ?>
				<?php echo $form->error($model,'title_es'); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<?php echo $form->labelEx($model,'year'); ?>
				<?php echo $form->textField($model,'year', array("class"=>"form-control", "placeholder"=>"Year when the film was released (premiere)")); ?>
				<?php echo $form->error($model,'year'); ?>
			</div>
			<div class="col-md-6">
				<?php echo $form->labelEx($model,'country'); ?>
				<select name="Films[country_id]" class="form-control">
					<option value="">Seleccione un país</option>
				<?php foreach ($countriesMod as $countryMod) { ?>
					<option value="<?php echo $countryMod->id; ?>"><?php echo $countryMod->country_name_es; ?></option>
				<?php } ?>
				</select>				

				<?php echo $form->error($model,'country'); ?>
			</div>
		</div>
		<div class="row">			
			<div class="col-md-6">
				<?php echo $form->labelEx($model,'director'); ?>
				<?php echo $form->textField($model,'director', array("class"=>"form-control")); ?>
				<?php echo $form->error($model,'director'); ?>
			</div>
			<div class="col-md-6">
				<?php echo $form->labelEx($model,'casting'); ?>
				<?php echo $form->textField($model,'casting', array("class"=>"form-control")); ?>
				<?php echo $form->error($model,'casting'); ?>
			</div>
		</div>		
		<div class="row">
			<div class="col-md-6">
				<?php echo $form->labelEx($model,'nota'); ?>
				<?php echo $form->textField($model,'nota', array("class"=>"form-control", "placeholder"=>"Internal rate")); ?>
				<?php echo $form->error($model,'nota'); ?>
			</div>
			<div class="col-md-6">
				<?php echo $form->labelEx($model,'imdb_code'); ?>
				<?php echo $form->textField($model,'imdb_code', array("class"=>"form-control", "placeholder"=>"IMDB Code")); ?>
				<?php echo $form->error($model,'imdb_code'); ?>
			</div>
		</div>		
		<div class="row">
			<?php echo $form->labelEx($model,'synopsis'); ?>
			<?php echo $form->textField($model,'synopsis', array("class"=>"form-control", "placeholder"=>"Description of the film's argument")); ?>
			<?php echo $form->error($model,'synopsis'); ?>
		</div>
		<div class="row">
			<label for="" class="required">Genres:</label>
			<ul>
			<?php foreach ($gBaseMods as $gBaseMod) { ?>
	          <li>
	              <input type="checkbox" name="Films[genres][]" value="gen_<?php echo $gBaseMod->id ?>" id="gen_<?php echo $gBaseMod->id; ?>"> 
	              <label for="gen_<?php echo $gBaseMod->id; ?>"><?php echo $gBaseMod->name; ?></label>
	          </li>
	        <?php }?>
	    	</ul>			
			<?php echo $form->error($model,'image'); ?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($model,'image'); ?>
			<input type="file" name="image" class="form-control" placeholder="Original film's cover">
			<small class="form-text text-muted">Accepted files: png, jpg, jpeg</small>
			<?php echo $form->error($model,'image'); ?>
		</div>
		<div class="row">				
			<?php echo $form->labelEx($model,'trailer'); ?>
			<?php echo $form->textField($model,'trailer', array("class"=>"form-control")); ?>
			<small class="form-text text-muted">Accepted plattform: Youtube</small>
			<?php echo $form->error($model,'trailer'); ?>
		</div>		

		<hr />
		<h3>Links</h3>
		<div class="row">
			<label for="" class="required">Enlaces Online</label>
			<div class="row">
				<div class="col-md-11" style="padding-left:0;">
					<input type="text" class="form-control" placerholder="Operative link" id="online_link" >				
				</div>
				<div class="col-md-1" style="padding:2px 0;">
					<button type="button" class="btn btn-green" style="width: 100%" id="addLinkButton" disabled>+</button>			
				</div>
			</div>
			<div class="row links-place">
				<ul id="linksList">
				</ul>
			</div>
		</div>
		<div class="row">
			<label for="Torrents_link" class="required" placerholder="Can add multiple files">Torrents</label>
			<input type="file" class="form-control" name="torrentFiles[]" accept=".torrent" multiple>			
			<small id="emailHelp" class="form-text text-muted">You can add multiple files together.</small>
		</div>		
		<div class="row buttons">
			<button type="submit" id="saveFilmButton" class="btn btn-success" pull-center><i class="fa fa-spinner faa-spin animated hidden"></i> <span>Save</span></button>
			<?php //ho CHtml::submitButton('Submit'); ?>
		</div>

	<?php $this->endWidget(); ?>

	</div><!-- form -->
  </div>
</div>