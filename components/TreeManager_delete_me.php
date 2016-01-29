<?php

namespace app\base\components;

use \Yii;
use yii\base\Component;
use yii\base\ErrorException;
use yii\helpers\ArrayHelper;

class TreeManager extends Component
{
	/**
	 * source array
	 * @var mixed
	 * */
	public $array;

	/**
	 * Tree element namespace
	 * @var mixed
	 * */
	private $namespace;

	/**
	 * @param $array mixed
	 * @return mixed
	 * @throws ErrorException
	 * */
	public function getModulesTree($array = []){
		$this->array = $array;
		if(is_array($this->array)){
			$this->buildTreeRecursive($this->array);
		} else {
			throw new ErrorException('Source $array empty type');
		}
		return array_values($this->array);
	}

	/**
	 * Build tree for fancyTree widget
	 * @param $modules mixed
	 * @param $depth integer
	 * */
	private function buildTreeRecursive(&$modules, $depth = -1)
	{
		$depth++;//текущая вложенность
		//замена на числовые ключи
		$keys = $this->arrayValues($modules);
		foreach($modules as $key => &$module){
			//Удаление служебных модулей
			if(ArrayHelper::getValue($module, 'params') and ArrayHelper::getValue($module['params'], 'excludeFromMenu')) {
				unset($modules[$key]);
				continue;
			}
			//Удаление лишних параметров
			unset($module['params'], $module['class']);
			//построение роутов
			$this->namespace[$depth] = ArrayHelper::getValue($keys, $key, $key);
			//название модуля согласно роуту
			$module['key'] = implode('.', $this->getNamespace($depth));
			$module['title'] = Yii::t('system', 'modules.'.$module['key']);
			//проверка на дочерние модули, замена ключа
			if(ArrayHelper::getValue($module, 'modules')){
				$this->replaceKey($module);
				$this->buildTreeRecursive($module['children'], $depth);
			}
		}
	}

	/**
	 * @param $array mixed
	 * */
	private function replaceKey(&$array){
		$array['children'] = &$array['modules'];
		unset($array['modules']);
	}

	/**
	 * @param $array mixed
	 * @return mixed
	 * */
	private function arrayValues(&$array){
		$keys = [];
		foreach($array as $key => $value){
			$keys[] = $key;
		}
		$array = array_values($array);
		return $keys;
	}

	/**
	 * Build Namespace(route) for Internationalization (I18N)
	 * @param $depth integer
	 * @return mixed
	 * */
	private function getNamespace($depth){
		$namespace = [];
		for($i = 0; $i <= $depth; $i++){
			if(ArrayHelper::getValue($this->namespace, $i)){
				$namespace[] = $this->namespace[$i];
			}
		}
		return $namespace;
	}
}