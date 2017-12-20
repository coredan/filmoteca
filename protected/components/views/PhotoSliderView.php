<fieldset>
    <legend>Últimas Películas:</legend>
  <div class="wipe_slider">
      <div class="newfilms_slider">
        <?php foreach ($this->filmsMod as $filmMod) { ?>
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
  </div>
</fieldset>    