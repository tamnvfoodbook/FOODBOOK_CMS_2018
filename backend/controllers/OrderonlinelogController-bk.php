<?php

namespace backend\controllers;

use backend\models\BookingonlinelogSearch;
use backend\models\DmcitySearch;
use backend\models\DmdistrictSearch;
use backend\models\Dmitem;
use backend\models\DmitemtypeSearch;
use backend\models\Dmmembership;
use backend\models\DmmembershipSearch;
use backend\models\DmposparentSearch;
use backend\models\DmposSearch;
use backend\models\MemberaddresslistSearch;
use backend\models\Orderonlinelogpending;
use backend\models\OrderonlinelogpendingSearch;
use backend\models\UserSearch;
use Yii;
use backend\models\Orderonlinelog;
use backend\models\OrderonlinelogSearch;
use yii\data\ArrayDataProvider;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use linslin\yii2\curl;
use yii\helpers\ArrayHelper;

/**
 * OrderonlinelogController implements the CRUD actions for Orderonlinelog model.
 */
class OrderonlinelogController extends Controller
{

    public $ahamove_cancelled = 'CANCELLED';

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
     * Lists all Orderonlinelog models.
     * @return mixed
     */
    public function actionIndex($checkPjax = null)
    {

        $posParent = null;
        $type = \Yii::$app->session->get('type_acc');
        $callcenter_ext  = \Yii::$app->session->get('callcenter_ext');

        $searchPosModel = new DmposSearch();
        $searchModel = new OrderonlinelogSearch();

        $ids = $searchPosModel->getIds();
        $posParent = \Yii::$app->session->get('pos_parent');
        $allPos = $searchPosModel->searchAllPosById($ids);
        $allPosMap= ArrayHelper::map($allPos,'ID','POS_NAME');

        $searchPosparentModel = new DmposparentSearch();
        $posParentModel = $searchPosparentModel->searchPosparentById($posParent);

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$ids,$posParent);
        $dataProvider->setSort(false);

        //echo 'hello';
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'callcenter_ext' => $callcenter_ext,
            'ws_server' => @$posParentModel->WS_SIP_SERVER,
            'ws_pass' => @$posParentModel->PASS_SIP_SERVER,
            'checkPjax' => $checkPjax,
            'allPosMap' => $allPosMap,
            'oderDraft' => @$oderDraft,
//            'allMemberMap' => $allMemberMap,
        ]);
    }

    public function actionIndexstatic()
    {
        $ids = null;
        $posParent = \Yii::$app->session->get('pos_parent');
        $type = \Yii::$app->session->get('type_acc');
        $callcenter_ext  = \Yii::$app->session->get('callcenter_ext');

        $searchPosModel = new DmposSearch();
        $searchModel = new OrderonlinelogSearch();

        $ids = $searchPosModel->getIds();
        $allPos = $searchPosModel->searchAllPosById($ids);
        $allPosMap= ArrayHelper::map($allPos,'ID','POS_NAME');


        $searchPosparentModel = new DmposparentSearch();
        $posParentModel = $searchPosparentModel->searchPosparentById($posParent);

        $dataProvider = $searchModel->searchStatic(Yii::$app->request->queryParams,$ids,$posParent);
        $dataProvider->setSort(false);

//        echo '<pre>';
//        //var_dump(Yii::$app->params['CMS_API_PATH']);
//        echo '</pre>';


        return $this->render('index_static', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'callcenter_ext' => $callcenter_ext,
            'ws_server' => @$posParentModel->WS_SIP_SERVER,
            'ws_pass' => @$posParentModel->PASS_SIP_SERVER,
            'allPosMap' => $allPosMap,
        ]);
    }
    public function actionReport()
    {
        if(!isset(Yii::$app->request->queryParams['OrderonlinelogSearch']['created_at'])){
            //$timeRanger = date('m/d/Y').' - '.date('m/d/Y');
            $timeRanger = date('d/m/Y',strtotime("-1 week")).' - '.date('d/m/Y');
        }else{
            $timeRanger = Yii::$app->request->queryParams['OrderonlinelogSearch']['created_at'];
        }

//        $keycityMap = 'cityMap';
        //$allCityMap = \Yii::$app->cache->get($keycityMap);
        //if ($allCityMap === false) {
//            $searchCityModel = new DmcitySearch();
//            $allCity = $searchCityModel->searchAllCity();
//            $allCityMap = ArrayHelper::map($allCity,'CITY_NAME','CITY_NAME');
//            \Yii::$app->cache->set($keycityMap, $allCityMap, 43200); // time in seconds to store cache
        //}

            $searcDmposhModel = new DmposSearch();
            $ids = $searcDmposhModel->getIds();

            $searhUser = new UserSearch();
            $userMap = $searhUser->searchUserbyPPandPermis();

            $allPos = $searcDmposhModel->searchAllPosById($ids);
            $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');

            $searchModel = new OrderonlinelogSearch();
            $dataProvider = $searchModel->searchAllorderbypos(Yii::$app->request->queryParams,$ids,$timeRanger);
            $dataProvider->setSort(false);

            $allSourceMap = $searchModel->searchClausereport('created_by',$ids,$timeRanger);
//            echo '<pre>';
//            var_dump($allSourceMap);
//            echo '</pre>';
//            die();
//          Comment chỗ này vì làm ảnh hưởng tới toogle all đơn hàng
           /* $orders = $dataProvider->getModels();
            $allCityMap = ArrayHelper::map($orders,'province','province');
            $allDistrictMap = ArrayHelper::map($orders,'district','district');*/
//          $allSourceMap = ArrayHelper::map($orders,'created_by','created_by');


            return $this->render('report',[
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'allPosMap' => $allPosMap,
                'timeRanger' => $timeRanger,
                'allCityMap' => @$allCityMap,
                'userMap' => @$userMap,
                'allDistrictMap' => @$allDistrictMap,
                'allSourceMap' => @$allSourceMap,

            ]);
    }
    public function actionReportall()
    {


        if(!isset(Yii::$app->request->queryParams['dateRanger'])){
            //$timeRanger = date('m/d/Y').' - '.date('m/d/Y');
            $timeRanger = date('d/m/Y',strtotime("-1 month")).' - '.date('d/m/Y');
        }else{
            $timeRanger = Yii::$app->request->queryParams['dateRanger'];
        }

            $searcDmposhModel = new DmposSearch();
            $ids = $searcDmposhModel->getIds();

            $allPos = $searcDmposhModel->searchAllPosById($ids);
            $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');

            $searchModel = new OrderonlinelogSearch();
            $dataReport = $searchModel->searchAllOrderbyTime($ids,$timeRanger);
//            $dataReport = $dataProvider->getModels();
//            echo '<pre>';
//            var_dump($timeRanger);
//            var_dump($dataProvider);
//            echo '</pre>';
//            die();
            $data = array();
            foreach((array)$dataReport as $value){
                if(!isset($data[$value->pos_id])){
                    $data[$value->pos_id]['pos_id'] = $value->pos_id;
                    switch ($value->status) {
                        case 'CANCELLED':
                            $data[$value->pos_id]['CANCELLED'] = 1;
                            @$data[$value->pos_id]['AMOUNT_CANCELLED'] = $value->amount;
                            break;
                        case 'CONFIRMED':
                            $data[$value->pos_id]['CONFIRMED'] = 1;
                            @$data[$value->pos_id]['AMOUNT_CONFIRMED'] = $value->amount;
                            break;

                        case 'COMPLETED':
                            $data[$value->pos_id]['CONFIRMED'] = 1;
                            @$data[$value->pos_id]['AMOUNT_CONFIRMED'] = $value->amount;
                            break;
                        default:
                            # code...
                            break;
                    }

                }else{
                    switch ($value->status) {
                        case 'CANCELLED':
                            @$data[$value->pos_id]['CANCELLED']++;
                            @$data[$value->pos_id]['AMOUNT_CANCELLED'] = $value->amount + @$data[$value->pos_id]['AMOUNT_CANCELLED'];
                            break;
                        case 'CONFIRMED':
                            @$data[$value->pos_id]['CONFIRMED']++;
                            @$data[$value->pos_id]['AMOUNT_CONFIRMED'] = $value->amount + @$data[$value->pos_id]['AMOUNT_CONFIRMED'];
                            break;
                        case 'COMPLETED':
                            @$data[$value->pos_id]['CONFIRMED']++;
                            @$data[$value->pos_id]['AMOUNT_CONFIRMED'] = $value->amount + @$data[$value->pos_id]['AMOUNT_CONFIRMED'];
                            break;
                        default:
                            # code...
                            break;
                    }
                }
            }

//        echo '<pre>';
//        var_dump($data);
//        echo '</pre>';
//        die();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['pos_id', 'CONFIRMED', 'CANCELLED','AMOUNT_CONFIRMED','AMOUNT_CANCELLED'],
            ],
        ]);

        if(isset(Yii::$app->request->queryParams['dateRanger'])){
            return $this->renderAjax('reportall_form',[
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'allPosMap' => $allPosMap,
                'dateRanger' => $timeRanger,
            ]);
        }else{
            return $this->render('reportall',[
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'allPosMap' => $allPosMap,
                'dateRanger' => $timeRanger,
            ]);
        }

    }

    public function actionFiltercity(){
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $city_id = $parents[0];
                $out = self::getDistrictList($city_id);
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

    public function getDistrictList($city_name){
        $keydistrictMap = 'districtMap';
        $districtMap = \Yii::$app->cache->get($keydistrictMap);
        $allDistrictMap = array();
        //if ($districtMap === false) {
            $searchDistrictModel = new DmdistrictSearch();
            $searchOrderonlineModel = new OrderonlinelogSearch();
            $allDistrict = $searchOrderonlineModel->searchOrderByCityName($city_name);
            //$allDistrict = $searchDistrictModel->searchDistrictByCityId($city_name);
            foreach($allDistrict as $value){
                if($value['district'] == ''){
                    array_push($allDistrictMap,['id'=>'0','name'=> 'Chưa xác định']);
                }else{
                    array_push($allDistrictMap,['id'=>$value['district'],'name'=> $value['district']]);
                }
            }
            \Yii::$app->cache->set($keydistrictMap, $districtMap, 43200); // time in seconds to store cache
        //}

        return $allDistrictMap;
    }






    public function actionCallcenter()
    {

        return $this->render('callcenter');
    }



    public function actionGetinfomembershortcallcenter(){
        $post = Yii::$app->request->post();
        $posParent = \Yii::$app->session->get('pos_parent');
        $ACCESS_TOKEN = Yii::$app->params['ACCESS_TOKEN'];

        $nameAPI = 'user_cc_info';
        $apiPath = Yii::$app->params['CMS_API_PATH'];
        $id = AjaxapiController::fixPhoneNumbTo84(@$post['user_id']);

        $param = array(
            'user_id'=> $id,
            'pos_parent'=> $posParent,
            'access_token'=> $ACCESS_TOKEN,
        );

        $headers = array();
        $headers[] = 'access_token: ' . Yii::$app->params['ACCESS_TOKEN'];
        $result = self::getApiByMethod($nameAPI, $apiPath, $param, $headers, 'GET');


        /*echo '<pre>';
        var_dump($result);
        echo '</pre>';
        die();*/

        if(isset($result->data)){
            $searchPosModel = new DmposSearch();
            $allPos = $searchPosModel->searchAllPos();
            $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');
            $provider = new ArrayDataProvider([
                'allModels' => @$result->data->order_online_history,

            ]);

            return $this->renderAjax('history_order', [
                'dataProvider' => $provider,
                'allPosMap' => $allPosMap,
                'result' => $result
            ]);
        }else{
            return 'Không có dữ liệu';
        }
    }

    public function actionGetdatauser(){
        $post = Yii::$app->request->post();
        $id = AjaxapiController::fixPhoneNumbTo84(@$post['user_id']);

        $posParent = \Yii::$app->session->get('pos_parent');
        $ACCESS_TOKEN = Yii::$app->params['ACCESS_TOKEN'];

        $nameAPI = 'user_cc_info';
        $apiPath = Yii::$app->params['CMS_API_PATH'];

        $param = array(
            'user_id'=> $id,
            'pos_parent'=> $posParent,
            'access_token'=> $ACCESS_TOKEN,
        );

        $headers = array();
        $headers[] = 'access_token: ' . Yii::$app->params['ACCESS_TOKEN'];
        $result = self::getApiByMethod($nameAPI, $apiPath, $param, $headers, 'GET');

//        echo '<pre>';
//        var_dump($result);
//        echo '</pre>';
//        die();
//        var_dump(json_encode($result));
//        return false;

        if(isset($result->data)){
            return json_encode($result->data);
        }else{
            return false;
        }
    }


    public function actionCreatorder($id,$isBooking = null)
    {

        if (strpos($id, '@') !== false) {
            $arrId = explode("@",$id);
            $id = $arrId[0];
        }

        $fisrtChar = substr($id,0,1); // Lấy kí tự đầu của chuỗi
        if ($fisrtChar == '84'){
            $phoneNumber = $id;
        }
        else if ($fisrtChar == '0'){
            $cutId = substr($id,1);
            $phoneNumber = '84'.$cutId;

        }else if(!($fisrtChar == '0') || !($fisrtChar == '84') ){
            $phoneNumber = '84'.$id;
        }else{
            $phoneNumber = null;
        }

        if(!$id){
            $phoneNumber = null;
        }

        $id = $phoneNumber;
        $model = new Orderonlinelog();
        $model->user_id = $phoneNumber;

        $modelMember = $this->findMemberModel($id);

        $searchOrderModel = new OrderonlinelogSearch();
        //$dataProvider = $searchOrderModel->searchByMember(Yii::$app->request->queryParams,$id);
        $order = $searchOrderModel->searchAllOrderByUserId($id);


        $searchPosModel = new DmposSearch();
        $allPos = $searchPosModel->searchAllPos();
        $posMapOrder = array();
        $allPosToCheckDistance = array();
        foreach($allPos as $key => $pos){
            $allPosToCheckDistance[$key]['POS_NAME'] = $pos['POS_NAME'].'-'.$pos['POS_LONGITUDE'].'-'.$pos['POS_LATITUDE'];
            $allPosToCheckDistance[$key]['ID'] = $pos['ID'];
            if(@$pos['IS_ORDER_LATER']){
                $posMapOrder[] = $pos['ID'];
            }
        }

        $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');
        $allPosToCheckDistanceMap = ArrayHelper::map($allPosToCheckDistance,'ID','POS_NAME');
        $wait_confirm = NULL;
        $assigning = NULL;
        $accepted = NULL;
        $comfirmed = NULL;
        $in_process = NULL;
        $cancelled = NULL;
        $failed = NULL;
        $complete = NULL;
        $total = 0;

        if($order){
            $total = count($order);
            foreach($order as $key => $value){
                $order[$key]['_id'] = $value['_id']-> __Tostring();
                if($key == 0){
                    $model = $this->findModel($order[0]['_id']);
                    date_default_timezone_set('Asia/Bangkok');
                    $model->created_at = date('Y-m-d h:i:s', $model->created_at->sec);
                    $tmpPos = $searchPosModel->searchById($model->pos_id);
                    $model->pos_id = $tmpPos['POS_NAME'];

                    if(isset($model->order_data_item)){
                        $listItem = NULL;
                        foreach((array)$model->order_data_item as $item){
                            if(isset($item['Item_Name'])){
                                if($listItem){
                                    $listItem = $listItem.' , '.$item['Item_Name'].'('.$item['Quantity'].')';
                                }else{

                                    $listItem = $item['Item_Name'].'('.$item['Quantity'].') ';;
                                }
                            }

                        }
                        $model->order_data_item = $listItem;
                    }
//                    echo '<pre>';
//                    var_dump($model->order_data_item);
//                    echo '</pre>';
//                    die();
                }
            }

            $orderMap = ArrayHelper::map($order,'_id','user_id','status');



            foreach($orderMap as $key => $value){
                switch ($key) {
                    case 'COMPLETED':
                        $complete = $value;
                        break;
                    case 'CANCELLED':
                        $cancelled = $value;
                        break;
                    case 'FAILED':
                        $failed = $value;
                        break;
                    case 'WAIT_CONFIRM':
                        $wait_confirm = $value;
                        break;
                    case 'ASSIGNING':
                        $assigning = $value;
                        break;
                    case 'ACCEPTED':
                        $accepted = $value;
                        break;
                    case 'CONFIRMED':
                        $comfirmed = $value;
                        break;
                    case 'IN PROCESS':
                        $in_process = $value;
                        break;

                    default:
                        # code...
                        break;
                }
            }
        }



        if ($model->load(Yii::$app->request->post())) {
            $id = null;
            $fisrtChar = substr($model->user_id,0,1); // Lấy kí tự đầu của chuỗi
            if($fisrtChar === '0'){
                $id = UsermanagerController::format_number($model->user_id);
            }

            //Get Accetoken user
            $param= ['msisdn' => (int)$id];  //'msisdn' => (int)$model->user_id,

            $apiPath = Yii::$app->params['CMS_API_PATH_SHORT'];
            $type = 'auth/partner_login';
            $access_token = Yii::$app->params['ACCESS_TOKEN'];

            $member = self::actionCallApiByPost($param,$apiPath,$type,$access_token);
            //. ./Get Accetoken user

            //Get Item by User
            $name = 'item/item_order_pos';

            $paramItem = array(
                'id' => $model->pos_id,
            );

            $headers = array();
            $headers[] = 'access_token: '.$access_token;
            $headers[] = 'token: '.$member->data->Token;
            $itemList = self::getApiByMethod($name,$apiPath,$paramItem,$headers,'GET');

            // ./Get Item by User
            $orderItem = null;
            $post = Yii::$app->request->post();





            if(isset($post['products_selected'])){
                foreach($post['products_selected'] as $product){
                    $proArray = explode("|",$product); // phần tử 0 là id, 1 là số lượng, 2 là ghi chú
                    foreach($itemList->data as $item){
                        if($item->Id == $proArray[0]){
                            $orderItem[$item->Id]['Item_Type_Id'] = $item->Item_Type_Id;
                            $orderItem[$item->Id]['User_Id'] = $model->user_id;
                            $orderItem[$item->Id]['Item_Name'] = $item->Item_Name;
                            $orderItem[$item->Id]['Item_Id'] = $item->Item_Id;
                            $orderItem[$item->Id]['Note'] = $proArray[2];
                            $orderItem[$item->Id]['Discount'] = $item->Discount_Ta_Price;
                            $orderItem[$item->Id]['Price'] = $item->Ta_Price;
                            $orderItem[$item->Id]['Quantity'] = (int)$proArray[1];
                        }
                    }
                }
            }



            $ItemParam =  [
                'pos_id' => $model->pos_id,
                'orders' => json_encode(array_values($orderItem)),
                'address_id' => $model->address_id,
                'payment_method' => $model->paymentInfo,
                'full_address' => $model->to_address,
                'longitude' => $post['newLongAdress'],
                'latitude' => $post['newLatAdress'],
                'campaign_id' => NULL,
                'coupon_id' => null,
                'booking_info' => null,
            ];

            $nameAPI = 'member/v2/order_online';

            $result = self::getApiByMethod($nameAPI,$apiPath,$ItemParam,$headers,'POST');
            if(isset($result->data)){
                Yii::$app->getSession()->setFlash('success', 'Chúc mừng bạn đã tạo đơn hàng thành công!!');
                return $this->redirect('index.php?r=orderonlinelog',302);
            }else if($result->error) {
                Yii::$app->getSession()->setFlash('error', $result->error->message);
                return $this->redirect('index.php?r=orderonlinelog',302);
            }

        } else {
            $searchMemberModel = new DmmembershipSearch();
            $userPhone = $searchMemberModel->seachAllPhone();
            $userPhoneData = array();
            foreach($userPhone as $phone){
                array_push($userPhoneData,$phone['ID']);
            }

            $callcenter_short  = \Yii::$app->session->get('callcenter_short');

            $ids = $searchPosModel->getIds();

            $itemTypeModelSearch = new DmitemtypeSearch();
            $itemTypeModel = $itemTypeModelSearch->searchCategoryByPos($ids);
            foreach((array)$itemTypeModel as $itemType){
                $itemTypeMap[$itemType['ITEM_TYPE_ID']] = $itemType['ITEM_TYPE_ID'] .' - '.$itemType['ITEM_TYPE_NAME'];
                $itemTypeMap['CBTHUONG'] = 'CBTHUONG - COMBO THUONG';
                $itemTypeMap['CBEXTRA'] = 'CBEXTRA - COMBO EXTRA';
                $itemTypeMap['COMBO'] = 'COMBO - Combo';
            }


            //if((array)$ids){
            if(@$callcenter_short != null || $isBooking != null){
                $items = self::actionGetAllDataForMiniCC();

//                $comboExtraJson = '[{"id_value":221,"combo_id":"123","combo_name":"Mua 1 tặng 2 lấy tiền 3","combo_item_id":"BCSG","start_date":"2017-12-13 15:03:09","end_date":"2017-12-23 15:03:09","start_hour":0,"end_hour":23,"promotion_id":"348","date_time_week":3,"combo_details":[{"id_value":551,"order":1,"item_id_list":"PZ4,PZ51","ta_price":0,"ots_price":0,"quantity":1,"ta_discount":0,"ots_discount":0,"fix":1,"is_main":0,"price_by_menu":0,"sub_id":"","add_price":0},{"id_value":561,"order":1,"item_id_list":"PZ51,PZ7","ta_price":0,"ots_price":0,"quantity":2,"ta_discount":0,"ots_discount":0,"fix":1,"is_main":0,"price_by_menu":0,"sub_id":"","add_price":0}]}]';
//                $comboExtra = json_decode($comboExtraJson);
//                $combo = self::actionConvertComboExtra($comboExtra);

                $comboNomal = self::actionConvertCombo($items->data->list_normal_combo,1);
                $combo = self::actionConvertCombo($items->data->list_special_combo,0);


                $items->data->list_item = array_merge($items->data->list_item,$combo);
                $items->data->list_item = array_merge($items->data->list_item,$comboNomal);


                \Yii::$app->session->set('data',$items->data);

                $allItemMap = array();
                $allItem = array();
                $allIEathwithtemMap = array();
                $mainItemMap = array();
                $tmpEawt = 0;
                foreach($items->data->list_item as $key => $item){

                    if(!$item->Is_Eat_With){
                        $tmpEawt++;
                    }
                    $allItem[$item->Item_Id] = $item;

                    $allItemMap[$item->Item_Id] = $key.'_*_'.$item->Id.'_*_'.$item->Item_Id.'_*_'.$item->Item_Name.'_*_'.$item->Ta_Price.'_*_'.@$item->Item_Id_Eat_With.'_*_'.$tmpEawt;

                    $allIEathwithtemMap[$item->Item_Id] = $item->Item_Id.'_*_'.$item->Ta_Price.'_*_'.$item->Item_Name;
                }


                $comboToppping = self::actionConvertComboTopping(@$items->data->list_topping_combo,$allItem);
                foreach($items->data->list_item as $keyCBTp => $itemCBtopping){
                    if(isset($comboToppping[$itemCBtopping->Item_Id])){
                        unset($items->data->list_item[$keyCBTp]);
                    }
                }
                $items->data->list_item = array_merge($items->data->list_item,$comboToppping);
                /*echo '<pre>';
//                var_dump($comboToppping);
                var_dump($items->data->list_item);
                echo '</pre>';
                die();*/


                $tmpEawt = 0;

                foreach($items->data->list_item as $key => $item){
                    if(!$item->Is_Eat_With){
                        $mainItemMap[$item->Item_Id] = $tmpEawt.'_*_'.$item->Item_Name.'_*_'.$item->Id.'_*_'.$item->Ta_Price.'_*_'.$item->Ta_Price;
                        $tmpEawt++;
                    }
                }



                \Yii::$app->session->set('items_map',$allItemMap);
                \Yii::$app->session->set('items_eatwith_map',$allIEathwithtemMap);
                \Yii::$app->session->set('main_items_map',$mainItemMap);
                \Yii::$app->session->set('all_items',$allItem);

                //Yii::info($items);
                if((array)$ids){
                    return $this->render('creatorder_short', [
                        'model' => $model,
                        'allPosMap' => $allPosMap,
                        'allPosToCheckDistanceMap' => $allPosToCheckDistanceMap,
                        'userPhoneData' => $userPhoneData,
                        'listItems' => @array_values($items->data->list_item),
                        'phoneNumber' => $phoneNumber,
                        'isBooking' => $isBooking,
                        'posMapOrder' => $posMapOrder,
                        'itemTypeMap' => $itemTypeMap,


                    ]);
                }else{
                        return $this->render('../site/null_pos', [
                            'model' => $model,
                        ]);
                }

            }else{
                return $this->render('creatorder', [
                    'model' => $model,
                    'modelMember' => $modelMember,
                    'allPosMap' => $allPosMap,
                    'allPosToCheckDistanceMap' => $allPosToCheckDistanceMap,
                    'userPhoneData' => $userPhoneData,

//                'searchModel' => $searchOrderModel,
//                'dataProvider' => $dataProvider,
                    'phoneNumber' => $phoneNumber,

                    'wait_confirm' => $wait_confirm,
                    'assigning' => $assigning,
                    'accepted' => $accepted,
                    'comfirmed' => $comfirmed,
                    'in_process' => $in_process,
                    'cancelled' => $cancelled,
                    'failed' => $failed,
                    'complete' => $complete,
                    'total' => $total,
                    //'order' => $order,

                ]);
            }

        }
    }


    public static  function actionConvertCombo($comboArr,$isnomal = 0)
    {

        $items = array();
        foreach($comboArr as $item){
            $date_from_user = date('Y-m-d H:i:s');
            if(isset($item->start_date)){
                $checkdateRanger = self::check_in_range($item->start_date, $item->end_date, $date_from_user);
            }else{
                $checkdateRanger = true;
            }
            if(isset($item->start_date)){
                $checkTimeRanger = self::check_hour_range($item->start_hour, $item->end_hour, date('H'));
            }else{
                $checkTimeRanger = true;
            }

            $checkDateInWeek = self::check_date_in_week($item->date_time_week);

            if($checkdateRanger == true && $checkTimeRanger == true && $checkDateInWeek== true){

                $object = new \stdClass();
                $object->Id = $item->combo_id;
                $object->Item_Id = 'CB'.@$item->combo_item_id;
                $object->Combo_Item_Id = @$item->combo_item_id;


                if($item->combo_name){
                    $object->Item_Name = $item->combo_name;
                }else{
                    $object->Item_Name = $item->combo_id;
                }



                $object->Item_Image_Path_Thumb = 'https://image.foodbook.vn/images/items/combo_defaut.png';
                $object->Ta_Price = 0;
                $object->Discount_Ta_Price = 0;
                $object->Is_Eat_With = 0;
                $object->Item_Id_Eat_With = null;
                if($isnomal){
                    $object->Item_Type_Id = 'CBTHUONG';
                }else{
                    $object->Item_Type_Id = 'CBEXTRA';
                }

                $object->Description = $item->combo_name;
                $object->Is_Nomal_Combo = $isnomal;
                $object->combo_details = json_encode(@$item->combo_details,true);


                if(isset($item->combo_details)){ //Nếu có món combo chi tiết thì mới add vào món combo
                    $items['CBET'.$item->combo_id] = $object;
                }


            }
        }

        return $items;
    }
    public static  function actionConvertComboTopping($comboArr,$allItems)
    {
        $items = array();

        foreach((array)$comboArr as $item){
            $object = new \stdClass();
            $object->Id = $item->id;
            $object->Item_Id = @$item->item_id;
            $object->Combo_Item_Id = @$item->item_id;
            $object->Item_Name = @$allItems[$item->item_id]->Item_Name;
            $object->Item_Image_Path_Thumb = 'https://image.foodbook.vn/images/items/combo_defaut.png';
            $object->Ta_Price = $item->ta_price;
            $object->Discount_Ta_Price = $item->ta_discount;
            $object->Is_Eat_With = 1;
            $object->Item_Id_Eat_With = null;
            $object->Item_Type_Id = 'COMBO';
            $object->Description = $item->item_id;
            $object->quantity = $item->quantity;
            $object->combo_details = json_encode(@$item->combo_item_id_list);
            if(isset($item->combo_item_id_list)){ //Nếu có món combo chi tiết thì mới add vào món combo
                $items[$item->item_id] = $object;
            }
        }


        return $items;
    }



    function check_in_range($start_date, $end_date, $date_from_user)
    {
        // Convert to timestamp
        $start_ts = strtotime($start_date);
        $end_ts = strtotime($end_date);
        $user_ts = strtotime($date_from_user);

        // Check that user date is between start & end
        return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
    }
    function check_hour_range($start_hour, $end_hour, $hour_from_user)
    {

        // Check that user date is between start & end
        return (($hour_from_user >= $start_hour) && ($hour_from_user <= $end_hour));
    }

    function check_date_in_week($date_in_week) {

        $dateInWeek = date('w');

        if($date_in_week == 1){
            $dateArray = [0];
        }else{
            $dateArray = DmpositemController::DecToBin($date_in_week,7);
        }

        if((array)$dateArray){
            return in_array($dateInWeek,$dateArray);
        }else{
            return false;
        }

    }

    function actionCheckship(){
        $post = Yii::$app->request->post();

        $apiPath = Yii::$app->params['CMS_API_PATH_SHORT'];
        $access_token = Yii::$app->params['ACCESS_TOKEN'];
        $name = 'partner/caculate_ship_fee';
        $headers = array();
        $headers[] = 'access_token: '.$access_token;

        $result = self::getApiByMethod($name,$apiPath,$post,$headers,'POST');
        /*echo '<pre>';
        var_dump($result);
        var_dump($post);
        echo '</pre>';*/

        if(isset($result->data)){
            if($result->data->fee > 0){
                return $result->data->fee;
            }else{
                return 0;
            }
        }else{
            return false;
        }
    }

    public function actionCallApiByPost($param,$apiPath,$type,$access_token){
        $vars = http_build_query($param);
        $url = $apiPath.$type;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$vars);  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = array();
        $headers[] = 'access_token: '.$access_token;


        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $server_output = curl_exec ($ch);

        curl_close ($ch);

        return json_decode($server_output);
    }


    public function actionOrdercancel()
    {
        $searchModel = new OrderonlinelogSearch();
        $dataProvider = $searchModel->searchCancel(Yii::$app->request->queryParams);

        return $this->render('ordercancel', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionAllorder()
    {
        $searchModel = new OrderonlinelogSearch();
        $dataProvider = $searchModel->searchAllorder(Yii::$app->request->queryParams);

        $searchPosModel = new DmposSearch();
        $allPos = $searchPosModel->searchAllPos();
        $allPosMap= ArrayHelper::map($allPos,'ID','POS_NAME');

        if(!isset(Yii::$app->request->queryParams['SaleposmobileSearch']['dateTime'])){
            $timeRanger = date('m/d/Y').' - '.date('m/d/Y');
        }else{
            $timeRanger = Yii::$app->request->queryParams['SaleposmobileSearch']['dateTime'];
        }

        return $this->render('allorder', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'allPosMap' => $allPosMap,
            'timeRanger' => $timeRanger,
        ]);
    }

    public function actionWaitorder()
    {
        $searchModel = new OrderonlinelogSearch();
        $dataProviderOrder = $searchModel->searchWaitorder(Yii::$app->request->queryParams);
        $dataProviderOrder->setPagination(false);
        $dataProviderOrder->setSort(false);
        $arrayOrder = $dataProviderOrder->getModels();

        $searchBookingModel = new BookingonlinelogSearch();
        $dataProviderBooking = $searchBookingModel->searchWait(Yii::$app->request->queryParams);
        $dataProviderBooking->setPagination(false);
        $dataProviderBooking->setSort(false);
        $arrayBooking = $dataProviderBooking->getModels();

        $order = array();
        $posIds = array();
        $member = array();
        foreach($arrayOrder as $record){
            $posIds[$record->pos_id] = $record->pos_id;
        }

        foreach($arrayBooking as $record){
            $posIds[$record->Pos_Id] = $record->Pos_Id;
            $member[$record->User_Id] = $record->User_Id;
        }


        $searchPosModel = new DmposSearch();
        $allPos = $searchPosModel->searchAllPosById($posIds);
        $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');
        $allPosPhoneMap = ArrayHelper::map($allPos,'ID','PHONE_NUMBER');

        $searchMemberModel = new DmmembershipSearch();
        $allMember = $searchMemberModel->searchMemberById($member);
        $allMemberMap = ArrayHelper::map($allMember,'ID','MEMBER_NAME');


        foreach($arrayOrder as $record){
//            echo '<pre>';
//            var_dump($record);
//            echo '</pre>';
//            die();
            $order[$record->foodbook_code]['foodbook_code'] = $record->foodbook_code;
            $order[$record->foodbook_code]['booking_info'] = self::getOrderinfo($record->booking_info);
            $order[$record->foodbook_code]['user_phone'] = self::getMemberinfo($record->user_phone,$record->username);
            $order[$record->foodbook_code]['pos_id'] = $allPosMap[$record->pos_id];
            $order[$record->foodbook_code]['pos_phone'] = $allPosPhoneMap[$record->pos_id];
            //$order[$record->foodbook_code]['created_at'] = self::getCountUpdateTime($record->updated_at,$record->created_at,$record->status);
            $order[$record->foodbook_code]['updated_at'] = self::getCountUpdateTime($record->updated_at,$record->created_at,$record->status,$record->foodbook_code);
        }

        $booking = array();
        foreach($arrayBooking as $record){
            if($record->Status == 'WAIT_CONFIRMED'){
                $booking[$record->Foodbook_Code]['foodbook_code'] = $record->Foodbook_Code;
                $booking[$record->Foodbook_Code]['booking_info'] = self::getBookinginfo($record->Book_Date,$record->Hour,$record->Minute,$record->Number_People);
                $booking[$record->Foodbook_Code]['user_phone'] = self::getMemberinfo($record->User_Id,@$allMemberMap[$record->User_Id]);
                $booking[$record->Foodbook_Code]['pos_id'] = $allPosMap[$record->Pos_Id];
                $booking[$record->Foodbook_Code]['pos_phone'] = $allPosPhoneMap[$record->Pos_Id];
                $booking[$record->Foodbook_Code]['created_at'] = $record->Created_At;
                $booking[$record->Foodbook_Code]['updated_at'] = self::getCountUpdateTime($record->Updated_At,$record->Created_At,$record->Status,$record->Foodbook_Code);
            }
        }


        $dataProvider = new ArrayDataProvider([
            'allModels' => array_merge($booking, $order),
            'sort' => [
                'attributes' => ['foodbook_code', 'booking_info','user_phone','pos_id', 'updated_at','created_at','pos_phone'],
                'defaultOrder' => [
                    'updated_at' => SORT_DESC,
                    //'title' => SORT_ASC,
                ]
            ],

            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $searchPosModel = new DmposSearch();
        $allPos = $searchPosModel->searchAllPos();
        $allPosMap= ArrayHelper::map($allPos,'ID','POS_NAME');

        return $this->render('_form_waitorder', [
//            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'allPosMap' => $allPosMap,
        ]);
    }

    public function getOrderinfo($booking_info)
    {
        if($booking_info){
            $hour = $booking_info['Hour'];
            $minute = $booking_info['Minute'];

            if($hour < 10){
                $hour = '0'.$booking_info['Hour'];
            }
            if($minute < 10){
                $minute = '0'.$booking_info['Minute'];
            }

            return 'Giao sau' .'<br> '.$hour.':'.$minute.':00'.' '. date(Yii::$app->params['DATE_FORMAT'], $booking_info['Book_Date']->sec);
        }else{
            return 'Giao ngay';
        }
    }
    public function getBookinginfo($Book_Date,$hour,$minute,$number_People)
    {
//        echo '<pre>';
//        var_dump($booking_info);
//        echo '</pre>';
//        die();

            if($hour < 10){
                $hour = '0'.$hour;
            }
            if($minute < 10){
                $minute = '0'.$minute;
            }

            return 'Đặt bàn' .'<br> '.$hour.':'.$minute.':00'.' '. date(Yii::$app->params['DATE_FORMAT'], $Book_Date->sec);
        }

    public function getMemberinfo($user_id,$username = null){
        return $user_id.'<br>'.$username;
    }

    public function getCountUpdateTime($updated_at,$created_at,$status,$foodbookCode){

        $timecounted =  Orderonlinelog::getChangeUpdateTimeWaitOrder($updated_at,$created_at,$status,$foodbookCode);
        return $timecounted;
    }


    public function actionAllorderpos($checkAjax = null,$control = 'allorderpos')
    {
//        echo '<pre>';
//        var_dump($control);
//        echo '</pre>';
//        die();
        if(!isset(Yii::$app->request->queryParams['OrderonlinelogSearch']['created_at'])){
            //$timeRanger = date('m/d/Y').' - '.date('m/d/Y');
            $timeRanger = date('d/m/Y',strtotime("-1 week")).' - '.date('d/m/Y');
        }else{
            $timeRanger = Yii::$app->request->queryParams['OrderonlinelogSearch']['created_at'];
        }

        $searcDmposhModel = new DmposSearch();
        $ids = $searcDmposhModel->getIds();

        $allPos = $searcDmposhModel->searchAllPosById($ids);
        $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');

        $searchModel = new OrderonlinelogSearch();
        $dataProvider = $searchModel->searchAllorderbypos(Yii::$app->request->queryParams,$ids,$timeRanger);
//        $dataProvider->setPagination(false);
        $dataProvider->setSort(false);

        // Chỗ này phải gọi vào database 2 lần
        $dataReport = $searchModel->searchAllorderbypos(Yii::$app->request->queryParams,$ids,$timeRanger);
        //$dataReport = $dataProvider;
        $dataReport->setPagination(false);
        $order = $dataReport->getModels();


        if(isset($order)){
            foreach($order as $key => $value){
                $order[$key]['_id'] = $value['_id']-> __Tostring();
            }
            $orderMap = ArrayHelper::map($order,'_id','user_id','status');

            foreach($orderMap as $key => $value){
                switch ($key) {
                    case 'COMPLETED':
                        $complete = $value;
                        break;
                    case 'CANCELLED':
                        $cancelled = $value;
                        break;
                    case 'FAILED':
                        $failed = $value;
                        break;
                    case 'WAIT_CONFIRM':
                        $wait_confirm = $value;
                        break;
                    case 'ASSIGNING':
                        $assigning = $value;
                        break;
                    case 'ACCEPTED':
                        $accepted = $value;
                        break;
                    case 'CONFIRMED':
                        $comfirmed = $value;
                        break;
                    case 'IN PROCESS':
                        $in_process = $value;
                        break;

                    default:
                        # code...
                        break;
                }
            }
        }

        return $this->render($control,[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'allPosMap' => $allPosMap,
            'timeRanger' => $timeRanger,

            'wait_confirm' => @$wait_confirm,
            'assigning' => @$assigning,
            'accepted' => @$accepted,
            'comfirmed' => @$comfirmed,
            'in_process' => @$in_process,
            'cancelled' => @$cancelled,
            'failed' => @$failed,
            'complete' => @$complete
        ]);

    }

    /**
     * Displays a single Orderonlinelog model.
     * @param integer $_id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        date_default_timezone_set('Asia/Bangkok');

        // Tính Amount
        $sale = 0;

        foreach((array)$model->order_data_item as $item){
            if($item['mDiscount']){
                $sale = ($item['Price']*$item['Quantity']*(1 - $item['mDiscount'])) + $sale;
            }else{
                $sale = ($item['Price']*$item['Quantity']) + $sale;
            }
        }
        $model->amount = $sale;
        $discount = 0;
        if(@$model->discount_extra){
            $discount = $model->discount_extra*$sale;
        }

        if(@$model->discount_extra_amount){
            $discount = $model->discount_extra_amount;
        }

        $total = $sale - $discount;
        $total = $total + @$model->service_charge*$total;
        $total = $total + $total*$model->vat_tax_rate;
        $model->total_amount = $total + $model->ship_price_real;


            /*var sumTotal = Number(totalValue - discountBill);
            sumTotal = Number(sumTotal + sumTotal*charge/100);
            sumTotal = Number(sumTotal + sumTotal*vat/100);*/

        //End tính Amount


        $listItem = NULL;
        foreach((array)$model->order_data_item as $item){
            if(isset($item['Item_Name'])){

                $note = '';
                if($item['Note']){
                    $note = '-'.$item['Note'].'';
                }
                $listItem = $listItem.$item['Item_Name'].'('.$item['Quantity'].')'.$note.'<br/>';
            }
        }

        $model->order_data_item = $listItem;

        if(@$hour = $model->booking_info['hour']){
            $hour = $model->booking_info['hour'];
            $minute = $model->booking_info['minute'];

            $time = date(Yii::$app->params['DATE_FORMAT'], $model->booking_info['book_date']->sec).' '. $hour.':'.$minute;

            $model->booking_info =  'Giao sau lúc ' .date(Yii::$app->params['DATE_TIME_FORMAT'], strtotime($time));
        }else{
            $model->booking_info = "Giao ngay";
        }



        if(isset($model->created_at)){
            $model->created_at = date(Yii::$app->params['DATE_TIME_FORMAT_2'],$model->created_at->sec);
        }
        if(isset($model->updated_at)){
            $model->updated_at = date(Yii::$app->params['DATE_TIME_FORMAT_2'],$model->updated_at->sec);
        }
        if(isset($model->time_assigning)){
            $model->time_assigning = date(Yii::$app->params['DATE_TIME_FORMAT_2'],$model->time_assigning->sec);
        }
        if(isset($model->time_accepted)){
            $model->time_accepted = date(Yii::$app->params['DATE_TIME_FORMAT_2'],$model->time_accepted->sec);
        }
        if(isset($model->time_confirmed)){
            $model->time_confirmed = date(Yii::$app->params['DATE_TIME_FORMAT_2'],$model->time_confirmed->sec);
        }
        if(isset($model->time_inprocess)){
            $model->time_inprocess = date(Yii::$app->params['DATE_TIME_FORMAT_2'],$model->time_inprocess->sec);
        }
        if(isset($model->time_cancelled)){
            $model->time_cancelled = date(Yii::$app->params['DATE_TIME_FORMAT_2'],$model->time_cancelled->sec);
        }
        if(isset($model->time_failed)){
            $model->time_failed = date(Yii::$app->params['DATE_TIME_FORMAT_2'],$model->time_failed->sec);
        }
        if(isset($model->time_completed)){
            $model->time_completed = date(Yii::$app->params['DATE_TIME_FORMAT_2'],$model->time_completed->sec);
        }
        if($model->ship_price_real < 0){
            $model->ship_price_real = 'Nhà hàng liên hệ';
        }else{
            $model->ship_price_real = number_format($model->ship_price_real);
        }

        /*echo '<pre>';
        var_dump($model);
        echo '</pre>';
        die();*/

        if(isset($model->delivery_partner_info)){

            $model->ahamove_code = $model->delivery_partner_info['partner_code'];
            $model->shared_link = $model->delivery_partner_info['partner_link'];
            $model->supplier_id = $model->delivery_partner_info['driver_id'];
            $model->supplier_name = $model->delivery_partner_info['driver_name'];
            $model->ship_price_real = number_format($model->delivery_partner_info['ship_fee'],2);
            $model->distance = number_format($model->delivery_partner_info['distance'],2);
        }



//        echo '<pre>';
//        var_dump($listItem);
//        echo '</pre>';
//        die();


        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Orderonlinelog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Orderonlinelog();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => (string)$model->_id]);
        } else {
            $post = Yii::$app->request->post();
            $phoneNumber = null;
            $nameMember = null;
            if(isset($post['textPhone'])){
                $phoneNumber = $post['textPhone'];
                $fisrtChar = substr($phoneNumber,0,2); // Lấy kí tự đầu của chuỗi
                if($fisrtChar === '84'){
                    $phone = substr($phoneNumber,2);
                    $phoneNumber = (int)'0'.$phone;
//                    var_dump($phoneNumber);
//                    die();
                }

            }
            if(isset($post['textName'])){
                $nameMember = $post['textName'];
            }

//            echo '<pre>';
//            var_dump($post);
//            echo '</pre>';
//            die();
            if(isset($post['lastorder'])){
                $lastOrder = json_decode($post['lastorder']);
            }


            $searcDmposhModel = new DmposSearch();

            $accType = \Yii::$app->session->get('type_acc');
            $posParent = \Yii::$app->session->get('pos_parent');

            if($accType == 1){
                $allPos = $searcDmposhModel->searchAllPos();
            }else{
                $posIdlist = \Yii::$app->session->get('pos_id_list');
                if($posIdlist !=''){
                    $allPos = $searcDmposhModel->searchAllPosByListId($posIdlist);
                }else{
                    $allPos = $searcDmposhModel->searchAllPosByPosParent($posParent);
                }
            }

            foreach($allPos as $key => $pos){
                $allPosToCheckDistance[$key]['POS_NAME'] = $pos['POS_NAME'].'._.'.$pos['POS_LONGITUDE'].'._.'.$pos['POS_LATITUDE'];
                $allPosToCheckDistance[$key]['ID'] = $pos['ID'];
            }

            $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');
            $allPosToCheckDistanceMap = ArrayHelper::map($allPosToCheckDistance,'ID','POS_NAME');

//            echo '<pre>';
//            var_dump($lastOrder);
//            echo '</pre>';
//            die();

            return $this->render('create', [
                'model' => $model,
                'phoneNumber' => $phoneNumber,
                'nameMember' => $nameMember,
                'allPosMap' => $allPosMap,
                'lastOrder' => @$lastOrder,
                'allPosToCheckDistanceMap' => $allPosToCheckDistanceMap
            ]);
        }
    }

    public function actionCreateshortorder()
    {
        $post = Yii::$app->request->post();
        $id = AjaxapiController::fixPhoneNumbTo84(@$post['textPhone']);

        $param= [
            'msisdn' => trim(@$post['textPhone']),
            'username' => @$post['textName']
        ];

        $apiPath = Yii::$app->params['CMS_API_PATH_SHORT'];
        $type = 'auth/partner_login';
        $access_token = Yii::$app->params['ACCESS_TOKEN'];

        $member = self::actionCallApiByPost($param,$apiPath,$type,$access_token);


        if(isset($member->data)){
            $headers = array();
            $headers[] = 'access_token: '.$access_token;
            $headers[] = 'token: '.$member->data->Token;
            $itemList = self::actionGetAllDataForMiniCC();

            // ./Get Item by User
            $orderItem = array();


            if(isset($post['products_selected'])){
                $tmp = 1;
                foreach($post['products_selected'] as $product){
                    $proArray = explode("|",$product); // phần tử 0 là id, 1 là số lượng, 2 là ghi chú, 4 là giảm giá, 5 là các món ăn kèm của món đó, 6 là các món ăn kèm đã chọn , 7 giá, 8 PaketId
                    foreach($itemList->data->list_item as $item){
                        if($item->Id == $proArray[0]){
                            $orderItem[$tmp]['Item_Type_Id'] = @$item->Item_Type_Id;
                            $orderItem[$tmp]['User_Id'] = $id;
                            $orderItem[$tmp]['Item_Name'] = $item->Item_Name;
                            $orderItem[$tmp]['Item_Id'] = $item->Item_Id;
                            $orderItem[$tmp]['Note'] = $proArray[2];
                            $orderItem[$tmp]['Discount'] = @$proArray[4]/100; //$item->Discount_Ta_Price;
                            $orderItem[$tmp]['Price'] = $item->Ta_Price;
                            $orderItem[$tmp]['Quantity'] = (int)$proArray[1];

                            if(isset($proArray[8])){
                                if($proArray[8] != 'null'){
                                    $orderItem[$tmp]['Package_Id'] = $proArray[8];
                                    $orderItem[$tmp]['Fix'] = 1;
                                }
                            }



                            if((int)@$proArray[4] > 0){
                                $orderItem[$tmp]['Foc'] = 1;
                            }

                            if(isset($proArray[6]) && $proArray[6] != 'undefined' && $proArray[6] != ''){

                                $arrEatWith = explode(",",$proArray[6]);
                                $tmpEatWith = 1;

                                foreach((array)$arrEatWith as $eawithLine){
                                    $comboEatwith = explode("_**_",$eawithLine);
                                    if(count($comboEatwith) >1){
                                        foreach($comboEatwith as $comboEw){
                                            $rand= mt_rand(1262055681,1262055681);
                                            foreach((array)$comboEw as $itemEatWith){
                                                $arrElementEatWith = explode("_*_",$itemEatWith);
                                                $orderItem[$tmp.$tmpEatWith]['User_Id'] = $id;
                                                $orderItem[$tmp.$tmpEatWith]['Item_Name'] = $arrElementEatWith[2];
                                                $orderItem[$tmp.$tmpEatWith]['Item_Id'] = $arrElementEatWith[0];
                                                $orderItem[$tmp.$tmpEatWith]['Discount'] = @$proArray[4]/100; //$item->Discount_Ta_Price;
                                                $orderItem[$tmp.$tmpEatWith]['Quantity'] = (int)@$arrElementEatWith[3]*(int)$proArray[1];
                                                $orderItem[$tmp.$tmpEatWith]['Price'] = $arrElementEatWith[1];
                                                $orderItem[$tmp.$tmpEatWith]['Package_Id'] = $rand;
                                                $orderItem[$tmp.$tmpEatWith]['Fix'] = 1;
                                                $orderItem[$tmp.$tmpEatWith]['Note'] = 'Combo ăn kèm của '.$item->Item_Name;

                                                if((int)@$proArray[4] > 0){
                                                    $orderItem[$tmp+1]['Foc'] = 1;
                                                }
                                                $tmpEatWith++;
                                            }
                                        }

                                    }else{
                                        foreach((array)$eawithLine as $itemEatWith){
                                            $arrElementEatWith = explode("_*_",$itemEatWith);
                                            if(!isset($arrElementEatWith[3])){
                                                $arrElementEatWith[3] = 1;
                                            }

                                            /*echo '<pre>';
                                            var_dump($arrElementEatWith);
                                            echo '</pre>';
                                            die();*/

                                            $orderItem[$tmp.$tmpEatWith]['User_Id'] = $id;
                                            $orderItem[$tmp.$tmpEatWith]['Item_Name'] = $arrElementEatWith[2];
                                            $orderItem[$tmp.$tmpEatWith]['Item_Id'] = $arrElementEatWith[0];
                                            $orderItem[$tmp.$tmpEatWith]['Discount'] = @$proArray[4]/100; //$item->Discount_Ta_Price;
                                            $orderItem[$tmp.$tmpEatWith]['Quantity'] = (int)@$arrElementEatWith[3]*(int)$proArray[1];
                                            $orderItem[$tmp.$tmpEatWith]['Price'] = $arrElementEatWith[1];

                                            if(isset($proArray[8])){
                                                if($proArray[8] != 'null'){
                                                    $orderItem[$tmp.$tmpEatWith]['Package_Id'] = $proArray[8];
                                                    $orderItem[$tmp.$tmpEatWith]['Fix'] = 1;
                                                }
                                            }else{
                                                $orderItem[$tmp.$tmpEatWith]['Note'] = 'món ăn kèm của '.$item->Item_Name;
                                            }



                                            if((int)@$proArray[4] > 0){
                                                $orderItem[$tmp+1]['Foc'] = 1;
                                            }
                                            $tmpEatWith++;
                                        }

                                    }

                                }



                            }
                        }
                    }
                    $tmp ++;
                }
            }




            if(@$post['bookingTimeLaterTxt'] != ''){
                $arrTimeInfo = explode(" ",$post['bookingTimeLaterTxt']);
                $time = explode(":",$arrTimeInfo[1]);

                $bookingInfo = [
                    'Book_Date' => date('Y-m-d 00:00:00',strtotime($arrTimeInfo[0])),
                    'Hour' => $time[0],
                    'Minute' => $time[1],
                    'Number_People' => -1,
                    'Note' => ''
                ];
                $jsonBookInfo = json_encode(@$bookingInfo);
            }

            if(@$post['bookingTimeTxt'] != ''){
                $arrTimeInfo = explode(" ",$post['bookingTimeTxt']);
                $time = explode(":",$arrTimeInfo[1]);

                $bookingInfo = [
                    'Number_People' => @(int)$post['Number_People'],
                    'Book_Date' => date('Y-m-d 00:00:00',strtotime($arrTimeInfo[0])),
                    'Hour' => $time[0],
                    'Minute' => $time[1],
                    'Note' => @$post['noteTxt']
                ];

                $jsonBookInfo = json_encode(@$bookingInfo);
            }

            $update_user_info = array();

            if(@$post['group_member'] != ''){
                $update_user_info = [
                    'User_Groups' => @$post['group_member'],
                ];
            }
            if(@$post['sex_member'] != ''){
                $update_user_info['Sex'] = @$post['sex_member'];
            }

            if(@$post['birthday_member'] != ''){
                $update_user_info['Birthday'] = date('Y-m-d 00:00:00',strtotime(@$post['birthday_member']));
            }


            if(array_count_values($update_user_info)){
                $json_update_member = json_encode($update_user_info);
            }



            if(isset($post['addressTxt'])){
                $ItemParam =  [
                    'pos_id' => $post['posSelect'],
                    'pos_parent' => @$post['pos_parent'],
                    'orders' => json_encode(array_values($orderItem)),
                    'address_id' => @$post['addressTxt'],
                    'payment_method' => 'PAYMENT_ON_DELIVERY',
                    'payment_info' => '',
                    'booking_info' => @$jsonBookInfo,
                    'full_address' => $post['addressTxt'],
                    'note' => $post['noteTxt'],
                    'ship_fee_manual' => $post['feeTxt'],
                    'update_user_info' => @$json_update_member,
                    'purpose_of_orders' => @$post['purpose'],
                    'province' => @$post['txtcity'],
                    'district' => @$post['txtstate'],
                    'manager_id' => \Yii::$app->session->get('user_id'),
                    'is_pending' => 0,
                    'partner_name' => @$post['created_by'],
                    'coupon_id' => strtoupper(@$post['coupon_log_id'])
                ];


                /*Nếu như là đơn hàng tạo lại từ đơn hàng hủy thì sẽ không có id_pending. không gửi FOODBOOK CODE tránh việc dublicate foodbook_code*/


                if(@$post['id_pending']){
                    /*echo '<pre>';
                    var_dump($post['id_pending']);
                    echo '</pre>';
                    die();*/
                    $ItemParam['foodbook_code'] = @$post['foodbook_code'];
                }

                if(@$post['txt-vat']){
                    $ItemParam['vat_tax_rate'] = @$post['txt-vat']/100;
                }
                if(@$post['txt-service_charge']){
                    $ItemParam['service_charge'] = @$post['txt-service_charge']/100;
                }

                if(@$post['Orderonlinelog']['DISCOUNT_BILL']){
                    if($post['Orderonlinelog']['DISCOUNT_BILL_TYPE']){
                        $ItemParam['discount_extra_amount'] = @$post['Orderonlinelog']['DISCOUNT_BILL'];

                    }else{
                        $ItemParam['discount_extra'] = @$post['Orderonlinelog']['DISCOUNT_BILL']/100;

                    }
                    $ItemParam['ato'] = 1;
                }



                $ItemParam['foodbook_code'] = @$post['foodbook_code'];

                /*echo '<pre>';
                var_dump($ItemParam);
                echo '</pre>';
                die();*/


                $nameAPI = 'partner/order_online';


            }else{
                $ItemParam =  [
                    'pos_id' => $post['posSelect'],
                    'orders' => json_encode(array_values($orderItem)),
                    'note' => $post['noteTxt'],
                    'booking_info' => @$jsonBookInfo,
                ];


                $nameAPI = 'partner/booking_online';
            }

            $result = self::getApiByMethod($nameAPI,$apiPath,$ItemParam,$headers,'POST');


            if(isset($result->data)){
                if(isset($post['addressTxt'])){
                    if(isset($post['id_pending'])){
                        $pendingModel = Orderonlinelogpending::findOne($post['id_pending']);
                        if($pendingModel){
                            $pendingModel->is_pending = 0;
                            $pendingModel->save();
                        }
                    }
                    Yii::$app->getSession()->setFlash('success', 'Chúc mừng bạn đã tạo đơn hàng thành công!!');
                    return 200;
                }else{
                    Yii::$app->getSession()->setFlash('success', 'Chúc mừng bạn đặt bàn thành công!!');
                    return 200;
//                    return $this->redirect('index.php?r=orderonlinelog',200);
                }


            }else{

                if(isset($result->error->message)){

                    $errorMess = $result->error->message;
                }else{
                    $errorMess = 'Lỗi kết nối, vui lòng thử lại sau';
                }
                //Yii::$app->getSession()->setFlash('error', @$result->error->message);
                return $errorMess;
            }
        }else{
            if(isset($member->error->message)){
                $errorMess = $member->error->message;
            }else{
                $errorMess = 'Lỗi kết nối, vui lòng thử lại sau';
            }
            return $errorMess;

        }
    }
    public function preEatwith($eatwith){

    }

    public function actionPro()
    {
        $model = new Orderonlinelog();

        if ($model->load(Yii::$app->request->post())){

            $post = Yii::$app->request->post();
            //Get Accetoken user

            $id = null;
            $fisrtChar = substr($model->user_id,0,1); // Lấy kí tự đầu của chuỗi
            if($fisrtChar === '0'){
                $id = UsermanagerController::format_number($model->user_id);
            }

            $param= [
                'msisdn' => $id,
                'username' => $post['userName'],
            ];
            //$param= ['msisdn' => 84979358807];



            $apiPath = Yii::$app->params['CMS_API_PATH_SHORT'];
            $type = 'auth/partner_login';
            $access_token = Yii::$app->params['ACCESS_TOKEN'];

            $member = self::actionCallApiByPost($param,$apiPath,$type,$access_token);

            //. ./Get Accetoken user

            //Get Item by User
            $name = 'item/item_order_pos';

            $paramItem = array(
                'id' => $model->pos_id,
            );

            $headers = array();
            $headers[] = 'access_token: '.$access_token;
            $headers[] = 'token: '.$member->data->Token;
            $itemList = self::getApiByMethod($name,$apiPath,$paramItem,$headers,'GET');

            // ./Get Item by User
            $orderItem = null;

            if(isset($post['products_selected'])){
                $tmp = 1;
                foreach($post['products_selected'] as $product){

                    $proArray = explode("|",$product); // phần tử 0 là id, 1 là số lượng, 2 là ghi chú, 4 là giảm giá

                    foreach($itemList->data as $item){
//                        echo '<pre>';
//                        var_dump($product);
//                        echo '</pre>';
//                        die();
                        if($item->Id == $proArray[0]){
                            $orderItem[$tmp]['Item_Type_Id'] = @$item->Item_Type_Id;
                            $orderItem[$tmp]['User_Id'] = $model->user_id;
                            $orderItem[$tmp]['Item_Name'] = $item->Item_Name;
                            $orderItem[$tmp]['Item_Id'] = $item->Item_Id;
                            $orderItem[$tmp]['Note'] = $proArray[2];
                            $orderItem[$tmp]['Discount'] = @$proArray[4]/100; //$item->Discount_Ta_Price;
                            $orderItem[$tmp]['Price'] = $item->Ta_Price;
                            $orderItem[$tmp]['Quantity'] = (int)$proArray[1];
                            if((int)@$proArray[4] > 0){
                                $orderItem[$tmp]['Foc'] = 1;
                            }
                        }
                    }
                    $tmp ++;
                }
            }

//            echo '<pre>';
//            var_dump($orderItem);
//            echo '</pre>';
//            die();


            $ItemParam =  [
                'pos_id' => $model->pos_id,
                'orders' => json_encode(array_values($orderItem)),
                'address_id' => $model->address_id,
                'payment_method' => $model->paymentInfo,
                'full_address' => $model->to_address,
                'longitude' => $post['newLongAdress'],
                'latitude' => $post['newLatAdress'],
                'campaign_id' => NULL,
                'coupon_id' => null,
                'booking_info' => null,
                //'note' => 'Đơn hàng từ CALL CENTER CMS'
            ];

            $nameAPI = 'member/v2/order_online';

            $result = self::getApiByMethod($nameAPI,$apiPath,$ItemParam,$headers,'POST');
            if(isset($result->data)){
                Yii::$app->getSession()->setFlash('success', 'Chúc mừng bạn đã tạo đơn hàng thành công!!');
                return $this->redirect('index.php?r=orderonlinelog',302);
            }else if($result->error) {
                Yii::$app->getSession()->setFlash('error', $result->error->message);
                return $this->redirect('index.php?r=orderonlinelog',302);
            }
        }

    }

    public function getApiByMethod($name,$apiPath,$param,$headers,$method = 'GET'){
        // Set body parameter

        $api_request_url = $apiPath.$name;



        /*
  Set the Request Url (without Parameters) here
*/
        /*
          Which Request Method do I want to use ?
          DELETE, GET, POST or PUT
        */
        $method_name = $method;


        /*
          Let's set all Request Parameters (api_key, token, user_id, etc)
        */
        $api_request_parameters = $param;



        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        if ($method_name == 'DELETE')
        {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($api_request_parameters));
        }

        if ($method_name == 'GET')
        {
            $api_request_url .= '?' . http_build_query($api_request_parameters);

        }

        if ($method_name == 'POST')
        {
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($api_request_parameters));
        }

        if ($method_name == 'PUT')
        {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($api_request_parameters));
        }

        /*
          Here you can set the Response Content Type you prefer to get :
          application/json, application/xml, text/html, text/plain, etc
        */

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        /*echo '<pre>';
    var_dump($header);
    //var_dump($api_request_url);
    echo '</pre>';
    die();*/




        /*
          Let's give the Request Url to Curl
        */
        curl_setopt($ch, CURLOPT_URL, $api_request_url);

        /*
          Yes we want to get the Response Header
          (it will be mixed with the response body but we'll separate that after)
        */
        //curl_setopt($ch, CURLOPT_HEADER, TRUE);

        /*
          Allows Curl to connect to an API server through HTTPS
        */
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        /*
          Let's get the Response !
        */
        $api_response = curl_exec($ch);

        Yii::info($api_response);



        /*
          We need to get Curl infos for the header_size and the http_code
        */
        //$api_response_info = curl_getinfo($ch);

        /*
          Don't forget to close Curl
        */
        curl_close($ch);



        return json_decode($api_response);
    }

    public function actionChangeStatusAhamove($fb_code,$status = 'CANCELLED',$service_type = 'order_online_update_status'){
        // Set body parameter
        $vars = http_build_query(array(
                'foodbook_code' => $fb_code,
                'status' => $status,
            )
        );

        $apiPath = Yii::$app->params['CMS_API_PATH'];
        $url = $apiPath.$service_type;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$vars);  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = array();
        $headers[] = 'access_token: D0FBGS3NKZUUFZCIURBDKPR9N5RRML7K';

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $server_output = curl_exec ($ch);
        curl_close ($ch);

        return $server_output;
    }


    public function actionToahamove($id)
    {
        $model = $this->findModel($id);
        $result = self::actionChangeStatusAhamove($model->foodbook_code,$status = 'ASSIGNING','order_online_ahamove_ship'); // Ném đơn hàng sang AHAMOVE -


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => (string)$model->_id]);
        } else {
            return $this->redirect('index.php?r=orderonlinelog',302);
        }
    }


    public function actionChangestatus($id,$statusUpdate = NULL)
    {
        $model = $this->findModel($id);
        $result = self::actionChangeStatusAhamove($model->foodbook_code,$status = $statusUpdate,'order_online_update_status'); // Ném đơn hàng sang AHAMOVE -

        if (isset($result->data)){
            return $this->redirect(['view', 'id' => (string)$model->_id]);
        } else {
            return $this->redirect('index.php?r=orderonlinelog',302);
        }
    }

    public function actionCancel($id)
    {
        $model = $this->findModel($id);
        OrderonlinelogController::actionChangeStatusAhamove($model->foodbook_code,$status = 'CANCELLED','order_online_update_status'); // Hủy đơn hàng

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => (string)$model->_id]);
        } else {
            return $this->redirect('index.php?r=orderonlinelog',302);
        }
    }


    /**
     * Updates an existing Orderonlinelog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionUpdate($id,$statusUpdate = NULL)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();

            $id = null;
            $fisrtChar = substr($model->user_id,0,1); // Lấy kí tự đầu của chuỗi

            if($fisrtChar === '0'){
                $id = UsermanagerController::format_number($model->user_id);
            }else{
                $id = $model->user_id;
            }

            $param= ['msisdn' => (int)$id];
            //$param= ['msisdn' => 84982680996];

            $apiPath = Yii::$app->params['CMS_API_PATH_SHORT'];
            $type = 'auth/partner_login';
            $access_token = Yii::$app->params['ACCESS_TOKEN'];

            $member = self::actionCallApiByPost($param,$apiPath,$type,$access_token);
            //. ./Get Accetoken user

            //Get Item by User
            $name = 'item/item_order_pos';

            $paramItem = array(
                'id' => $model->pos_id,
            );

            $headers = array();
            $headers[] = 'access_token: '.$access_token;
            $headers[] = 'token: '.$member->data->Token;
            $itemList = self::getApiByMethod($name,$apiPath,$paramItem,$headers,'GET');

            // ./Get Item by User
            $orderItem = null;
            $post = Yii::$app->request->post();
            if(isset($post['products_selected'])){
                $tmp = 1;
                foreach($post['products_selected'] as $product){

                    $proArray = explode("|",$product); // phần tử 0 là id, 1 là số lượng, 2 là ghi chú , 3 là index
                    foreach($itemList->data as $item){
                        if($item->Item_Id == $proArray[0]){
//                            echo '<pre>';
//                            var_dump($item);
//                            echo '</pre>';
//                            die();
                            $orderItem[$tmp]['Item_Type_Id'] = @$item->Item_Type_Id;
                            $orderItem[$tmp]['User_Id'] = $model->user_id;
                            $orderItem[$tmp]['Item_Name'] = $item->Item_Name;
                            $orderItem[$tmp]['Item_Id'] = $item->Item_Id;
                            $orderItem[$tmp]['Note'] = $proArray[2];
                            $orderItem[$tmp]['Discount'] = $item->Discount_Ta_Price;
                            $orderItem[$tmp]['Price'] = $item->Ta_Price;
                            $orderItem[$tmp]['Quantity'] = (int)$proArray[1];
                        }
                    }
                    $tmp ++;
                }
            }
//            echo '<pre>';
//            var_dump($orderItem);
//            echo '</pre>';
//            die();


            $ItemParam =  [
                'pos_id' => $model->pos_id,
                'orders' => json_encode(array_values($orderItem)),
                'address_id' => $model->address_id,
                'payment_method' => $model->paymentInfo,
                'full_address' => $model->to_address,
                'longitude' => $post['newLongAdress'],
                'latitude' => $post['newLatAdress'],
                'campaign_id' => NULL,
                'coupon_id' => null,
                'booking_info' => null,
            ];

            $nameAPI = 'member/v2/order_online';

            $result = self::getApiByMethod($nameAPI,$apiPath,$ItemParam,$headers,'POST');


            if(isset($result->data)){
                Yii::$app->getSession()->setFlash('success', 'Chúc mừng bạn cập nhật đơn hàng thành công!!');
                return $this->redirect('index.php?r=orderonlinelog',302);
            }else if($result->error) {
                Yii::$app->getSession()->setFlash('error', $result->error->message);
                return $this->redirect('index.php?r=orderonlinelog',302);
            }

        } else {

            $searchPos = new DmposSearch();
            $pos = $searchPos->searchById($model->pos_id);

            $key = 'items'.$model->pos_id;
            $items = \Yii::$app->cache->get($key);

            if ($items === false) {
                $items_json = self::getAPI('item_order_pos',$model->pos_id,$model->user_id);
                $items = json_decode($items_json);

                $items = get_object_vars($items); // Convert StdClass to Array.
                \Yii::$app->cache->set($key, $items, 43200); // time in seconds to store cache
            }

            $itemsMap = ArrayHelper::map($items['data'],'Item_Id','Item_Name');
//            echo '<pre>';
//            var_dump($itemsMap);
//            echo '</pre>';
//            die();



            // Convert sdt ve chuan +84
            $fisrtChar = substr($model->user_id,0,1); // Lấy kí tự đầu của chuỗi
            if($fisrtChar === '0'){
                $model->user_id = UsermanagerController::format_number($model->user_id);
            }

            $param= ['msisdn' => (int)$model->user_id];  //'msisdn' => (int)$model->user_id,
            //$param= ['msisdn' => 84982680996];  //'msisdn' => (int)$model->user_id,
            $apiPath = Yii::$app->params['CMS_API_PATH_SHORT'];
            $type = 'auth/partner_login';
            $access_token = Yii::$app->params['ACCESS_TOKEN'];

            $member = self::actionCallApiByPost($param,$apiPath,$type,$access_token);
            //. ./Get Accetoken user

            //Get Item by User
            $name = 'item/item_order_pos';

            $paramItem = array(
                'id' => $model->pos_id,
            );

            $headers = array();
            $headers[] = 'access_token: '.$access_token;
            $headers[] = 'token: '.$member->data->Token;
            $itemList = self::getApiByMethod($name,$apiPath,$paramItem,$headers,'GET');

            $allPos = $searchPos->searchAllPos();
            foreach($allPos as $key => $pos){
                $allPosToCheckDistance[$key]['POS_NAME'] = $pos['POS_NAME'].'-'.$pos['POS_LONGITUDE'].'-'.$pos['POS_LATITUDE'];
                $allPosToCheckDistance[$key]['ID'] = $pos['ID'];
            }

            $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');
            $allPosToCheckDistanceMap = ArrayHelper::map($allPosToCheckDistance,'ID','POS_NAME');
            return $this->render('update', [
                'allPosMap' => $allPosMap,
                'allPosToCheckDistanceMap' => $allPosToCheckDistanceMap,
                'model' => $model,
                'pos' => $pos,
                'itemsMap' => $itemsMap,
                'itemList' => $itemList,
            ]);
        }
    }


    public function actionUpdateshortcart($id)
    {
        $model = new Orderonlinelog();
        if ($model->load(Yii::$app->request->post())){
            $post = Yii::$app->request->post();

            $id = null;
            $fisrtChar = substr($model->user_id,0,1); // Lấy kí tự đầu của chuỗi

            if($fisrtChar === '0'){
                $id = UsermanagerController::format_number($model->user_id);
            }else{
                $id = $model->user_id;
            }

            $param= ['msisdn' => (int)$id];
            //$param= ['msisdn' => 84982680996];

            $apiPath = Yii::$app->params['CMS_API_PATH_SHORT'];
            $type = 'auth/partner_login';
            $access_token = Yii::$app->params['ACCESS_TOKEN'];

            $member = self::actionCallApiByPost($param,$apiPath,$type,$access_token);
//            . ./Get Accetoken user

//            Get Item by User
            $name = 'item/item_order_pos';

            $paramItem = array(
                'id' => $model->pos_id,
            );

            $headers = array();
            $headers[] = 'access_token: '.$access_token;
            $headers[] = 'token: '.$member->data->Token;
            $itemList = self::getApiByMethod($name,$apiPath,$paramItem,$headers,'GET');

            // ./Get Item by User
            $orderItem = null;
            $post = Yii::$app->request->post();
            if(isset($post['products_selected'])){
                $tmp = 1;
                foreach($post['products_selected'] as $product){
                    $proArray = explode("|",$product); // phần tử 0 là id, 1 là số lượng, 2 là ghi chú , 3 là index
                    foreach($itemList->data as $item){
                        if($item->Item_Id == $proArray[0]){
                            $orderItem[$tmp]['Item_Type_Id'] = $item->Item_Type_Id;
                            $orderItem[$tmp]['User_Id'] = $model->user_id;
                            $orderItem[$tmp]['Item_Name'] = $item->Item_Name;
                            $orderItem[$tmp]['Item_Id'] = $item->Item_Id;
                            $orderItem[$tmp]['Note'] = $proArray[2];
                            $orderItem[$tmp]['Discount'] = $item->Discount_Ta_Price;
                            $orderItem[$tmp]['Price'] = $item->Ta_Price;
                            $orderItem[$tmp]['Quantity'] = (int)$proArray[1];
                        }
                    }
                    $tmp ++;
                }
            }
//            echo '<pre>';
//            echo 'order Item';
//            var_dump($orderItem);
//            echo '</pre>';
//            die();


            $ItemParam =  [
                'pos_id' => $model->pos_id,
                'orders' => json_encode(array_values($orderItem)),
                'address_id' => $model->address_id,
                'payment_method' => $model->paymentInfo,
                'full_address' => $model->to_address,
                'longitude' => $post['newLongAdress'],
                'latitude' => $post['newLatAdress'],
                'campaign_id' => NULL,
                'coupon_id' => null,
                'booking_info' => null,
            ];

            $nameAPI = 'member/v2/order_online';

            $result = self::getApiByMethod($nameAPI,$apiPath,$ItemParam,$headers,'POST');


            if(isset($result->data)){
                Yii::$app->getSession()->setFlash('success', 'Chúc mừng bạn cập nhật đơn hàng thành công!!');
                return $this->redirect('index.php?r=orderonlinelog',302);
            }else if($result->error) {
                Yii::$app->getSession()->setFlash('error', $result->error->message);
                return $this->redirect('index.php?r=orderonlinelog',302);
            }

        } else {

            $draftOrder = Yii::$app->getRequest()->getCookies()->getValue('pendingOrder', (isset($_COOKIE['pendingOrder']))? $_COOKIE['pendingOrder']: null);

            if($draftOrder != null){
                foreach(json_decode($draftOrder) as $order){
//                    $arrKeyData = explode("_",$order->keyData);
//                    echo '<pre>';
//                    var_dump($arrKeyData);
//                    var_dump($id);
//                    echo '</pre>';
//                    die();
                    if($order->keyData == $id){
                        $arayInfo = explode('&',$order->dataArray);
                        foreach((array)$arayInfo as $element){
                            $tmp = explode("=",$element);
                            if($tmp[0] == 'products_selected[]'){
                                $oder['products_selected'][] = $tmp[1];
                                $tmpItem = explode("|",$tmp[1]);
                                $order_data_item[$tmpItem[3]]['Item_Id']= $tmpItem[0];
                                $order_data_item[$tmpItem[3]]['Quantity']= $tmpItem[1];
                            }else{
                                $oder[$tmp[0]] = $tmp[1];
                            }
                        }
                    }
                }
            }
            $model->order_data_item = @$order_data_item;
//            echo '<pre>';
//            var_dump($order_data_item);
//            echo '</pre>';
//            die();



//            $model = $this->findModel($id);

            $searchPos = new DmposSearch();
            $pos = $searchPos->searchById(@$oder['posSelect']);

            $model->pos_id = $oder['posSelect'];
            $model->user_id = $oder['textPhone'];
            $model->to_address = $oder['addressTxt'];
            $model->username = $oder['textName'];

            $key = 'items'.$model->pos_id;
            $items = \Yii::$app->cache->get($key);

            if ($items === false) {
                $items_json = self::getAPI('item_order_pos',$model->pos_id,$model->user_id);
                $items = json_decode($items_json);

                $items = get_object_vars($items); // Convert StdClass to Array.
                \Yii::$app->cache->set($key, $items, 43200); // time in seconds to store cache
            }

            $itemsMap = ArrayHelper::map($items['data'],'Item_Id','Item_Name');

            // Convert sdt ve chuan +84
            $fisrtChar = substr($model->user_id,0,1); // Lấy kí tự đầu của chuỗi
            if($fisrtChar === '0'){
                $model->user_id = UsermanagerController::format_number($model->user_id);
            }

            $items = self::actionGetAllDataForMiniCC();


            $allPos = $searchPos->searchAllPos();
            foreach($allPos as $key => $pos){
                $allPosToCheckDistance[$key]['POS_NAME'] = $pos['POS_NAME'].'-'.$pos['POS_LONGITUDE'].'-'.$pos['POS_LATITUDE'];
                $allPosToCheckDistance[$key]['ID'] = $pos['ID'];
            }

            $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');
            $allPosToCheckDistanceMap = ArrayHelper::map($allPosToCheckDistance,'ID','POS_NAME');



            $searchPosModel = new DmposSearch();
            $allPos = $searchPosModel->searchAllPos();
            $posMapOrder = array();
            foreach($allPos as $key => $pos){
                $allPosToCheckDistance[$key]['POS_NAME'] = $pos['POS_NAME'].'-'.$pos['POS_LONGITUDE'].'-'.$pos['POS_LATITUDE'];
                $allPosToCheckDistance[$key]['ID'] = $pos['ID'];
                if(@$pos['IS_ORDER_LATER']){
                    $posMapOrder[] = $pos['ID'];
                }

            }

            return $this->render('short_cart_update', [
                'allPosMap' => $allPosMap,
                'phoneNumber' => $oder['textPhone'],
                'posMapOrder' => $posMapOrder,
                'allPosToCheckDistanceMap' => $allPosToCheckDistanceMap,
                'model' => $model,
                'pos' => $pos,
                'itemsMap' => $itemsMap,
                'listItems' => @$items->data->list_item,
            ]);
        }
    }

    public function getAPI($name,$pos_id,$user_id){
        // Set body parameter

        $api_request_url = Yii::$app->params['CMS_API_PATH'].$name;

        /*
  Set the Request Url (without Parameters) here
*/
        /*
          Which Request Method do I want to use ?
          DELETE, GET, POST or PUT
        */
        $method_name = 'GET';

        /*
          Let's set all Request Parameters (api_key, token, user_id, etc)
        */
        $api_request_parameters = array(
            'pos_id' => $pos_id,
            'user_id' => $user_id,
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        if ($method_name == 'DELETE')
        {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($api_request_parameters));
        }

        if ($method_name == 'GET')
        {
            $api_request_url .= '?' . http_build_query($api_request_parameters);
        }

        if ($method_name == 'POST')
        {
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($api_request_parameters));
        }

        if ($method_name == 'PUT')
        {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($api_request_parameters));
        }

        /*
          Here you can set the Response Content Type you prefer to get :
          application/json, application/xml, text/html, text/plain, etc
        */
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('access_token: D0FBGS3NKZUUFZCIURBDKPR9N5RRML7K'));

        /*
          Let's give the Request Url to Curl
        */
        curl_setopt($ch, CURLOPT_URL, $api_request_url);

        /*
          Yes we want to get the Response Header
          (it will be mixed with the response body but we'll separate that after)
        */
        //curl_setopt($ch, CURLOPT_HEADER, TRUE);

        /*
          Allows Curl to connect to an API server through HTTPS
        */
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        /*
          Let's get the Response !
        */
        $api_response = curl_exec($ch);

        /*
          We need to get Curl infos for the header_size and the http_code
        */
        //$api_response_info = curl_getinfo($ch);

        /*
          Don't forget to close Curl
        */
        curl_close($ch);


        return $api_response;
    }

    public function actionUpdatelocation($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            if($post['processOrder'] === 'ASSIGNING'){
                //echo $model->address_id;
                $addressModel = new MemberaddresslistSearch();
                $adrees = $addressModel->searchModel($model->address_id);

                $arrayAddress = explode(",",$model->to_address);
                $arrayAddressRemoveCountry = array_pop($arrayAddress);
                $cityName =  end($arrayAddress);

                // Lấy City by GG
                $searchCity = new DmcitySearch();
                $city = $searchCity->searchCityByName($cityName); //Obj City

                // Lấy District by GG
                array_pop($arrayAddress);
                $districtName =  end($arrayAddress);

                $searchDistrict = new DmdistrictSearch();
                $districtObj = $searchDistrict->searchDistrictByName($districtName,(int)($city->ID)); //Obj City


                $adrees->district_id = (int)($districtObj->ID);
                $adrees->city_id = (int)($city->ID);
                $adrees->latitude = $post['newLatAdress'];
                $adrees->longitude = $post['newLongAdress'];
                $adrees->full_address = $model->to_address;

                $adrees->save();
                $model->save();

                if($post['is_ahamove_pos'] === '1'){
                    OrderonlinelogController::actionChangeStatusAhamove($model->foodbook_code,$status = 'ASSIGNING','order_online_ahamove_ship'); // Ném đơn hàng sang AHAMOVE -
                }else{
//                    echo 'Chưa chuyển sang chế độ ASSIGN';
//                    die();
                    OrderonlinelogController::actionChangeStatusAhamove($model->foodbook_code,$status = '','order_online_with_confirmed');
                }
            }else{
//                echo 'vao day';
//                die();
                //OrderonlinelogController::actionChangeStatusAhamove($model->foodbook_code,$status = '','order_online_with_confirmed');
                OrderonlinelogController::actionChangeStatusAhamove($model->foodbook_code,$status = 'CANCELLED','order_online_update_status'); // Hủy đơn hàng

            }

            return $this->redirect('index.php?r=orderonlinelog',302);

        } else {
            $curl = new curl\Curl();
            $urlAddress = urlencode ($model->to_address);
            $url = "http://maps.google.com/maps/api/geocode/json?address=".$urlAddress;
            $response = $curl->get($url);

            $response = json_decode($response);
            $arrayLocation = NULL;
            if($response->status == 'OK' && $response->results != null){
                foreach($response->results as $value){
                    $key = $value->geometry->location->lat.'-'.$value->geometry->location->lng;
                    $arrayLocation[$key] = $value->formatted_address; // Lấy location của các địa điểm gợi ý của Google
                }
            }
//            $firstLat = $response->results[0]->geometry->location->lat;
//            $firstLong = $response->results[0]->geometry->location->lng;


            $searchPos = new DmposSearch();
            $pos = $searchPos->searchById($model->pos_id);

//            $addressModel = new Memberaddresslist();
//            $adrees = $addressModel->findModel($model->address_id);
            /*echo '<pre>';
            var_dump($arrayLocation);
            echo '</pre>';*/
//            die();


            return $this->render('update_location', [
                'model' => $model,
                'pos' => $pos,
//                'firstLat' => $firstLat,
//                'firstLong' => $firstLong,
                'arrayLocation' => $arrayLocation,
            ]);
        }
    }

    /**
     * Deletes an existing Orderonlinelog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionDelete($id)
    {
//        var_dump($id);
//        die();
        $model = $this->findModel($id);/*->delete();*/
        OrderonlinelogController::actionChangeStatusAhamove($model->foodbook_code,$status = 'CANCELLED','order_online_update_status'); // Hủy đơn hàng

        return $this->redirect(['index']);
    }

    public function actionConfirmtopos($id)
    {
        $model = $this->findModel($id);/*->delete();*/


        $confirm = OrderonlinelogController::actionChangeStatusAhamove($model->foodbook_code,$status = 'RES_DELIVERY','order_online_update_status');
        //$confirm = OrderonlinelogController::actionChangeStatusAhamove($model->foodbook_code,$status = 'RES_DELIVERY','order_online_with_confirmed');
        $confirmValue = json_decode($confirm);
//        echo '<pre>';
//        var_dump($confirm);
//        echo '</pre>';
//        die();

//        $key = 'checkSendToPos_'.$id;
//        $checkSendToPos = \Yii::$app->cache->get($key);
//        if ($checkSendToPos === false) {
//            $confirm = OrderonlinelogController::actionChangeStatusAhamove($model->foodbook_code,$status = 'RES_DELIVERY','order_online_with_confirmed');
//            $confirmValue = json_decode($confirm);
//            if($confirmValue->data === '1'){
//                    \Yii::$app->cache->set($key,$id, 3600); // time in seconds to store cache
//            }
//        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Orderonlinelog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return Orderonlinelog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orderonlinelog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
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

    public function actionSearch()
    {
        //$post = Yii::$app->request->post();
//        var_dump($post);
//        die();
        return $this->redirect('index.php?r=orderonlinelog/creatorder&id=',302);

    }

    public function actionGetAllDataForMiniCC(){
        //Get Item by User
        $apiPath = Yii::$app->params['CMS_API_PATH_SHORT'];
        $access_token = Yii::$app->params['ACCESS_TOKEN'];
        $name = 'ipcc/get_all_data';
//
        $paramItem = array();
//
        $headers = array();
        $headers[] = 'access_token: '.$access_token;
        $headers[] = 'token: '.\Yii::$app->session->get('user_token');
        $itemList = self::getApiByMethod($name,$apiPath,$paramItem,$headers,'GET');

        $itemMap = ArrayHelper::map($itemList->data->list_item,'Id','Item_Type_Id');
        $itemTypeMap = ArrayHelper::map($itemList->data->list_item_type,'Item_Type_Id','sort');

        foreach($itemList->data->list_item as $key => $item){
            $item->Item_Type_Id_Sort = @$itemTypeMap[$item->Item_Type_Id];
            $itemList->data->list_item[$key] = $item;
        }

        ArrayHelper::multisort($itemList->data->list_item, ['Item_Type_Id_Sort','Sort'], [SORT_ASC,SORT_ASC]);

        return $itemList;
    }


    function sortArrayByArray(array $array, array $orderArray) {
        $ordered = array();
        foreach ($orderArray as $key) {
            if (array_key_exists($key, $array)) {
                $ordered[$key] = $array[$key];
                unset($array[$key]);
            }
        }
        return $ordered + $array;
    }


    public function actionSubcat1($id,$longitude,$latitude,$address,$user_id) {
        $posModel = new DmposSearch();
        $pos = $posModel->searchById($id);

        $fisrtChar = substr($user_id,0,1); // Lấy kí tự đầu của chuỗi
        if($fisrtChar === '0'){
            $user_id = UsermanagerController::format_number($user_id);
        }

        $param= ['msisdn' => $user_id];  //'msisdn' => (int)$model->user_id,

        //$param= ['msisdn' => 84982680996];  //'msisdn' => (int)$model->user_id,
        $apiPath = Yii::$app->params['CMS_API_PATH_SHORT'];
        $type = 'auth/partner_login';
        $access_token = Yii::$app->params['ACCESS_TOKEN'];

        $member = self::actionCallApiByPost($param,$apiPath,$type,$access_token);
		
		// echo '<pre>';
		// var_dump($access_token);
		// var_dump($param);
		// var_dump($apiPath);
		// var_dump($type);
		// var_dump($member);
		// echo '</pre>';
		// die();

        //. ./Get Accetoken user

        //Get Item by User
        $name = 'item/item_order_pos';

        $paramItem = array(
            'id' => $id,
        );

        $headers = array();
        $headers[] = 'access_token: '.$access_token;
        $headers[] = 'token: '.$member->data->Token;
        $itemList = self::getApiByMethod($name,$apiPath,$paramItem,$headers,'GET');

        $categoryModel = new DmitemtypeSearch();
        $allCategory = $categoryModel->searchCategoryByPos($id);


        echo $this->renderPartial('cart', [
            'allPos' => $itemList,
            'posId' => $id,
            'posName' => $pos['POS_NAME'],
            'longitude' => $longitude,
            'latitude' => $latitude,
            'address' => $address,
            'allCategory' => $allCategory,
        ]);
    }
}
