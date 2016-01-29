<?php

namespace app\base\widgets\DetailView;

class DetailView extends \kartik\detail\DetailView {

	public $striped = false;
	public $hAlign = 'left';
	public $mainTemplate = false;
	public $enableEditMode = false;
	public $responsive = true;


	public function init(){
		parent::init();
//		$this->mainTemplate or $this->mainTemplate = $this->render('@widgets/DetailView/views/detailView');
	}

}