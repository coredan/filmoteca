<?php 
  $title = isset($_GET['Search']['title']) ? $_GET['Search']['title'] : "";
  $yearRange = isset($_GET['Search']['year_range']) ? $_GET['Search']['year_range'] : "";
  if(isset($_GET['Search']["year_range"])) {
    $rangeArr = explode(" ", trim(preg_replace("/[^0-9,. ]/", "", $_GET['Search']["year_range"])), 2);
  }
  $rangeArr = (isset($rangeArr) && is_array($rangeArr) && count($rangeArr) == 2) ? $rangeArr : array("1990","2010");
  $genresArr = (isset($_GET['Search']['genres']) && is_array($_GET['Search']['genres']))? $_GET['Search']['genres'] : array();
  
?>

<div class="panel panel-default panel-dark">
  <div class="panel-heading">
    <h3 class="panel-title"><i class="fa fa-search" aria-hidden="true"></i> Búsqueda</h3>
  </div>
  <div class="panel-body">
    <form action="/films/search" method="GET">
      <div class="form-group">
        <label class="title">Título</label>
        <ul>           
          <li><label for="searchTitle"></label><input type="text" name="Search[title]" id="searchTitle" class="form-control" value="<?= $title; ?>"></li>          
        </ul>
      </div>
      <div class="form-group">
        <label class="title"><i class="fa fa-folder" aria-hidden="true"></i> Año</label>
        <ul>           
          <li>
            <div class="col-md-12" style="padding: 0">
              <!-- input type="range" min="1970" max="2018" value="2017" id="yearRange" -->
                               
              <input type="text" id="amount" name="Search[year_range]" readonly style="border:0; color:#2e9fad; font-weight:bold;" value="<?= $yearRange; ?>">
              <div id="year-slider-range" first="<?= $rangeArr[0]; ?>" last="<?= $rangeArr[1]; ?>"></div>
              
            </div>            
          </li>          
        </ul>
      </div>  
      <div class="form-group">
        <label class="title"><i class="fa fa-folder" aria-hidden="true"></i> Géneros</label>
        <ul class="double plegable">     
        <?php foreach ($this->gBaseMods as $gBaseMod) { 
            $checked = in_array($gBaseMod->id, $genresArr) ? "checked" : "";            
          ?>
          <li>
              <input type="checkbox" id="gen_<?php echo $gBaseMod->id; ?>"  name="Search[genres][]" value="<?php echo $gBaseMod->id; ?>" <?php echo $checked; ?>> 
              <label for="gen_<?php echo $gBaseMod->id; ?>"><?php echo $gBaseMod->name; ?></label>
          </li>
        <?php }?>                        
        </ul>
      </div>
      <button class="btn btn-info">Buscar</button>       
    </form>
  </div>
</div>