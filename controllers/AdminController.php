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
        $searchModel = new $this->searchModel;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
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
            $recordModel = $this->findRecordModel($id);
        } else {
            $recordModel = new $this->recordModel;
        }

        /** @var Model $recordModel * */
        if ($recordModel->load(Yii::$app->request->post()) and $recordModel->save()) {
            $this->trigger(self::EVENT_AFTER_UPDATE);
        } else {
            if (Yii::$app->request->isAjax) {
                return $this->renderAjax('update', [
                    'recordModel' => $recordModel,
                ]);
            } else {
                return $this->render('update', [
                    'recordModel' => $recordModel,
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
        if ($recordModel = $this->findRecordModel($id)) {
            $recordModel->delete();
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
        if ($recordModel = $this->findRecordModel($id)) {
            if (Yii::$app->request->isAjax) {
                return $this->renderAjax('view', [
                    'recordModel' => $recordModel,
//					'model' => new Model(),
                ]);
            } else {
                return $this->render('view', [
                    'recordModel' => $recordModel,
//					'model' => new Model(),
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
        $recordModel = $this->recordModel;
        /** @var Model $recordModelObject * */
        $recordModelObject = new $recordModel;
        $table = $recordModel::tableName();
        $alias = $recordModelObject->isMultiLangField($colAlias) ? $colAlias : $table . '.' . $colAlias;
        $out = ['more' => false];
        if (!is_null($search)) {
            $query = new MultilingualQuery($recordModel);
            $query->select('DISTINCT(' . $alias . ') AS id, ' . $alias . ' AS text')
                ->from($table);
            if ($recordModelObject->isMultiLangField($colAlias)) {
                $query->joinWith('translation');
            }
            $query->where($alias . ' LIKE "%' . $search . '%"')
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($value > 0) {
            $out['results'] = ['id' => $value, 'text' => $recordModel::find($value)->$colAlias];
        }
        return Json::encode($out);
    }


}