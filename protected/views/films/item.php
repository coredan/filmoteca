<?php
  /* @var $this FilmsController */

  $this->breadcrumbs=array(
  	'Films'=>'/films',
  	$filmMod->title." (".$filmMod->year.")",
  );
?>
<h3 class="title">Ver <span class="it-title-es"><?php echo $filmMod->title ?></span> (<?php echo $filmMod->year ?>) /
    <small style="color:#eee"><em><span class="it-title-es"><?php echo $filmMod->title_es; ?></span></em></small>
    <button type="button" id="editFilmButton" class="btn btn-info btn-sm pull-right"><i class="fa fa-pencil-square" aria-hidden="true"></i></button>
</h3>
  <div class="row update">
      <div class="col-md-12">
       <?php echo $this->renderPartial('add', array("model"=>$filmMod, "torrentsMod"=>new Torrents, "gBaseMods"=>$gBaseMods, "countriesMod" => $countriesMod));?>
      </div>
    </div>
  <div class="row details">
    <div class="film-image-place col-md-6 col-sm-7 col-xs-12">
      <p><?php echo cl_image_tag($filmMod->image, array("width" => 398, "height" => 512, "crop" => "fill", "quality"=>"auto" )); ?></p>
        <?php if(!empty($filmMod->nota)) :
            $fixedRate = ceil($filmMod->nota * 2) / 2;
            $entireRate = floor($fixedRate);
            $isFloat = intval($fixedRate - $entireRate) !== 0;
            $i = 0;
            ?>
        <div class="floating-rate">
            <i class="fa fa-bullhorn" aria-hidden="true"></i> <em>FilmAffinity</em> <span class="checked"><strong><?php echo $filmMod->nota; ?></strong></span> / 10 <br />
            <?php for ($i = 0; $i < $entireRate; $i++) : ?>
                <span class="fa fa-star checked"></span>
            <?php endfor;
                if ($isFloat) : ?>
                    <span class="fa fa-star-half-o checked"></span>
            <?php endif; ?>
            <?php for ($i = $entireRate; $i <= 10; $i++) : ?>
                <span class="fa fa-star"></span>
            <?php endfor; ?>
        </div>
        <?php endif; //end if !empty(...) ?>
    </div>      

    <div class="film-details-place col-md-6 col-sm-5 col-xs-12 last">
      <div class="detail">
        <div class="row">
          <div class="col-md-2">Título:</div>
          <div class="col-md-10 last">
            <span class="it-title">
            <?php 
              $title = !empty($filmMod->title_es) ? $filmMod->title." / ".$filmMod->title_es : $filmMod->title;
              echo $title;
            ?>
            </span>
          </div>          
        </div>
        <div class="row">
          <div class="col-md-2">Año:</div>
          <div class="col-md-10 last"><span class="it-year"><?php echo $filmMod->year; ?></span></div>
        </div>
        <?php if (isset($filmMod->country)) { ?>
          <div class="row">
            <div class="col-md-2">País:</div>
            <div class="col-md-10 last">
              <span class="flag-icon flag-icon-<?php echo strtolower($filmMod->country->country_code); ?>"></span>              
              <span class="it-country"><?php echo $filmMod->country->country_name_es; ?></span>
            </div>            
          </div>
        <?php } ?>
        <div class="row">
          <div class="col-md-2">Género:</div>
          <div class="col-md-10 last it-genres">
            <?php 
              $filmGenres = $filmMod->genres;          
              
              //var_dump($filmMod->genres); exit();
              foreach ($filmGenres as $filmGenre) { ?>            
                <span class="bubble"><?php echo $filmGenre->name; ?></span>
            <?php  } ?>        
                    
            <?php //echo $filmMod->genres; ?>
          </div>
          <div class="col-md-10 hidden"><input type="text" name="Film[genres]" class="form-control"></div>
        </div>
        <div class="row">
          <div class="col-md-2" style="text-align:right;">Director:</div>
          <div class="col-md-10 last"><span class="it-director"><?php echo $filmMod->director; ?></span></div>
          <div class="col-md-10 hidden"><input type="text" name="Film[director]" class="form-control"></div>
        </div>
      <?php if (isset($filmMod->casting)) { ?>
          <div class="row">
              <div class="col-md-2">Casting:</div>
              <div class="col-md-10 last">
                  <span class="it-casting"><?php echo $filmMod->casting; ?></span>
              </div>
          </div>
      <?php } ?>
        <div class="row">
          <div class="col-md-2" style="text-align:right;">Sinopsis:</div>
          <div class="col-md-10 last"><p class="it-synopsis"><?php echo $filmMod->synopsis; ?></p></div>
        </div>
      </div> <!-- end of div "detail" -->      

    </div>
    <?php if (isset($filmMod->trailer)) { ?>
    <div clas="row">
      <div class="col-md-12">
        <?php 
        if(isset($filmMod->trailer) && !empty($filmMod->trailer)) {
            $url = $filmMod->trailer;
            parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
            $id = $my_array_of_vars['v'];  
         
            $width = '100%';
            $height = '400px';
            echo '<object width="' . $width . '" height="' . $height . '"><param name="movie" value="http://www.youtube.com/v/' . $id . '&amp;hl=en_US&amp;fs=1?rel=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/' . $id . '&amp;hl=en_US&amp;fs=1?rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="' . $width . '" height="' . $height . '"></embed></object>';
        }
        ?>
      </div>
    </div>
    <?php } ?>
  </div>
<div class="row item-torrents">
    <div class="col-md-12">
        <h3>Descargar</h3>
        <?php if (!empty($filmMod->torrents)) {
            $torrentsCounter = 1;
            foreach ($filmMod->torrents as $torrent) {
                ?>
                <div class="row">
                    <div class="col-md-2 col-xs-4">
                        <span class="flag-icon flag-icon-es"></span> Opción <?= $torrentsCounter++ ?>
                    </div>
                    <div class="col-md-10 col-xs-8 text-left">
                        <a class="btn btn-success" href="https://res.cloudinary.com/filmoteca/raw/upload/<?php echo $torrent->link; ?>.torrent">Torrent</a>
                    </div>
                </div>
            <?php }
        }
        ?>
    </div>
</div>
<?php if (!empty($filmMod->links)) { ?>
    <div clas="row">
        <div class="show-links col-md-12">
            <h3> Ver online</h3>
            <ul class="nav nav-pills">
                <?php $counter = 0;
                foreach ($filmMod->links as $link) { ?>
                    <li class="active"><a data-toggle="pill" href="#Opción<?php echo $counter; ?>">Opción<?php echo $counter; ?></a></li>
                    <div class="tab-content">
                        <div id="Opción<?php echo $counter++; ?>" class="tab-pane fade in active">
                            <iframe src="https://openload.co/embed/5KAf7Tj6EcU/" scrolling="no" frameborder="0" width="700" height="430" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>
                        </div>
                    </div>
                <?php } ?>
            </ul>

        </div>
    </div>
<?php } ?>


<?php //var_dump($filmMod); ?>
