<?php

namespace app\base\widgets\Menu;

use \Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\widgets\Menu;

class AdminMenu extends Widget
{
	private $menuArray = array();
	private $route = '';
	private $itemTemplate = '@widgets/Menu/views/AdminMenuItemView';
	private $submenuTemplate = '<ul class="nav sub-nav">{items}</ul>';
	public $suffix = '/admin';


	public function init(){
		parent::init();
		$this->getCurrentRoute();
		$this->getMenuArray();
		$this->getMenuList();
	}

	/**
	 * Is active item?
	 * @param $item array
	 * @return bool
	 * */
	public function isItemActive($item){
		$moduleName = $this->getModuleName($item);
		return $moduleName === $this->route;
	}

	public function getModuleName($item){
		$url = ArrayHelper::getValue($item, 'url', '/');
		$arrUrl = explode('/', ltrim(ArrayHelper::getValue($url, '0', $url), '/'));
		return trim(ArrayHelper::getValue($arrUrl, '0', 'main'));
	}

	/**
	 * Get modules list from config/web.php
	 * */
	private function getMenuArray(){
		foreach (Yii::$app->params['modules'] as $key_1 => $level_1) {

			if(isset($level_1['params']['excludeFromMenu'])) continue;

			//Уровень меню 1
			$this->menuArray[$key_1] = [
				'label' => Yii::t($key_1, isset($level_1['params']['menuMessage']) ? $level_1['params']['menuMessage'] : ucfirst($key_1)),
				'url' => [ArrayHelper::getValue($level_1['params'], 'menuRoute', '/'.$key_1.$this->suffix)],
				'template' => $this->getItemTemplate($level_1, false, $this->isItemActive(['url' => [ArrayHelper::getValue($level_1['params'], 'menuRoute', '/'.$key_1.$this->suffix)]]), true),
				'active' => $this->isItemActive(['url' => ['/'.$key_1.'/'.$this->suffix]]),
			];

			if (isset($level_1['modules'])) {
				foreach ($level_1['modules'] as $key_2 => $level_2) {
					//Уровень меню 2
					$this->menuArray[$key_1]['items'][] = [
						'label' => Yii::t('system', 'modules.' . $key_1.'.'.$key_2),
						'url' => ['/'.$key_1.'/'.$key_2.$this->suffix],
						'template' => $this->getItemTemplate($level_2, false, $this->isItemActive(['url' => ['/'.$key_1.'/'.$key_2.$this->suffix]])),
					];
					$this->menuArray[$key_1]['template'] = $this->getItemTemplate($level_1, true, $this->isItemActive(['url' => ['/'.$key_1.'/'.$key_2.$this->suffix]]));
					$this->menuArray[$key_1]['submenuTemplate'] = $this->submenuTemplate;

//					if (isset($level_2['modules'])) {
//						foreach ($level_2['modules'] as $key_3 => $level_3) {
//							//Уровень меню 3
//							$this->menuArray[$key_1]['items'][$key_2]['items'][] = [
//								'label' => Yii::t('system', $key_3),
//								'url' => ['/'.$key_1.'/'.$key_2.'/'.$key_3.$this->suffix],
//								'template' => $this->getItemTemplate($level_3),
//							];
//							$this->menuArray[$key_1]['items'][$key_2]['template'] = $this->getParentItemTemplate($level_2);
//						}
//					}
				}
			}
		}
	}


	private function getItemTemplate($module, $isParent, $isActive, $firstLevel = false){
		$params = [
			'iconLeft' => $this->getIcon($module),
			'isActive' => $isActive,
			'isParent' => $isParent,
			'firstLevel' => $firstLevel
		];
		return $this->render($this->itemTemplate, $params);
	}

	/**
	 * Get menu item icon
	 * @param $module array
	 * @return string
	 * */
	private function getIcon($module){
		return isset($module['params']['menuIcon']) ? '<span class="'.$module['params']['menuIcon'].'"></span> ' : null;
	}

	/**
	 * Delete Controller action from route
	 * */
	private function getCurrentRoute() {
		$route = explode('/', ltrim(Yii::$app->controller->getRoute()));
		$this->route = trim(ArrayHelper::getValue($route, '0', '/'));
	}

	/**
	 *
	 * @return Menu object
	 * */
	private function getMenuList(){
		return Menu::widget([
			'options' => [
				'class' => 'nav sidebar-menu',//parent ul class
			],
			'activeCssClass' => 'active',
			'activateParents' => true,
			'items' => $this->menuArray,
			'route' => $this->route,
		]);
	}

	/**
	 * Final run widget and output menu
	 * @return Menu
	 * */
	public function run(){
		return $this->getMenuList();
	}
}