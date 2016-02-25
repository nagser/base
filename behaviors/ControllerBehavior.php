<?php

namespace nagser\base\behaviors;

use nagser\base\helpers\FileHelper;
use nagser\themes\components\ThemeConfigurator;
use yii\base\Behavior;
use nagser\base\controllers\Controller;
use \Yii;
use yii\helpers\Json;
use yii\web\View;


/** @property $owner Controller**/
class ControllerBehavior extends Behavior
{

    public $module;
	public $layout = 'frontend';

	public function events()
	{
		return [
			Controller::EVENT_BEFORE_ACTION => 'beforeAction',
		];
	}

	/**
	 * "beforeAction" Handle
	 * */
	public function beforeAction()
	{
        $this->owner->layout = $this->loadLayout();
		$this->registerTranslationsInJs();
		$this->registerNotificationsInJs();
	}

	/**
	 * Динамическая загрузка темы оформления, которая указана в настройках сайта/проекта/контроллере
	 * */
	private function loadLayout(){
        //Присвоить алиасы для текущей темы оформления
        Yii::setAlias('@currentTheme', Yii::$app->params['themes'][$this->layout]);
        Yii::setAlias('@currentThemePath', Yii::getAlias('@themes') . '/' . Yii::$app->params['themes'][$this->layout]);
        //Сконфигурировать элементы согласно настройкам темы
        new ThemeConfigurator();
        //Вернуть путь к layout
		return '/' . Yii::getAlias('@currentTheme') . '/layouts/' . $this->layout;
	}

	/**
	 * Загрузка перевода в массив JavaScript
	 * */
	private function registerTranslationsInJs()
	{
		$json = Json::encode([
			'system' => FileHelper::requireFile(Yii::getAlias('@vendor').'/nagser/base/messages/'.Yii::$app->language.'/js.php'),
		]);
		Yii::$app->view->registerJs('var language = ' . $json, View::POS_HEAD);
	}

	/**
	 * Регистрация уведомлений для пользователя в JavaScript
	 * */
	private function registerNotificationsInJs()
	{
        $types = ['primary', 'success', 'info', 'warning', 'danger'];
        foreach($types as $type){
            $text = Yii::$app->session->getFlash($type) and $json = Json::encode(['text' => $text, 'type' => $type]);
        }
        isset($json) and Yii::$app->view->registerJs('var notification = ' . $json, View::POS_HEAD);
	}
}