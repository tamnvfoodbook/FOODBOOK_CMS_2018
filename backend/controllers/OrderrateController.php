<?php

namespace backend\controllers;

use backend\models\Dmpos;
use backend\models\DmposparentSearch;
use backend\models\DmposSearch;
use Yii;
use backend\models\Orderrate;
use backend\models\OrderrateSearch;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderrateController implements the CRUD actions for Orderrate model.
 */
class OrderrateController extends Controller
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
     * Lists all Orderrate models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new OrderrateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $searchPosModel = new DmposSearch();
        $allPos = $searchPosModel->searchAllPos();
        $allPosMap= ArrayHelper::map($allPos,'ID','POS_NAME');

        $searchPosParentModel = new DmposparentSearch();
        $allPosparent = $searchPosParentModel->searchAllParent();
        $allPosparentMap = ArrayHelper::map($allPosparent,'ID','ID');

        $type = \Yii::$app->session->get('type_acc');
        if($type != 1){
            return $this->render('index-pos', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'allPosMap' => $allPosMap,
                'allPosparentMap' => $allPosparentMap,
            ]);

        }else{

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'allPosMap' => $allPosMap,
                'allPosparentMap' => $allPosparentMap,
            ]);
        }
    }

    public function actionReport()
    {
        $searchModel = new OrderrateSearch();
        $dateTime = new \DateTime;

        $post = \Yii::$app->request->post();
        if(@$post['dateRanger']){
            $cutTime1 = substr($post['dateRanger'],0,10); // Cắt đầu chuỗi lấy time start

            $dateTmp  = str_replace('/', '-', $cutTime1);
            $cut1Convert = date('Y-m-d 0:0:0',(strtotime($dateTmp)));
            $time1 = date('c', strtotime($cut1Convert));
            $startDate = new \MongoDate(strtotime($time1));

            $cutTime2 = substr($post['dateRanger'],-10);   // Cắt đầu chuỗi lấy time End
            $dateTmp2  = str_replace('/', '-', $cutTime2);
            $cut2Convert = date('Y-m-d 0:0:0',(strtotime($dateTmp2)));
            $time2 = date('c', strtotime($cut2Convert));
            $endDate = new \MongoDate(strtotime($time2));

            /*echo '<pre>';
            var_dump($time1);
            var_dump($cutTime2);
            echo '</pre>';*/
//            die();

        }else{

            $dateTime->sub(new \DateInterval("P30D"));
            $DAY2 = $dateTime->format( \DateTime::ISO8601 );

            $firstDAY2 = date('Y-m-d 0:0:0',(strtotime($DAY2)));
            $startDate = new \MongoDate(strtotime($firstDAY2));
            $endDate = new \MongoDate(strtotime(date('c')));
        }

        $data = $searchModel->reportRate($startDate,$endDate);

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' =>
                    [
                        'rate_average'
                    ],
            ],
            'pagination' => false
        ]);


        $searchPosModel = new DmposSearch();
        $allPos = $searchPosModel->searchAllPos();
        $allPosMap= ArrayHelper::map($allPos,'ID','POS_NAME');
        if(@$post['dateRanger']){
            return $this->renderAjax('_form_report', [
                'dataProvider' => $dataProvider,
                'allPosMap' => $allPosMap
            ]);
        }else{
            return $this->render('index-pos', [
                'dataProvider' => $dataProvider,
                'allPosMap' => $allPosMap
            ]);
        }

    }

    /**
     * Displays a single Orderrate model.
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
     * Creates a new Orderrate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Orderrate();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => (string)$model->_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Orderrate model.
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
     * Deletes an existing Orderrate model.
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
     * Finds the Orderrate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return Orderrate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orderrate::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
