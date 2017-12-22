<?php
class Navbar extends CWidget
{
    public $filmsActive;
    public $serieActive;
    public $appsActive;

	public function init() { 
		if(!Yii::app()->user->isGuest) {			
		}
		$this->filmsActive = "";
        $this->serieActive = "";
        $this->appsActive = "";

        if (Yii::app()->controller->id == "films") {

            switch (Yii::app()->controller->action->id) {
                case "index":
                    $this->filmsActive = "active";
                    break;
                case "about":
                    $this->serieActive = "active";
                    break;
            }
        }
        //var_dump(Yii::app()->controller->action->id); exit();
	}

    public function run()
    {    	
        $this->render('NavbarView', array(/*'model'=>User::model()->findbyPk(Yii::app()->user->id)*/));
    }
}