<?php
class BestRatedFilms extends CWidget
{
    private $bestRatedFilmsMod;

	public function init() { 

	    //$this->similarFilmsMod = Films::Model()->findAllBySql("SELECT * FROM tbl WHERE id IN (SELECT id FROM (SELECT id FROM tbl ORDER BY RAND() LIMIT 10) t)");
        $criteria = new CDbCriteria();
        $criteria->select = 'id, image';
        $criteria->order = 'nota DESC';
        $criteria->limit = 12;
        $this->bestRatedFilmsMod = Films::Model()->findAll($criteria);
	}

    public function run()
    {    	
        $this->render('BestRatedFilmsView', array('bestRatedFilmsMod'=> $this->bestRatedFilmsMod));
    }
}