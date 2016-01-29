<?php

namespace app\base;

use app\base\behaviors\CustomControllerBehavior;
use dektrium\user\models\Profile;
use \Yii;
use yii\base\ActionEvent;
use \yii\web\Controller;
use \yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use app\base\models\CustomRecordModel;
use app\base\models\CustomSearchModel;


/**
 * @property CustomRecordModel $recordModel
 * @property CustomSearchModel $searchModel
 * */
class CustomController extends Controller
{

    const EVENT_AFTER_CREATE = 'afterCreate';
    const EVENT_AFTER_UPDATE = 'afterUpdate';

    public $layout = 'frontend';

    /**
     * @object $module
     * @see CustomModule
     * */
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
                'class' => CustomControllerBehavior::className(),
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
    protected function getRecordModel()
    {
        return $this->module->recordModel;
    }

    /**
     * Геттер для поисковой модели
     * @return string
     * */
    protected function getSearchModel()
    {
        return $this->module->searchModel;
    }

    /**
     * Поиск модели
     * @param $id integer||string
     * @throws NotFoundHttpException
     * @return object app\base\models\CustomRecordModel
     */
    protected function findRecordModel($id)
    {
        $recordModel = $this->recordModel;
        if((new $recordModel)->multiLangAttributes){
            $model = $recordModel::find()->where(array('id' => $id))->multilingual()->one();
        } else {
            $model = $recordModel::find()->where(array('id' => $id))->one();
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