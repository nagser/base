<?php

namespace app\base\widgets\Wizard;

use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\JsExpression;

class Wizard extends Widget
{

	public $id = 'wizard';
	public $options = [];
	public $source = [];

	public function init()
	{
		parent::init();
		$_options = [
			'tabClass' => 'tablist',
			'nextSelector' => 'a[href$="#next"]',
			'onTabClick' => new JsExpression('function(tab, navigation, index){ return false; }'),
			'onNext' => new JsExpression('function(tab, navigation, index){
				$("#step"+index).submit();
				return false;
			}'),
		];
		$this->options = ArrayHelper::merge($_options, $this->options);
	}

	public function run()
	{
		$view = $this->getView();
		WizardAsset::register($view);
		$view->registerJs("$('#wizard').bootstrapWizard(" . Json::encode($this->options) . ");");
		return $this->render('wizard', [
			'id' => $this->id,
			'options' => $this->options,
			'source' => $this->source
		]);
	}
}