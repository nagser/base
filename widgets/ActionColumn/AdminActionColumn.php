<?php

namespace app\base\widgets\ActionColumn;

use kartik\grid\ActionColumn;
use \Yii;
use yii\helpers\ArrayHelper;

class AdminActionColumn extends ActionColumn {

	public $headerOptions = [
		'class' => 'minWidth',
	];

	public $contentOptions = [
		'class' => 'minWidth',
	];

	public $viewOptions = [
		'class' => 'btn btn-sm btn-default',
	];

	public $updateOptions = [
		'class' => 'btn btn-sm btn-primary',
	];

	public $deleteOptions = [
		'class' => 'btn btn-sm btn-danger jsDialog',
		'data-modal-type' => 'confirm',
        'data-type' => 'danger',
		'data-method' => false,
		'data-confirm' => false,
		'data-pjax' => 'true',
	];

	public function init(){
		parent::init();
		//Стандартное сообщение при удалении элемента
		$this->deleteOptions['data-message'] =  ArrayHelper::getValue($this->deleteOptions, 'data-message', Yii::t('yii', 'Are you sure you want to delete this item?'));
	}




}