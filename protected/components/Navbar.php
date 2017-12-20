<?php
class Navbar extends CWidget
{	
	
	public function init() { 
		if(!Yii::app()->user->isGuest) {			
		}	    	

	}

    public function run()
    {    	
        $this->render('NavbarView', array(/*'model'=>User::model()->findbyPk(Yii::app()->user->id)*/));
    }
}