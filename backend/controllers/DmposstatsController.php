<?php

namespace backend\controllers;

use backend\models\Dmposparent;
use backend\controllers\SiteController;
use Yii;
use backend\models\DmPosStats;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use linslin\yii2\curl;
use yii\helpers\ArrayHelper;
/**
 * DmposstatsController implements the CRUD actions for DmPosStats model.
 */
class DmposstatsController extends Controller
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
     * Lists all DmPosStats models.
     * @return mixed
     */

    public function actionCountOrder($count,$tmpDay,$tmpType){
        if(!isset($count)){
            $count = [$tmpDay,0,0,0,0,0];
        }
        foreach ($count as $key => $value) {
            if ($key == $tmpType){
                $value++;
                $replacements = array($tmpType => $value);
                $count =  array_replace($count,$replacements);
            }
        }// End foreach  
        return $count;
    }


    public function actionCountDistance($dataSevenDay,$arrayDay,$type){
//        echo '<pre>';
//        var_dump($dataSevenDay);
//        echo '</pre>';
//        die();


        // Đếm quãng đường trong vòng 7 ngày
        $distanceMap = ArrayHelper::map($dataSevenDay,'_id',$type,'create_time');

        // Khởi tạo mảng chung bao gồm dữ liệu của tất cả các ngày
        $distanceByDay = NULL;
        foreach($arrayDay as $key =>$value){
            $distanceByDay[$value] = 0;
        }


        // Lấy phần tử trong mảng tông ra kiểm tra với dữ liệu thực tế, nếu có giá trị thì gán ngay giá trị của ngày đó vào
        foreach($distanceByDay as $day => $value){
            foreach($distanceMap as $key => $value1){
                if($day === $key){
                    if(array_sum($value1)){
                        if($type == 'duration'){
                            /*Nếu là lấy thời gian ra thì chia cho 60 để lấy số phút*/
                            $distanceByDay[$day] = array_sum($value1)/(count($value1)*60);
                        }else{
                            /*Nếu là lấy quãng đường thì chỉ cần lấy tổng quãng đường chia đơn hàng*/
                            $distanceByDay[$day] = array_sum($value1)/count($value1);
                        }
                    }else{
                        $distanceByDay[$day] = 0;
                    }
                }
            }
        }
        //End Đếm quãng đường trong vòng 7 ngày
        $arrayDistance = NULL;
        foreach($distanceByDay as $day => $value){
            if($type === 'total_pay'){ // Nếu là tính phí ship thì không lấy số lẻ 2 số
                $arrayDistance[]['value'] = (int)$value;
            }else{
                $arrayDistance[]['value'] = number_format($value,2);
            }
        }

//        echo '<pre>';
//            var_dump($arrayDistance);
//        echo '</pre>';
//        die();

        return $arrayDistance;
    }

    public function actionCountTime($count,$tmpDay,$time){
        if(!isset($count)){
            $count = [$tmpDay,0,0];
        }
        foreach ($count as $key => $value) {
            $value = $value+ $time;
            $replacements = array(1 => $value);
            $replacements2 = array(2 => $value);
            $count =  array_replace($count,$replacements,$replacements2);
        }// End foreach          
        return $count;
    }

    public function actionGenderMobileApi($posParentObj){
        if($posParentObj['AHAMOVE_ID'] == NULL){
            return "";
        }
        //pn = "8450xxxxxxx";
//        $pn = "8468";
//        if($posParent!= NULL && $posId == NULL){
        $pn = "8466";
        //}

        for ($i = 0; $i < 15; $i++) {
            $temp = $pn.$posParentObj['AHAMOVE_ID'];
            if(strlen($temp) > 10){
                $pn = $temp;
                break;
            }
            $pn = $pn."0";
        }
        return $pn;

    }


    public function actionIndex()
    {
        $post = Yii::$app->request->post();
//        echo '<pre>';
//        var_dump($post);
//        echo '</pre>';
        //Init curl
        $curl = new curl\Curl();

        // Chuẩn bị API để lấy Token

        $url = Yii::$app->params['API_AHAMOVE'].'partner/register_account?';

        $ahamoveApiKey  = "AIzaSyBf6FLjuQt6_UQ-G9ibxgg5ZNqqDHP1mVG";
        $posParent = \Yii::$app->session->get('pos_parent');
        $posParentObj = Dmposparent::find()
            ->select(['ID','AHAMOVE_ID'])
            ->where(['ID' => $posParent])
            ->asArray()
            ->one();

        $mobile = DmposstatsController::actionGenderMobileApi($posParentObj);
//        echo $mobile;
//        die();


        $options = array(
            'mobile' => $mobile,
            'name' => '',
            'address' => $posParentObj['ID'],
            'lat' => '0',
            'lng' => '0',
            'parent_id' => '',
            'api_key' => $ahamoveApiKey,
        );

//        $options = array(
//            'mobile' => '84908842280',
//            'name' => 'Mon+Hue+restaurant',
//            'address' => '4+Nguyen+Dinh+Chieu,Da+Kao,Quan+1,TPHCM',
//            'lat' => '10.7918246',
//            'lng' => '106.7022344',
//            'parent_id' => '',
//            'api_key' => 'test_api_key',
//        );

        $param = NULL;
        foreach ($options as $key => $value) {
            if($param){
                $param = $key.'='.$value.'&'.$param;
            }else{
                $param = $key.'='.$value;
            }

        }
        $token = $curl->get($url.$param,false);

//        echo '<pre>';
//        var_dump($url.$param);
//        var_dump($token);
//        echo '</pre>';
//        die();


        $urlTrafic = Yii::$app->params['API_URL_TRAFIC'];
        //$urlTrafic = 'https://sharestg.ahamove.com/service_statistics/';
        $optionTrafic = 'HAN-FOODBOOK';
        $linkTrafic =  $urlTrafic.'/'.$optionTrafic.'/'.$token['token'];

        $urlStaticTrafic = Yii::$app->params['API_AHAMOVE'].'order/list?token=';
        //$urlStaticTrafic = 'http://apistg.ahamove.com/v1/order/list?token=';
        $json = $curl->get($urlStaticTrafic.$token['token'],false);

//        echo '<pre>';
//        var_dump($url.$param);
//        var_dump($token);
//        var_dump($urlStaticTrafic.$token['token']);
//        var_dump(json_encode($json));
//        echo '</pre>';
//        die();


//        $linkJson = 'test_data.json';
//        $str = file_get_contents($linkJson);
//        $json = json_decode($str, true);


        $countStatusASSINING = 0;
        $countStatusACCEPTED = 0;
        $countStatusIN_PROCESS = 0;
        $countStatusCOMPLETED = 0;
        $countStatusCANCELLED = 0;

        $totalTime= 0;
        $totalDistance = 0;


        $date = new \DateTime();
        //$now  = $date->getTimestamp();
        $currentTime  = $date->getTimestamp();
        //$currentTime = $now + (24*60*60);
        //$currentTime = $now + (24*60*60);
        //echo $date = date('m/d/Y', $currentTime);

        $tmpTime = $currentTime ;


        $countOrder = NULL; //Đếm Oder theo từng ngày.
        $countDistance = NULL;

        foreach ((array)$json as $key => $value){
            // Xử lý đếm thời gian trong khoảng thời gian là một tuần            
            if($currentTime >= ($value['create_time']) && ($value['create_time'] > ($currentTime - (7*24*60*60) ))){
                $tmpDay = date('Y-m-d', $value['create_time']);
                $json[$key]['create_time'] = $tmpDay;

                switch ($value['status']) {
                    case 'ASSINING':
                        $countStatusASSINING++;
                        $tmpType =1;
                        $countOrder[$tmpDay] = DmposstatsController::actionCountOrder(@$countOrder[$tmpDay],$tmpDay,$tmpType);
                        break;
                    case 'ACCEPTED':
                        $countStatusACCEPTED++;
                        $tmpType =2 ;
                        $countOrder[$tmpDay] = DmposstatsController::actionCountOrder(@$countOrder[$tmpDay],$tmpDay,$tmpType);
                        break;
                    case 'IN_PROCESS':
                        $countStatusIN_PROCESS++;
                        $tmpType =3 ;
                        $countOrder[$tmpDay] = DmposstatsController::actionCountOrder(@$countOrder[$tmpDay],$tmpDay,$tmpType);
                        break;
                    case 'COMPLETED':
                        $countStatusCOMPLETED++;
                        $totalTime = $value['duration']+ $totalTime;
                        $totalDistance = $value['distance'] + $totalDistance; //Tong hoa don thanh toan - Chi nhung don hang nao complte thi moi Tính km

                        $tmpType =4 ;
                        $countOrder[$tmpDay] = DmposstatsController::actionCountOrder(@$countOrder[$tmpDay],$tmpDay,$tmpType);
                        $dataCompleteSevenDay[] = $json[$key];

                        $countTime[$tmpDay] = DmposstatsController::actionCountTime(@$countTime[$tmpDay],$tmpDay,$value['duration']);
                        break;
                    case 'CANCELLED':
                        $countStatusCANCELLED++;
                        $tmpType =5 ;
                        $countOrder[$tmpDay] = DmposstatsController::actionCountOrder(@$countOrder[$tmpDay],$tmpDay,$tmpType);
                        $dataCancelSevenDay[] = $json[$key];
                        break;
                    case 'FAILED':
                        $countStatusCANCELLED++;
                        $tmpType =5 ;
                        $countOrder[$tmpDay] = DmposstatsController::actionCountOrder(@$countOrder[$tmpDay],$tmpDay,$tmpType);
                        $dataCancelSevenDay[] = $json[$key];
                        break;
                    default:
                        break;

                }//End xử lý đếm đơn hàng
            }
            //End xử lý lọc thời gian trong vòng 7 ngày

        }


        date_default_timezone_set('Asia/Bangkok');
        $dateStamp = new \DateTime;
        $dateStamp->sub(new \DateInterval("P7D"));
        $DAY2 = $dateStamp->format( \DateTime::ISO8601 );

        $end = new \MongoDate(strtotime(date('c')));
        $start = new \MongoDate(strtotime($DAY2));
        $arrayDay = SiteController::actionCountDay($start,$end);

        $arrayDayToChart = SiteController::actionCountDay($start,$end,'D');
        foreach($arrayDayToChart as $key => $day){
            $allDay[]['label'] = $day;
        }

        // Đếm đơn hàng trong vòng 7 ngày
        // Khởi tạo mảng chung bao gồm dữ liệu của tất cả các ngày
        $orderByDay = NULL;
        foreach($arrayDay as $key =>$value){
            $orderByDay[$value] = [$value,0,0,0,0,0];
        }

        // Lấy phần tử trong mảng tông ra kiểm tra với dữ liệu thực tế, nếu có giá trị thì gán ngay giá trị của ngày đó vào
        if(isset($countOrder) && $countOrder != NULL){
            foreach($orderByDay as $day => $value){
                foreach($countOrder as $key => $value1){
                    if($day === $key){
                        $orderByDay[$day] = $value1;
                    }
                }
            }
        }

        // End Đếm đơn hàng trong vòng 7 ngày

        // Lấy ra mảng Cancel và mảng Complete.
        $arrayOrderCancel = NULL;
        $arrayOrderComplete = NULL;
        foreach($orderByDay as $key => $value){
            $arrayOrderComplete[]['value'] = $value[4];
            $arrayOrderCancel[]['value'] = $value[5];
        }



        $totalCountTime= NULL;
        if(isset($countTime) && $countTime != NULL){
            foreach ($countTime as $key => $value) {
                $totalCountTime[] = $value;
            }
        }

//        echo '<pre>';
//        var_dump($dataCompleteSevenDay);
//        echo '</pre>';
//        die();
        if(isset($dataCompleteSevenDay)){
            // Lấy mảng quãng đường trung bình trên đơn hàng
            $arrayDistanceCompleted = DmposstatsController::actionCountDistance($dataCompleteSevenDay,$arrayDay,'distance');
            $arrayTimeComplete = DmposstatsController::actionCountDistance($dataCompleteSevenDay,$arrayDay,'duration');

            $arrayPayComplete = DmposstatsController::actionCountDistance($dataCompleteSevenDay,$arrayDay,'total_pay');

        }else{
            $arrayDistanceCompleted = [['value'=> 0],['value'=> 0],['value'=> 0],['value'=> 0],['value'=> 0],['value'=> 0],['value'=> 0],['value'=> 0] ];
            $arrayTimeComplete = [['value'=> 0],['value'=> 0],['value'=> 0],['value'=> 0],['value'=> 0],['value'=> 0],['value'=> 0],['value'=> 0] ];
            $arrayPayComplete = [['value'=> 0],['value'=> 0],['value'=> 0],['value'=> 0],['value'=> 0],['value'=> 0],['value'=> 0],['value'=> 0] ];
        }

        if(isset($dataCancelSevenDay)){
            // Lấy mảng quãng đường trung bình trên đơn hàng

            $arrayDistanceCanceled = DmposstatsController::actionCountDistance($dataCancelSevenDay,$arrayDay,'distance');
            $arrayTimeCanceled = DmposstatsController::actionCountDistance($dataCancelSevenDay,$arrayDay,'duration');

        }else{
            $arrayDistanceCanceled = [['value'=> 0],['value'=> 0],['value'=> 0],['value'=> 0],['value'=> 0],['value'=> 0],['value'=> 0],['value'=> 0] ];
            $arrayTimeCanceled = [['value'=> 0],['value'=> 0],['value'=> 0],['value'=> 0],['value'=> 0],['value'=> 0],['value'=> 0],['value'=> 0] ];
        }


        $totalPayToday = end($arrayPayComplete);




//        echo '<pre>';
//        var_dump($totalPayToday['value']);
//        echo '</pre>';
//        die();
        if(isset($post['checkAjax'])){  // Neu dang su dung ajax thi se goi view nay
            return $this->renderPartial('index_form', [
                'countStatusCANCELLED'=> $countStatusCANCELLED,
                'countStatusCOMPLETED'=>$countStatusCOMPLETED,
                'countStatusACCEPTED'=>$countStatusACCEPTED,
                'countStatusASSINING'=>$countStatusASSINING,
                'countStatusIN_PROCESS'=>$countStatusIN_PROCESS,
                'totalTime'=>$totalTime,
                'totalDistance'=>$totalDistance,
                'totalPayToday'=>$totalPayToday['value'],

                'arrayDistanceCompleted'=>$arrayDistanceCompleted,
                'arrayDistanceCanceled'=>$arrayDistanceCanceled,
                'arrayTimeCanceled'=>$arrayTimeCanceled,
                'arrayTimeComplete'=>$arrayTimeComplete,
                'arrayPayComplete'=>$arrayPayComplete,
                'totalCountTime'=>$totalCountTime,
                'linkTrafic'=>$linkTrafic,

            ]);
        }else{
            return $this->render('index', [
                'countStatusCANCELLED'=> $countStatusCANCELLED,
                'countStatusCOMPLETED'=>$countStatusCOMPLETED,
                'countStatusACCEPTED'=>$countStatusACCEPTED,
                'countStatusASSINING'=>$countStatusASSINING,
                'countStatusIN_PROCESS'=>$countStatusIN_PROCESS,
                'totalTime'=>$totalTime,
                'totalDistance'=>$totalDistance,
                'totalPayToday'=>$totalPayToday['value'],

                'arrayDistanceCompleted'=>$arrayDistanceCompleted,
                'arrayDistanceCanceled'=>$arrayDistanceCanceled,
                'arrayTimeCanceled'=>$arrayTimeCanceled,
                'arrayTimeComplete'=>$arrayTimeComplete,
                'arrayPayComplete'=>$arrayPayComplete,
                'totalCountTime'=>$totalCountTime,
                'linkTrafic'=>$linkTrafic,

                'allDay'=>$allDay,
                'arrayOrderComplete'=> $arrayOrderComplete,
                'arrayOrderCancel'=> $arrayOrderCancel,

            ]);
        }


    }

    /**
     * Displays a single DmPosStats model.
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
     * Creates a new DmPosStats model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate()
    {
        $model = new DmPosStats();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DmPosStats model.
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
     * Deletes an existing DmPosStats model.
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
     * Finds the DmPosStats model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return DmPosStats the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DmPosStats::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
