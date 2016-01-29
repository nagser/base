<?php

namespace app\base\widgets\ActiveForm;

use kartik\form\ActiveForm as BaseActiveForm;
use app\base\assets\vendors\AdminFormsAsset;

class ActiveForm extends BaseActiveForm {

	public $fieldConfig = [
		'class' => 'app\base\widgets\ActiveField\ActiveField'
	];
	public $errorCssClass = 'state-error';
	public $successCssClass = 'state-success';
    public $options = ['class' => 'form-horizontal'];

    /**
     * Код перед формой
     * */
    public $prepend = '
	    <div class="admin-form">
            <div class="panel panel-default heading-border">';

    /**
     * Код после формы
     * */
    public $append = '
			</div>
        </div>';


	public function init(){
//		AdminFormsAsset::register(\Yii::$app->getView());
		echo $this->prepend;
		parent::init();
	}

	public function run(){
		parent::run();
		echo $this->append;
	}

}