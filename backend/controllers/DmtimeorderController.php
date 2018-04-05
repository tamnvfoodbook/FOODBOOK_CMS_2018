<?php

namespace backend\controllers;

use backend\models\DmposSearch;
use backend\models\MgitemchangedSearch;
use Yii;
use backend\models\Dmtimeorder;
use backend\models\DmtimeorderSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DmtimeorderController implements the CRUD actions for Dmtimeorder model.
 */
class DmtimeorderController extends Controller
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
     * Lists all Dmtimeorder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DmtimeorderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $searchPosModel = new DmposSearch();
        $allPos = $searchPosModel->searchAllPos();
        $posActiveMap= ArrayHelper::map($allPos,'ID','POS_NAME');


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'posActiveMap' => $posActiveMap,
        ]);
    }

    /**
     * Displays a single Dmtimeorder model.
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
     * Creates a new Dmtimeorder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dmtimeorder();

        if ($model->load(Yii::$app->request->post())) {
            foreach($model->DAY_OF_WEEK as $day){
                $modelTmp = new Dmtimeorder();
                $modelTmp->POS_ID = $model->POS_ID;
                $modelTmp->DAY_OF_WEEK = $day;

                if($model->TIME_START){
                    $modelTmp->TIME_START  = date("H:i", strtotime($model->TIME_START));
                }
                if($model->TIME_END){
                    $modelTmp->TIME_END  = date("H:i", strtotime($model->TIME_END));
                }
                $modelTmp->TYPE = $model->TYPE;
                $modelTmp->DAY_OFF = $model->DAY_OFF;
                $modelTmp->ACTIVE = $model->ACTIVE;
                $modelTmp->save();
            }

            $mgItemUpdate = new MgitemchangedSearch();
            $mgItemUpdate->updatechange($model->POS_ID);

            return $this->redirect(['index']);
            //return $this->redirect(['view', 'id' => $model->ID]);
        } else {

            $searchPosModel = new DmposSearch();
            $allPosModel = $searchPosModel->searchAllPos();
            $allPosMap = ArrayHelper::map($allPosModel,'ID','POS_NAME');

            if($model->TIME_START){
                $model->TIME_START  = date("g:i a", strtotime($model->TIME_START));
            }
            if($model->TIME_END){
                $model->TIME_END  = date("g:i a", strtotime($model->TIME_END));
            }

            return $this->render('create', [
                'model' => $model,
                'allPosMap' => $allPosMap,
            ]);
        }
    }

    /**
     * Updates an existing Dmtimeorder model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
//            if($model->TIME_START){
//                $model->TIME_START  = date("H:i", strtotime($model->TIME_START));
//            }
//            if($model->TIME_END){
//                $model->TIME_END  = date("H:i", strtotime($model->TIME_END));
//            }

            $model->save();
            $mgItemUpdate = new MgitemchangedSearch();
            $mgItemUpdate->updatechange($model->POS_ID);

            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            $searchPosModel = new DmposSearch();
            $allPosModel = $searchPosModel->searchAllPos();
            $allPosMap = ArrayHelper::map($allPosModel,'ID','POS_NAME');

//            if($model->TIME_START){
//                $model->TIME_START  = date("g:i a", strtotime($model->TIME_START));
//            }
//            if($model->TIME_END){
//                $model->TIME_END  = date("g:i a", strtotime($model->TIME_END));
//            }



            return $this->render('update', [
                'model' => $model,
                'allPosMap' => $allPosMap,
            ]);
        }
    }

    /**
     * Deletes an existing Dmtimeorder model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Dmtimeorder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Dmtimeorder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dmtimeorder::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
