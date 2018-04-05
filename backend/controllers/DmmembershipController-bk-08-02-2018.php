<?php

namespace backend\controllers;

use backend\models\DmcitySearch;
use backend\models\Dmevent;
use backend\models\DmeventSearch;
use backend\models\Dmmembershiptype;
use backend\models\Dmmembershiptyperelate;
use backend\models\DmmembershiptyperelateSearch;
use backend\models\DmmembershiptypeSearch;
use backend\models\DmposparentSearch;
use backend\models\Dmvouchercampaign;
use backend\models\UserSearch;
use Yii;
use backend\models\Dmmembership;
use backend\models\DmmembershipSearch;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DmmembershipController implements the CRUD actions for Dmmembership model.
 */
class DmmembershipController extends Controller
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
     * Lists all Dmmembership models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DmmembershipSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort(false);

        $searchCityModel = new DmcitySearch();
        $allCity = $searchCityModel->searchAllCity();
        $allCityMap = ArrayHelper::map($allCity,'CITY_NAME','CITY_NAME');

        $groupMember = Yii::$app->params['groupMember'];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'allCityMap' => $allCityMap,
            'groupMember' => $groupMember,
        ]);
    }


    public function actionReport1()
    {

        if(!isset(Yii::$app->request->queryParams['DmmembershipSearch']['created_at'])){
            $timeRanger = date('d/m/Y',strtotime("-1 week")).' - '.date('d/m/Y');
        }else{
            $timeRanger = Yii::$app->request->queryParams['DmmembershipSearch']['created_at'];
        }

        $searchModel = new DmmembershipSearch();
//        $allMember = $searchModel->seachAllPhoneByPospent();
//        $allMemberMap = ArrayHelper::map($allMember,'ID','MEMBER_NAME');
//        $allMemberMapPhone = array();
//        foreach((array)$allMember as $value){
//            if($value['MEMBER_NAME']){
//                $allMemberMapPhone[$value['ID']] = $value['MEMBER_NAME'].' '.$value['ID'];
//            }else{
//                $allMemberMapPhone[$value['ID']] = $value['ID'];
//            }
//
//        }

        $dataProvider = new ArrayDataProvider([

        ]);
        $model = new Dmevent();
        $modelCampagin = new Dmvouchercampaign();
        $eventModelSeach = new DmeventSearch();
        $data = $eventModelSeach->searchByApi(Yii::$app->request->queryParams);
        $dataProvider->allModels = @$data->data;
        $dataProvider->totalCount = @$data->is_next;

        $paramData = $eventModelSeach->searchParam(Yii::$app->request->queryParams);

        $paramData['data']['expected_approach'] = count($dataProvider->allModels);

//        echo '<pre>';
//        var_dump($paramData);
//        echo '</pre>';
//        die();

        $apiName = 'ipcc/get_campaign_event';
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];

        $paramGetCampaign = array();

        $campagins = ApiController::getApiByMethod($apiName,$apiPath,$paramGetCampaign,'GET');

//        echo '<pre>';
//        var_dump($campagins);
//        echo '</pre>';
//        die();


        $campaginsMap = array();
        if(isset($campagins->data) && count($campagins->data) >0){
            $campaginsMap = ArrayHelper::map($campagins->data,'id','voucher_campaign_name');
        }

        $groupMember = Yii::$app->params['groupMember'];

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();

            $preData = json_decode($post['predata'],true);

//            echo '<pre>';
//            var_dump($preData);
//            echo '</pre>';
//            die();

            if(@$post['check_in_week']){
                $preData['is_filter_member'] = 1;
            }

            if($model->EVENT_TYPE ==1){
                $model->CONTENT_MESSAGE = $post['sms-for-voucher'];
            }
            $preData['event_name'] = $model->EVENT_NAME;
            $preData['date_start'] = date('Y-m-d H:i:s',strtotime($model->DATE_START));
            $preData['campaign_id'] = $model->CAMPAIGN_ID;
            $preData['content_message'] = $model->CONTENT_MESSAGE;
            $preData['send_type'] = $model->SEND_TYPE;
            $preData['event_type'] = $model->EVENT_TYPE;

//            echo '<pre>';
//            var_dump($preData);
////            var_dump($post);
//            echo '</pre>';
//            die();


            $apiName = 'ipcc/create_event';
            $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];


            $data = ApiController::getApiByMethod($apiName,$apiPath,$preData,'POST');

            if(isset($data->data)){
                Yii::$app->session->setFlash('success', 'Tạo sự kiện '.$model->EVENT_NAME.' thành công');
//                return $this->redirect(['report']);
                return $this->redirect(['dmevent/report','DmeventSearch[EVENT_TYPE]' => $model->EVENT_TYPE ]);
            }else{
                if(isset($data->error)){
                    Yii::$app->session->setFlash('error', 'Tạo sự kiện lỗi '.@$data->error->message);
                }else{
                    Yii::$app->session->setFlash('error', 'Lỗi kết nối máy chủ');
                }
                return $this->render('report', [
                    'searchModel' => $eventModelSeach,
                    'timeRanger' => $timeRanger,
                    'dataProvider' => $dataProvider,
                    'groupMember' => $groupMember,
//                    'allMemberMap' => $allMemberMap,
//                    'allMemberMapPhone' => $allMemberMapPhone,
                    'model' => $model,
                    'campaginsMap' => $campaginsMap,
                    'paramData' => $paramData['data'],
                ]);

                return $this->redirect(['dmevent/report']);
            }

        }else{


            return $this->render('report1', [
                'searchModel' => $eventModelSeach,
                'timeRanger' => $timeRanger,
                'dataProvider' => $dataProvider,
                'groupMember' => $groupMember,
                'allMemberMap' => $allMemberMap,
//                'allMemberMapPhone' => $allMemberMapPhone,
                'model' => $model,
                'campaginsMap' => $campaginsMap,
                'paramData' => $paramData['data'],
            ]);
        }

    }


    public function actionReport()
    {

        $model = new Dmevent();
        $posparent = Yii::$app->session->get('pos_parent');
        $posparentSearchModel = new DmposparentSearch();
        $posparentModel = $posparentSearchModel->searchPosparentById($posparent);

        $eventModelSeach = new DmeventSearch();
        $dataProvider = $eventModelSeach->searchByModel(Yii::$app->request->queryParams);
//        echo '<pre>';
//        var_dump($dataProvider);
//        echo '</pre>';
//        die();

        /*$data = $eventModelSeach->searchByApi(Yii::$app->request->queryParams,$page);
        $dataProvider->allModels = @$data->data;
        $dataProvider->totalCount = @$data->is_next;*/

        $paramData = $eventModelSeach->searchParam(Yii::$app->request->queryParams);

        $memberTypeSearch = new DmmembershiptypeSearch();
        $memberTypeArr = $memberTypeSearch->allType($posparent);
        $allMemberTypeMap = ArrayHelper::map($memberTypeArr,'MEMBERSHIP_TYPE_ID','MEMBERSHIP_TYPE_NAME');

        /*echo '<pre>';
        var_dump($memberTypeArr);
        echo '</pre>';
        die();*/

//        $paramData['data']['expected_approach'] = count($dataProvider->allModels);

//        echo '<pre>';
//        var_dump($dataProvider);
//        echo '</pre>';
//        die();

        $apiName = 'ipcc/get_campaign_event';
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];

        $paramGetCampaign = array();

        $campagins = ApiController::getApiByMethod($apiName,$apiPath,$paramGetCampaign,'GET');

//        echo '<pre>';
//        var_dump($campagins);
//        echo '</pre>';
//        die();


        $campaginsMap = array();
        if(isset($campagins->data) && count($campagins->data) >0){
            $campaginsMap = ArrayHelper::map($campagins->data,'id','voucher_campaign_name');
        }

        $groupMember = Yii::$app->params['groupMember'];

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();

            $preData = json_decode($post['predata'],true);

            if(@$post['check_in_week']){
                $preData['is_filter_member'] = 1;
            }

            if($model->EVENT_TYPE ==1){
                $model->CONTENT_MESSAGE = $post['sms-for-voucher'];
            }
            $preData['event_name'] = $model->EVENT_NAME;
            $preData['date_start'] = date('Y-m-d H:i:s',strtotime($model->DATE_START));
            $preData['campaign_id'] = $model->CAMPAIGN_ID;
            $preData['content_message'] = $model->CONTENT_MESSAGE;
            $preData['send_type'] = $model->SEND_TYPE;
            $preData['event_type'] = $model->EVENT_TYPE;

//            echo '<pre>';
//            var_dump($preData);
////            var_dump($post);
//            echo '</pre>';
//            die();


            $apiName = 'ipcc/create_event';
            $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];


            $data = ApiController::getApiByMethod($apiName,$apiPath,$preData,'POST');

            if(isset($data->data)){
                Yii::$app->session->setFlash('success', 'Tạo sự kiện '.$model->EVENT_NAME.' thành công');
//                return $this->redirect(['report']);
                return $this->redirect(['dmevent/report','DmeventSearch[EVENT_TYPE]' => $model->EVENT_TYPE ]);
            }else{
                if(isset($data->error)){
                    Yii::$app->session->setFlash('error', 'Tạo sự kiện lỗi '.@$data->error->message);
                }else{
                    Yii::$app->session->setFlash('error', 'Lỗi kết nối máy chủ');
                }
                return $this->render('report', [
                    'searchModel' => $eventModelSeach,
                    'dataProvider' => $dataProvider,
                    'groupMember' => $groupMember,
                    'posparentModel' => $posparentModel,
//                    'allMemberMap' => $allMemberMap,
//                    'allMemberMapPhone' => $allMemberMapPhone,
                    'model' => $model,
                    'campaginsMap' => $campaginsMap,
                    'paramData' => $paramData['data'],
                    'allMemberTypeMap' => $allMemberTypeMap,
                ]);

                return $this->redirect(['dmevent/report']);
            }

        }else{


            return $this->render('report', [
                'searchModel' => $eventModelSeach,
                'dataProvider' => $dataProvider,
                'groupMember' => $groupMember,
                'posparentModel' => $posparentModel,
//                'allMemberMapPhone' => $allMemberMapPhone,
                'model' => $model,
                'campaginsMap' => $campaginsMap,
                'paramData' => $paramData['data'],
                'allMemberTypeMap' => $allMemberTypeMap
            ]);
        }

    }


    public function validatePhone($string) {
        $number = str_replace(array('-', '.', ' '), '', $string);
        if (!preg_match('/^(01[2689]|09)[0-9]{8}$/', $number)){
            return false;
        }else{
            return true;
        }
    }

    function validateGender($variable)
    {
        if($variable){
            if(is_numeric($variable) == true && $variable > -2 && $variable < 2){
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }

    }

    function validateDate($variable)
    {
        $test_arr  = explode('/', $variable);
        if (count($test_arr) == 3) {
            if (checkdate($test_arr[1], $test_arr[0], $test_arr[2])) {
                return true;
                // valid date ...
            } else {
                return false;
                // problem with dates ...
            }
        } else {
            // problem with input ...
            return false;
        }
    }

    public function actionImportexcel()
    {
        $model = new Dmevent();
        $tmp = 0;

        if (\yii\web\UploadedFile::getInstance($model, 'ID')) {
            $fileImage = \yii\web\UploadedFile::getInstance($model, 'ID');

            $objPHPExcel = \PHPExcel_IOFactory::load($fileImage->tempName);
            $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);


            if($sheetData){
                $memberData = array();
                $tmp = 0;
                foreach ($sheetData as $key => $data) {
                    if ($key > 1) {
                        /*if(self::validatePhone($data['A']) == false){
                            Yii::$app->session->setFlash('error', 'Số điện thoại chưa đúng định dạng - Dòng : '.$key);
                            return $this->redirect(['report']);
                        }*/
                        if(!$data['A']){
                            Yii::$app->session->setFlash('error', 'Số điện thoại không được để trống - Dòng : '.$key);
                            return $this->redirect(['report']);
                        }

                        if(self::validateGender($data['C']) == false){
                            Yii::$app->session->setFlash('error', 'Giới tính chưa đúng định dạng kiểu số  và trong 3 giá trị (-1) Không xác định, (0) Nữ, (1) Nam"  Dòng : '.$key);
                            return $this->redirect(['report']);
                        }

                        /*if(self::validateDate($data['D']) == false){
                            Yii::$app->session->setFlash('error', 'Ngày chưa đúng định dạng dữ liệu Ngày/Tháng/Năm - Dòng : '.$key);
                            return $this->redirect(['report']);
                        }*/
                        if($data['E']){
                            if(!is_numeric($data['E'])){
                                Yii::$app->session->setFlash('error', 'Số lần ăn chưa đúng định dạng dữ liệu kiểu số   - Dòng : '.$key);
                                return $this->redirect(['report']);
                            }
                        }

                        if($data['F']){
                            if(!is_numeric($data['F'])){
                                Yii::$app->session->setFlash('error', 'Số tiền trả chưa đúng định dạng dữ liệu kiểu số - Dòng : '.$key);
                                return $this->redirect(['report']);
                            }
                        }
                        if($data['G']){
                            if (!is_numeric($data['G'])) {
                                Yii::$app->session->setFlash('error', 'Số điểm chưa đúng định dạng dữ liệu kiểu số - Dòng : ' . $key);
                                return $this->redirect(['report']);
                            }
                        }
                        if($data['H']){
                            if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ]/', $data['H']))
                            {
                                Yii::$app->session->setFlash('error', 'Hạng hội viên không được sử dụng kí tự đặc biệt và chữ có dấu- Dòng : ' . $key);
                                return $this->redirect(['report']);
                                // one or more of the 'special characters' found in $string
                            }
                        }


                        $phone = '';
                        if($data['A']){
                            $phone = $data['A'];
                        }
                        $name = '';
                        if($data['B']){
                            $name = $data['B'];
                        }

                        $gender = -1;
                        if($data['C']){
                            $gender = $data['C'];
                        }
                        $birthday = '';
                        if($data['D']){
                            $birthday = $data['D'];
                        }
                        $eat_count = 0;
                        if($data['E']){
                            $eat_count = $data['E'];
                        }
                        $pay_amount = 0;
                        if($data['F']){
                            $pay_amount = $data['F'];
                        }
                        $point = 0;
                        if($data['G']){
                            $point = $data['G'];
                        }
                        $membership_type_relate = '';
                        if($data['H']){
                            $membership_type_relate = $data['H'];
                        }

                        $address = '';
                        if($data['I']){
                            $address = @$data['I'];
                        }


                        $memberData[] = [
                            'phone' => $phone,
                            'name' => $name,
                            'gender' => $gender,
                            'birthday' => $birthday,
                            'eat_count' => $eat_count,
                            'pay_amount' => $pay_amount,
                            'point' => $point,
                            'address' => $address,
                            'membership_type_relate' => $membership_type_relate,
                        ];

//                        echo '<pre>';
//                        var_dump(json_encode($memberData));
//                        echo '</pre>';
//                        die();

                        $tmp++;
                    }

                }

                $param = [
                    'pos_parent' => \Yii::$app->session->get('pos_parent'),
                    'type' => 1,
                    'data_json' => json_encode($memberData)
                ];

                $apiName = 'ipcc/import_data';
                $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];
                $dataCustommer = ApiController::getApiByMethod($apiName,$apiPath,$param,'POST');
                if(isset($dataCustommer->data)){
                    Yii::$app->session->setFlash('success', 'Thêm ' . $tmp . ' khách hàng thành công');
                }else{
                    Yii::$app->session->setFlash('error', @$dataCustommer->error->message);
                }

                return $this->redirect(['report']);
            }else{
                Yii::$app->session->setFlash('error', "Thêm khách hàng lỗi - File excel không không có dữ liệu ");
                return $this->redirect(['report']);
            }
        }

//        Yii::$app->session->setFlash('success', 'Thêm ' . $tmp . ' món thành công');
//        return $this->redirect(['view', 'id' => $posId]);

    }

    /**
     * Displays a single Dmmembership model.
     * @param string $id
     * @return mixed
     */
    public function actionSendgiftzalo()
    {
        $post = Yii::$app->request->post();

        $param = [
            'phone_number' => $post['phone'],
            'zalo_id' => $post['zaloId'],
            'message' => $post['smscontent'],
            'send_type' => $post['typeGift']
        ];

        $apiName = 'ipcc/send_message_cskh';
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];
        $result = ApiController::getApiByMethod($apiName,$apiPath,$param,'POST');

//        echo '<pre>';
//        var_dump($result);
//        echo '</pre>';
//        die();

        if(isset($result->data)){
            $data =  ['status'=> 1, 'message' => 'Tặng thành công'];
        }else{
            if(@$result->error->message){
                $mess = @$result->error->message;
            }else{
                $mess = 'Lỗi kết nối server ';
            }
            $data =  ['status'=> 0, 'message' => $mess];
        }
        return json_encode($data);

    }
    public function actionPushmess()
    {

        $post = Yii::$app->request->post();

        $preData = json_decode($post['preData']);
        if(isset($preData->phone)){
            $list_phone = $preData->phone;
        }else{
            $eventModelSeach = new DmeventSearch();
            $dataUser = $eventModelSeach->searchModelByArrayParam($preData);
            $list_phone = NULL;
            foreach((array)$dataUser as $value){
                if($list_phone){
                    $list_phone = $list_phone.','.$value['ID'];
                }else{
                    $list_phone = $value['ID'];
                }
            }
        }

        if(@$post['phone']){
            $list_phone = @$post['phone'];
        }

        $param = [
            'phone_numbers' => $list_phone,
            'message' => @$post['messPushApp'],
            'url' => @$post['urlPushApp'],
        ];

        $apiName = 'ipcc/push_notify_app';
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];
        $result = ApiController::getApiByMethod($apiName,$apiPath,$param,'POST');



        if(isset($result->data)){
            $data =  ['status'=> 1, 'message' => 'Gửi thông báo thành công'];
        }else{
            if(@$result->error->message){
                $mess = @$result->error->message;
            }else{
                $mess = 'Lỗi kết nối server ';
            }
            $data =  ['status'=> 0, 'message' => $mess];
        }
        return json_encode($data);

    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Dmmembership model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dmmembership();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Dmmembership model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldModel = $model->oldAttributes;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            DmquerylogController::actionCreateLog('UPDATE',get_class($model),$oldModel,$model->attributes);
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Dmmembership model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        DmquerylogController::actionCreateLog('DELETE',get_class($model),$model->oldAttributes,null);

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Dmmembership model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Dmmembership the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dmmembership::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
