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
    <div class="film-image-place col-md-4 col-sm-7 col-xs-12">
      <p><?php echo cl_image_tag($filmMod->image, array("width" => 398, "height" => 512, "crop" => "limit", "quality"=>"auto" )); ?></p>
        <?php if(!empty($filmMod->nota)) :
            $fixedRate = ceil($filmMod->nota * 2) / 2;
            $entireRate = floor($fixedRate);
            $isFloat = $fixedRate - $entireRate !== 0.0;
            $i = 0;
            //var_dump($fixedRate - $entireRate !== 0.0); exit();
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
                <span class="fa fa-star-o"></span>
            <?php endfor; ?>
        </div>
        <?php endif; //end if !empty(...) ?>
    </div>      

    <div class="film-details-place col-md-8 col-sm-5 col-xs-12 last">
      <div class="detail">
        <div class="row">
          <div class="col-lg-1 col-md-2 col-xs-3">Título:</div>
          <div class="col-xs-10 last">
            <span class="it-title">
            <?php 
              $title = !empty($filmMod->title_es) ? $filmMod->title." / ".$filmMod->title_es : $filmMod->title;
              echo $title;
            ?>
            </span>
          </div>          
        </div>
        <div class="row">
          <div class="col-lg-1 col-md-2 col-xs-3">Año:</div>
          <div class="col-lg-11 col-md-10 col-xs-9 last"><span class="it-year"><?php echo $filmMod->year; ?></span></div>
        </div>
        <?php if (isset($filmMod->country)) { ?>
          <div class="row">
            <div class="col-lg-1 col-md-2 col-xs-3">País:</div>
            <div class="col-lg-11 col-md-10 col-xs-9 last">
              <span class="flag-icon flag-icon-<?php echo strtolower($filmMod->country->country_code); ?>"></span>              
              <span class="it-country"><?php echo $filmMod->country->country_name_es; ?></span>
            </div>            
          </div>
        <?php } ?>
        <div class="row">
          <div class="col-lg-1 col-md-2 col-xs-3">Género:</div>
          <div class="col-lg-11 col-md-10 col-xs-9 last it-genres">
            <?php 
              $filmGenres = $filmMod->genres;          
              
              //var_dump($filmMod->genres); exit();
              foreach ($filmGenres as $filmGenre) { ?>            
                <span class="bubble"><?php echo $filmGenre->name; ?></span>
            <?php  } ?>        
                    
            <?php //echo $filmMod->genres; ?>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-1 col-md-2 col-xs-3">Director:</div>
          <div class="col-lg-11 col-md-10 col-xs-9 last"><span class="it-director"><?php echo $filmMod->director; ?></span></div>
        </div>
      <?php if (isset($filmMod->casting)) { ?>
          <div class="row">
              <div class="col-lg-1 col-md-2 col-xs-3">Casting:</div>
              <div class="col-lg-11 col-md-10 col-xs-9  last">
                  <span class="it-casting"><?php echo $filmMod->casting; ?></span>
              </div>
          </div>
      <?php } ?>
        <div class="row">
          <div class="col-lg-1 col-md-2 col-xs-3">Sinopsis:</div>
          <div class="col-lg-11 col-md-10 col-xs-9 last"><p class="it-synopsis"><?php echo $filmMod->synopsis; ?></p></div>
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
<?php if (Yii::app()->params["enableDownloads"]) { ?>
    <div class="row">

    </div>
    <div class="row item-downloads">
        <div class="col-md-6 col-xs-12">
            <h3><i class="fa fa-eye" aria-hidden="true"></i> Ver Online:</h3>
            <?php if (!empty($filmMod->links)) {
                $linksCounter = 1;
                ?>
                <div class="col-md-12 col-xs-12 t-header">
                    <div class="col-lg-2 col-xs-3">IDIOMA</div>
                    <div class="col-lg-8 col-xs-6">SERVER</div>
                    <div class="col-lg-2 col-xs-3">CALIDAD</div>
                </div>
                <?php foreach ($filmMod->links as $link) {
                    $hostUrl = "filmoteca.000webhostapp.com";
                    if(!empty($link->url)){
                        $hostUrl = strtolower(parse_url($link->url, PHP_URL_HOST));
                    }
                    $iconUrl = "http://www.google.com/s2/favicons?domain=".$hostUrl;
                    ?>
                    <div class="col-md-12 col-xs-12 t-body">
                        <a class="" href="<?php echo $link->url; ?>">
                            <div class="col-lg-2 col-xs-3 text-center">
                                <span class="flag-icon flag-icon-es" style="margin: 10px 0;"></span>
                            </div>
                            <div class="col-lg-8 col-xs-6" style="font-size: 12px;">
                                <span class="domainIco">
                                    <img src="<?php echo $iconUrl; ?>" alt="Films host icon">
                                </span>
                                <?php echo $hostUrl; ?>
                            </div>
                            <div class="col-lg-2 col-xs-3 text-right">
                                <?php echo $link->quality; ?>
                            </div>

                        </a>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="col-md-12 col-xs-12 text-center">
                    <span>Oh, oh... parece que no hay ningún enlace Online disponible</span>
                </div>
                <div class="col-md-12 col-xs-12 text-center">
                    Puedes <button class="btn btn-danger">Pedir</button> que se revise y se incluya.
                </div>
            <?php } ?>
        </div>
        <div class="col-md-6 col-xs-12">
            <h3><i class="fa fa-file-video-o" aria-hidden="true"></i> Torrents:</h3>
            <?php if (!empty($filmMod->torrents)) {
                $torrentsCounter = 1;
            ?>
                <div class="col-md-12 col-xs-12 t-header">
                    <div class="col-lg-2 col-xs-3">IDIOMA</div>
                    <div class="col-lg-8 col-xs-6">TAMAÑO</div>
                    <div class="col-lg-2 col-xs-3">ARCHIVO</div>
                </div>
            <?php foreach ($filmMod->torrents as $torrent) {
                    ?>
                    <div class="col-md-12 col-xs-12  t-body">
                        <div class="col-lg-2 col-xs-3 text-center">
                            <span class="flag-icon flag-icon-es" style="margin: 10px 0;"></span>
                        </div>
                        <div class="col-lg-8 col-xs-6" style="font-size: 12px;">
                            2.5 GB
                        </div>
                        <div class="col-lg-2  col-xs-3 text-right">
                            <a class="btn btn-success btn-sm btn-xs" style="margin: 6px 0; color: #fff" href="https://res.cloudinary.com/filmoteca/raw/upload/<?php echo $torrent->link; ?>.torrent">Torrent</a>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="col-md-12 col-xs-12 text-center">
                    <span>Oh, oh... parece que no hay ningún archivo Torrent disponible</span>
                </div>
                <div class="col-md-12 col-xs-12 text-center">
                    Puedes <button class="btn btn-danger">Pedir</button> que se revise y se incluya.
                </div>
            <?php } ?>
        </div>
    </div>
<?php } //If enable downloads ?>
<?php
    if(isset($filmMod)) {
        $this->widget('Comments', array("filmId" => $filmMod->id));
    }
?>
