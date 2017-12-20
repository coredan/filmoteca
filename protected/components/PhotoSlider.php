<?php
class PhotoSlider extends CWidget
{	
	public $filmsMod;
	public function init() { 
		if(!Yii::app()->user->isGuest) {			
		}	    	
		$this->filmsMod = Films::Model()->findAll(array('order'=>'ins_date DESC'));
	}

    public function run()
    {    	
        $this->render('PhotoSliderView'/*, array('model'=>User::model()->findbyPk(Yii::app()->user->id))*/);
    }
}