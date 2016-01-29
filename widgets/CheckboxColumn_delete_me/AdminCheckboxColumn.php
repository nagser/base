<?php

namespace app\base\widgets\CheckboxColumn;

use kartik\builder\Form;
use kartik\checkbox\CheckboxX;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Html;
use Closure;
use yii\helpers\ArrayHelper;

class AdminCheckboxColumn extends \kartik\grid\CheckboxColumn {

	public $buttons = [];

	public function init(){
		parent::init();

	}

	/**
	 * Renders the header cell content.
	 * The default implementation simply renders [[header]].
	 * This method may be overridden to customize the rendering of the header cell.
	 * @return string the rendering result
	 */
	protected function renderHeaderCellContent()
	{
		$name = rtrim($this->name, '[]') . '_all';
		$id = $this->grid->options['id'];
		$options = json_encode([
			'name' => $this->name,
			'multiple' => $this->multiple,
			'checkAll' => $name,
		], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		$this->grid->getView()->registerJs("jQuery('#$id').yiiGridView('setSelectionColumn', $options);");

		if ($this->header !== null || !$this->multiple) {
			return parent::renderHeaderCellContent();
		} else {
			return Html::checkBox($name, false, ['class' => 'select-on-check-all']);
		}
	}

//	public $useCustomCheckbox;
//	public $customCheckbox;
//
//	public function __construct($config = []){
//		parent::__construct($config);
//		$this->customCheckbox = function($name, $options){
//			$id = 'id_' . rand(111111111, 999999999);
//			$content = [
//				Html::beginTag('div', ['class' => 'checkbox-custom checkbox-primary gridView']),
//					Html::checkbox($name, !empty($options['checked']), ArrayHelper::merge(['id' => $id], $options)),
//					Html::label('', $id, ArrayHelper::getValue($options, 'labelOptions')),
//					Html::tag('span', '', ['class' => 'checkbox']),
//				Html::endTag('div'),
//			];
//			return implode('', $content);
//		};
//	}
//
//    /**
//     * @inheritdoc
//     */
//    protected function renderDataCellContent($model, $key, $index)
//    {
//        if ($this->checkboxOptions instanceof Closure) {
//            $options = call_user_func($this->checkboxOptions, $model, $key, $index, $this);
//        } else {
//            $options = $this->checkboxOptions;
//            if (!isset($options['value'])) {
//                $options['value'] = is_array($key) ? json_encode($key, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : $key;
//            }
//        }
//		//Замена на стильный чекбокс
//		return $this->useCustomCheckbox ? call_user_func($this->customCheckbox, $this->name, $options) : Html::checkbox($this->name, !empty($options['checked']), $options);
//    }

}