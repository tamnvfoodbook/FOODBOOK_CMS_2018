<?php

namespace backend\controllers;
use backend\controllers\OrderonlinelogController;

use backend\models\Dmmembership;
use backend\models\DmmembershipSearch;
use backend\models\DmposparentSearch;
use backend\models\DmposSearch;
use backend\models\Dmvoucherlog;
use backend\models\Orderonlinelog;
use backend\models\OrderonlinelogSearch;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class AjaxapiController extends \yii\web\Controller
{
    public function actionIndex($pos_id,$address,$longitude,$latitude,$amount)
    {

        $callback ='mycallback';

        $feeShip = '';
        $distance = 0;

        if(isset($_GET['mycallback'])) {
            $callback = $_GET['mycallback'];

            $nameAPI = 'member/caculate_ship_fee';
            $apiPath = Yii::$app->params['CMS_API_PATH_SHORT'];


            $param = array(
                'pos_id' => $pos_id,
                'amount' => $amount,
                'address' => $address,
                'longitude' => $longitude,
                'latitude' => $latitude,
            );
            /*var_dump($param);
            die();*/

            $headers = array();
            $headers[] = 'access_token: ' . Yii::$app->params['ACCESS_TOKEN'];

            $dataFee = self::getApiByMethod($nameAPI, $apiPath, $param, $headers, 'POST');



            if (isset($dataFee->data)) {
                if ($dataFee->data->fee == "-2") {
                    $feeShip = 'Ahamove quyết định';
                } else if ($dataFee->data->fee == "-1") {
                    $feeShip = 'Nhà hàng liên hệ';
                } else if ($dataFee->data->fee == "0") {
                    $feeShip = 'Miễn phí vận chuyển';
                } else {
                    $feeShip = $dataFee->data->fee;
                    $distance = $dataFee->data->distance;

                }

            }
            // ./Get Fee Ship
        }
        $arr =array();
        $arr['feeValue']= $feeShip;
        $arr['distanceValue']= $distance;

        echo $callback.'(' . json_encode($arr) . ')';
    }

    function startsWith($haystack, $needle) {
        // search backwards starting from haystack length characters from the end
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
    }

    public static function fixPhoneNumbTo84($phone){
        if ($phone == null || strlen($phone) < 9){
            return "";
        }

        if (self::startsWith($phone,"084")){
            $phone = substr($phone,1);
        }else if(self::startsWith($phone,"0")){
            $phone = '84'.substr($phone,1);
        }else if(!self::startsWith($phone,"84")){
            $phone = '84'.$phone;
        }
        return $phone;
    }


    public function actionUserphone($userphone){

        $userphone = self::fixPhoneNumbTo84($userphone);
        $id = (int)$userphone;
        $model = new Orderonlinelog();
        $model->user_id = $id;


        $searchOrderModel = new OrderonlinelogSearch();
        //$dataProvider = $searchOrderModel->searchByMember(Yii::$app->request->queryParams,$id);
        $order = $searchOrderModel->searchAllOrderByUserId($id);


        $searchPosModel = new DmposSearch();
        //$allPos = $searchPosModel->searchAllPos();
//        foreach($allPos as $key => $pos){
//            $allPosToCheckDistance[$key]['POS_NAME'] = $pos['POS_NAME'].'-'.$pos['POS_LONGITUDE'].'-'.$pos['POS_LATITUDE'];
//            $allPosToCheckDistance[$key]['ID'] = $pos['ID'];
//        }

//        $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');
//        $allPosToCheckDistanceMap = ArrayHelper::map($allPosToCheckDistance,'ID','POS_NAME');

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
    }

    public function actionMember($userphone)
    {

        $userphone = self::fixPhoneNumbTo84($userphone);
        $id = (int)$userphone;

        $searchMemberModel = new DmmembershipSearch();
        //$dataProvider = $searchOrderModel->searchByMember(Yii::$app->request->queryParams,$id);
        $member = $searchMemberModel->searchMemberModelById($id);
//        echo '<pre>';
//        var_dump($member);
//        echo '</pre>';

        return $this->renderPartial('member_data', [
            'model' => $member
        ]);
    }


    public function actionLastorder($userphone){
        $userphone = self::fixPhoneNumbTo84($userphone);
        $id = (int)$userphone;

        $model = new Orderonlinelog();
        $model->user_id = (int)$id;

        $searchOrderModel = new OrderonlinelogSearch();

        $order = $searchOrderModel->searchAllOrderByUserId($id);

        $searchPosModel = new DmposSearch();

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

        }
            return $this->renderPartial('last_order_ajax', [
                'model' => $model,
            ]);


    }

    public function actionGetname($userphone){
        $userphone = self::fixPhoneNumbTo84($userphone);
        $id = (int)$userphone;
        $modelMember = $this->findMemberModel($id);
            return $modelMember->MEMBER_NAME;


    }

    public function actionGetcommentinrate($page = 1,$commentType = 'get_comments_in_rate',$dateStart,$dateEnd){
        $posModelSearch = new DmposSearch();
        $posIdList = \Yii::$app->session->get('pos_id_list');
        $posObj = $posModelSearch->searchAllPosByListId($posIdList);
        $posNameMap = ArrayHelper::map($posObj,'ID','POS_NAME');
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];
        $access_token = Yii::$app->params['ACCESS_TOKEN'];
        $user_token = \Yii::$app->session->get('user_token');
        $headers = array();
        $headers[] = 'access_token: '.$access_token;
        $headers[] = 'token: '.$user_token;

        $comments_in_rate = 'ipcc/'.$commentType;
        $param_comments_in_rate = array(
            'date_start' => $dateStart,
            'date_end' => $dateEnd,
            'page' => $page
        );


        $comment = ApiController::getApiByMethod($comments_in_rate,$apiPath,$param_comments_in_rate,'GET');

        $dataComment = array();
        if(isset($comment->data)){
            foreach((array)$comment->data as $cm){
                $dataComment[$cm->id]['member_id'] = $cm->member_id;
                $dataComment[$cm->id]['memberName'] = $cm->dmMember->Member_Name;
                $dataComment[$cm->id]['pos_id'] = $cm->pos_id;
                $dataComment[$cm->id]['pos_name'] = $posNameMap[$cm->pos_id];
                $dataComment[$cm->id]['reson_note'] = $cm->reason_note;
                $dataComment[$cm->id]['created_at'] = $cm->created_at;
                $dataComment[$cm->id]['pos_parent'] = $cm->pos_parent;
            }
        }

        return json_encode(array_values((array)$dataComment));

    }


    public function actionGetinfomember(){

        $post = Yii::$app->request->post();
        $posParent = \Yii::$app->session->get('pos_parent');

        $nameAPI = 'ipcc/member_extra_info_v2';
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];

        $param = array(
            'member_id'=> $post['member_id'],
            'pos_parent'=> $posParent
        );

        $headers = array();
        $headers[] = 'access_token: ' . Yii::$app->params['ACCESS_TOKEN'];
        $result = self::getApiByMethod($nameAPI, $apiPath, $param, $headers, 'POST');
//        echo '<pre>';
//        var_dump($param);
//        var_dump($result);
//        echo '</pre>';

        if(isset($result->data)){
            $result_content = '<div><p>Lần đầu tiên : '.date(Yii::$app->params['DATE_FORMAT'],strtotime(@$result->data->eat_first_date)).'</p>'.
            '<p>Lần gần nhất : '.date(Yii::$app->params['DATE_FORMAT'],strtotime(@$result->data->eat_last_date)).'</p>'.
            '<p>Tổng số lần : '.@$result->data->eat_count.'</p>'.
            '<p>Tổng số điểm: '.number_format(@$result->data->point,1).'</p>'.
            '<p>Tổng số tiền : '.number_format(@$result->data->amount).'</p>'.
//            '<p>Đơn hàng cuối cùng: '.@$result->data->last_sale_desc.'</p>'.
            '</div>';
            return $result_content;
        }else{
            return 'Không có dữ liệu';
        }
    }


    public function actionGetitemwith(){
        $post = Yii::$app->request->post();
        $itemId = $post['item_id'];
        $result_content = '';
        if(isset($itemId)){
            $dataItem = json_decode($post['dataItem'],true);
            $allPosMap = ArrayHelper::map($dataItem,'Id','Item_Id_Eat_With');
            $itemEatWithArrId = explode(',',$allPosMap[$itemId]);
            foreach((array)$itemEatWithArrId as $itemEatWith){
                $result_content = '<input value="'.$itemEatWith.'" type= "button" onclick="addIemWithToCart()">'. $result_content;
            }
        }
        return $result_content;
//        echo '<pre>';
//        var_dump($allPosMap);
//        echo '</pre>';
//        die();

    }

    public function actionRatedetail(){
        $post = Yii::$app->request->post();
        if($post['star']>5){
            $nameAPI = 'ipcc/get_member_rate_by_reason_rate';
            $arrayReson = [
                10 => 'reson_bad_food',
                9 =>'reson_expensive_price',
                8 =>'reson_bad_shipper',
                7 => 'reson_bad_service',
                6 => 'reson_other'
            ];

            $param = array(
                'reason_rate' => $arrayReson[$post['star']],
                'date_start' => $post['date_start'],
                'date_end' => $post['date_end'],
            );
        }else{
            $nameAPI = 'ipcc/get_member_rate_by_score';
            $param = array(
                'score' => $post['star'],
                'date_start' => $post['date_start'],
                'date_end' => $post['date_end'],
            );
        }



        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];

        $rate = ApiController::getApiByMethod($nameAPI,$apiPath,$param,'GET');


        $data = SiteController::getMemberRateDetail(json_decode($post['posnamemap'],true),@$rate->data);

//        echo '<pre>';
//        var_dump($data);
//        echo '</pre>';
//        die();
        return json_encode(array_values($data));
    }

    public function actionSetgift(){
        $post = Yii::$app->request->post();
        $posParent = \Yii::$app->session->get('pos_parent');

        $nameAPI = 'cms/gen_code';
        $apiPath = Yii::$app->params['CMS_API_PATH_SHORT'];

        $param = array(
        );

        $headers = array();
        $headers[] = 'access_token: ' . Yii::$app->params['ACCESS_TOKEN'];
        $result = self::getApiByMethod($nameAPI, $apiPath, $param, $headers, 'POST');
//        echo '<pre>';
//        var_dump($apiPath);
//        echo '</pre>';
//        die();

        if(isset($result->data)){
            $voucherModel = new Dmvoucherlog();
            $voucherModel->VOUCHER_CODE = $result->data;
            $voucherModel->VOUCHER_CAMPAIGN_ID = 0;
            $voucherModel->VOUCHER_CAMPAIGN_NAME = 'Hệ thống '. $posParent.' tặng phiếu giảm giá';

            $voucherModel->POS_PARENT = $posParent;

            $voucherModel->POS_ID = 0;

            $voucherModel->DATE_CREATED = date('Y-m-d H:i:s');
            $voucherModel->DATE_START = date('Y-m-d H:i:s');
            $voucherModel->DATE_END = date('Y-m-d 23:59:59', strtotime('+1 month'));
            $voucherModel->DATE_HASH = date('Ymd');

            $voucherModel->AMOUNT_ORDER_OVER = 0;

            $voucherModel->DISCOUNT_TYPE = $post['campain_discount_type'];

            $posParentModelSearch = new DmposparentSearch();
            $posParentModel = $posParentModelSearch->searchPosparentById($posParent);

            if($voucherModel->DISCOUNT_TYPE == 1){
                $voucherModel->DISCOUNT_AMOUNT = $post['campain_discount'];
                $voucherModel->VOUCHER_DESCRIPTION = @$posParentModel->NAME.' tặng bạn mã giảm giá '.number_format($voucherModel->DISCOUNT_AMOUNT).'đ trên toàn bộ hóa đơn cho lần ăn tiếp theo. Mã VC: '.$voucherModel->VOUCHER_CODE.' . HSD: '.date(Yii::$app->params['DATE_FORMAT'],strtotime($voucherModel->DATE_END)).'. Xin cảm ơn!';
            }else{
                $voucherModel->DISCOUNT_EXTRA = $post['campain_discount']/100;
                $voucherModel->VOUCHER_DESCRIPTION = @$posParentModel->NAME.' tặng bạn mã giảm giá '.$post['campain_discount'].'% trên toàn bộ hóa đơn cho lần ăn tiếp theo. Mã VC: '.$voucherModel->VOUCHER_CODE.' . HSD: '.date(Yii::$app->params['DATE_FORMAT'],strtotime($voucherModel->DATE_END)).'. Xin cảm ơn!';
            }

            $voucherModel->IS_ALL_ITEM = 1;
            $voucherModel->ITEM_TYPE_ID_LIST = '';

            $voucherModel->STATUS = 4;
            $voucherModel->BUYER_INFO = $post['member_id'];
            $voucherModel->AFFILIATE_ID = 0;
            $voucherModel->save();

            if($voucherModel->save()){

                $nameAPI = 'sendmt';
                $apiPath = Yii::$app->params['CMS_API_PATH'];

                $param = array(
                    'msisdn' => $voucherModel->BUYER_INFO,
                    'content' => $voucherModel->VOUCHER_DESCRIPTION
                );

                $headers = array();
                $headers[] = 'access_token: ' . Yii::$app->params['ACCESS_TOKEN'];

                $sendSms = self::getApiByMethod($nameAPI, $apiPath, $param, $headers, 'POST');
                if(isset($sendSms->data)){
                    return 'Đã tạo thành công voucher và đã gửi tin nhắn tới người dùng';
                }else{
                    return 'Đã tạo thành công voucher nhưng chưa nhắn tin được tới người dùng';
                }
            }else{
                return false;
            }
        }

        return true;
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


    public function actionMemberdetail($data_table){

        return $this->render('memberdetail1', [
            'data' => $data_table,
        ]);
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

    protected function findModel($id)
    {
        if (($model = Orderonlinelog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



}
