<?php

namespace backend\controllers;

use backend\models\DmposSearch;
use backend\models\DmvouchercampaignSearch;
use Yii;
use backend\models\Dmvoucherlog;
use backend\models\DmvoucherlogSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DmvoucherlogController implements the CRUD actions for Dmvoucherlog model.
 */
class DmvoucherlogController extends Controller
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
     * Lists all Dmvoucherlog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $type = \Yii::$app->session->get('type_acc');

        if($type == 1){
            $searchModel = new DmvoucherlogSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            $searchPosModel = new DmposSearch();
            $allPos = $searchPosModel->searchAllPos();
            $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'allPosMap' => $allPosMap,
            ]);
        }else{
            $searchModel = new DmvoucherlogSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $searchPosModel = new DmposSearch();
            $allPos = $searchPosModel->searchAllPos();
            $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');

            $posParent = \Yii::$app->session->get('pos_parent');
            $searchCampaignModel = new DmvouchercampaignSearch();
            $allCampagin = $searchCampaignModel->searchAllCampainByPosParent($posParent);
            $allCampaginMap = ArrayHelper::map($allCampagin,'ID','VOUCHER_NAME');

            return $this->render('index_pos', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'allPosMap' => $allPosMap,
                'allCampaginMap' => $allCampaginMap,
            ]);
        }

    }
    public function actionReport()
    {
        $type = \Yii::$app->session->get('type_acc');

        $searchModel = new DmvoucherlogSearch();
        $dataProvider = $searchModel->searchReport(Yii::$app->request->queryParams);
        $dataProvider->setSort(false);

        $searchPosModel = new DmposSearch();
        $allPos = $searchPosModel->searchAllPos();
        $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');

        $posParent = \Yii::$app->session->get('pos_parent');
        $searchCampaignModel = new DmvouchercampaignSearch();
        $allCampagin = $searchCampaignModel->searchAllCampainByPosParent($posParent);
        $allCampaginMap = ArrayHelper::map($allCampagin,'ID','VOUCHER_NAME');


        return $this->render('report', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'allPosMap' => $allPosMap,
            'allCampaginMap' => $allCampaginMap,
        ]);

    }

    public function actionCheck($vouchercode = null)
    {
        $type = \Yii::$app->session->get('type_acc');
        $searchModel = new DmvoucherlogSearch();
        if($vouchercode){
            $model = $searchModel->searchCheckWithCode($vouchercode);
            $searchModel->VOUCHER_CODE = $vouchercode;
        }else{
            $model = $searchModel->searchCheckvoucher(Yii::$app->request->queryParams);
        }

//        die();

        $searchPosModel = new DmposSearch();
        $allPos = $searchPosModel->searchAllPos();
        $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');
        if(isset($model->USED_POS_ID)){
            $model->USED_POS_ID = @$allPosMap[@$model->USED_POS_ID];
        }

        return $this->render('checkvoucher', [
            'searchModel' => $searchModel,
            'allPosMap' => $allPosMap,
            'model' => $model,
        ]);

    }

    public function actionCheckajax($vouchercode)
    {
        $searchModel = new DmvoucherlogSearch();
        $model = $searchModel->searchCheckWithCode($vouchercode);
        $searchPosModel = new DmposSearch();
        $allPos = $searchPosModel->searchAllPos();
        $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');
        if(isset($model->USED_POS_ID)){
            $model->USED_POS_ID = @$allPosMap[@$model->USED_POS_ID];
        }


        return $this->renderAjax('view_ajax', [
            'searchModel' => $searchModel,
            'allPosMap' => $allPosMap,
            'model' => $model,
        ]);

    }

    /**
     * Displays a single Dmvoucherlog model.
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
     * Creates a new Dmvoucherlog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dmvoucherlog();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->VOUCHER_CODE]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Dmvoucherlog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->VOUCHER_CODE]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Dmvoucherlog model.
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
     * Finds the Dmvoucherlog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Dmvoucherlog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dmvoucherlog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
