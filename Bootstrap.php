<?php

namespace nagser\base;

use yii\base\BootstrapInterface;
use yii\helpers\ArrayHelper;

class Bootstrap implements BootstrapInterface {

    private $_modelMap = [
        'model' => 'nagser/base/models/Model',
        'modelMultiLang' => 'nagser/base/models/ModelMultiLang',
    ];

    /**
     * @inheritdoc
     * */
    public function bootstrap($app){
        /**@var Module $module**/
//        $module = $app->getModule('base');
//        $this->_modelMap = ArrayHelper::merge($this->_modelMap, $module->modelMap);
//        foreach ($this->_modelMap as $name => $definition) {
//            $class = "nagser\\logger\\models";
//            \Yii::$container->set($class, $definition);
//            $modelName = is_array($definition) ? $definition['class'] : $definition;
//            $module->modelMap[$name] = $modelName;
//        }
    }

}