<?php

namespace nagser\base\widgets\DetailView;

class DetailView extends \kartik\detail\DetailView {

	public $striped = false;
	public $hAlign = 'left';
	public $enableEditMode = false;
	public $responsive = true;


	public function init(){
		parent::init();
	}

}