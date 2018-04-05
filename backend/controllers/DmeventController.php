<?php

namespace backend\controllers;

use Yii;
use backend\models\Dmevent;
use backend\models\DmeventSearch;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DmeventController implements the CRUD actions for Dmevent model.
 */
class DmeventController extends Controller
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
     * Lists all Dmevent models.
     * @return mixed
     */
    public function actionIndex()
    {

        $apiName = 'ipcc/get_events';
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];
        $paramCommnet = array();
        $dataCustommer = ApiController::getApiByMethod($apiName,$apiPath,$paramCommnet,'GET');
        $data = array();
        if(isset($dataCustommer->data)){
            $data = $dataCustommer->data;
        }

//        echo '<pre>';
//        var_dump($data);
//        echo '</pre>';
//        die();

        return $this->render('index', [
//            'searchModel' => $searchModel,
            'data' => $data,
        ]);
    }
    public function actionReport()
    {

        $searchModel = new DmeventSearch();

        $dataProvider = new ArrayDataProvider([
        ]);
        $dataProvider->allModels = $searchModel->getEvent(Yii::$app->request->queryParams);
        $apiName = 'ipcc/get_campaign_event';
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];

        $paramGetCampaign = array();

        $campagins = ApiController::getApiByMethod($apiName,$apiPath,$paramGetCampaign,'GET');

        $campaginsMap = array();
        if(isset($campagins->data) && count($campagins->data) >0){
            $campaginsMap = ArrayHelper::map($campagins->data,'id','voucher_campaign_name');
        }
        return $this->render('report', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'campaginsMap' => $campaginsMap,
        ]);
    }
    public function actionCampaindetail($campagin_id)
    {

        $apiName = 'ipcc/get_campaign_by_id';
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];

        $paramGetCampaign = [
            'campaign_id' => $campagin_id
        ];

        $campagin = ApiController::getApiByMethod($apiName,$apiPath,$paramGetCampaign,'GET');
//        echo '<pre>';
//        var_dump($campagin->data);
//        echo '</pre>';
//        die();

        return $this->renderPartial('../dmvouchercampaign/view_api', [
            'model' => @$campagin->data
//            'data' => $data,
        ]);
    }

    /**
     * Displays a single Dmevent model.
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
     * Creates a new Dmevent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dmevent();

        $apiName = 'ipcc/get_campaign_event';
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];
        $paramCommnet = array();
        $dataCampain = ApiController::getApiByMethod($apiName,$apiPath,$paramCommnet,'GET');
        $campainsMap = array();
        if(isset($dataCampain->data)){
            foreach($dataCampain->data as $campain){
//                echo '$campain->discount_type'. $campain->discount_type;
//                echo '$campain->discount_amount'. $campain->discount_type;
                if($campain->discount_type == 1){
                    $campainsMap[$campain->id] = 'Giảm '.number_format($campain->discount_amount).' đ - '. $campain->voucher_campaign_name;
                }else{
                    $campainsMap[$campain->id] = 'Giảm '.$campain->discount_extra*100 .' % - '. $campain->voucher_campaign_name;
                }

            }
            //$campainsMap = ArrayHelper::map($dataCampain->data,'id','voucher_campaign_name');
        }


        /*echo '<pre>';
        var_dump($dataCampain);
        echo '</pre>';
        die();*/

        if ($model->load(Yii::$app->request->post())) {
            $array =  (array)$model->attributes;

            $date = explode('/', $model->DATE_START);
            $model->DATE_START  = date('Y-m-d H:i:s', strtotime(implode('-', array_reverse($date))));

            $apiName = 'ipcc/create_event';
            $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];
            $paramCommnet = array_change_key_case($array, CASE_LOWER);
            $paramCommnet['date_start'] = $model->DATE_START;
            $paramCommnet['min_eat_amount'] = doubleval($model->MIN_PAY_AMOUNT);
            $paramCommnet['max_eat_amount'] = doubleval($model->MAX_PAY_AMOUNT);



            $data = ApiController::getApiByMethod($apiName,$apiPath,$paramCommnet,'POST');

            if(isset($data->data)){
                Yii::$app->session->setFlash('success', 'Tạo sự kiện '.$model->EVENT_NAME.' thành công');
                return $this->redirect(['index']);
            }else{
                if(isset($data->error)){
                    Yii::$app->session->setFlash('error', 'Tạo sự kiện lỗi '.@$data->error->message);
                }else{
                    Yii::$app->session->setFlash('error', 'Lỗi kết nối máy chủ');
                }
                return $this->render('create', [
                    'model' => $model,
                    'campains' => $campainsMap,
                ]);
            }

        } else {
            return $this->render('create', [
                'model' => $model,
                'campains' => $campainsMap,
            ]);
        }
    }


    public function actionGetexpected($min_eat_count,$max_eat_count,$min_eat_payment,$max_eat_payment,$last_visit_frequency,$campaign_id,$date_start,$event_name){
        $apiName = 'ipcc/expected_approach';
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];

        $date = explode('/', $date_start);
        $dateStart  = date('Y-m-d H:i:s', strtotime(implode('-', array_reverse($date))));
        $paramCommnet = array(
            'min_eat_count' => $min_eat_count,
            'max_eat_count' => $max_eat_count,
            'min_eat_payment' => $min_eat_payment,
            'max_eat_payment' => $max_eat_payment,
            'last_visit_frequency' => $last_visit_frequency,
            'campaign_id' => $campaign_id,
            'date_start' => $dateStart,
            'event_name' => $event_name,
        );

        $data = ApiController::getApiByMethod($apiName,$apiPath,$paramCommnet,'POST');

//        if(isset($data->data)){
//            return $data->data->expected_approach;
//        }else{
//            if($data){
//                return -1;
//            }else{
//                return -2;
//            }
//        }
        return json_encode($data);
    }
    /**
     * Updates an existing Dmevent model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Dmevent model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    public function actionRemove($id)
    {
        $model = $this->findModel($id);

        $apiName = 'ipcc/remove_event';
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];
        $paramCommnet = array(
            'event_id' => $id
        );

        $data = ApiController::getApiByMethod($apiName,$apiPath,$paramCommnet,'POST');

//        echo '<pre>';
//        var_dump($paramCommnet);
//        var_dump($data);
//        echo '</pre>';
//        die();

        if(isset($data->data)){
            Yii::$app->session->setFlash("success", "Hủy sự kiện ' ".$model->EVENT_NAME."' thành công");
            return $this->redirect(['report']);
        }else{
            if(isset($data->error)){
//                Yii::$app->session->setFlash('error', 'Tạo sự kiện lỗi '.@$data->error->message);
                return $data->error->message;
            }else{
                return 'Lỗi kết nối máy chủ';
            }
        }

    }

    /**
     * Finds the Dmevent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Dmevent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dmevent::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
