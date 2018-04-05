<?php

namespace backend\controllers;

use backend\models\DmcitySearch;
use Yii;
use backend\models\Dmdistrict;
use backend\models\DmdistrictSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DmdistrictController implements the CRUD actions for Dmdistrict model.
 */
class DmdistrictController extends Controller
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
     * Lists all Dmdistrict models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DmdistrictSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $allDistrict = $searchModel->searchAllDistrict();
        $allDistrictMap= ArrayHelper::map($allDistrict,'DISTRICT_NAME','DISTRICT_NAME');

        $searchCityModel = new DmcitySearch();
        $allCity = $searchCityModel->searchAllCity();
        $allCityMap= ArrayHelper::map($allCity,'ID','CITY_NAME');


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'allDistrictMap' => $allDistrictMap,
            'allCityMap' => $allCityMap,
        ]);
    }

    /**
     * Displays a single Dmdistrict model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Dmdistrict model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dmdistrict();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            $searchCityModel = new DmcitySearch();
            $allCity = $searchCityModel->searchAllCity();
            $allCityMap= ArrayHelper::map($allCity,'ID','CITY_NAME');

            return $this->render('create', [
                'model' => $model,
                'allCityMap' => $allCityMap,
            ]);
        }
    }

    /**
     * Updates an existing Dmdistrict model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
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
            $searchCityModel = new DmcitySearch();
            $allCity = $searchCityModel->searchAllCity();
            $allCityMap= ArrayHelper::map($allCity,'ID','CITY_NAME');

            return $this->render('update', [
                'model' => $model,
                'allCityMap' => $allCityMap,
            ]);
        }
    }

    /**
     * Deletes an existing Dmdistrict model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
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
     * Finds the Dmdistrict model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Dmdistrict the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dmdistrict::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
