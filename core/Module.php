<?php

namespace nagser\base\core;

use \Yii;

class Module extends \yii\base\Module
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

}
