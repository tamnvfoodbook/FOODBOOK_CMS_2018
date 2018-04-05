<?php

namespace backend\controllers;

use backend\models\DmcitySearch;
use backend\models\DmitemSearch;
use backend\models\DmitemtypeSearch;
use backend\models\Dmmembership;
use backend\models\DmmembershipSearch;
use backend\models\DmpartnerSearch;
use backend\models\DmposparentSearch;
use backend\models\DmposSearch;
use backend\models\DmuserpartnerSearch;
use Yii;
use backend\models\Dmvouchercampaign;
use backend\models\DmvouchercampaignSearch;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DmvouchercampaignController implements the CRUD actions for Dmvouchercampaign model.
 */
class DmvouchercampaignController extends Controller
{
    public static $TIME_MORNING = 1;
    public static $TIME_LUNCH = 2;
    public static $TIME_AFTERNOON = 3;
    public static $TIME_NIGHT = 4;
    public static $TIME_MID_NIGHT = 5;

    //Ăn sáng (06h00 - 10h59)
    //Ăn trưa (11h00 - 13h59)
    //Ăn chiều (14h00 - 16h59)
    //Ăn tối (17h00 - 20h59)
    //Ăn đêm(21h00 - 23h59)

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
     * Lists all Dmvouchercampaign models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DmvouchercampaignSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $searchCityModel = new DmcitySearch();
        $allCity = $searchCityModel->searchAllCity();
        $allCityMap= ArrayHelper::map($allCity,'ID','CITY_NAME');

        $searchPosModel = new DmposSearch();
        $allPos = $searchPosModel->searchAllPos();
        $allPosMap= ArrayHelper::map($allPos,'ID','POS_NAME');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'allCityMap' => $allCityMap,
            'allPosMap' => $allPosMap,
        ]);
    }


    public function actionEvoucher()
    {
        $dataCampain = array();
        $apiName = 'ipcc/get_campaign_of_pos_parent';
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];
        $paramCommnet = array();
        $data = ApiController::getApiByMethod($apiName,$apiPath,$paramCommnet,'GET');
        if(isset($data->data)){
            $dataCampain = $data->data;
        }

        return $this->render('evoucher', [
            'dataCampain' => $dataCampain,
        ]);
    }
    public function actionDetail($id,$name)
    {

        $dataProvider = new ArrayDataProvider([
        ]);

        $apiName = 'ipcc/get_voucher_log_of_campaign';
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];
        $paramCommnet = [
            'campaign_id' => $id
        ];
        $data = ApiController::getApiByMethod($apiName,$apiPath,$paramCommnet,'GET');
        /*echo '<pre>';
        var_dump($data);
        echo '</pre>';
        die();*/

        if(isset($data->data)){
            $dataProvider->allModels = $data->data;
        }

        return $this->render('../dmvoucherlog/index_apidata', [
            'dataProvider' => $dataProvider,
            'id' => $id,
            'name' => $name,
        ]);
    }
    public function actionStatistics()
    {
        $dataProvider = new ArrayDataProvider([
        ]);

        $searchModel = new DmvouchercampaignSearch();
        $dataProvider->allModels = $searchModel->searchCampainApi(Yii::$app->request->queryParams);

//        echo '<pre>';
//        var_dump($dataProvider->allModels);
//        echo '</pre>';
//        die();

        return $this->render('statistics', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionGetvoucherdetail($id,$pageinside = 1)
    {
        $dataCampain = array();
        $apiName = 'cms/get_used_voucher_of_campaign';
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];
        $paramCommnet = [
            'campaign_id' => $id,
            'page' => $pageinside
        ];
        $data = ApiController::getApiByMethod($apiName,$apiPath,$paramCommnet,'GET');

        $is_next = 0;
        if(isset($data->data)){
            $searchPosModel = new DmposSearch();
            $allPos = $searchPosModel->searchAllPos();
            $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');

            $dataCampain = array();
            foreach($data->data as $key => $value){
                $dataCampain[$key]['voucher_code'] = $value->voucher_code;
                $dataCampain[$key]['used_member_info'] = $value->used_member_info;
                $dataCampain[$key]['used_pos_id'] = @$allPosMap[$value->used_pos_id];
                $dataCampain[$key]['used_date'] = $value->used_date;
                $dataCampain[$key]['used_discount_amount'] = $value->used_discount_amount;
                $dataCampain[$key]['used_discount_amount'] = number_format($value->used_discount_amount);
                $dataCampain[$key]['used_bill_amount'] = number_format($value->used_bill_amount);
            }
            $is_next = $data->is_next;
        }


        return $this->renderAjax('evoucher_detail', [
            'dataCampain' => $dataCampain,
            'id' => $id,
            'is_next' => $is_next,
            'pageinside' => $pageinside,
        ]);
    }


    public function actionSendevoucher()
    {
        $searchMemberModel = new DmmembershipSearch();
        $userPhone = $searchMemberModel->seachAllPhoneByPospent();
        $userPhoneData = array();
        foreach($userPhone as $phone){
            array_push($userPhoneData,$phone['ID']);
        }

        $dataCampainMap = array();
        $apiName = 'ipcc/get_campaign_of_pos_parent';
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];

        $paramCommnet = array();
        $data = ApiController::getApiByMethod($apiName,$apiPath,$paramCommnet,'GET');
        if(isset($data->data)){
            $dataCampain = $data->data;
            foreach((array)$dataCampain as $campain){
//                echo '<pre>';
//                var_dump($campain);
//                echo '</pre>';
//                die();
                if($campain->campaign_type == 7 && $campain->active == 1){
                    if($campain->discount_type == 1){
                        $dataCampainMap[$campain->id] = 'Giảm '. $campain->discount_amount.' đ - ' .$campain->voucher_campaign_name;
                    }else{
                        $dataCampainMap[$campain->id] = 'Giảm '. $campain->discount_extra*100 .' % - ' .$campain->voucher_campaign_name;
                    }
                }
            }
        }

        //$model =
        if (Yii::$app->request->post()){
            $post = Yii::$app->request->post();

            $apiName = 'ipcc/send_gift_voucher_sms';
            $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];

            $userModel = $searchMemberModel->searchMemberModelById($post['textPhone']);

            $paramCommnet = array(
                'phone_number' => $post['textPhone'],
                'voucher_campaign_id' => $post['campaign_id'],
                'zalo_id' => @$userModel->ZALO_UID,
                'facebook_id' => @$userModel->FACEBOOK_ID,
                'send_type' => @$post['send_type']
            );
            $data = ApiController::getApiByMethod($apiName,$apiPath,$paramCommnet,'POST');
//            echo '<pre>';
//            var_dump($data);
//            echo '</pre>';
//            die();

            if(isset($data->data)){
                Yii::$app->session->setFlash('success', 'Tặng e - Voucher thành công');
                return $this->redirect(['sendevoucher']);
            }else{
                if(isset($data->error)){
                    Yii::$app->session->setFlash('error', 'Tạo e - Voucher lỗi '.@$data->error->message);
                }else{
                    Yii::$app->session->setFlash('error', 'Lỗi kết nối máy chủ');
                }
                return $this->render('sendevoucher', [
                    'userPhoneData' => $userPhoneData,
                    'dataCampainMap' => $dataCampainMap,
                    'post' => $post,
                ]);
            }

        } else {


            return $this->render('sendevoucher', [
                'userPhoneData' => $userPhoneData,
                'dataCampainMap' => $dataCampainMap,
            ]);
        }
    }

    protected function findMemberModel($id)
    {
        if (($model = Dmmembership::findOne($id)) !== null) {
            return $model;
        } else {
            $model = new Dmmembership();
            return $model;
        }
    }

    public function actionCreateevoucher()
    {
        $model = new Dmvouchercampaign();

        $searchPosModel = new DmposSearch();
        $allPos = $searchPosModel->searchAllPosForCampagin();
        $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');
        $allPosIdMap = ArrayHelper::map($allPos,'ID','ID');


        $itemModelSearch = new DmitemSearch();
        $itemObj = $itemModelSearch->searchItemByPos($allPosIdMap);
        $itemMap = ArrayHelper::map($itemObj,'ID','ITEM_NAME');

        $itemtypeModelSearch = new DmitemtypeSearch();
        $itemTypeObj = $itemtypeModelSearch->searchCategoryByPos($allPosIdMap);
        $iteTypemMap = ArrayHelper::map($itemTypeObj,'ITEM_TYPE_ID','ITEM_TYPE_NAME');

        $partnerSearch = new DmuserpartnerSearch();
        $partner = $partnerSearch->searchAllpartner();
        $partnerMap = ArrayHelper::map($partner,'ID','PARTNER_NAME');


        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            if(@$post['ck_all_pos'] ==  'on'){
                $model->LIST_POS_ID =  NULL;
            }else{
                if($model->LIST_POS_ID){
                    $model->LIST_POS_ID = implode(',',$model->LIST_POS_ID);
                }
            }

            if(@$post['ck_all_itemtype'] ==  'on'){
                $model->IS_ALL_ITEM =  1;
            }else{
                if($model->ITEM_TYPE_ID_LIST){
                    $model->ITEM_TYPE_ID_LIST = implode(',',$model->ITEM_TYPE_ID_LIST);
                }
            }


            $dataCampain = array();
            $apiName = 'ipcc/create_campaign';
            $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];
            $discountExtra = 0;
            $discountAmount = 0;

            if($model->DISCOUNT_TYPE){
                $discountType = 1; // Gán bằng 2 vì giá trị của switch input đang mặc định là 0 và 1.
                $discountAmount = $model->DISCOUNT_AMOUNT;
            }else{
                $discountType = 2; // Gán bằng 2 vì giá trị của switch input đang mặc định là 0 và 1.
                $discountExtra = $model->DISCOUNT_AMOUNT/100;
            }

            $model->DATE_START = date("Y-m-d",strtotime($model->DATE_START));
            $model->DATE_END = date("Y-m-d 23:59:59",strtotime($model->DATE_END));
            if($model->DATE_LOG_START){
                $model->DATE_LOG_START = date("Y-m-d",strtotime($model->DATE_LOG_START));
            }

            $manyTimecode = '';
            if($model->MANY_TIMES_CODE){
                if($model->CAMPAIGN_TYPE == 9){
                    $manyTimecode =  'FB'.strtoupper($model->MANY_TIMES_CODE);
                }else{
                    $manyTimecode =  strtoupper($model->MANY_TIMES_CODE);
                }
            }

            if($model->TIME_DATE_WEEK){
                $sumday = 0;
                foreach((array)$model->TIME_DATE_WEEK as $day){
                    $sumday = pow(2,$day)+ $sumday;
                }
                $model->TIME_DATE_WEEK = $sumday;
            }

            if($model->TIME_HOUR_DAY){
                $sumhour = 0;
                foreach((array)$model->TIME_HOUR_DAY as $hour){
                    $sumhour = pow(2,$hour)+ $sumhour;
                }
                $model->TIME_HOUR_DAY = $sumhour;
            }
            if($model->ITEM_ID_LIST){
                $model->ITEM_ID_LIST = implode(",",$model->ITEM_ID_LIST);
            }



            $paramCommnet = array(
                'campaign_name' => $model->VOUCHER_NAME,
                'discount_type' => $discountType,
                'discount_amount' => $discountAmount,
                'discount_extra' => $discountExtra,
                'date_start' => $model->DATE_START,
                'date_end' => $model->DATE_END,
                'campaign_type' => $model->CAMPAIGN_TYPE,
                'quantity_per_day' => $model->QUANTITY_PER_DAY,
                'duration' => $model->DURATION,
                'list_pos_id' => $model->LIST_POS_ID,
                'list_item_type' => $model->ITEM_TYPE_ID_LIST,
                'discount_max' => $model->DISCOUNT_MAX,
                'code_many_time' => $manyTimecode,
                'sms_content' => $model->SMS_CONTENT,
                'date_log_start' => @$model->DATE_LOG_START,
                'discount_one_item' => @$model->DISCOUNT_ONE_ITEM,
                'requied_member' => @$model->REQUIED_MEMBER,
                'list_item_id' => @$model->ITEM_ID_LIST,
                'lucky_number' => @$model->LUCKY_NUMBER,
                'amount_order_over' => @$model->AMOUNT_ORDER_OVER,
                'is_coupon' => @$model->IS_COUPON,
                'only_coupon' => @$model->ONLY_COUPON,
            );

/*            echo '<pre>';
            var_dump($paramCommnet);
            echo '</pre>';
            die();*/


            if($model->AFFILIATE_ID){
                $paramCommnet['affilate_id'] = $model->AFFILIATE_ID;
            }
            if($model->VOUCHER_TYPE  == 2){
                $paramCommnet['number_item_buy'] = $model->NUMBER_ITEM_BUY;
                $paramCommnet['number_item_free'] = $model->NUMBER_ITEM_FREE;
                if($model->APPLY_ITEM_ID){
                    $model->APPLY_ITEM_ID = implode(",",$model->APPLY_ITEM_ID);
                    $paramCommnet['apply_item_id'] = $model->APPLY_ITEM_ID;
                }

                if($model->APPLY_ITEM_TYPE){
                    $paramCommnet['apply_item_type'] = implode(',',$model->APPLY_ITEM_TYPE);
                }
            }
            if($model->VOUCHER_TYPE  == 3){
                $paramCommnet['same_price'] = $model->SAME_PRICE;
            }


            if($model->TIME_DATE_WEEK){
                $paramCommnet['time_date_week'] = $model->TIME_DATE_WEEK;
            }

            if($model->TIME_HOUR_DAY){
                $paramCommnet['time_hour_day'] = $model->TIME_HOUR_DAY;
            }
            if($model->LIMIT_DISCOUNT_ITEM){
                $paramCommnet['limit_discount_item'] = $model->LIMIT_DISCOUNT_ITEM;
            }
            if($model->MIN_QUANTITY_DISCOUNT){
                $paramCommnet['min_quantity_discount'] = $model->MIN_QUANTITY_DISCOUNT;
            }
            if($model->APPLY_ONCE_PER_USER){
                $paramCommnet['apply_one_per_user'] = $model->APPLY_ONCE_PER_USER;
            }

            $data = ApiController::getApiByMethod($apiName,$apiPath,$paramCommnet,'POST');
            if(isset($data->data)){
                Yii::$app->session->setFlash('success', 'Tạo e voucher "'.$model->VOUCHER_NAME.'" thành công');
                return $this->redirect(['statistics']);
            }else{
                if(isset($data->error)){
                    Yii::$app->session->setFlash('error', 'Tạo e voucher lỗi '.@$data->error->message);
                }else{
                    Yii::$app->session->setFlash('error', 'Lỗi kết nối máy chủ');
                }
                return $this->render('create_evoucher', [
                    'model' => $model,
                    'allPosMap' => $allPosMap,
                    'itemMap' => $itemMap,
                    'iteTypemMap' => $iteTypemMap,
                    'partnerMap' => $partnerMap,
                ]);
            }
        } else {
            return $this->render('create_evoucher',[
                'model' => $model,
                'allPosMap' => $allPosMap,
                'itemMap' => $itemMap,
                'iteTypemMap' => $iteTypemMap,
                'partnerMap' => $partnerMap,
            ]);
        }
    }

    public function actionCreatefollow()
    {
        $model = new Dmvouchercampaign();

        $apiName = 'ipcc/get_campaign_event';
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];

        $paramGetCampaign = array();


        $campagins = ApiController::getApiByMethod($apiName,$apiPath,$paramGetCampaign,'GET');
        $campaginsMap = array();
        if(isset($campagins->data) && count($campagins->data) >0){
            $campaginsMap = ArrayHelper::map($campagins->data,'id','voucher_campaign_name');
        }

//        echo '<pre>';
//        var_dump($campagins);
//        echo '</pre>';
//        die();


        if ($model->load(Yii::$app->request->post())) {

            $apiName = 'ipcc/create_event';

            $paramCommnet = array(
                'campaign_name' => $model->VOUCHER_NAME,
                'discount_type' => $discountType,
                'discount_amount' => $discountAmount,
                'discount_extra' => $discountExtra,
                'date_start' => $model->DATE_START,
                'date_end' => $model->DATE_END,
                'campaign_type' => $model->CAMPAIGN_TYPE,
                'quantity_per_day' => $model->QUANTITY_PER_DAY,
                'duration' => $model->DURATION,
                'list_pos_id' => $model->LIST_POS_ID,
                'list_item_type' => $model->ITEM_TYPE_ID_LIST,
                'discount_max' => $model->DISCOUNT_MAX,
                'code_many_time' => $model->MANY_TIMES_CODE,
                'sms_content' => $model->SMS_CONTENT,
                'date_log_start' => @$model->DATE_LOG_START,
//                'lucky_number' => @$model->LUCKY_NUMBER,
            );


//            echo '<pre>';
//            var_dump($model->DATE_LOG_START);
//            var_dump($paramCommnet);
//            echo '</pre>';
//            die();

            $data = ApiController::getApiByMethod($apiName,$apiPath,$paramCommnet,'POST');
            if(isset($data->data)){
                Yii::$app->session->setFlash('success', 'Tạo e voucher '.$model->VOUCHER_NAME.' thành công');
                return $this->redirect(['evoucher']);
            }else{
                if(isset($data->error)){
                    Yii::$app->session->setFlash('error', 'Tạo e voucher lỗi '.@$data->error->message);
                }else{
                    Yii::$app->session->setFlash('error', 'Lỗi kết nối máy chủ');
                }
                return $this->render('create_evoucher', [
                    'model' => $model,
                ]);
            }
        } else {

            return $this->render('create_evoucher',[
                'model' => $model,
                'campaginsMap' => $campaginsMap,
            ]);
        }
    }
    public function actionCreatmulti()
    {
        $model = new Dmvouchercampaign();

        $apiName = 'ipcc/get_campaign_by_type';
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];

        $paramGetCampaign = [
            'campaign_type' => 5
        ];

        $campagins = ApiController::getApiByMethod($apiName,$apiPath,$paramGetCampaign,'GET');

        $campaginsMap = array();
        if(isset($campagins->data) && count($campagins->data) >0){
            $campaginsMap = ArrayHelper::map($campagins->data,'id','voucher_campaign_name');
        }

//        echo '<pre>';
//        var_dump($campagins);
//        echo '</pre>';
//        die();

        if ($model->load(Yii::$app->request->post()) && $model->validate(['MANY_TIMES_CODE'])){

            $apiName = 'ipcc/create_voucher_series';


            $dateArr = explode(' - ', $model->DATE_START);

            $date_start_tmp = str_replace('/', '-', $dateArr[0]);
            $start_date = date("Y-m-d H:i:s", strtotime($date_start_tmp));

            $date_end_tmp = str_replace('/', '-', $dateArr[1]);
            $end_date = date("Y-m-d 23:59:59", strtotime($date_end_tmp));

            $paramCommnet = array(
                'campaign_id' => $model->ID,
                'quantity' => $model->QUANTITY_PER_DAY,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'affiliate_id' => 10000000,
                'prefix' => $model->MANY_TIMES_CODE,
            );

//            echo '<pre>';
//            var_dump($paramCommnet);
//            echo '</pre>';
//            die();

            $data = ApiController::getApiByMethod($apiName,$apiPath,$paramCommnet,'POST');


            if(isset($data->data)){
                Yii::$app->session->setFlash('success', 'Tạo mã thành công');
                return $this->render('list_evoucher', [
                    'data' =>  $data->data ,
                ]);
//                return $this->render(['listevoucher','data' => $data->data ]);
            }else{
                if(isset($data->error)){
                    Yii::$app->session->setFlash('error', 'Tạo e voucher lỗi '.@$data->error->message);
                }else{
                    Yii::$app->session->setFlash('error', 'Lỗi kết nối máy chủ');
                }
                return $this->render('form_create_multi_evoucher', [
                    'model' => $model,
                    'campaginsMap' => $campaginsMap,
                ]);
            }
        } else {
            return $this->render('form_create_multi_evoucher',[
                'model' => $model,
                'campaginsMap' => $campaginsMap,
            ]);
        }
    }

    /**
     * Displays a single Dmvouchercampaign model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id,$total_voucher_log = null)
    {
        $searchPosModel = new DmposSearch();
        $allPos = $searchPosModel->searchAllPos();
        $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');
        $model = $this->findModel($id);

        $listPos = '';
        if($model->LIST_POS_ID){
            $listArr = explode(",",$model->LIST_POS_ID);
            foreach($listArr as $pos_id){
                if($listPos){
                    $listPos = $listPos.', '.@$allPosMap[$pos_id];
                }else{
                    $listPos = @$allPosMap[$pos_id];
                }
            }
        }else{
            $listPos = 'Áp dụng toàn hệ thống';
        }

        $model->LIST_POS_ID = $listPos;
        $model->TIME_HOUR_DAY = $total_voucher_log; // Mượn tạm trường để show voucher log count

        return $this->render('view', [
            'model' => $model,
            '$total_voucher_log' => $total_voucher_log
        ]);
    }

    public function actionListevoucher($data)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Dmvouchercampaign model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dmvouchercampaign();

        if ($model->load(Yii::$app->request->post())) {
            if($model->DISCOUNT_EXTRA){
                $model->DISCOUNT_EXTRA = $model->DISCOUNT_EXTRA/100;
            }

            $posArr = $model->POS_ID;
            $model->LIST_POS_ID = implode(",",$posArr);
            $model->POS_ID = @$model->POS_ID[0];

//            if($posArr){
//                foreach((array)$posArr as $posId){
//                    $model->POS_ID = $posId;
//                    $model->DATE_START = date("Y-m-d",strtotime($model->DATE_START));
//                    $model->DATE_END = date("Y-m-d 23:59:59",strtotime($model->DATE_END));
//                    $model->save();
//                    $tmp++;
//                }
//            }else{
//                $model->POS_ID = 0;
//                $model->DATE_START = date("Y-m-d",strtotime($model->DATE_START));
//                $model->DATE_END = date("Y-m-d 23:59:59",strtotime($model->DATE_END));
//                $model->save();
//                $tmp++;
//            }


            $model->DATE_START = date("Y-m-d",strtotime($model->DATE_START));
            $model->DATE_END = date("Y-m-d 23:59:59",strtotime($model->DATE_END));

            if(is_array($model->ITEM_TYPE_ID_LIST)){
                $model->ITEM_TYPE_ID_LIST =  implode(",",$model->ITEM_TYPE_ID_LIST);
                $model->IS_ALL_ITEM = 0;

            }else{
                $model->IS_ALL_ITEM = 1;
            }

            if($model->save()){
                Yii::$app->session->setFlash('success', 'Tạo mới '.$model->VOUCHER_NAME.' thành công');
            }else{
                Yii::$app->session->setFlash('error', 'Tạo lỗi');
            }
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {

            $searchCityModel = new DmcitySearch();
            $allCity = $searchCityModel->searchAllCity();
            $allCityMap= ArrayHelper::map($allCity,'ID','CITY_NAME');

            $posparentSearchModel = new DmposparentSearch();
            $posParentObj = $posparentSearchModel->searchAllParent();
            $posParentMap = ArrayHelper::map($posParentObj,'ID','ID');

            //Tính giá trị cho các khung thời gian trong ngày
            $timeHourDayArrPrepair = [
                '6_7_8_9_10' => 'Ăn sáng (6h00 - 10h59)',
                '11_12_13' => 'Ăn trưa (11h00 - 13h59)',
                '14_15_16' => 'Ăn chiều (14h00 - 16h59)',
                '17_18_19_20' => 'Ăn tối (17h00 - 20h59)',
                '21_22_23' => 'Ăn đêm(21h00 - 23h59)',
                '0_1_2_3_4_5_6_7_8_9_10_11_12_13_14_15_16_17_18_19_20_21_22_23' => 'Cả ngày'
            ];
            $timeHourDayArr = array();
            foreach($timeHourDayArrPrepair as $timeList => $timeName){
                $timeArr = explode("_",$timeList);
                $tmp = 0;
                foreach($timeArr as $day){
                    $tmp = pow(2,$day)+ $tmp;
                }
                $timeHourDayArr[$tmp] = $timeName;
            }
            // !.Tính giá trị cho các khung thời gian trong ngày

            //$timesaleBinArray = DmpositemController::DecToBin($model->TIME_SALE_DATE_WEEK,7); // 7 ngày

            //Tính giá trị cho các khung ngày tỏng tuần
            $timeDayOfWeekPrepair = [
                '2_3_4_5_6' => 'Từ Thứ 2 - Thứ 6',
                '1_2_3_4_5_6_7' => 'Từ Thứ 2 - Chủ nhật',
                '2' => 'Thứ 2',
                '3' => 'Thứ 3',
                '4' => 'Thứ 4',
                '5' => 'Thứ 5',
                '6' => 'Thứ 6',
                '7' => 'Thứ 7',
                '1' => 'Chủ nhật',
            ];
            $timeDayOfWeekArr = array();
            foreach($timeDayOfWeekPrepair as $dayList => $dayName){
                $timeArr = explode("_",$dayList);
                $tmp = 0;
                foreach($timeArr as $day){
                    $tmp = pow(2,$day)+ $tmp;
                }
                $timeDayOfWeekArr[$tmp] = $dayName;
            }
            // !.Tính giá trị cho các khung ngày tỏng tuần


//            echo '<pre>';
//            var_dump($timeDayOfWeekArr);
//            echo '</pre>';
//            die();

            return $this->render('create', [
                'model' => $model,
                'allCityMap' => $allCityMap,
                'posParentMap' => $posParentMap,
                'timeHourDayArr' => $timeHourDayArr,
                'timeDayOfWeekArr' => $timeDayOfWeekArr,
            ]);
        }
    }

    public function actionFilterpos(){
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $pos_parent = $parents[0];
                $out = self::getPosList($pos_parent);
                // the getSubCatList1 function will query the database based on the
                // cat_id, param1, param2 and return an array like below:
                // [
                //    'group1'=>[
                //        ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
                //        ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
                //    ],
                //    'group2'=>[
                //        ['id'=>'<sub-cat-id-3>', 'name'=>'<sub-cat-name3>'],
                //        ['id'=>'<sub-cat-id-4>', 'name'=>'<sub-cat-name4>']
                //    ]
                // ]


                //$selected = self::getPosList($pos_parent);
                // the getDefaultSubCat function will query the database
                // and return the default sub cat for the cat_id

                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    public function actionFilteritemtype(){
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $pos_parent = $parents[0];
                $out = self::getItemTypeList($pos_parent);
                // the getSubCatList1 function will query the database based on the
                // cat_id, param1, param2 and return an array like below:
                // [
                //    'group1'=>[
                //        ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
                //        ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
                //    ],
                //    'group2'=>[
                //        ['id'=>'<sub-cat-id-3>', 'name'=>'<sub-cat-name3>'],
                //        ['id'=>'<sub-cat-id-4>', 'name'=>'<sub-cat-name4>']
                //    ]
                // ]

                //$selected = self::getPosList($pos_parent);
                // the getDefaultSubCat function will query the database
                // and return the default sub cat for the cat_id

//                echo '<pre>';
//                var_dump($out);
//                echo '</pre>';
//                die();
                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }
    public function actionFilteritem(){
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $pos_parent = $parents[0];
                $out = self::getItem($pos_parent);
                // the getSubCatList1 function will query the database based on the
                // cat_id, param1, param2 and return an array like below:
                // [
                //    'group1'=>[
                //        ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
                //        ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
                //    ],
                //    'group2'=>[
                //        ['id'=>'<sub-cat-id-3>', 'name'=>'<sub-cat-name3>'],
                //        ['id'=>'<sub-cat-id-4>', 'name'=>'<sub-cat-name4>']
                //    ]
                // ]

                //$selected = self::getPosList($pos_parent);
                // the getDefaultSubCat function will query the database
                // and return the default sub cat for the cat_id

                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    public function getPosList($pos_parent){
        $searchPosModel = new DmposSearch();
        $allPos = $searchPosModel->searchAllPosByPosParent($pos_parent);
        $allPosMap = array();
        foreach($allPos as $value){
            array_push($allPosMap,['id'=>$value['ID'],'name'=> $value['POS_NAME']]);

        }

        return $allPosMap;
    }
    public function getItemTypeList($pos_id_list){
        $searchPosModel = new DmitemtypeSearch();
//        $allItemType = $searchPosModel->searchCategoryByPos($pos_id_list);
        $allItemTypemap = $searchPosModel->searchCategoryForCampain($pos_id_list);
        return $allItemTypemap;
    }

    public function getItem($pos_id_list){
        $searchPosModel = new DmitemSearch();
        $allItemTypemap = $searchPosModel->searchItemCampain($pos_id_list);
        return $allItemTypemap;
    }

    /**
     * Updates an existing Dmvouchercampaign model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            if($model->LIST_POS_ID){
                $model->LIST_POS_ID = implode(',',$model->LIST_POS_ID);
            }

            $model->save();
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            $posSearch = new DmposSearch();
            $dmPos = $posSearch->searchAllPosForCampagin($model->POS_PARENT);
            $allPosMap = ArrayHelper::map($dmPos,'ID','POS_NAME');


            if($model->LIST_POS_ID){
                $model->LIST_POS_ID = explode(',',$model->LIST_POS_ID);
            }else{

            }

            $itemTypeSearch = new DmitemtypeSearch();
            $itemTypes = $itemTypeSearch->searchCategoryByPos($model->LIST_POS_ID);
            $allItemTypeMap = ArrayHelper::map($itemTypes,'ITEM_TYPE_ID','ITEM_TYPE_NAME');



            $allItemsMap = array();
            $itemSearch = new DmitemSearch();
            $items = $itemSearch->searchItemByPos($model->LIST_POS_ID);
            $allItemsMap = ArrayHelper::map($items,'ITEM_ID','ITEM_NAME');



            return $this->render('update', [
                'model' => $model,
                'allPosMap' => $allPosMap,
                'allItemTypeMap' => $allItemTypeMap,
                'allItemsMap' => $allItemsMap,
            ]);
        }
    }



    /**
     * Deletes an existing Dmvouchercampaign model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
//        $model = $this->findModel($id);

        $apiName = 'ipcc/deactive_campaign';
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];

        $paramCommnet = array(
            'campaign_id' => $id,
        );

        $data = ApiController::getApiByMethod($apiName,$apiPath,$paramCommnet,'POST');

        if(isset($data->data)){
            Yii::$app->session->setFlash('success', 'Hủy chiến dịch thành công');
        }else{
            Yii::$app->session->setFlash('error', @$data->error->message);
        }

        return $this->redirect(['statistics']);
    }
    public function actionRemoveevoucher($id)
    {
        $model = $this->findModel($id);

        $apiName = 'ipcc/deactive_campaign';
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];
        $paramCommnet = array(
            'campaign_id' => $id
        );
        $data = ApiController::getApiByMethod($apiName,$apiPath,$paramCommnet,'POST');

        if(isset($data->data)){
            Yii::$app->session->setFlash('success', 'Hủy e - Voucher '.$model->VOUCHER_NAME.' thành công');
            return $this->redirect(['evoucher']);
        }else{
            if(isset($data->error)){
                return $data->error->message;
            }else{
                return 'Lỗi kết nối máy chủ';
            }
        }

    }

    /**
     * Finds the Dmvouchercampaign model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Dmvouchercampaign the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dmvouchercampaign::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }




}
