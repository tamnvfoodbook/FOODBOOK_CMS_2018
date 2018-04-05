<?php

namespace backend\controllers;

use backend\models\DmposSearch;
use Yii;
use backend\models\Saleposmobile;
use backend\models\SaleposmobileSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SaleposmobileController implements the CRUD actions for Saleposmobile model.
 */
class SaleposmobileController extends Controller
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
     * Lists all Saleposmobile models.
     * @return mixed
     */
    public function actionPosIds($searchSaleModel){
        $idList = \Yii::$app->session->get('pos_id_list');


        if($idList == NULL || $idList == ''){
            $posParent = \Yii::$app->session->get('pos_parent');
            $allPos = $searchSaleModel->searchAllPosByPosParent($posParent);
            foreach($allPos as $pos){
                $ids[] = (int)$pos['ID'];
            }
        }else{
            $ids = array_map('intval', explode(',', $idList));
        }
        // Set session ids

        \Yii::$app->session->set('ids',$ids);
        return $ids;
    }

    public function actionIndex()
    {
        $searchSaleModel = new DmposSearch();

        $ids = SaleposmobileController::actionPosIds($searchSaleModel);

        $startDay = new \DateTime("00:00:00");
        $startDay->sub(new \DateInterval("P7D"));
        $DAY = $startDay->format( \DateTime::ISO8601 );
        $startDayMongoTime = new \MongoDate(strtotime($DAY));

        $startToday = new \DateTime("00:00:00");
        $startTodayISO = $startToday->format( \DateTime::ISO8601 );
        $startToDayMongoTime = new \MongoDate(strtotime($startTodayISO));
        \Yii::$app->session->set('startToDayMongoTime',$startToDayMongoTime);

        $dateStartDay = $startDay->format('Y-m-d');
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d',strtotime("-1 days"));

        $nowTimeToday = new \DateTime();
        $NOWTIMEDAY = $nowTimeToday->format( \DateTime::ISO8601 );
        $nowTimeTodayMonogo = new \MongoDate(strtotime($NOWTIMEDAY));


        $searchModel = new SaleposmobileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataAllPos = $searchModel->searchAllSaleByTime($ids,$startDayMongoTime,$nowTimeTodayMonogo);

        /*Khởi tạo mảng giá trị cho các nhà hàng*/
        $data = NULL;
        $idsAndAllPos = $ids;

        array_unshift($idsAndAllPos,'allPos'); // Themm phần tử vào top của mảng

        $arrayDay = SiteController::actionCountDay($startDayMongoTime,$nowTimeTodayMonogo); // Lấy 8 ngày từ ngày này tuần trước tới hiện tại

        $dayArray = SiteController::actionCountDay($startDayMongoTime,$nowTimeTodayMonogo,'D');

        foreach($dayArray as $key => $day){
            $allDayToChart[]['label'] = $day;
        }

        foreach($idsAndAllPos as $posId){
            if($posId != 'allPos'){
                $pos = $searchSaleModel->searchById($posId);
                $data[$posId]['POS_NAME'] = $pos['POS_NAME'];
            }else{
                $data['allPos']['POS_NAME'] = 'Điểm tổng';
            }

            foreach($arrayDay as $date){
                $data[$posId][$date]['order'] = 0;
                $data[$posId][$date]['price'] = 0;
                $data[$posId]['datachart'][$date]['value'] = 0;
            }
        }

//        echo '<pre>';
//        var_dump($data);
//        echo '</pre>';
//        die();

        foreach($dataAllPos as $key => $dataPos){
            $id = $dataPos['pos_id']; // Định nghĩa biến Id cho pơs
            $dateTime = date('Y-m-d',$dataPos['date_time']->sec); // Convert MongoDate to Datetime

            $data[$id][$dateTime]['order']++;
            $data['allPos'][$dateTime]['order'] ++;

            foreach($dataPos['data_sale_detail'] as $value){
                $data[$id][$dateTime]['price'] = $value['amount'] + $data[$id][$dateTime]['price'];
                $data[$id]['datachart'][$dateTime]['value'] = $value['amount'] + $data[$id]['datachart'][$dateTime]['value'];
                $data['allPos'][$dateTime]['price'] = $value['amount'] + $data['allPos'][$dateTime]['price'];
                $data['allPos']['datachart'][$dateTime]['value'] = $value['amount'] + $data['allPos']['datachart'][$dateTime]['value'];
            }
        }

        $dataToIndex = [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'data' => $data,
            'dateStartDay' => $dateStartDay,
            'today' => $today,
            'yesterday' => $yesterday,
            'allDayToChart' => $allDayToChart,
        ];
		
		echo '<pre>';
		var_dump($dataToIndex['allDayToChart']);
		echo '</pre>';
		die();

        //$menus = SaleposmobileController::setMenuItem($ids,$dataToIndex);
        //$dataToIndex['menus'] = $menus;

        return $this->render('allpos',$dataToIndex);
    }

    public function getTimeAndConvertToMongoDate($queryDate = NULL){
        // Lấy mốc thời gian
        $startDayOfYear = new \DateTime(".$queryDate.");
        //$startDayOfYear->setTime(0, 0, 0);
        $FIST_DAY_OF_YEAR = $startDayOfYear->format( \DateTime::ISO8601 );
        $startDayMongoTime = new \MongoDate(strtotime($FIST_DAY_OF_YEAR));
        return $startDayMongoTime;
    }

//    static function actionCountMonth($start,$end,$format = 'Y-m-d',$step = '+1 month'){
//        $days = (strtotime(date('Y-m-d',$end->sec)) - strtotime(date('Y-m-d',$start->sec))) / (60 * 60 * 24);
//        $first = date('Y-m-d',$start->sec);
//        $last = date('Y-m-d',$end->sec);
//
//        $dates = array();
//        $current = strtotime($first);
//        $last = strtotime($last);
//
//        while( $current <= $last ) {
//            $dates[] = date($format, $current);
//            $current = strtotime($step, $current);
//        }
//
//        return $dates;
//    }


    public function actionAllposmonth(){
        $searchSaleModel = new DmposSearch();
        $ids = SaleposmobileController::actionPosIds($searchSaleModel);
        $startYearMongoTime = self::getTimeAndConvertToMongoDate('first day of January ' . date('Y'));


        $nowTimeToday = new \DateTime();
        $NOWTIMEDAY = $nowTimeToday->format( \DateTime::ISO8601 );
        $nowTimeTodayMonogo = new \MongoDate(strtotime($NOWTIMEDAY));


        $today = date('Y-m');
        $yesterday = date('Y-m',strtotime("-1 month"));


        $searchModel = new SaleposmobileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataAllPos = $searchModel->searchAllSaleByTime($ids,$startYearMongoTime,$nowTimeTodayMonogo);

        /*Khởi tạo mảng giá trị cho các nhà hàng*/
        $data = NULL;
        $idsAndAllPos = $ids;

//                echo '<pre>';
//        var_dump($yesterday);
//        echo '</pre>';
//        die();

        array_unshift($idsAndAllPos,'allPos'); // Themm phần tử vào top của mảng

        $arrayDay = SiteController::actionCountDay($startYearMongoTime,$nowTimeTodayMonogo,$format = 'Y-m', $step = '+1 month'); // Lấy 8 ngày từ ngày này tuần trước tới hiện tại

        $dayArray = SiteController::actionCountDay($startYearMongoTime,$nowTimeTodayMonogo,'M',$step = '+1 month');
//        echo '<pre>';
//        var_dump($dayArray);
//        echo '</pre>';
//        die();

        foreach($dayArray as $key => $day){
            $allDayToChart[]['label'] = $day;
        }

        foreach($idsAndAllPos as $posId){
            if($posId != 'allPos'){
                $pos = $searchSaleModel->searchById($posId);
                $data[$posId]['POS_NAME'] = $pos['POS_NAME'];
            }else{
                $data['allPos']['POS_NAME'] = 'Điểm tổng';
            }

            foreach($arrayDay as $date){
                $data[$posId][$date]['order'] = 0;
                $data[$posId][$date]['price'] = 0;
                $data[$posId]['datachart'][$date]['value'] = 0;
            }
        }

//        echo '<pre>';
//        var_dump($data);
//        echo '</pre>';
//        die();



        foreach($dataAllPos as $key => $dataPos){
            $id = $dataPos['pos_id']; // Định nghĩa biến Id cho pơs
            $dateTime = date('Y-m',$dataPos['date_time']->sec); // Convert MongoDate to Datetime


            $data[$id][$dateTime]['order']++;
            $data['allPos'][$dateTime]['order'] ++;

            foreach($dataPos['data_sale_detail'] as $value){
                $data[$id][$dateTime]['price'] = $value['amount'] + $data[$id][$dateTime]['price'];
                $data[$id]['datachart'][$dateTime]['value'] = $value['amount'] + $data[$id]['datachart'][$dateTime]['value'];
                $data['allPos'][$dateTime]['price'] = $value['amount'] + $data['allPos'][$dateTime]['price'];
                $data['allPos']['datachart'][$dateTime]['value'] = $value['amount'] + $data['allPos']['datachart'][$dateTime]['value'];
            }
        }

        $dataToIndex = [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'data' => $data,
            'today' => $today,
            'yesterday' => $yesterday,
            'allDayToChart' => $allDayToChart,
        ];



        //$menus = SaleposmobileController::setMenuItem($ids,$dataToIndex);
        //$dataToIndex['menus'] = $menus;

        return $this->render('allposmonth',$dataToIndex);
    }

    /*public function setMenuItem($ids,$data){
        $searchSaleModel = new DmposSearch();
        $menuItem = NULL;

        foreach($ids as $posId){
            $pos = $searchSaleModel->searchById($posId);
            $menuItem[] = [
                'label'=>'<i class="glyphicon glyphicon-chevron-right"></i>'.$pos['POS_NAME'],
                'encode'=>false,
                'content'=> 'hello',
                'linkOptions'=>['data-url'=>Url::to(['/saleposmobile/tabs-pos','id'=>$posId])]
            ];
        }

        return $menuItem;
    }*/

    /**
     * Displays a single Saleposmobile model.
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
     * Creates a new Saleposmobile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Saleposmobile();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => (string)$model->_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Saleposmobile model.
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
     * Deletes an existing Saleposmobile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionTabsData() {
        $html = $this->renderPartial('allpos');
        return Json::encode($html);
    }

    public function actionTabsPos($id) {
        $startToDayMongoTime = \Yii::$app->session->get('startToDayMongoTime');
        $nowTimeToday = new \DateTime();
        $NOWTIMEDAY = $nowTimeToday->format( \DateTime::ISO8601 );
        $nowTimeTodayMonogo = new \MongoDate(strtotime($NOWTIMEDAY));

        $posData = self::actionStaticOnePos((int)$id,$startToDayMongoTime,$nowTimeTodayMonogo);

        $html = $this->render('onepos',['data' => $posData]);
        return $html;
    }


    /*public function actionTabsPos($id) {
        $startToDayMongoTime = \Yii::$app->session->get('startToDayMongoTime');
        $nowTimeToday = new \DateTime();
        $NOWTIMEDAY = $nowTimeToday->format( \DateTime::ISO8601 );
        $nowTimeTodayMonogo = new \MongoDate(strtotime($NOWTIMEDAY));

        $posData = self::actionStaticOnePos((int)$id,$startToDayMongoTime,$nowTimeTodayMonogo);

        $html = $this->renderPartial('onepos',['data' => $posData]);
        return Json::encode($html);
    }*/


    public function detailType($dataAllSaleMap,$type){
        $foodbookData['order'] = 0;
        $foodbookData['amount'] = 0;

        if(isset($dataAllSaleMap[$type])){
            $foodbookData['order'] = count($dataAllSaleMap[$type]);
            if($foodbookData['order']){
                foreach($dataAllSaleMap[$type] as $valueType){
                    foreach($valueType as $valueDetail){
                        $foodbookData['amount'] = $valueDetail['amount'] + $foodbookData['amount'];
                    }
                }
            }
        }

        return $foodbookData;
    }


    public function actionStaticOnePos($id,$startDayMongoTime,$nowTimeTodayMonogo)
    {

        $searchSaleModel = new SaleposmobileSearch();
        $allSale = $searchSaleModel->searchAllSaleByTime($id,$startDayMongoTime,$nowTimeTodayMonogo);

        $dataItem = array();

        foreach($allSale as $key => $value){
            $allSale[$key]['_id'] = $value['_id']->__Tostring();
            foreach($value['data_sale_detail'] as $items){
                if(isset($dataItem[$items['item_id']]['quantity'])){
                    $dataItem[$items['item_id']]['quantity'] = $items['quantity'] + $dataItem[$items['item_id']]['quantity'];
                    $dataItem[$items['item_id']]['amount'] = $items['amount'] + $dataItem[$items['item_id']]['amount'];
                }else{

                    $dataItem[$items['item_id']]['quantity'] = $items['quantity'];
                    $dataItem[$items['item_id']]['amount'] = $items['amount'];
                    $dataItem[$items['item_id']]['item_name'] = $items['item_name'];
                }
            }
        }
        //die();

        $dataAllSaleMap = ArrayHelper::map($allSale,'_id','data_sale_detail','trans_type');
        $foodbookData = SaleposmobileController::detailType($dataAllSaleMap,'FOODBOOK');
        $taData = SaleposmobileController::detailType($dataAllSaleMap,'TA');
        $otsData = SaleposmobileController::detailType($dataAllSaleMap,'OTS');
//        echo '<pre>';
//        var_dump($dataItem);
//        echo '</pre>';
//        die();

        return [
            'dataItem' => $dataItem,
            'foodbookData' => $foodbookData,
            'taData' => $taData,
            'otsData' => $otsData,
        ];

    }


    /**
     * Finds the Saleposmobile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return Saleposmobile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Saleposmobile::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
