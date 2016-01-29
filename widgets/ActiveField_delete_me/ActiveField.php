<?php

namespace app\base\widgets\ActiveField;

use app\modules\languages\Languages;
use yii\widgets\ActiveField as BaseActiveField;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use app\modules\config\Config;

class ActiveField extends BaseActiveField
{
	/**
	 * Current field label(using for all languages)
	 * */
	public $label;
	public $options = ['class' => ''];
	public $inputOptions = ['class' => 'gui-input'];
//	public $labelOptions = ['class' => 'col-lg-3 control-label'];
	/**
	 * Current field input type
	 * */
	public $inputType;
	/**
	 * Enable MultiLang function for this field
	 * */
	public $multiLang;
	/**
	 * Print field without any padding
	 * */
	public $withoutBox;
	/**
	 * Field View File
	 * */
//	public $fieldView = '@widgets/ActiveField/views/ActiveField.php';
	/**
	 * MultiLang Field View File
	 * */
	public $fieldMultiLangView = '@widgets/ActiveField/views/ActiveFieldMultiLang.php';


    /**
     * @inheritdoc
     * */
    public function init(){
//        $this->template = \Yii::$app->view->renderFile('@widgets/ActiveField/views/ActiveField.php');
    }

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
		/* Вывести обычное поле ввода? */
		if ($this->withoutBox or !$this->multiLang) {
			return $this->begin() . $content . $this->end();
		} else {
			return $this->printLangField($content);
		}
	}


	public function printLangField($content = null)
	{
        return $this->buildLanguagesInputs([
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
		return parent::label($label, $options);
	}

	/**
	 * @inheritdoc
	 */
	public function textInput($options = [])
	{
		$this->inputType = 'textInput';
		return parent::textInput($options);
	}

	/**
	 * @inheritdoc
	 */
	public function textarea($options = [])
	{
		$this->inputType = 'textarea';
		return parent::textarea($options);
	}


	public function buildLanguagesInputs($params)
	{
		/** @var $form ActiveForm * */
		$recordModel = $params['model'];
		$form = $params['form'];
		//Default language
		$inputs[Languages::getDefaultLanguage()] = [
			'begin' => $params['begin'],
			'content' => $params['content'],
			'end' => $params['end'],
			'label' => Languages::getLanguageNameByCode(Languages::getDefaultLanguage()),
		];
		//Other languages
		foreach (Languages::getAllowedLanguages() as $code => $name) {
			if (Languages::getDefaultLanguage() == $code) {continue;}
			$method = $this->inputType;
			$newAttribute = $params['attribute'] . '_' . $code;
			$inputs[$code] = [
				'begin' => '',
				'content' => $form->field($recordModel, $newAttribute)->label($params['label'])->$method($this->inputOptions)->withoutBox(),
				'end' => '',
				'label' => Languages::getLanguageNameByCode($code)
			];
		}
		return \Yii::$app->view->renderFile($this->fieldMultiLangView, [
			'inputs' => $inputs
		]);
	}

	public function multiLang()
	{
		$this->multiLang = true;
		return $this;
	}

	protected function withoutBox()
	{
		$this->withoutBox = true;
		return $this;
	}

    /**
     * Makes field remember its value between page reloads
     * @return static the field object itself
     */
    public function sticky()
    {
        $this->options['class'] .= ' sticky';
        return $this;
    }


}