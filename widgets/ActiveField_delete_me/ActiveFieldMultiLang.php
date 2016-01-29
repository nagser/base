<?php

namespace app\base\widgets\ActiveField;

use yii\widgets\ActiveField;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use app\modules\config\Config;
use yii\helpers\ArrayHelper;

class ActiveFieldMultiLang extends ActiveField
{
	public $label;
	public $inputType;

	/**
	 * @inheritdoc
	 * */
	public function render($content = null)
	{
		if ($content === null) {
			if (!isset($this->parts['{input}'])) {
				$this->parts['{input}'] = Html::activeTextInput($this->model, $this->attribute, $this->inputOptions);
			}
			if (!isset($this->parts['{label}'])) {
				$this->parts['{label}'] = Html::activeLabel($this->model, $this->attribute, $this->labelOptions);
			}
			if (!isset($this->parts['{error}'])) {
				$this->parts['{error}'] = Html::error($this->model, $this->attribute, $this->errorOptions);
			}
			if (!isset($this->parts['{hint}'])) {
				$this->parts['{hint}'] = '';
			}
			$content = strtr($this->template, $this->parts);
		} elseif (!is_string($content)) {
			$content = call_user_func($content, $this);
		}
		return $this->buildLangsInputs([
			'begin' => $this->begin(),
			'content' => $content,
			'end' => $this->end(),
			'attribute' => $this->attribute,
			'label' => $this->label,
			'model' => $this->model,
			'form' => $this->form,
		]);
	}

	/**
	 * @inheritdoc
	 * */
	public function label($label = null, $options = [])
	{
		$this->label = $label;
		if ($label === false) {
			$this->parts['{label}'] = '';
			return $this;
		}

		$options = array_merge($this->labelOptions, $options);
		if ($label !== null) {
			$options['label'] = $label;
		}
		$this->parts['{label}'] = Html::activeLabel($this->model, $this->attribute, $options);
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function textInput($options = [])
	{
		$this->inputOptions = $options = array_merge($this->inputOptions, $options);
		$this->adjustLabelFor($options);
		$this->parts['{input}'] = Html::activeTextInput($this->model, $this->attribute, $options);
		$this->inputType = 'textInput';
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function textarea($options = [])
	{
		$this->inputOptions = $options = array_merge($this->inputOptions, $options);
		$this->adjustLabelFor($options);
		$this->parts['{input}'] = Html::activeTextarea($this->model, $this->attribute, $options);
		$this->inputType = 'textarea';
		return $this;
	}


	public function buildLangsInputs($params)
	{
		/**
		 * @var $form ActiveForm
		 * */
		$recordModel = $params['model'];
		$form = $params['form'];
		//default language
		$inputs[Config::getDefaultLanguage()] = [
				'begin' => $params['begin'],
				'content' => $params['content'],
				'end' => $params['end'],
				'label' => Config::getLanguages(Config::getDefaultLanguage()),
		];
		//other languages
		foreach (Config::getLanguages() as $code => $name) {
			if(Config::getDefaultLanguage() === $code) {
				continue;
			}
			$newAttribute = $params['attribute'] . '_' . $code;
			if (isset($recordModel->$newAttribute)) {
				$method = $this->inputType;
				$inputs[$code] = [
					'begin' => '',
					'content' => $form->field($recordModel, $newAttribute)->label($params['label'])->$method($this->inputOptions),
					'end' => '',
					'label' => Config::getLanguages($code)
				];
			}
			else {
				return $params['begin'] . "\n" . $params['content'] . "\n" . $params['end'];
			}
		}
		return \Yii::$app->view->renderFile('@widgets/ActiveField/views/ActiveFieldMultiLang.php', [
			'inputs' => $inputs
		]);
	}

	public function multiLang(){

	}


}