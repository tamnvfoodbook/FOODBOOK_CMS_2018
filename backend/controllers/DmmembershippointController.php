<?php

namespace backend\controllers;

use Yii;
use backend\models\Dmmembershippoint;
use backend\models\DmmembershippointSearch;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DmmembershippointController implements the CRUD actions for Dmmembershippoint model.
 */
class DmmembershippointController extends Controller
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
     * Lists all Dmmembershippoint models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DmmembershippointSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Dmmembershippoint model.
     * @param string $MEMBERSHIP_ID
     * @param string $POS_PARENT
     * @return mixed
     */
    public function actionView($MEMBERSHIP_ID, $POS_PARENT)
    {
        return $this->render('view', [
            'model' => $this->findModel($MEMBERSHIP_ID, $POS_PARENT),
        ]);
    }

    public function actionStaticcrm()
    {
        $apiName = 'ipcc/get_customer_statics';
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];
        $paramCommnet = array();
        $dataCustommer = ApiController::getApiByMethod($apiName,$apiPath,$paramCommnet,'GET');


        $weekChart = array();
        $visitFreequency = array();
        $totalCustomer = array();
        $genderJson = array();
        $oldArr = array();
        $amountStatis = array();
        $sourceJson = array();
//        echo '<pre>';
//        var_dump($dataCustommer->data);
//        echo '</pre>';
//        die();

        if(isset($dataCustommer->data)){
            /*echo '<pre>';
            var_dump($dataCustommer->data);
            echo '</pre>';
            die();*/

            $visitFreequency[] = ['Task', 'Tần suất ăn'];
            $visitFreequency[] = ['Khách quay lại trong 1 tuần', $dataCustommer->data->block_visit_frequency->count_1_week_frequency];
            $visitFreequency[] = ['Khách quay lại trong 2 tuần', $dataCustommer->data->block_visit_frequency->count_2_weeks_frequency];
            $visitFreequency[] = ['Khách quay lại trong 3 tuần', $dataCustommer->data->block_visit_frequency->count_3_weeks_frequency];
            $visitFreequency[] = ['Khách quay lại trong 1 tháng',$dataCustommer->data->block_visit_frequency->count_1_month_frequency];
            $visitFreequency[] = ['Khách quay lại trong 2 tháng',$dataCustommer->data->block_visit_frequency->count_2_months_frequency];
            $visitFreequency[] = ['Khách quay lại trên 2 tháng',$dataCustommer->data->block_visit_frequency->count_over_2_months_frequency];

            $totalCustomer = [
                ['label' => 'Hôm nay', 'value' => $dataCustommer->data->block_total->increase_yesterday],
                ['label' => 'Tuần này', 'value' => $dataCustommer->data->block_total->increase_week],
                ['label' => 'Tháng này', 'value' => $dataCustommer->data->block_total->increase_month],
            ];


            $weekChart = self::dataChartFlip($dataCustommer->data->weekly_statistical);

//            $dontEattotal = self::dataChartFlip($dataCustommer->data->block_total);
            $dontEat1week = self::dataDontEat($dataCustommer->data->block_eat_1_time,1,1);
            $dontEat2week = self::dataDontEat($dataCustommer->data->block_eat_2_time,2,2);
            $dontEat3week = self::dataDontEat($dataCustommer->data->block_eat_over_3_time,3,9999999);

            $sourceJson = self::dataSource($dataCustommer->data->source_statistical);

            $genderJson[] =  ['Task', 'Giới tính'];
            foreach((array)$dataCustommer->data->gender_statistical as $key => $value){
                $genderJson[] = [Yii::$app->params['genderParam'][$key],$value];
            }



            $oldArr[] =  ['Task', 'Tuổi'];
            foreach((array)$dataCustommer->data->age_statistical as $key => $value){
                $oldArr[] = ['Từ '.$value->Data_Name.' tuổi',$value->Data_Value];
            }
            $amountStatis[] =  ['Task', 'Chi tiêu'];
            foreach((array)$dataCustommer->data->amount_statistical as $key => $value){
                $amountStatis[] = [$value->Data_Name,$value->Data_Value];
            }


        }

//        echo '<pre>';
//        var_dump($weekChart);
////        var_dump($dontEat1week);
//        echo '</pre>';
//        die();

        return $this->render('static', [
            'customer' => @$dataCustommer->data,
            'visitFreequency' => $visitFreequency,
            'totalCustomer' => @$totalCustomer,
            'genderJson' => $genderJson,
            'oldArr' => $oldArr,
            'amountStatis' => $amountStatis,
            'weekChart' => $weekChart,
//            'dontEattotal' => $dontEattotal,
            'dontEat1week' => $dontEat1week,
            'dontEat2week' => $dontEat2week,
            'dontEat3week' => $dontEat3week,
            'sourceJson' => $sourceJson,
        ]);
    }
    public function actionStaticcrm1()
    {
        return $this->render('static1', [

        ]);
    }

    public  static  function dataChartFlip($data){
        $weekChart = array();
        foreach($data as $value){
            $weekChart['Up_First_Time'][] = ['label' => 'Tuần '.$value->Week_In_Year , 'value' => $value->Up_First_Time];
            $weekChart['Up_More_Times'][] = ['label' => 'Tuần '.$value->Week_In_Year , 'value' => $value->Up_More_Times];
            $weekChart['Up_Third_Times'][] = ['label' => 'Tuần '.$value->Week_In_Year , 'value' => $value->Up_Third_Times];
            $weekChart['Up_Second_Times'][] = ['label' => 'Tuần '.$value->Week_In_Year , 'value' => $value->Up_Second_Times];
        }
        return $weekChart;
    }

    public  static  function dataDontEat($data,$min_eat_acount = null,$max_eat_acount = null){
        $weekChart = array();
            $clauseMinMax = '&DmeventSearch[MIN_EAT_COUNT]='.$min_eat_acount.'&DmeventSearch[MAX_EAT_COUNT]='.$max_eat_acount;
            $weekChart[] = ['label' => '1 tuần' , 'value' => $data->dont_eat_7day,'link' => 'index.php?r=dmmembership/report&DmeventSearch[LAST_VISIT_FREQUENCY]=7'.$clauseMinMax];
            $weekChart[] = ['label' => '2 tuần', 'value' => $data->dont_eat_14day, 'link' => 'index.php?r=dmmembership/report&DmeventSearch[LAST_VISIT_FREQUENCY]=14'.$clauseMinMax];
            $weekChart[] = ['label' => '1 tháng', 'value' => $data->dont_eat_30day, 'link' => 'index.php?r=dmmembership/report&DmeventSearch[LAST_VISIT_FREQUENCY]=30'.$clauseMinMax];
            $weekChart[] = ['label' => '3 tháng', 'value' => $data->dont_eat_90day, 'link' => 'index.php?r=dmmembership/report&DmeventSearch[LAST_VISIT_FREQUENCY]=90'.$clauseMinMax];
            $weekChart[] = ['label' => '6 tháng', 'value' => $data->dont_eat_180day, 'link' => 'index.php?r=dmmembership/report&DmeventSearch[LAST_VISIT_FREQUENCY]=180'.$clauseMinMax];
        return $weekChart;
    }
    public  static  function dataSource($data){
        $chart = array();
        $dataTotal = 0;
        foreach($data as $key => $value){
            if($value->Data_Name == 'SMS'){
                $dataTotal = $value->Data_Value;
            }
        }

        foreach($data as $key => $value){

            if($value->Data_Name == 'SMS'){
                $chart[] = ['label' => $value->Data_Name .'(100%)', 'value' => $value->Data_Value];
            }else{
                if(@$dataTotal){
                    $chart[] = ['label' => $value->Data_Name . '('.number_format($value->Data_Value/$dataTotal,2)*100 .'%)', 'value' => $value->Data_Value];
                }else{
                    $chart[] = ['label' => $value->Data_Name . '(0%)', 'value' => $value->Data_Value];
                }
            }

        }

        return $chart;
    }

    /**
     * Creates a new Dmmembershippoint model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dmmembershippoint();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'MEMBERSHIP_ID' => $model->MEMBERSHIP_ID, 'POS_PARENT' => $model->POS_PARENT]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionExport(){

        $apiName = 'ipcc/get_all_member_of_pos_parent';
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];
        $paramCommnet = array();
        $result = ApiController::getApiByMethod($apiName,$apiPath,$paramCommnet,'GET');

//        echo '<pre>';
//        var_dump($result);
//        echo '</pre>';
//        die();

        $data = array();

        if(isset($result->data))
        {
            foreach((array)$result->data as $value){
                $data[] = [
                    utf8_decode('Phone number') => doubleval($value->membership_id),
                    utf8_decode('Số điểm') => (string)$value->point,
                    utf8_decode('Số lần ăn') => (string)$value->eat_count,
                    utf8_decode('Số tiền đã chi tiêu') => (string)$value->amount,
                    utf8_decode('Lần ăn đầu tiên') => (string)$value->eat_first_date,
                    utf8_decode('Lần ăn cuối cùng') => (string)$value->eat_last_date,
                ];
            }

            $pos = \Yii::$app->session->get('pos_parent');
            $filename = " Dánh sách khách hàng .xls";
            header('Content-Encoding: UTF-8');
            header('Content-type: text/csv; charset=UTF-8');
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=\"$filename\"");
            header("Pragma: public");
            header("Expires: 0");
            ExtendController::ExportFile($data);
            exit();
        }
    }

    /**
     * Updates an existing Dmmembershippoint model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $MEMBERSHIP_ID
     * @param string $POS_PARENT
     * @return mixed
     */
    public function actionUpdate($MEMBERSHIP_ID, $POS_PARENT)
    {
        $model = $this->findModel($MEMBERSHIP_ID, $POS_PARENT);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'MEMBERSHIP_ID' => $model->MEMBERSHIP_ID, 'POS_PARENT' => $model->POS_PARENT]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Dmmembershippoint model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $MEMBERSHIP_ID
     * @param string $POS_PARENT
     * @return mixed
     */
    public function actionDelete($MEMBERSHIP_ID, $POS_PARENT)
    {
        $this->findModel($MEMBERSHIP_ID, $POS_PARENT)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Dmmembershippoint model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $MEMBERSHIP_ID
     * @param string $POS_PARENT
     * @return Dmmembershippoint the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($MEMBERSHIP_ID, $POS_PARENT)
    {
        if (($model = Dmmembershippoint::findOne(['MEMBERSHIP_ID' => $MEMBERSHIP_ID, 'POS_PARENT' => $POS_PARENT])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
