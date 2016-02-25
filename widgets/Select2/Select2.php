<?php

namespace nagser\base\widgets\Select2;

use \Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\JsExpression;

class Select2 extends \kartik\select2\Select2
{
	public $select2Type;
//    public $theme = self::THEME_DEFAULT;

	public function init()
	{
		$this->setDefaultOptions();
		if ($this->getSelect2Type() == 'ajax') {
			$this->setAjaxOptions();
		}
		parent::init();
	}

	public function setDefaultOptions()
	{
		$this->options = ArrayHelper::merge([
			'placeholder' => Yii::t('system', 'Enter text'),
		], $this->options);
		$this->pluginOptions = ArrayHelper::merge([
			'allowClear' => true,
		], $this->pluginOptions);
	}

	public function getSelect2Type()
	{
		if (ArrayHelper::keyExists('ajax', $this->pluginOptions) and $this->pluginOptions['ajax']) {
			return 'ajax';
		}
		return false;
	}

	public function setAjaxOptions()
	{
		if(!is_array($this->pluginOptions['ajax'])){
			$this->pluginOptions['ajax'] = [];
		}
		$this->pluginOptions = ArrayHelper::merge([
			'ajax' => [
				'url' => Url::to(['select2-list']),
				'dataType' => 'json',
				'data' => new JsExpression('function(params) { return {search:params.term, colAlias: "' . ArrayHelper::getValue($this->pluginOptions['ajax'], 'colAlias', 'title') . '"}; }'),
			],
			'minimumInputLength' => 1,
			'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
			'templateResult' => new JsExpression('function(item) { return item.text; }'),
			'templateSelection' => new JsExpression('function (item) { return item.text; }'),
		], $this->pluginOptions);

	}

}