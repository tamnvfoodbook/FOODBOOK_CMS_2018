<?php

namespace backend\controllers;

use backend\models\DmitemtypeSearch;
use backend\models\Dmmembership;
use backend\models\DmmembershippointSearch;
use backend\models\DmmembershipSearch;
use backend\models\DmposSearch;
use backend\models\Orderonlinelog;
use backend\models\OrderonlinelogSearch;
use Yii;
use backend\models\Orderonlinelogpending;
use backend\models\OrderonlinelogpendingSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderonlinelogpendingController implements the CRUD actions for Orderonlinelogpending model.
 */
class OrderonlinelogpendingController extends Controller
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
     * Lists all Orderonlinelogpending models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderonlinelogpendingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort(false);

        $searchPosModel = new DmposSearch();
        $allPos = $searchPosModel->searchAllPos();
        $allPosMap= ArrayHelper::map($allPos,'ID','POS_NAME');

        /*$searchModel = new DmmembershipSearch();
        $allMember = $searchModel->seachAllPhoneByPospent();
        $allMemberMap = ArrayHelper::map($allMember,'ID','MEMBER_NAME');*/

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
//            'allMemberMap' => $allMemberMap,
            'allPosMap' => $allPosMap,
        ]);
    }

    /**
     * Displays a single Orderonlinelogpending model.
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
     * Creates a new Orderonlinelogpending model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Orderonlinelogpending();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => (string)$model->_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }


    public function actionUpdate($id,$isBooking = null)
    {
        $orderModel = $this->findModel($id);
        @$orderModel->note = trim(preg_replace('/\s\s+/', ' ', @$orderModel->note));


        $phoneNumber = $orderModel->user_phone;
        $model = new Orderonlinelog();
        $model->user_id = $orderModel->user_phone;
        if($orderModel->username){
            $model->username = $orderModel->username;
        }else{
            $model->username = @$orderModel->user_status;
        }

        if($orderModel->pos_id){
            $model->pos_id = $orderModel->pos_id;
        }

        $model->to_address = $orderModel->to_address;
        $model->note = $orderModel->note;
        $model->order_data_item = $orderModel->order_data_item;
        $model->pos_parent = $orderModel->pos_parent;
        $model->foodbook_code = $orderModel->foodbook_code;
        $model->created_by = $orderModel->created_by;


        if(isset($orderModel->voucher_code)){
            $model->coupon_log_id = $orderModel->voucher_code;
        }

        $listItemSelected = json_decode(json_encode($model->order_data_item), true);


        if(!$listItemSelected){
            $listItemSelected = array();
        }

        $voucherDiscount = self::actionCheckvoucherwhenloadupdate($model->user_id,$model->pos_id,$model->order_data_item,$model->coupon_log_id);


        $modelMember = $this->findMemberModel($orderModel->user_phone);

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
            $itemList = OrderonlinelogController::getApiByMethod($name,$apiPath,$paramItem,$headers,'GET');



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
                'pos_parent' => $model->pos_parent,
                'orders' => json_encode(array_values($orderItem)),
                'address_id' => $model->address_id,
                'payment_method' => $model->paymentInfo,
                'full_address' => $model->to_address,
                'longitude' => $post['newLongAdress'],
                'latitude' => $post['newLatAdress'],
                'campaign_id' => NULL,
                'coupon_id' => null,
//                'booking_info' => null,
                'is_pending' => 0,
                'voucher_code' => $model->coupon_log_id,
            ];


            $nameAPI = 'member/v2/order_online';

            $result = OrderonlinelogController::getApiByMethod($nameAPI,$apiPath,$ItemParam,$headers,'POST');
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
//            $itemTypeMap = ArrayHelper::map($itemTypeModel,'ITEM_TYPE_ID','ITEM_TYPE_NAME');
            $listNotExit = '';
            //if((array)$ids){
//            var_dump($isBooking);
//            die();
//            if(@$callcenter_short != null || $isBooking != null){
            if($isBooking == null){

                $items = OrderonlinelogController::actionGetAllDataForMiniCC();



                $comboNomal = OrderonlinelogController::actionConvertCombo($items->data->list_normal_combo,1);
                $combo = OrderonlinelogController::actionConvertCombo($items->data->list_special_combo,0);


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

                $comboToppping = OrderonlinelogController::actionConvertComboTopping(@$items->data->list_topping_combo,$allItem);
                foreach($items->data->list_item as $keyCBTp => $itemCBtopping){
                    if(isset($comboToppping[$itemCBtopping->Item_Id])){
                        unset($items->data->list_item[$keyCBTp]);
                    }
                }
                $items->data->list_item = array_merge($items->data->list_item,$comboToppping);

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


                if(isset($items->data)){
                    $itemMap = array();
                    $itemEatwithListMap = array();
                    $itemMapEatWith = array();
                    foreach($items->data->list_item as $itemValue){
                        $itemMap[$itemValue->Item_Id] = $itemValue->Id;
                        $itemEatwithListMap[$itemValue->Item_Id] = @trim($itemValue->Item_Id_Eat_With);
                        $itemMapEatWith[$itemValue->Item_Id] = $itemValue->Is_Eat_With;
                    }


                    foreach((array)$listItemSelected as $key => $item){
                        if(isset($itemMap[$item['Item_Id']])){
                            if(!$itemMapEatWith[$item['Item_Id']]){
                                $listItemSelected[$key]['Id'] = @$itemMap[$item['Item_Id']];
                                $listItemSelected[$key]['Item_Id_Eat_With'] = @$itemEatwithListMap[$item['Item_Id']];

                            }else{
                                $preKey = self::getPrevKey($key,$listItemSelected);
                                $listEatwith = $item['Item_Id'].'_*_'.$item['Price'].'_*_'.$item['Item_Name'].'_*_1_*_'; // Cho bằng 1 vì chọn trên zalo không có tỉ lệ của món ăn kèm
//                                $listEatwith = $item['Item_Id'].'_*_'.$item['Price'].'_*_'.$item['Item_Name'].'_*_'.$item['Quantity'].'_*_';
                                if(!isset($listItemSelected[$preKey]['Eat_with_selected'])){
                                    $listItemSelected[$preKey]['Eat_with_selected'] = $listEatwith;
                                }else{
                                    $listItemSelected[$preKey]['Eat_with_selected'] = $listItemSelected[$preKey]['Eat_with_selected'].','.$listEatwith;
                                }

                                unset($listItemSelected[$key]);
                            }
                        }else{
                            if($listNotExit){
                                $listNotExit = $listNotExit.','.$listItemSelected[$key]['Item_Name'];
                            }else{
                                $listNotExit = $listItemSelected[$key]['Item_Name'];
                            }

                            unset($listItemSelected[$key]);
                        }

                    }


                    //Yii::info($items);
                    if(isset($orderModel->is_pending)){
                        $pending = $id;
                    }else{
                        $pending = '';
                    }
                    /*echo '<pre>';
                    var_dump($pending);
                    echo '</pre>';
                    die();*/


                    if((array)$ids){
                        return $this->render('../orderonlinelog/creatorder_short', [
                            'model' => $model,
                            'allPosMap' => $allPosMap,
                            'listItemSelected' => $listItemSelected,
                            'allPosToCheckDistanceMap' => $allPosToCheckDistanceMap,
                            'userPhoneData' => $userPhoneData,
                            'listItems' => @$items->data->list_item,
                            'phoneNumber' => $phoneNumber,
                            'isBooking' => $isBooking,
                            'listNotExit' => $listNotExit,
                            'posMapOrder' => $posMapOrder,
                            'itemTypeMap' => $itemTypeMap,
                            'voucherDiscount' => @$voucherDiscount,
                            'id_pending' => $pending,
//                            'id_pending' => $id,
                        ]);
                    }else{
                        return $this->render('../site/null_pos', [
                            'model' => $model,
                        ]);
                    }

                }else{
                    Yii::$app->getSession()->setFlash('error', @$items->error->message);
                    return $this->redirect('index.php?r=orderonlinelog',302);
                }
            }else{

//                return $this->render('creatorder', [
                return $this->render('../orderonlinelog/creatorder_short', [
                    'model' => $model,
                    'modelMember' => $modelMember,
                    'allPosMap' => $allPosMap,
                    'listItemSelected' => $listItemSelected,
                    'allPosToCheckDistanceMap' => $allPosToCheckDistanceMap,
                    'userPhoneData' => $userPhoneData,
                    'isBooking' => $isBooking,
                    'listNotExit' => $listNotExit,
                    'voucherDiscount' => @$voucherDiscount,
//                'searchModel' => $searchOrderModel,
//                'dataProvider' => $dataProvider,
                    'phoneNumber' => $phoneNumber,

                    //'order' => $order,

                ]);
            }

        }
    }


    function getPrevKey($key, $hash = array())
    {
        $keys = array_keys($hash);
        $found_index = array_search($key, $keys);
        if ($found_index === false || $found_index === 0)
            return false;
        return $keys[$found_index-1];
    }

    public function actionCheckvoucher()
    {
        $post = Yii::$app->request->post();
        $id = AjaxapiController::fixPhoneNumbTo84(@$post['textPhone']);


        $param= [
            'msisdn' => trim(@$post['textPhone']),
        ];

        $apiPath = Yii::$app->params['CMS_API_PATH_SHORT'];
        $type = 'auth/partner_login';
        $access_token = Yii::$app->params['ACCESS_TOKEN'];

        $member = self::actionCallApiByPost($param,$apiPath,$type,$access_token);
        if(isset($member->data)){
            $headers = array();
            $headers[] = 'access_token: '.$access_token;
            $headers[] = 'token: '.$member->data->Token;
            $itemList = OrderonlinelogController::actionGetAllDataForMiniCC();



            // ./Get Item by User
            $orderItem = array();

            if(isset($post['products_selected'])){
                $tmp = 1;
                foreach($post['products_selected'] as $product){
                    $itemTypeMap = ArrayHelper::map($itemList->data->list_item,'Item_Id','Item_Type_Id');
                    /*echo '<pre>';
                    var_dump($product);
                    echo '</pre>';
                    die();*/
                    $proArray = explode("|",$product['value']); // phần tử 0 là id, 1 là số lượng, 2 là ghi chú, 4 là giảm giá, 5 là các món ăn kèm của món đó, 6 là các món ăn kèm đã chọn
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
                            if((int)@$proArray[4] > 0){
                                $orderItem[$tmp]['Foc'] = 1;
                            }

                            if(isset($proArray[6]) && $proArray[6] != 'undefined' && $proArray[6] != ''){
                                $arrEatWith = explode(",",$proArray[6]);
                                $tmpEatWith = 1000;
                                foreach((array)$arrEatWith as $itemEatWith){
                                    $arrElementEatWith = explode("_*_",$itemEatWith);
                                    /*echo '<pre>';
                                    var_dump($itemEatWith);
                                    echo '</pre>';
                                    die();*/

                                    $orderItem[$tmp.$tmpEatWith]['User_Id'] = $id;
                                    $orderItem[$tmp.$tmpEatWith]['Item_Name'] = @$arrElementEatWith[2];
                                    $orderItem[$tmp.$tmpEatWith]['Item_Id'] = @$arrElementEatWith[0];
                                    $orderItem[$tmp.$tmpEatWith]['Item_Type_Id'] = @$itemTypeMap[$arrElementEatWith[0]];
                                    $orderItem[$tmp.$tmpEatWith]['Note'] = 'món ăn kèm của '.$item->Item_Name;
                                    $orderItem[$tmp.$tmpEatWith]['Discount'] = @$proArray[4]/100; //$item->Discount_Ta_Price;
                                    $orderItem[$tmp.$tmpEatWith]['Quantity'] = (int)$proArray[1];
                                    $orderItem[$tmp.$tmpEatWith]['Price'] = $arrElementEatWith[1];
                                    if((int)@$proArray[4] > 0){
                                        $orderItem[$tmp+1]['Foc'] = 1;
                                    }
                                    $tmpEatWith++;
                                }
                            }
                        }
                    }
                    $tmp ++;
                }
            }


            $apiName = 'member/check_voucher';


            $ItemParam =  [
                'voucher_code' => strtoupper(@$post['voucherCode']),
                'pos_parent' => \Yii::$app->session->get('pos_parent'),
                'pos_id' => @$post['posSelect'],
                'order_lines' => json_encode(array_values($orderItem))
            ];
            /*echo '<pre>';
            var_dump($apiPath.$apiName);
            var_dump($ItemParam);
            var_dump($headers);
            echo '</pre>';
            die();*/

            $result = OrderonlinelogController::getApiByMethod($apiName,$apiPath,$ItemParam,$headers,'POST');
            if(isset($result->data)){
                return json_encode($result->data);
            }else{
                if(isset($result->error->message)){
                    $errorMess = $result->error->message;
                }else{
                    $errorMess = 'ERROR';
                }
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
    public function actionCheckvoucherwhenloadupdate($phone,$pos_id,$order_items,$voucherCode)
    {

        $param= [
            'msisdn' => trim($phone),
        ];

        $apiPath = Yii::$app->params['CMS_API_PATH_SHORT'];
        $type = 'auth/partner_login';
        $access_token = Yii::$app->params['ACCESS_TOKEN'];

        $member = self::actionCallApiByPost($param,$apiPath,$type,$access_token);
        if(isset($member->data)){
            $headers = array();
            $headers[] = 'access_token: '.$access_token;
            $headers[] = 'token: '.$member->data->Token;

            // ./Get Item by User
            $apiName = 'member/check_voucher';

            $ItemParam =  [
                'voucher_code' => $voucherCode,
                'pos_parent' => \Yii::$app->session->get('pos_parent'),
                'pos_id' => $pos_id,
                'order_lines' => json_encode(array_values($order_items))
            ];
 /*           echo '<pre>';
            var_dump($ItemParam);
            echo '</pre>';
            die();*/


            $result = OrderonlinelogController::getApiByMethod($apiName,$apiPath,$ItemParam,$headers,'POST');
            if(isset($result->data)){
                return $result->data->Discount_Amount*-1;
            }else{
                /*if(isset($result->error->message)){
                    $errorMess = $result->error->message;
                }else{
                    $errorMess = 'ERROR';
                }
                return $errorMess;*/
                return 0;
            }
        }else{
//            if(isset($member->error->message)){
//                $errorMess = $member->error->message;
//            }else{
//                $errorMess = 'Lỗi kết nối, vui lòng thử lại sau';
//            }
//            return $errorMess;
            return 0;

        }
    }


    function actionCheckship(){
        $post = Yii::$app->request->post();

        $apiPath = Yii::$app->params['CMS_API_PATH_SHORT'];
        $access_token = Yii::$app->params['ACCESS_TOKEN'];

        $name = 'partner/caculate_ship_fee';
        $headers = array();
        $headers[] = 'access_token: '.$access_token;

        $result = OrderonlinelogController::getApiByMethod($name,$apiPath,$post,$headers,'POST');
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

    public function actionUpdate_bk($id)
    {
        $orderModel = $this->findModel($id);

        $post = Yii::$app->request->post();
//        $id = AjaxapiController::fixPhoneNumbTo84($orderModel->user_phone);

        $param= [
            'msisdn' => trim($orderModel->user_phone),
            'username' => @$orderModel->username
        ];

        $apiPath = Yii::$app->params['CMS_API_PATH_SHORT'];
        $type = 'auth/partner_login';
        $access_token = Yii::$app->params['ACCESS_TOKEN'];

        $member = self::actionCallApiByPost($param,$apiPath,$type,$access_token);
        if(isset($member->data)){
            $headers = array();
            $headers[] = 'access_token: '.$access_token;
            $headers[] = 'token: '.$member->data->Token;
            $itemList = OrderonlinelogController::actionGetAllDataForMiniCC();

            // ./Get Item by User
            $orderItem = array();
//            echo '<pre>';
//            var_dump($post);
//            echo '</pre>';
//            die();

            if(isset($post['products_selected'])){
                $tmp = 1;
                foreach($post['products_selected'] as $product){
                    $proArray = explode("|",$product); // phần tử 0 là id, 1 là số lượng, 2 là ghi chú, 4 là giảm giá, 5 là các món ăn kèm của món đó, 6 là các món ăn kèm đã chọn
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
                            if((int)@$proArray[4] > 0){
                                $orderItem[$tmp]['Foc'] = 1;
                            }

                            if(isset($proArray[6]) && $proArray[6] != 'undefined'){
                                $arrEatWith = explode(",",$proArray[6]);
                                $tmpEatWith = 1000;
                                foreach((array)$arrEatWith as $itemEatWith){
                                    $arrElementEatWith = explode("_*_",$itemEatWith);
                                    //$orderItem[$tmp+1]['Item_Type_Id'] = @$item->Item_Type_Id;
                                    $orderItem[$tmp.$tmpEatWith]['User_Id'] = $id;
                                    $orderItem[$tmp.$tmpEatWith]['Item_Name'] = $arrElementEatWith[2];
                                    $orderItem[$tmp.$tmpEatWith]['Item_Id'] = $arrElementEatWith[0];
                                    $orderItem[$tmp.$tmpEatWith]['Note'] = 'món ăn kèm của '.$item->Item_Name;
                                    $orderItem[$tmp.$tmpEatWith]['Discount'] = @$proArray[4]/100; //$item->Discount_Ta_Price;
                                    $orderItem[$tmp.$tmpEatWith]['Quantity'] = (int)$proArray[1];
                                    $orderItem[$tmp.$tmpEatWith]['Price'] = $arrElementEatWith[1];
                                    if((int)@$proArray[4] > 0){
                                        $orderItem[$tmp+1]['Foc'] = 1;
                                    }
                                    $tmpEatWith++;
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
                ];

//                echo '<pre>';
//                var_dump($ItemParam);
//                echo '</pre>';
//                die();

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

//            echo '<pre>';
//            var_dump($ItemParam);
//            echo '</pre>';
//            die();
            $result = OrderonlinelogController::getApiByMethod($nameAPI,$apiPath,$ItemParam,$headers,'POST');

            if(isset($result->data)){
                if(isset($post['addressTxt'])){
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



    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    public function actionDeactive($id)
    {
        $model = $this->findModel($id);
        $model->is_pending = 0;
        if($model->save()){
            Yii::$app->getSession()->setFlash('success', 'Hủy đơn hàng chờ thành công!!');
        }else{
            Yii::$app->getSession()->setFlash('error', 'Hủy đơn hàng chờ thất bại!!');
        }

        return $this->redirect(['index']);
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

    /**
     * Finds the Orderonlinelogpending model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return Orderonlinelogpending the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

    protected function findMemberModel($id)
    {
        if (($model = Dmmembership::findOne($id)) !== null) {
            return $model;
        } else {
            $model = new Dmmembership();
            return $model;
        }
    }

    protected function findModel($id)
    {
        if (($model = Orderonlinelogpending::findOne($id)) !== null) {
            return $model;
        } else {
            if (($model = Orderonlinelog::findOne($id)) !== null) {
                return $model;
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }
    }
}
