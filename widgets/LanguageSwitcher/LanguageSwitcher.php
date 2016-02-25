<?php

namespace app\base\widgets\LanguageSwitcher;

use yii\bootstrap\Dropdown;
use \Yii;

class LanguageSwitcher extends Dropdown
{
	private static $_labels;

	private $_isError;

	public function init()
	{
		$route = Yii::$app->controller->route;
		$appLanguage = Yii::$app->language;
		$params = $_GET;
		$this->_isError = $route === Yii::$app->errorHandler->errorAction;
		array_unshift($params, '/'.$route);
		foreach (Yii::$app->urlManager->languages as $language) {
			$isWildcard = substr($language, -2)==='-*';
			if (
				$language===$appLanguage ||
				// Also check for wildcard language
				$isWildcard && substr($appLanguage,0,2)===substr($language,0,2)
			) {
				continue;   // Exclude the current language
			}
			if ($isWildcard) {
				$language = substr($language,0,2);
			}
			$params['language'] = $language;
			$this->items[] = [
				'code' => $language,
				'url' => $params,
			];
		}
		parent::init();
	}

	public function run()
	{
		return $this->render('languageSwitcher', [
			'items' => $this->items
		]);
	}

//	public static function label($code)
//	{
//		return Yii::t('system', 'languages.' . $code);
//	}
}