<?php
require_once 'cloudinary/Cloudinary.php';
require_once 'cloudinary/Uploader.php';
require_once 'cloudinary/Api.php';

require_once 'filmaffinity/api.php';

\Cloudinary::config(array( 
  "cloud_name" => "filmoteca", 
  "api_key" => "897546987296749", 
  "api_secret" => "jo6gl1WXyNfFV3E3xyODtd8d9r8" 
));


class FilmsController extends Controller
{

	private $gBaseMods;
	private $errors = array("Undeterminated error ocurred");
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	public function init() {
		//$this->page = "index";
		$this->layout = "column3";
		$this->gBaseMods = GenresBase::Model()->findAll(array('order'=>'name'));
	}

	public function actionIndex()
	{
        $this->layout = "column3";
        $criteria = new CDbCriteria();
        $criteria->order = 'year DESC';
        $pages = new CPagination(Films::Model()->count('id'));
        $pages->pageSize = SiteGlobals::MAX_FILMS_PER_PAGE;
	    if(isset($_GET["page"])) {
	        $page = $_GET["page"];
	        $pages->currentPage = $page-1;
        }
        $pages->applyLimit($criteria);
        $filmMods = Films::Model()->findAll($criteria);

        $this->render('index', array("filmMods" => $filmMods, "pages"=>$pages));
	}

	public function actionAdd()
	{		
		$cs = Yii::app()->getClientScript();		
				
		//$cs->registerScriptFile(Yii::app()->baseUrl.'/js/dropzone.js');
		
		$filmMods = Films::Model()->findAll();	
		$countries = Country::Model()->findAll(array('order'=>'country_name_es'));		
		$this->layout = "column1";
		$this->render('add', array("model"=>new Films, "torrentsMod"=>new Torrents, "gBaseMods"=>$this->gBaseMods, "countriesMod" => $countries));
	}

	public function actionItem() {
		$filmMod = Films::Model()->findByPk($_GET["id"]);
		$countries = Country::Model()->findAll(array('order'=>'country_name_es'));	
		$this->layout = "item";
		$this->render('item', array("model"=>new Films, "torrentsMod"=>new Torrents, "filmMod"=>$filmMod, "gBaseMods"=>$this->gBaseMods, "countriesMod" => $countries));
	}

	public function actionSave(){

		$request = Yii::app()->request;
		$response = array("status"=>"success");			
		$filmPost = $request->getPost('Films');
		$detail = array();

		// If $filmPost is Null, returns an error:
		if($filmPost == NULL) {
		    $response["error"] = "Films POST data is required";
            $response["status"] = "error";
		    $this->renderJSON($response);
        }


        $response["Post"] = $filmPost;
        $response["FILES"] = $_FILES;

//        // Uploading image to the cloud
//        if (empty($imageFilePath = $this->uploadFilesToCloud($_FILES["image"], "films_covers", $filmMod->title, array('jpeg','jpg','png')))){
//            $response["errors"] = $this->errors;
//            $response["status"] = "error";
//        } else {
//            $response["imageFilePath"] = $imageFilePath[0];
//            $detail["uploaded_image"] =  $response["imageFilePath"];
//        }
//
        // Uploading torrents to the cloud
        if($_FILES["torrentFiles"]["name"][0] !== ""){
            if(empty($filePaths_torrents = $this->uploadFilesToCloud($_FILES["torrentFiles"], "torrents", $filmPost["title"], array('torrent')))){
                $response["errors"] = $this->errors;
                $response["status"] = "error";
            } else {
                $response["filePaths_torrents"] = $filePaths_torrents;
                $detail["uploaded_torrents"] =  $response["filePaths_torrents"];
            }
        }

        // ¿Save or Update?
        if (empty($filmPost["id"])) {   // is saving

            if (!isset($_FILES["image"])){
                $response["errors"] = "Image is required";
                $response["status"] = "error";
                $this->renderJSON($response);
            }
            $filmMod = new Films;
        } else {                        // is updating
            $filmMod = Films::Model()->findByPk($filmPost["id"]);
		}

        //Saving in Database
        if (isset($response["imageFilePath"])){
            $filmPost["image"] = $response["imageFilePath"];
        } else {
            $filmPost["image"] = $filmMod->image ?: "films_cover/no_image";
        }

		// Setting attributes data:
        $filmMod->attributes = $filmPost;

        // Retrieving no filled form data from FilmAffinity:
        // TODO HACER AQUÍ LO DE COMPROBAR SI TRAE IMAGEN O NO
        $this->fillDataRemote($filmPost, $filmMod);

        if($response["status"] !== "error" && $filmMod->save()){
            // Saving torrents paths
            if(isset($filePaths_torrents)){

                foreach ($filePaths_torrents as $torrentUrl) {
                    $detail["Aqui llega"] = "ENTRA";
                    $torrentMod = new Torrents;
                    $torrentMod->film_id = $filmMod->id;
                    $torrentMod->link = $torrentUrl;
                    if(!$torrentMod->save()) {
                        $response["errors"] = $torrentMod->getErrors();
                        $response["status"] = "error";
                        $detail["Torrents DB ERROR"] = $torrentMod->getErrors();
                    }
                }
            }

            // TODO : guardar bien los géneros usando los active records y no así.
            $filmPost["genres"] = is_array($filmPost["genres"]) ? $filmPost["genres"] : array($filmPost["genres"]);
            $filmAddGenres = array();

            // borrando en caso necesario solo al actualizar
            if (!empty($filmPost["id"])) { // updating
                $detail["Genre removed"] = "";
                $savedGenres = $filmMod->filmsGenres;
                foreach ($savedGenres as $savedGenre) {
                    if (!in_array($savedGenre->genre_id, $filmPost["genres"])) {
                        $savedGenre->delete();
                        $detail["Genre removed"] =", ".$savedGenre->genre_id;
                    }
                }
            }

            foreach ($filmPost["genres"] as $genre) {
                $genreId = str_replace("gen_", "", $genre);
                if(!FilmsGenres::Model()->exists("film_id = ".$filmMod->id." AND genre_id = ".$genreId)) {
                    $genresMod = new FilmsGenres;
                    $genresMod->film_id = $filmMod->id;
                    $genresMod->genre_id = $genreId;
                    if(!$genresMod->save()) {
                        $response["errors"] = $genresMod->getErrors();
                        $response["status"] = "error";
                        $detail["Genres DB ERROR"] = $genresMod->getErrors();
                    }
                    $detail["Genre added"] = $genresMod->genre_id;
                }
            }
            $response["filmPost[genres]"] = $filmPost["genres"];
            if(isset($filmPost["links"])) {
                $filmPost["links"] = is_array($filmPost["links"]) ? $filmPost["links"] : array($filmPost["links"]);
                foreach ($filmPost["links"] as $link) {
                    $linkMod = new Links;
                    $linkMod->film_id = $filmMod->id;
                    $linkMod->url = $link;
                    if(!$linkMod->save()) {
                        $response["errors"] = $linkMod->getErrors();
                        $response["status"] = "error";
                        $detail["Links DB ERROR"] = $linkMod->getErrors();
                    }
                }
            }
        } else {
            $response["errors"] = $filmMod->getErrors();
            $response["status"] = "error";
        }


			//$response["test"] = $this->uploadFilesToCloud($_FILES["image"], "films_covers", $filmMod->title, array('jpeg','jpg','png'));	
			//$response["test"] = $this->uploadFilesToCloud($_FILES["torrentFiles"], "torrents", $filmMod->title, array('torrent'));

		$response["detail"] = $detail;
		$this->renderJSON($response);
	}

	public function actionUpdate() {		
		$response = array("success"=>false);
		$request = Yii::app()->request;

		$filmPost = $request->getPost('Film');		
		$filmMod = Films::Model()->findByPk($filmPost["id"]);
		$filmMod->attributes = $filmPost;

		//$response["test"] = $filmMod;
		if($filmMod->save()) {
			$response["success"] = true; 
		}
		$response["filmMod"] = $filmMod;
		$this->renderJSON($response);
	}

	public function actionSearch() {
		$request = Yii::app()->request;		
		$criteria = new CDbCriteria;
		$criteria->with='genres';		
		$searchData = $_GET["Search"];
		// var_dump($searchData); exit();
		if(!empty($searchData["title"])) {
			$criteria->addCondition('title LIKE "%'.$searchData["title"].'%"');			
		}
		if(isset($searchData["year_range"])){
			$range = explode(" ", trim(preg_replace("/[^0-9,. ]/", "", $searchData["year_range"])), 2);			
			$criteria->addCondition('year BETWEEN '.$range[0].' AND '.$range[1]);				
			$searchData["range"] = $range;
		}
		if(isset($searchData["genres"])) {
			$enl = "AND";
			foreach ($searchData["genres"] as $genreId) {				
				$criteria->compare('genres.id', $genreId, false, $enl);
				$enl = "OR";
			}
		}
		// $criteria->addCondition('genres.d = 2');
		$filmMods = Films::Model()->findAll($criteria);		
		$this->layout = "column3";
		$this->render('index', array("filmMods"=>$filmMods, "search"=>$searchData));
	}

	private function fillDataRemote($filmPost, &$filmMod){
        // Filling with FilmAffinity data if needed:
        if(!empty($filmPost["imdb_code"])) {
            $filmAffinityInfo = getFilmInfo($filmPost["imdb_code"], false);
            foreach ($filmMod->attributes as $attr => $val) {
                if(empty($filmMod->attributes[$attr])){
                    if(strcmp($attr, "nota") == 0) {
                        $filmMod->nota = floatval($filmAffinityInfo->average);
                    } elseif(strcmp($attr, "synopsis") == 0) {
                        $filmMod->synopsis = $filmAffinityInfo->synopsis;
                    } elseif(strcmp($attr, "year") == 0) {
                        $filmMod->year = intval($filmAffinityInfo->year);
                    } elseif(strcmp($attr, "director") == 0) {
                        $filmMod->director = $filmAffinityInfo->director;
                    } elseif(strcmp($attr, "title") == 0) {
                        $filmMod->title = $filmAffinityInfo->title;
                    } elseif(strcmp($attr, "casting") == 0) {
                        $filmMod->casting = $filmAffinityInfo->cast;
                    }
                }
            }
        }
    }

	
	private function normalizeFileNm($title, $ext=NULL) {
		$fileName = strtolower($title);
		// Make alphanumeric (removes all other characters)    
		$fileName = preg_replace("/[^a-z0-9_\s-]/", "", $fileName);
		// Clean up multiple dashes or whitespaces
		$fileName = preg_replace("/[\s-]+/", " ", $fileName); 
    	//Convert whitespaces to dash
    	$fileName = preg_replace("/[\s]/", "_", $fileName);
    	if(NULL !== $ext){
			return $fileName.".".$ext;
		} else {
			return $fileName; 
		}
	}

	private function uploadFilesToCloud($files, $remotePath, $title, $acceptedExtensions=NULL, $cloud=true) {
        $filePaths = array();
	    if($files !== NULL) {

            $fileName = "";
            $uploadPath = "";
            $currentDir = getcwd();
            $uploadDirectory = "\uploads\\";

            $fileExtensions = $acceptedExtensions ?: array(); // Get all the file extensions

            // reArray files:
            $tmp = $files;
            $files = $this->reArrayFiles($files);
            $filesCounter = 0;
            foreach ($files as $f) {

                $fileName = $f['name'];
                $fileTmpName = $f['tmp_name'];
                //$fileType = $f['type'];
                $exp = explode('.', $fileName);
                $fileExtension = strtolower(end($exp));
                $fTemp = str_replace(".tmp","", $fileTmpName).".".$fileExtension;
                $remFileName = $filesCounter > 0 ? $title . "_" . $filesCounter : $title;
                $remFileName = $this->normalizeFileNm($remFileName);
                $uploadPath = $currentDir . $uploadDirectory . basename($fileName);

                if (!empty($fileExtensions) && !in_array($fileExtension, $fileExtensions)) {
                    $this->errors[] = "This file extension is not allowed. Please upload a (".explode(",", $fileExtensions).") file";
                } else {
                    $didUpload = move_uploaded_file($fileTmpName, $uploadPath);
                    if ($cloud) {
                        \Cloudinary\Uploader::upload($uploadPath, array("folder" => $remotePath, "public_id" => $remFileName, "resource_type" => "auto"));
                        unlink($uploadPath);
                    }
                }
                $filePaths[] = $remotePath . '/' . $remFileName;
                $filesCounter++;
            }
        } else {
            $this->errors["uploadFilesToCloud()"] = "One or more files are required";
        }
		return $filePaths;
	}

	function reArrayFiles($file_post) {

	    $file_ary = array();
	    $file_count = count($file_post['name']);
	    $file_keys = array_keys($file_post);

	    $borrame = array();
	    for ($i=0; $i<$file_count; $i++) {
	        foreach ($file_keys as $key) {	        	
	        	if(is_array($file_post[$key])){	        		
	            	$file_ary[$i][$key] = $file_post[$key][$i];
	            	//$borrame[] = $key;
	             } else {
	             	$file_ary[$i][$key] = $file_post[$key];
	             }
	        }
	    }

    	return $file_ary;
	}


	protected function renderJSON($data)
	{
	    header('Content-type: application/json');
	    echo CJSON::encode($data);

	    foreach (Yii::app()->log->routes as $route) {
	        if($route instanceof CWebLogRoute) {
	            $route->enabled = false; // disable any weblogroutes
	        }
	    }
	    Yii::app()->end();
	}
	
}