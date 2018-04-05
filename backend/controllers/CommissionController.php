<?php

namespace backend\controllers;
use backend\models\Commission;
use backend\models\CommissionSearch;
use backend\models\DmmembershipSearch;
use backend\models\DmpartnerSearch;
use backend\models\Dmpos;
use backend\models\DmposparentSearch;
use backend\models\DmposSearch;
use backend\models\Dmuserpartner;
use backend\models\DmuserpartnerSearch;
use backend\models\Orderonlinelog;
use Yii;
use backend\models\Bookingonlinelog;
use backend\models\BookingonlinelogSearch;
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
class CommissionController extends Controller
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
    public function actionIndex()
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

        $searchModel = new CommissionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,null);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'partnerMap' => $partnerMap,
            'posparentMap' => $posparentMap,
            'allPosMap' => $allPosMap,
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
//        $posMapWithParent = ArrayHelper::map($dmPos,'ID','POS_NAME','POS_PARENT');
        $posMapWithParent = ArrayHelper::map($dmPos,'ID','POS_NAME');

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
    public function actionCreate()
    {
        $model = new Commission();

        $partnerSearch = new DmuserpartnerSearch();
        $partner = $partnerSearch->searchAllPartner();
        $partnerMap = ArrayHelper::map($partner,'ID','PARTNER_NAME');

        $posParentSearch = new DmposparentSearch();
        $posparent = $posParentSearch->searchAllParent();
        $posparentMap = ArrayHelper::map($posparent,'ID','ID');

        $posSearchModel = new DmposSearch();
        $dmPos = $posSearchModel->searchAllPos();
        $allPosMap = ArrayHelper::map($dmPos,'ID','POS_NAME');


        if ($model->load(Yii::$app->request->post())) {

            $apiName = 'ipcc/create_commission';
            $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];

            $param = [
                'pos_parent' => $model->pos_parent,
                'pos_id' => $model->pos_id,
                'pos_name' => $allPosMap[$model->pos_id],
                'partner_id' => $model->partner_id,
                'partner_name' => $partnerMap[$model->partner_id],
                'commission_rate' => $model->commission_rate/100,
            ];

            $add = ApiController::postObjDataFromApi($apiPath,$apiName,$param,'POST');

            if(isset($add->data)){
                Yii::$app->session->setFlash('success', 'Thêm thành công');
                return $this->redirect(['index']);
            }else{
                if(isset($add->error)){
                    Yii::$app->session->setFlash('error', 'Thêm lỗi '.@$add->error->message);
                }else{
                    Yii::$app->session->setFlash('error', 'Lỗi kết nối máy chủ');
                }

                return $this->render('create', [
                    'model' => $model,
                    'partnerMap' => $partnerMap,
                    'posparentMap' => $posparentMap,
                    'allPosMap' => $allPosMap,
                ]);
            }

        } else {
            return $this->render('create', [
                'model' => $model,
                'partnerMap' => $partnerMap,
                'posparentMap' => $posparentMap,
                'allPosMap' => $allPosMap,
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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
