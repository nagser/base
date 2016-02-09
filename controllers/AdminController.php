<?php

namespace nagser\base\controllers;

use nagser\base\behaviors\AdminControllerBehavior;
use omgdef\multilingual\MultilingualQuery;
use \Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use nagser\base\models\Model;

class AdminController extends Controller
{

    public $layout = 'backend';
    public $params;

    /**
     * Behaviors
     * */
    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(), [
                'controller' => [
                    'class' => AdminControllerBehavior::className(),
                ],
            ]
        );
    }

    /**
     * Default Controllers Begin
     * Index Controller
     * */
    public function actionIndex()
    {
        $modelSearch = Yii::createObject($this->modelSearch);
        $dataProvider = $modelSearch->search(\Yii::$app->request->queryParams);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'modelSearch' => $modelSearch,
        ]);
    }

    /**
     * Create || Update item
     * @param integer $id
     * @return mixed
     * */
    public function actionUpdate($id = null)
    {
        if ($id) {
            $model = $this->findRecordModel($id);
        } else {
            $model = Yii::createObject($this->model);
        }

        /** @var Model $model * */
        if ($model->load(Yii::$app->request->post()) and $model->save()) {
            $this->trigger(self::EVENT_AFTER_UPDATE);
        } else {
            if (Yii::$app->request->isAjax) {
                return $this->renderAjax('update', [
                    'model' => $model,
                ]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Deletes an existing CustomRecordModel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        /** @var Model $recordModel * */
        if ($model = $this->findRecordModel($id)) {
            $model->delete();
            if(Yii::$app->request->isAjax){
                return json_encode(['id' => $id, 'type' => 'success', 'message' => \Yii::t('system', 'Delete completed')], JSON_UNESCAPED_UNICODE);
            } else {
                \Yii::$app->getSession()->setFlash('success', \Yii::t('system', 'Delete completed'));
                return $this->redirect(['index']);
            }
        }
        return false;
    }

    /**
     * Показать одну запись
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if ($model = $this->findRecordModel($id)) {
            if (Yii::$app->request->isAjax) {
                return $this->renderAjax('view', [
                    'model' => $model,
                ]);
            } else {
                return $this->render('view', [
                    'model' => $model,
                ]);
            }
        }
        return false;
    }

    /**
     * @param string $search
     * @param string $value
     * @param string $colAlias
     * @return Json
     * */
    public function actionSelect2List($search = '', $value = '', $colAlias = 'title')
    {
        /** @var Model $recordModel * */
        $model = $this->model;
        /** @var Model $recordModelObject * */
        $modelObject = Yii::createObject($model);
        $table = $model::tableName();
        $alias = $modelObject->isMultiLangField($colAlias) ? $colAlias : $table . '.' . $colAlias;
        $out = ['more' => false];
        if (!is_null($search)) {
            $query = new MultilingualQuery($model);
            $query->select('DISTINCT(' . $alias . ') AS id, ' . $alias . ' AS text')
                ->from($table);
            if ($modelObject->isMultiLangField($colAlias)) {
                $query->joinWith('translation');
            }
            $query->where($alias . ' LIKE "%' . $search . '%"')
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($value > 0) {
            $out['results'] = ['id' => $value, 'text' => $model::find($value)->$colAlias];
        }
        return Json::encode($out);
    }


}