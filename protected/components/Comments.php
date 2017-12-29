<?php
class Comments extends CWidget
{

    public $filmId;
    private $commentsMods;

	public function init() { 
        if(isset($this->filmId)) {
            $filmMod = Films::Model()->findByPk($this->filmId);
            $this->commentsMods = $filmMod->comments;
        }
	}

    public function run()
    {
        $this->render('CommentsView', array('commentsMods'=>$this->commentsMods));
    }
}