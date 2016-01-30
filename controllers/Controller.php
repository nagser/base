<?php

namespace nagser\base\controllers;

use nagser\base\behaviors\ControllerBehavior;
use \Yii;
use \yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use nagser\base\models\Model;

/**
 * @property Model $model
 * @property Model $searchModel
 * */
class Controller extends \yii\web\Controller
{

    const EVENT_AFTER_CREATE = 'afterCreate';
    const EVENT_AFTER_UPDATE = 'afterUpdate';

    public $layout = 'frontend';

    /**@var \nagser\base\Module **/
    public $module;

    public function init(){
        parent::init();
        $this->on(self::EVENT_AFTER_UPDATE, [$this, 'afterUpdate']);
    }

    /**
     * Behaviors
     * */
    public function behaviors()
    {
        return [
            'controller' => [
                'class' => ControllerBehavior::className(),
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Событие после обновления модели в контроллере Update
     * */
    protected function afterUpdate(){
        return $this->redirect(['index']);
    }

    /**
     * Геттер для модели
     * @return string
     * */
    protected function getModel()
    {
        return ArrayHelper::getValue($this->module->modelMap, 'Model', 'nagser\base\models\Model');
    }

    /**
     * Геттер для поисковой модели
     * @return string
     * */
    protected function getSearchModel()
    {
        return ArrayHelper::getValue($this->module->modelMap, 'SearchModel', 'nagser\base\models\Model');
    }

    /**
     * Поиск модели
     * @param $id integer||string
     * @throws NotFoundHttpException
     * @return object app\base\models\CustomRecordModel
     */
    protected function findRecordModel($id)
    {
        $model = $this->model;
        if((new $model)->multiLangAttributes){
            $model = $model::find()->where(array('id' => $id))->multilingual()->one();
        } else {
            $model = $model::find()->where(array('id' => $id))->one();
        }
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException;
        }
    }

    /**
     * Index Controller
     * */
    public function actionIndex()
    {
        return $this->render('index');
    }

}