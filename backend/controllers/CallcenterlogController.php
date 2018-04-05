<?php

namespace backend\controllers;

use backend\models\DmposparentSearch;
use Yii;
use backend\models\Callcenterlog;
use backend\models\CallcenterlogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * CallcenterlogController implements the CRUD actions for Callcenterlog model.
 */
class CallcenterlogController extends Controller
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
     * Lists all Callcenterlog models.
     * @return mixed
     */
    public function actionIndex($all = null)
    {
        $callcenter_ext  = \Yii::$app->session->get('callcenter_ext');
        $posParent = \Yii::$app->session->get('pos_parent');

        $searchPosparentModel = new DmposparentSearch();
        $posParentModel = $searchPosparentModel->searchPosparentById($posParent);
        $searchModel = new CallcenterlogSearch();
        $dataProvider = $searchModel->getDataccmonitor(Yii::$app->request->queryParams,$all,$posParentModel);

        if(!isset(Yii::$app->request->queryParams['CallcenterlogSearch']['dateTime'])){
            $timeRanger = date('d/m/Y').' - '.date('d/m/Y');
        }else{
            $timeRanger = Yii::$app->request->queryParams['CallcenterlogSearch']['dateTime'];
        }


        return $this->render('index', [
            //'dataCallcenter' => $dataCallcenter,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'timeRanger' => $timeRanger,
            'callcenter_ext' => $callcenter_ext,
            'ws_server' => @$posParentModel->WS_SIP_SERVER,
            'ws_pass' => @$posParentModel->PASS_SIP_SERVER,
            'all' => $all,
        ]);
    }

    public function actionCcmonitor($all = null)
    {
        $callcenter_ext  = \Yii::$app->session->get('callcenter_ext');
        $posParent = \Yii::$app->session->get('pos_parent');

        $searchPosparentModel = new DmposparentSearch();
        $posParentModel = $searchPosparentModel->searchPosparentById($posParent);
        $searchModel = new CallcenterlogSearch();
        $dataProvider = $searchModel->getDataccmonitor(Yii::$app->request->queryParams,$all,$posParentModel);

        if(!isset(Yii::$app->request->queryParams['CallcenterlogSearch']['dateTime'])){
            $timeRanger = date('d/m/Y').' - '.date('d/m/Y');
        }else{
            $timeRanger = Yii::$app->request->queryParams['CallcenterlogSearch']['dateTime'];
        }


        return $this->render('monitor', [
            //'dataCallcenter' => $dataCallcenter,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'timeRanger' => $timeRanger,
            'callcenter_ext' => $callcenter_ext,
            'ws_server' => @$posParentModel->WS_SIP_SERVER,
            'ws_pass' => @$posParentModel->PASS_SIP_SERVER,
            'all' => $all,
        ]);
    }

    /**
     * Displays a single Callcenterlog model.
     * @param integer $_id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Callcenterlog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Callcenterlog();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => (string)$model->_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Callcenterlog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => (string)$model->_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Callcenterlog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Callcenterlog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return Callcenterlog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Callcenterlog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
