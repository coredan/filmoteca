<?php
	/* @var $this SiteController */

	$this->pageTitle=Yii::app()->name;
	$this->breadcrumbs=array(
		'Películas',
	);
    $cloudinaryBaseUrl = "https://res.cloudinary.com/filmoteca/image/upload/c_fill,h_140,q_auto,w_98/v1/";
?>
<div class="tab-title"><i class="fa fa-video-camera" aria-hidden="true"></i> LISTADO DE PELÍCULAS (<?= count($filmMods); ?>)</div>
<div class="colpanel6x6 col-md-12 col-sm-12 col-xs-12">
    <?php if(count($filmMods) > 0) { ?>
        <?php foreach ($filmMods as $filmMod) {
            //list($folder, $fileNm) = explode(":", $filmMod->image, 2);
        ?>
        <div class="panel-cell col-lg-2 col-md-3 col-sm-2 col-xs-4 center-block">
            <a href="/films/item/<?php echo $filmMod->id; ?>">
                <?php  echo cl_image_tag( $filmMod->image, array(
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
                    <div class="row text-justify">
                        <?php echo Yii::app()->CustomHelper->cutText($filmMod->synopsis, 200); ?>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-xs-10 text-left">
                            <?php
                            $genres = $filmMod->genres;
                            foreach ($genres as $genre) { ?>
                                <span class="bubble"><?= $genre->name; ?> 0</span>
                            <?php } ?>
                        </div>
                        <div class="col-xs-2 text-right"><button class="btn btn-info btn-sm"><?= $filmMod->nota; ?></button></div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    <?php } else { ?>
        No se encontró ningún resultado
    <?php } ?>
    <div class="col-md-12 pagination-place">

            <?php
            if(isset($pages)) {
                $this->widget('CLinkPager', array(
                    'pages' => $pages,
                    'header' => '',
                    'nextPageLabel' => '<i class="fa fa-step-forward" aria-hidden="true"></i>',
                    'prevPageLabel' => '<i class="fa fa-step-backward" aria-hidden="true"></i>',
                    'firstPageLabel' => '<i class="fa fa-backward" aria-hidden="true"></i>',
                    'lastPageLabel' => '<i class="fa fa-forward" aria-hidden="true"></i>',
                    'selectedPageCssClass' => 'active',
                    'hiddenPageCssClass' => 'disabled',
                    'htmlOptions' => array(
                        'class' => 'pagination pagination-sm',
                    )
                ));
            }
            ?>

        <!--ul class="pagination">
            <li><a href="#"><i class="fa fa-caret-square-o-left" aria-hidden="true"></i></a></li>
            <li class="active"><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#"><i class="fa fa-caret-square-o-right" aria-hidden="true"></i></a></li>
        </ul-->
    </div>
    <div class="overlay">
        <div class="overlay-content">
            <i class="fa fa-spinner faa-spin animated faa-slow"></i> <p>Paciencia...</p>
        </div>
    </div>
</div>

