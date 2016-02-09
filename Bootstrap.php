<?php

namespace nagser\base;

use yii\base\BootstrapInterface;
use yii\helpers\ArrayHelper;

class Bootstrap implements BootstrapInterface {

    private $_modelMap = [
        'Model' => 'nagser\base\models\Model',
    ];

    public function bootstrap($app){
        /**@var Module $module**/
        $module = $app->getModule('base');
        $this->_modelMap = ArrayHelper::merge($this->_modelMap, $module->modelMap);
        foreach ($this->_modelMap as $name => $definition) {
            $class = "nagser\\base\\models\\" . $name;
            \Yii::$container->set($class, $definition);
            $modelName = is_array($definition) ? $definition['class'] : $definition;
            $module->modelMap[$name] = $modelName;
        }
        //Загрузка языков
        if (!isset($app->get('i18n')->translations['system'])) {
            $app->get('i18n')->translations['system'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@app/vendor/nagser/base/messages',
                'fileMap' => ['system' => 'system.php']
            ];
        }
        if (!isset($app->get('i18n')->translations['js'])) {
            $app->get('i18n')->translations['js'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@app/vendor/nagser/base/messages',
                'fileMap' => ['js' => 'js.php']
            ];
        }
    }

}