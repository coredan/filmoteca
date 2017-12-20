<?php
class SearchPanel extends CWidget
{	
	public $gBaseMods; 
	//public $totalMessages;
	public function init() { 
		if(!Yii::app()->user->isGuest) {		
		}	    	
		$this->gBaseMods = GenresBase::Model()->findAll(array('order'=>'name'));		
	}

    public function run()
    {    	

        $this->render('SearchPanelView', array(/*'model'=>User::model()->findbyPk(Yii::app()->user->id)*/));
    }
}