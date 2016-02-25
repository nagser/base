<?php

namespace nagser\base\components;

use codemix\localeurls\UrlManager as CodeMixUrlManager;
use \Yii;
use yii\helpers\ArrayHelper;

class UrlManager extends CodeMixUrlManager {

	public function init(){
		/*
		 * Чтобы избежать бесконечного редиректа смотрим, есть ли у сайта
		 * язык, который установлен в куках пользователя
		 * Есть такого языка нет, устанавливаем язык по умолчанию
		 * */
		if(!ArrayHelper::getValue($this->languages, Yii::$app->session[$this->languageSessionKey])){
			Yii::$app->session[$this->languageSessionKey] = Yii::$app->language;
		}
		parent::init();
	}

}