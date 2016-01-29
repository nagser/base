<?php

namespace app\base;

use \Yii;
use \yii\base\Module;
use app\base\helpers\CustomFileHelper;

class CustomModule extends Module
{
	public $mainModel;
	public $searchModel;
	public $recordModel;
    public $modulePath;

    public function init(){
        $this->modulePath = ltrim(str_replace(Yii::getAlias('@app'), '', $this->getBasePath()), '/'); //Путь до текущего модуля
        $this->registerAliases();
        $this->registerModels();
    }

    /**
     * Определение часто используемых алиасов
     * */
    public function registerAliases(){
        Yii::setAlias('@modulePath', $this->modulePath);
        Yii::setAlias('@moduleFullPath', '@app/' . $this->modulePath);
        Yii::setAlias('@moduleAdminForm', '@moduleFullPath/views/admin/_form');
        Yii::setAlias('@moduleAlias', array_pop(explode('/', Yii::getAlias('@moduleFullPath'))));
    }

    /**
     * Загрузка моделей для текущего модуля
     * Используется для корректного наследования контроллеров
     * */
    public function registerModels(){
        $modelsPath = str_replace('/', '\\', 'app/'  . $this->modulePath . '/models/');
        $moduleClass = ucfirst(Yii::getAlias('@moduleAlias'));
        $this->mainModel = $modelsPath . $moduleClass . 'Model';
        $this->searchModel = $modelsPath . $moduleClass . 'Search';
        $this->recordModel = $modelsPath . $moduleClass . 'Record';
    }

//    /**
//     * Получение локализации для модуля
//     * */
//    public function getModuleMessages(){
//        $currentLanguage = Yii::$app->language;
//        $moduleLangFile = Yii::getAlias('@moduleFullPath').'/messages/'.$currentLanguage.'/'.Yii::getAlias('@moduleAlias') . '.php';
//        $systemLangFile = Yii::getAlias('@app').'/base/messages/'.$currentLanguage.'/system.php';
//        $yiiLangFile = Yii::getAlias('@yii').'/messages/'.$currentLanguage.'/yii.php';
//        $params = [
//            'strict' => false,
//            'return' => []
//        ];
//        return [
//            'moduleLang' => CustomFileHelper::requireFile($moduleLangFile, $params),
//            'systemLang' => CustomFileHelper::requireFile($systemLangFile, $params),
//            'yiiLang' => CustomFileHelper::requireFile($yiiLangFile, $params)
//        ];
//    }

}
