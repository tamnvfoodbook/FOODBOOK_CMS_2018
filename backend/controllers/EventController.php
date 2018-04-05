<?php

namespace backend\controllers;


use backend\models\DmposparentSearch;
use backend\models\DmposSearch;
use backend\models\DmuserpartnerSearch;
use backend\models\Event;
use backend\models\EventSearch;

use Yii;

use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\ApiController;
use yii\helpers\Json;

/**
 * BookingonlineController implements the CRUD actions for Bookingonlinelog model.
 */
class EventController extends Controller
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
     * Lists all Bookingonlinelog models.
     * @return mixed
     */
    public function actionIndex($triggername)
    {
        $searchModel = new EventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$triggername);
        return $this->render($triggername, [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'triggername' => $triggername,
        ]);
    }

    public function actionMemberchange()
    {
        $searchModel = new EventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,'membership_card_changed');
        return $this->render('membership_card_changed', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReport($dateTime = null)
    {
        $partnerSearch = new DmuserpartnerSearch();
        $partner = $partnerSearch->searchAllPartner();
        $partnerMap = ArrayHelper::map($partner,'ID','PARTNER_NAME');

        $posParentSearch = new DmposparentSearch();
        $posparent = $posParentSearch->searchAllParent();
        $posparentMap = ArrayHelper::map($posparent,'ID','ID');

        $posSearchModel = new DmposSearch();
        $dmPos = $posSearchModel->searchAllPos();
        $allPosMap = ArrayHelper::map($dmPos,'ID','POS_NAME');
        $posMapWithParent = ArrayHelper::map($dmPos,'ID','POS_NAME','POS_PARENT');

        $searchModel = new CommissionSearch();
        $dataProvider = $searchModel->searchReport(Yii::$app->request->queryParams,$dateTime);

//        die();

        return $this->render('report',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'partnerMap' => $partnerMap,
            'posparentMap' => $posparentMap,
            'allPosMap' => $allPosMap,
            'dateTime' => $dateTime,
            'posMapWithParent' => $posMapWithParent,
        ]);
    }


    public function actionDetailorder($id)
    {
        /*$commission = \Yii::$app->session->get('commission_report');
        foreach($commission as $value){
            if($value['Id'] == $id){
//                $model = $value;
                $model = json_decode(json_encode((object) $value), FALSE);
                break;
            }
        }*/

        $model = $this->findModel($id);

        date_default_timezone_set('Asia/Bangkok');

        // Tính Amount
        $sale = 0;
        $discounItem = 0;

        foreach((array)$model->order_data_item as $item){
            if(@$item['mDiscount']){
                $discounItem = $item['Price']*$item['Quantity']*$item['mDiscount'] + $discounItem;
            }

            $sale = ($item['Price']*$item['Quantity']) + $sale;
        }

        $model->amount = $sale;

        $discountVoucher = 0;
        $discount = 0;
        if(@$model->voucher['discount_type']){
            $discountVoucher = $model->voucher['used_discount_amount'];
        }else{

            if(@$model->discount_extra){
                $discount = $model->discount_extra*$sale;
            }

            if(@$model->discount_extra_amount){
                $discount = $model->discount_extra_amount;
            }
        }

        if($model->voucher['only_coupon'] == 1){
            $discounItem = 0;
            $discount = 0;
        }

        $model->discount_items = $discounItem;

        $discount = $discount + $discountVoucher + $discounItem;
        $total = $sale - $discount;
        $total = $total + @$model->service_charge*$total;
        $model->total_amount = $total + $total*$model->vat_tax_rate;


//        $model->total_amount = $total + $model->ship_price_real;   Không tính phí ship


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
            $model->ship_price_real = number_format($model->ship_price_real,0);
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
            $model->ship_price_real = number_format($model->delivery_partner_info['ship_fee'],0);
            $model->distance = number_format($model->delivery_partner_info['distance'],2);
        }

//        echo '<pre>';
//        var_dump($listItem);
//        echo '</pre>';
//        die();


        return $this->render('../orderonlinelog/view', [
            'model' => $model,
        ]);
    }


    /**
     * Displays a single Bookingonlinelog model.
     * @param integer $_id
     * @return mixed
     */


    /**
     * Creates a new Bookingonlinelog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($triggername)
    {
        $model = new Event();
        $model->trigger_name = $triggername;
        $membershipsMap =array();

        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];
        $apiName = 'ipcc/filter_campaign';
        $pos_parent = \Yii::$app->session->get('pos_parent');

        $param = [
            'pos_parent' => $pos_parent,
            'active' => 1,
            'filter_expired' => 1,
        ];

        $campagin = ApiController::getObjDataFromApi($apiPath,$apiName,$param);

        if($triggername == 'membership_card_changed'){
            $apiName = 'ipcc/get_membership_types';
            $pos_parent = \Yii::$app->session->get('pos_parent');

            $param = [
                'pos_parent' => $pos_parent,
            ];

            $memberships = ApiController::getObjDataFromApi($apiPath,$apiName,$param);
            $membershipsMap = ArrayHelper::map($memberships->data,'Membership_Type_Id','Membership_Type_Name');
        }

        $campaginMap = array();
        if(@$campagin->data){
            foreach($campagin->data as $cam){
                $campaginMap[$cam->id] = $cam->id.' - '.$cam->voucher_campaign_name;
            }
//            $campaginMap = ArrayHelper::map($campagin->data,'id','voucher_campaign_name');
        }

        if ($model->load(Yii::$app->request->post())) {
            $apiName = 'ipcc/create_trigger_event';
            $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];
            if($model->trigger_time){
                $trigger_time_send = [
                    'remind_before_day' => $model->trigger_pre
                ];
            }else{
                $trigger_time_send = [
                    'remind_before_day' => 0
                ];
            }

            $data = [
                'trigger_name' => $model->trigger_name,
                'trigger_message' => $model->trigger_message,
                'pos_parent' => $pos_parent,
                'active' => 1,
                'send_via_sms' => (int)$model->send_via_sms,
                'send_via_zalo' => (int)$model->send_via_zalo,
                'send_via_facebook' => (int)$model->send_via_facebook,
                'created_at' => date(Yii::$app->params['DATE_TIME_FORMAT_3']),
            ];

            if($model->trigger_type){
                $data['trigger_voucher_campaign'] = $model->trigger_voucher_campaign;
            }

            if($model->trigger_name == 'birthday'){
                $data['trigger_birthday'] = $trigger_time_send;
            }elseif($model->trigger_name == 'membership_card_changed'){
                $trigger_membership_card_changed = [
                    'card_before' => $model->card_before,
                    'card_after' => $model->card_after
                ];
                $data['trigger_membership_card_changed'] = $trigger_membership_card_changed;
            }elseif($model->trigger_name == 'remind_voucher'){
                $data['trigger_remind_voucher'] = $trigger_time_send;
            }elseif($model->trigger_name == 'membership_money_spent'){
                $trigger_membership_money_spent = [
                    'spent_than' => $model->trigger_pre,
                ];
                $data['trigger_membership_money_spent'] = $trigger_membership_money_spent;
            }elseif($model->trigger_name == 'remind_return'){
                $trigger_remind_return = [
                    'remind_before_day' => $model->trigger_pre,
                ];
                $data['trigger_remind_return'] = $trigger_remind_return;
            }elseif($model->trigger_name == 'bill_printed'){
                $trigger_bill_printed = [
                    'min_amount' => $model->min_amount,
                    'max_amount' => $model->max_amount,
                ];
                $data['trigger_bill_printed'] = $trigger_bill_printed;
            }


            $add = ApiController::postObjDataFromApi($apiPath,$apiName,$data);

            /*echo '<pre>';
            var_dump($add);
            echo '</pre>';
            die();*/

            if(isset($add->data)){
                Yii::$app->session->setFlash('success', 'Thêm thành công');
                return $this->redirect(['index','triggername' => $triggername]);
            }else{
                if(isset($add->error)){
                    Yii::$app->session->setFlash('error', 'Thêm lỗi '.@$add->error->message);
                }else{
                    Yii::$app->session->setFlash('error', 'Lỗi kết nối máy chủ');
                }

                return $this->render('_form_birthday', [
                    'model' => $model,
                    'campaginMap' => $campaginMap,
                ]);
            }

        } else {

            return $this->render('_form_birthday', [
                'model' => $model,
                'campaginMap' => $campaginMap,
                'membershipsMap' => $membershipsMap,
            ]);
        }
    }



    public function actionSelectpos(){
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $param1 = null;
                $param2 = null;
                if (!empty($_POST['depdrop_params'])) {
                    $params = $_POST['depdrop_params'];
                    $param1 = $params[0]; // get the value of input-type-1
                    $param2 = $params[1]; // get the value of input-type-2
                }

                $out = self::getSubCatList1($cat_id, $param1, $param2);
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


                //$selected = self::getDefaultSubCat($cat_id);
                //$selected
                // the getDefaultSubCat function will query the database
                // and return the default sub cat for the cat_id

                echo Json::encode(['output'=>$out, 'selected'=>'']);
                //echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    public function getSubCatList1($pos_parent, $param1, $param2){
        $data = NULL;

        $searchItem = new DmposSearch();
        $allPos = $searchItem->searchAllPosByPosParent($pos_parent);
        /*$allItemMap = ArrayHelper::map($allItem,'ID','ITEM_NAME');
        echo '<pre>';
        var_dump($allItem);
        echo '</pre>';
        die();*/

        foreach($allPos as $key => $value){
            $data[] = ['id' => $value['ID'], 'name' => $value['POS_NAME']];
        }


        /*$data = [
                ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
                ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
            ];*/
        return $data;
    }

    /**
     * Updates an existing Bookingonlinelog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];
        $comments_in_rate = 'ipcc/get_list_commission';
        $param = array(
//            'pos_parent' => 'FOODBOOK',
//            'partner_id' => $dateEnd,
//            'pos_id' => $page
        );
        $model = new Commission();
        $comment = ApiController::getDataFromApi($apiPath,$comments_in_rate,$param);

        foreach((array)$comment as $data){
            if($data['id'] == $id){
                $model->_id = $data['id'];
                $model->commission_rate = $data['commission_rate']*100;
            }
        }

        if ($model->load(Yii::$app->request->post())){

            $comments_in_rate = 'ipcc/update_commission';
            $param = array(
                'commission_rate' => $model->commission_rate/100,
                'id' => $model->_id,
            );

            $update = ApiController::getDataFromApi($apiPath,$comments_in_rate,$param);

            if($update == 1){
                Yii::$app->session->setFlash('success', 'Sửa thành công');
                return $this->redirect(['view', 'id' => $model->_id ]);
            }else{
                Yii::$app->session->setFlash('error', 'Cập nhật lỗi '.$update);
                return $this->render('update', [
                    'model' => $model,
                ]);
            }




        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionView($id)
    {

        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];
        $comments_in_rate = 'ipcc/get_list_commission';
        $param = array(
//            'pos_parent' => 'FOODBOOK',
//            'partner_id' => $dateEnd,
//            'pos_id' => $page
        );
        $model = new Commission();
        $commision = ApiController::getDataFromApi($apiPath,$comments_in_rate,$param);

        foreach((array)$commision as $data){
            if($data['id'] == $id){
                $model->_id= $data['id'];
                $model->commission_rate = $data['commission_rate']*100;
                $model->partner_id = $data['partner_id'];
                $model->partner_name = $data['partner_name'];
                $model->pos_parent = $data['pos_parent'];
                $model->pos_id = $data['pos_id'];
                $model->pos_name = $data['pos_name'];
                $model->created_at = $data['created_at'];
                $model->updated_at = @$data['updated_at'];
            }
        }



        return $this->render('view', [
            'model' => $model,
        ]);
    }



    /**
     * Deletes an existing Bookingonlinelog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];
        $apiName = 'ipcc/delete_trigger_event';

        $param = [
            'trigger_id' => $id,
        ];

        $delete = ApiController::getObjDataFromApi($apiPath,$apiName,$param);
        echo '<pre>';
        var_dump($delete);
        echo '</pre>';
        die();


        return $this->redirect(['index']);
    }

    public function actionCancel($id,$trigger_name)
    {
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];
        $apiName = 'ipcc/delete_trigger_event';

        $param = [
            'trigger_id' => $id,
        ];

        $delete = ApiController::getObjDataFromApi($apiPath,$apiName,$param);

        if(isset($delete->data)){
            Yii::$app->session->setFlash('success', 'Hủy thành công');
            return $this->redirect(['index','triggername' => $trigger_name]);
        }else{
            if(isset($delete->error)){
                Yii::$app->session->setFlash('error', 'Hủy lỗi '.@$delete->error->message);
            }else{
                Yii::$app->session->setFlash('error', 'Lỗi kết nối máy chủ');
            }
            return $this->redirect(['index','triggername' => $trigger_name]);
        }



    }

    /**
     * Finds the Bookingonlinelog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return Bookingonlinelog the loaded model
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
}
