<?php 

?>
<div class="tab-title"><i class="fa fa-star" aria-hidden="true"></i> MEJOR VALORADAS</div>
    <div class="colpanel6x6 col-md-12 col-sm-12 col-xs-12">
        <?php foreach ($bestRatedFilmsMod as $item) : ?>
            <div class="panel-cell col-lg-4 col-md-4 col-sm-3 col-xs-2 center-block">
                    <a href="/films/item/<?php echo $item->id; ?>">
                        <?php  echo cl_image_tag( $item->image, array(
                            "width" => 54,
                            "height" => 83,
                            "crop" => "fill",
                            "quality" => "auto",
                            "data-toggle" => "popover",
                            "data-popover-content" => "#popover_content_".$item->id
                        )); ?>
                    </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>