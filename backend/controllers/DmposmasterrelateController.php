<?php

namespace backend\controllers;

use backend\models\DmcitySearch;
use backend\models\Dmpos;
use backend\models\DmposmasterSearch;
use backend\models\DmposparentSearch;
use backend\models\DmposSearch;
use Yii;
use backend\models\Dmposmasterrelate;
use backend\models\DmposmasterrelateSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DmposmasterrelateController implements the CRUD actions for Dmposmasterrelate model.
 */
class DmposmasterrelateController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Dmposmasterrelate models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DmposmasterrelateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $searchPosModel = new DmposSearch();
        $allPos = $searchPosModel->searchAllPos();
        $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');

        $searchCityModel = new DmcitySearch();
        $allCity = $searchCityModel->searchAllCity();
        $allCityMap = ArrayHelper::map($allCity,'ID','CITY_NAME');

        $searchPosMasterModel = new DmposmasterSearch();
        $allPosMaster = $searchPosMasterModel->searchAllPosmaster();
        $allPosMasterMap = ArrayHelper::map($allPosMaster,'ID','POS_MASTER_NAME');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'allPosMap' => $allPosMap,
            'allPosMasterMap' => $allPosMasterMap,
            'allCityMap' => $allCityMap,
        ]);
    }

    /**
     * Displays a single Dmposmasterrelate model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Dmposmasterrelate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dmposmasterrelate();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {

            $searchPosModel = new DmposSearch();
            $allPosModel = $searchPosModel->searchAllPos();
            $allPosMap = ArrayHelper::map($allPosModel,'ID','POS_NAME');

            $searchPosmasterModel = new DmposmasterSearch();
            $allPosmastertModel = $searchPosmasterModel->searchAllPosmaster();
            $allPosmasterMap = ArrayHelper::map($allPosmastertModel,'ID','POS_MASTER_NAME','city.CITY_NAME');

            return $this->render('create', [
                'model' => $model,
                'allPosMap' => $allPosMap,
                'allPosmasterMap' => $allPosmasterMap,
            ]);
        }
    }

    /**
     * Updates an existing Dmposmasterrelate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldModel = $model->oldAttributes;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            DmquerylogController::actionCreateLog('UPDATE',get_class($model),$oldModel,$model->attributes);
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {


            $keyAllposMap = Yii::$app->params['KEY_ALL_POS_MAP'];
            //Yii::$app->cache->delete($keyAllposMap);

            $allPosMap = \Yii::$app->cache->get($keyAllposMap);
            if ($allPosMap === false) {
                $searchPosModel = new DmposSearch();
                $allPosModel = $searchPosModel->searchAllPos();
                $allPosMap = ArrayHelper::map($allPosModel,'ID','POS_NAME');
                \Yii::$app->cache->set($keyAllposMap, $allPosMap, 43200); // time in seconds to store cache
            }

            $keyAllPosmasterMap = Yii::$app->params['KEY_ALL_POSMASTER_MAP'];
            //Yii::$app->cache->delete($keyAllPosmasterMap);

            $allPosmasterMap = \Yii::$app->cache->get($keyAllPosmasterMap);

            if ($allPosmasterMap === false) {
                $searchPosmasterModel = new DmposmasterSearch();
                $allPosmastertModel = $searchPosmasterModel->searchAllPosmaster();
                $allPosmasterMap = ArrayHelper::map($allPosmastertModel,'ID','POS_MASTER_NAME','city.CITY_NAME');
                \Yii::$app->cache->set($keyAllPosmasterMap, $allPosmasterMap, 43200); // time in seconds to store cache
            }

            return $this->render('update', [
                'model' => $model,
                'allPosMap' => $allPosMap,
                'allPosmasterMap' => $allPosmasterMap,
            ]);
        }
    }

    /**
     * Deletes an existing Dmposmasterrelate model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        DmquerylogController::actionCreateLog('DELETE',get_class($model),$model->oldAttributes,null);

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Dmposmasterrelate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Dmposmasterrelate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dmposmasterrelate::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
