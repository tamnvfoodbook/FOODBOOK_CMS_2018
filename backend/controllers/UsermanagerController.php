<?php

namespace backend\controllers;

use app\components\LanguageSelector;
use backend\models\Dmitem;
use backend\models\DmitemSearch;
use backend\models\DmposparentSearch;
use backend\models\DmposSearch;
use common\models\LoginForm;
use Yii;
use backend\models\User;
use backend\models\Dmpos;
use backend\models\Dmposparent;
use backend\models\UserSearch;
use yii\data\ArrayDataProvider;
use yii\helpers\FormatConverter;
use yii\helpers\Json;
use yii\rbac\Assignment;
use yii\rbac\DbManager;
use yii\web\Cookie;
use yii\web\Response;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use linslin\yii2\curl;
use backend\controllers\ApiController;

/**
 * UsermanagerController implements the CRUD actions for User model.
 */
class UsermanagerController extends Controller
{
    public $content = 'Foodbook: Ma reset mat khau cua ban la:';

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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort(false);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLalauser()
    {

        self::checkAccessToken();

        $searchModel = new UserSearch();
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS_MOBILE'];
        $name = 'manager/list_manager';
        $param = array();

        $user = ApiController::getLalaApiByMethod($name,$apiPath,$param,'GET');

        $dataProvider = new ArrayDataProvider([
            'allModels' => $user->data,
        ]);


        $type = \Yii::$app->session->get('type_acc');
        if($type == 3){
            return $this->render('index_submana', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }else{
            return $this->render('index_lala', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    function checkAccessToken(){
        $lalaAC = \Yii::$app->session->get('lala_user_token');
        if($lalaAC === NULL){
//            return $this->redirect(['lalalogin'],301)->send();
            $this->redirect(['lalalogin'],302);
            Yii::$app->response->send();
            return parent::beforeAction($lalaAC);

        }
    }


    public function actionLalalogin()
    {
        $model = new User();
        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            $param = [
                'pos_parent' => $model->POS_PARENT,
                'username' => $model->USERNAME,
                'password' => $model->PASSWORD_HASH,
            ];
            $apiPath = Yii::$app->params['CMS_API_PATH_IPOS_MOBILE'];
            $type = 'auth/manager_login';
            $access_token = Yii::$app->params['ACCESS_TOKEN_LALA'];
            $dataCode = ApiController::actionLalaLogin($param,$apiPath,$type,$access_token);

            if (isset($dataCode->data)) {
                \Yii::$app->session->set('lala_pos_parent',$dataCode->data->pos_parent);
                \Yii::$app->session->set('lala_type_acc',$dataCode->data->type);
                \Yii::$app->session->set('lala_username',$dataCode->data->username);
                \Yii::$app->session->set('lala_user_id',$dataCode->data->id);
                \Yii::$app->session->set('lala_user_token',$dataCode->data->token);
                return $this->goBack();

            }else{
                Yii::$app->session->setFlash('error', $dataCode->error->message );
                return $this->render('../dmpositem/login_lala', [
                    'model' => $model,
                ]);
            }

        } else {
            return $this->render('../dmpositem/login_lala', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $check = ExtendController::checkUserPermiswithPos($id);
        if($check){
            $model = $this->findModel($id);
            $posSearch = new DmposSearch();
            $model->POS_ID_LIST = $posSearch->searchPosNameListByListId($model->POS_ID_LIST);
            return $this->render('view', [
                'model' => $model,
            ]);
        }else{
            throw new NotFoundHttpException('Bạn không có quyển quản lý user này.');
        }
    }

    public function actionViewlala($id)
    {
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS_MOBILE'];
        $name = 'manager/list_manager';
        $param = array();

        $users = ApiController::getLalaApiByMethod($name,$apiPath,$param,'GET');
        foreach($users->data as $user){
            if($user->id == $id){
                $model = $user;
                break;
            }
        }

        if($user->type != 2){
            $posSearch = new DmposSearch();
            $model->pos_id_list = $posSearch->searchPosNameListByListId($model->pos_id_list);
        }

        return $this->render('view_lala', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        $posParentSession = \Yii::$app->session->get('pos_parent');
        $type = \Yii::$app->session->get('type_acc');

        $posSearchModel = new DmposSearch();
        $dmPos = $posSearchModel->searchAllPosByPosParent($posParentSession);
        $allPosMap = ArrayHelper::map($dmPos,'ID','POS_NAME');

        $posParentSearchModel = new DmposparentSearch();
        $dmPosParent = $posParentSearchModel->searchAllParent();
        $dmPosParent = ArrayHelper::map($dmPosParent,'ID','ID');

        if ($model->load(Yii::$app->request->post())) {

            //$post = Yii::$app->request->post();
            if(!$model->POS_PARENT){
                $model->POS_PARENT = $posParentSession;
            }

            if($model->POS_ID_LIST){
                $model->POS_ID_LIST = implode(",",$model->POS_ID_LIST);
            }
            if(!$model->MAX_POS_CREATE){
                $model->MAX_POS_CREATE = 3;
            }

            $model->CREATED_AT = date("Y-m-d H:i:s");
            $model->SOURCE = "FOODBOOK_CMS";


            $fisrtChar = substr($model->USERNAME,0,1); // Lấy kí tự đầu của chuỗi
            //Kiểm tra nếu đầu chuỗi là số 0 thì convert sang đầu 84
            if($fisrtChar === '0'){
                $model->USERNAME = self::format_number($model->USERNAME);
            }

            $password_generate = $model->USERNAME.$model->POS_PARENT.'YG4BQ0FYMD'.$model->newpass;

            $model->PASSWORD_HASH = Yii::$app->getSecurity()->generatePasswordHash($password_generate);
            $model->AUTH_KEY = Yii::$app->security->generateRandomString();


            if($model->save()){
                $dbManager = new DbManager();
                $role = new \stdClass();
                if($model->TYPE == 1){
                    $role->name = 'Super Admin';
                }else{
                    $role->name = 'Nhà hàng';
                }
                $dbManager->assign($role,$model->ID);
                return $this->redirect(['view', 'id' => $model->ID]);
            }else{
                return $this->redirect(['index']);
            }

//            $post = Yii::$app->request->post();
//            if(isset($post['optionPos'])){
//                $posList = implode(",",$post['optionPos']);
//            }else{
//                $posList = '';
//            }
//
//            $paramAddItem = [
//                'name' => $model->USERNAME,
//                'password' => $model->newpass,
//                'pos_id_list' => $posList,
//                'email' => $model->EMAIL,
//            ];
//
//            //Get Accetoken user
//            $apiPath = Yii::$app->params['CMS_API_PATH_IPOS_MOBILE'];
//
//
//            $access_token = Yii::$app->params['ACCESS_TOKEN'];
//            $user_token = \Yii::$app->session->get('user_token');
//            $name = 'manager/add_manager';
//
//            $headers = array();
//            $headers[] = 'access_token: '.$access_token;
//            $headers[] = 'token: '.$user_token;
//
//            $addItem = ApiController::getApiByMethod($name,$apiPath,$paramAddItem,$headers,'POST');
//
//            if(isset($addItem->data)){
//                Yii::$app->getSession()->setFlash('susscess',". Chúc mừng bạn đã tạo quản lý thành công ");
//                return $this->redirect(['index']);
//            }else{
//
//                Yii::$app->getSession()->setFlash('error', $addItem->error->message. ". Xin vui lòng thử lại");
//                return $this->redirect(['index']);
//            }

        } else {
            return $this->render('create', [
                'model' => $model,
                'allPosMap' => $allPosMap,
                'posParentSession' => $posParentSession,
                'type' => $type,
                'dmPosParent' => $dmPosParent,
            ]);
        }
    }


    public function actionCreatelala()
    {
        $model = new User();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        $posParentSession = \Yii::$app->session->get('lala_pos_parent');
        $type = \Yii::$app->session->get('type_acc');

        $dmPos= Dmpos::find()
            ->select(['ID','POS_NAME'])
            ->where(['POS_PARENT' => $posParentSession])
            ->asArray()
            ->all();
        $posMap = ArrayHelper::map($dmPos,'ID','POS_NAME');

        $dmPosParentObj = Dmposparent::find()
            ->select(['ID','DESCRIPTION'])
            ->asArray()
            ->all();
        $dmPosParent = ArrayHelper::map($dmPosParentObj,'ID','DESCRIPTION');

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            if(isset($post['optionPos'])){
                $posList = implode(",",$post['optionPos']);
            }else{
                $posList = '';
            }

            $paramAddItem = [
                'name' => $model->USERNAME,
                'password' => $model->newpass,
                'pos_id_list' => $posList,
                'email' => $model->EMAIL,
            ];

            //Get Accetoken user
            $apiPath = Yii::$app->params['CMS_API_PATH_IPOS_MOBILE'];
            $name = 'manager/add_manager';

            $addItem = ApiController::getLalaApiByMethod($name,$apiPath,$paramAddItem,'POST');

            if(isset($addItem->data)){
                Yii::$app->getSession()->setFlash('susscess',". Chúc mừng bạn đã tạo quản lý thành công ");
                return $this->redirect(['lalauser']);
            }else{

                Yii::$app->getSession()->setFlash('error', $addItem->error->message. ". Xin vui lòng thử lại");
                return $this->redirect(['create_lala']);
            }

        } else {
            return $this->render('create_lala', [
                'model' => $model,
                'posMap' => $posMap,
                'posParentSession' => $posParentSession,
                'type' => $type,
                'dmPosParent' => $dmPosParent,
            ]);
        }
    }

    //Convert SĐT local to internal
    static function format_number($number)
    {
        //make sure the number is actually a number
        if(is_numeric($number)){

            //if number doesn't start with a 0 or a 4 add a 0 to the start.
            if($number[0] != 0 && $number[0] != 4){
                $number = "0".$number;
            }

            //if number starts with a 0 replace with 8
            if($number[0] == 0){
                $number[0] = str_replace("0","4",$number[0]);
                $number = "8".$number;
            }

            //remove any spaces in the number
            $number = str_replace(" ","",$number);

            //return the number
            return $number;

            //number is not a number
        } else {

            //return nothing
            return false;
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())){
            if (isset($model->POS_ID_LIST) && is_array($model->POS_ID_LIST)) {
                //echo $model->pos_id_list;
                $model->POS_ID_LIST = implode(",",$model->POS_ID_LIST);
            }

            $model->UPDATED_AT = date( Yii::$app->params['DATE_TIME_FORMAT_3']);

//            echo '<pre>';
//            var_dump($model);
//            echo '</pre>';
//            die();

            //$model->MAX_POS_CREATE = (int)$model->MAX_POS_CREATE;
            //$model->ACTIVE = (int)$model->ACTIVE;
            DmquerylogController::actionCreateLog('UPDATE',get_class($model),$model->oldAttributes,$model->attributes);
            $model->save();
            return $this->redirect(['view', 
                'id' => $model->ID,
                ]);
        }else {
            $posParentSession = \Yii::$app->session->get('pos_parent');
            $type = \Yii::$app->session->get('type_acc');

            $userSearch = new UserSearch();
            $userData = $userSearch->searchAllUserById($id);
            $user = ArrayHelper::map($userData,'ID','USERNAME');

            $posSearch = new DmposSearch();
            $dmPos = $posSearch->searchAllPosByPosParent($model->POS_PARENT);
            $allPosMap = ArrayHelper::map($dmPos,'ID','POS_NAME');

            if($model->POS_ID_LIST){
                $dmPos = $posSearch->searchAllPosByListId($model->POS_ID_LIST);
                $model->POS_ID_LIST = ArrayHelper::map($dmPos,'ID','ID');
            }
//            echo '<pre>';
//            var_dump($model->POS_ID_LIST);
//            echo '</pre>';
//            die();

            $posparentSearch = new DmposparentSearch();
            $dmPosParrents = $posparentSearch->searchAllParent();
            $dmPosParent = ArrayHelper::map($dmPosParrents,'ID','ID');

            return $this->render('update', [
                'model' => $model,
                'user' => $user,
                'allPosMap' => $allPosMap,
                //'posMapChecked' => $posMapChecked,
                'dmPosParent' => $dmPosParent,
                'posParentSession' => $posParentSession,
                'type' => $type,
            ]);
        }
    }


    public function actionUpdatelala($id)
    {
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS_MOBILE'];
        $name = 'manager/list_manager';
        $param = array();
        $model = new User();

        $users = ApiController::getLalaApiByMethod($name,$apiPath,$param,'GET');
        foreach($users->data as $user){
            if($user->id == $id){
                $model->ID = $user->id;
                $model->USERNAME = $user->username;
                $model->EMAIL = $user->email;
                $model->POS_ID_LIST = @$user->pos_id_list;
                $model->ACTIVE = $user->active;
                $model->POS_PARENT = $user->pos_parent;
                $model->TYPE = $user->type;
                $model->PHONE_NUMBER = $user->phone_number;
                break;

            }
        }

        if ($model->load(Yii::$app->request->post())){
            $post = Yii::$app->request->post();

            if (isset($post['optionPos'])) {
                $model->POS_ID_LIST = implode(",",$post['optionPos']);
            }

            $itemData = [
                //'username' => $model->USERNAME,
                'pos_id_list' => $model->POS_ID_LIST,
                'email' => $model->EMAIL,
                'active' => $model->ACTIVE
            ];


            $updateData = ApiController::pmUpdateData($model->ID,$model->POS_ID_LIST,'DM_USER_MANAGER',$itemData);

            if(isset($updateData->data)){
                Yii::$app->getSession()->setFlash('susscess',". Cập nhật nhân viên thành công ");
            }else{
                Yii::$app->getSession()->setFlash('error',$updateData->error->message);
            }

            return $this->redirect(['index',
                //'id' => $model->ID,
            ]);
        }else {
            $posParentSession = \Yii::$app->session->get('lala_pos_parent');
            $type = \Yii::$app->session->get('lala_type_acc');


            $userData = User::find()
                ->select(['ID','USERNAME'])
                ->where(['ID' =>$id ])
                ->asArray()
                ->all();
            $user = ArrayHelper::map($userData,'ID','USERNAME');


            $dmPos= Dmpos::find()
                ->select(['ID','POS_NAME'])
                ->where(['POS_PARENT' => $model->POS_PARENT])
                ->asArray()
                ->all();
            $posMap = ArrayHelper::map($dmPos,'ID','POS_NAME');

            if(@$model->POS_ID_LIST){
                $idsChecked = array_map('intval', explode(',', $model->POS_ID_LIST));
                $dmPosCheck= Dmpos::find()
                    ->select(['ID','POS_NAME'])
                    ->where(['ID' => $idsChecked])
                    ->asArray()
                    ->all();
                $posMapChecked = ArrayHelper::map($dmPos,'ID','POS_NAME');

            }


            $dmPosParrents = Dmposparent::find()
                ->select(['ID','DESCRIPTION'])
                ->asArray()
                ->all();
            $dmPosParent = ArrayHelper::map($dmPosParrents,'ID','DESCRIPTION');
            $model->isNewRecord = 0;

            return $this->render('update_lala', [
                'model' => $model,
                'user' => $user,
                'posMap' => $posMap,
                //'posMapChecked' => $posMapChecked,
                'dmPosParent' => $dmPosParent,
                'posParentSession' => $posParentSession,
                'type' => $type,
            ]);
        }
    }


    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $user_session = \Yii::$app->session->get('username');
        $posParent_session = \Yii::$app->session->get('pos_parent');
        if($user_session == $model->USERNAME && $posParent_session == $model->POS_PARENT){
            Yii::$app->getSession()->setFlash('error', 'Bạn không thể xóa được tài khoản của chính mình, xin vui lòng liên hệ quản lý!!');
        }else{
            $model->delete();
            DmquerylogController::actionCreateLog('DELETE',get_class($model),$model->oldAttributes,null);
        }
        return $this->redirect(['index']);
    }

    public function actionReset($id)
    {
        $model = $this->findModel($id);
        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelByUsername($phoneNumber)
    {
        if (($model = User::find()->where(['USERNAME'=> $phoneNumber])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionPosdata($id) {
        $itemMap = NULL;
        if ($id){
            //$ids = array_map('intval', explode(',', $id));

            $posObj = Dmpos::find()
                ->select(['ID','POS_NAME'])
                ->where(['POS_PARENT' => $id])
                ->asArray()
                ->all();
            $posMap = ArrayHelper::map($posObj,'ID','POS_NAME');
            foreach($posMap as $key => $value){
                echo '<option value="'.$key.'">'.$value.'</option>';
            }

        }
    }

    /*public function actionCallAPI($phoneNumber,$reseTokenSms){
        // Set body parameter
        $vars = http_build_query(array(
                'msisdn' => $phoneNumber,
                'content' => 'Foodbook: Ma reset mat khau cua ban la:'.$reseTokenSms,
            )
        );

        $apiPath = Yii::$app->params['CMS_API_PATH'].'sendmt';
        $url = $apiPath;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$vars);  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = array();
        $headers[] = 'access_token: D0FBGS3NKZUUFZCIURBDKPR9N5RRML7K';


        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $server_output = curl_exec ($ch);

//        echo '<pre>';
//        var_dump($server_output);
//        echo '</pre>';
//        die();

        curl_close ($ch);

        print  $server_output ;
    }*/




    public function sendSms($phoneNumber,$reseTokenSms){
        // Set body parameter
        $vars = http_build_query(array(
                'msisdn' => $phoneNumber,
                'content' => 'Foodbook: Ma reset mat khau cua ban la:'.$reseTokenSms,
            )
        );

        $apiPath = Yii::$app->params['CMS_API_PATH'].'sendmt';
        $url = $apiPath;

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

        //print  $server_output ;

//        $url = 'http://119.17.212.89:3332/ipos/ws/cms/sendmt';
//        $curl = new curl\Curl();
//        $sendSMS = $curl->setOption(
//            CURLOPT_POSTFIELDS,
//            http_build_query(array(
//                    'msisdn' => $phoneNumber,
//                    'content' => 'Foodbook: Ma reset mat khau cua ban la:'.$reseTokenSms,
//                )
//            ))
//        ->post($url);
//        echo '<pre>';
//        var_dump($sendSMS);
//        echo '</pre>';
    }

    public  function actionForgot(){
        $model = new User();

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();

            $fisrtChar = substr($model->USERNAME,0,1); // Lấy kí tự đầu của chuỗi
            //Kiểm tra nếu đầu chuỗi là số 0 thì convert sang đầu 84
            if($fisrtChar === '0'){
                $model->USERNAME = UsermanagerController::format_number($model->USERNAME);
            }


            $searchModel = new UserSearch();
            $userReset = $searchModel->findModelByUsername($model->USERNAME);
//            echo '<pre>';
//            var_dump($model->username);
//            echo '</pre>';
//            die();
            \Yii::$app->session->set('id',$userReset['id']); // Lưu Id để sau này sử dụng

            if($userReset){
                $resetToken = strtoupper(substr(md5(rand()), 0, 5)); // strtoupper - Up case ----- Random string.
                UsermanagerController::sendSms($model->USERNAME,$resetToken);
                \Yii::$app->session->set('reset_token',$resetToken);

                $reset_client_token = Yii::$app->security->generateRandomString();
                \Yii::$app->session->set('reset_client_token',$reset_client_token);

                return $this->render('checktoken', [
                    'reset_client_token' => $reset_client_token,
                ]);

            }else{
                Yii::$app->getSession()->setFlash('error', 'Số điện thoại không đúng, xin vui lòng nhập số điện thoại chính xác!!');
                return $this->render('forgot', [
                    'model' => $model,
                ]);
            }

        } else {

            return $this->render('forgot', [
                'model' => $model,
            ]);
        }

    }

    public function actionResetpassword(){
        $model = new User();
        if(Yii::$app->request->post()){
            $post = Yii::$app->request->post();

            if($post['token_sms'] === \Yii::$app->session->get('reset_token') && $post['reset_client_token'] === \Yii::$app->session->get('reset_client_token')){

                return $this->render('_resetpassform', [
                    'model' => $model,
                ]);
            }else{
                Yii::$app->getSession()->setFlash('error', 'Bạn nhập mã sai, xin vui lòng kiểm tra lại tin nhắn hệ thống');
                return $this->render('checktoken', [
                    'reset_client_token' => \Yii::$app->session->get('reset_client_token'),
                ]);
            }
        }else{
            //return $this->redirect('/forgot');
            return $this->redirect(\Yii::$app->urlManager->createUrl("usermanager/forgot"));

        }
    }

    public function actionChangepassword($id){
        $check = ExtendController::checkUserPermiswithPos($id);
        if($check){
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post())){
                $password_validate = $model->USERNAME.$model->POS_PARENT.'YG4BQ0FYMD'.$model->oldpass;
                $checkOldPass = Yii::$app->security->validatePassword($password_validate, $model->PASSWORD_HASH);
                if($checkOldPass){
                    $password_generate = $model->USERNAME.$model->POS_PARENT.'YG4BQ0FYMD'.$model->newpass;
                    $model->PASSWORD_HASH = Yii::$app->getSecurity()->generatePasswordHash($password_generate);
                }else{
                    Yii::$app->session->setFlash('error', 'Mật khẩu cũ không đúng');
                    return $this->redirect(['view',
                        'id' => $model->ID,
                    ]);
                }
                $password_generate = $model->USERNAME.$model->POS_PARENT.'YG4BQ0FYMD'.$model->newpass;
                $model->PASSWORD_HASH = Yii::$app->getSecurity()->generatePasswordHash($password_generate);
                $model->UPDATED_AT = date('Y-m-d H:i:s');

                if($model->save()){
                    DmquerylogController::actionCreateLog('UPDATE',get_class($model),$model->oldAttributes,$model->attributes);
                    Yii::$app->user->logout();
                    return $this->redirect(['site/congratulation','meseage' => 'Đặt lại mật khẩu']);
//                    Yii::$app->session->setFlash('success', 'Đổi mật khẩu thành công');
//                    return $this->redirect(['view',
//                        'id' => $model->ID,
//                    ]);
                }else{
                    Yii::$app->session->setFlash('error', 'Đổi mật khẩu lỗi');
                    return $this->redirect(['_form_change_password',
                        'id' => $model->ID,
                    ]);
                }
            }else {
                return $this->render('_form_change_password', [
                    'model' => $model,
                ]);
            }

        }else{
            throw new NotFoundHttpException('Bạn không có quyển quản lý user này.');
        }
    }

    public function actionResetpw(){
        if(Yii::$app->request->post()){
            $post = Yii::$app->request->post();
            $id = \Yii::$app->session->get('id');
            self::actionUpdate($id);

            //Yii::$app->user->setFlash('reLog', "Chúc mừng bạn đã đổi mật khẩu thành công");
            //Yii::$app->user->logout();

            //return $this->goHome();
            return $this->redirect(\Yii::$app->urlManager->createUrl("usermanager/congratulation"));


        }else{

            return $this->redirect(\Yii::$app->urlManager->createUrl("usermanager/forgot"));
        }
    }
    public function actionCongratulation(){
        return $this->render('congratulation');
    }

    public function actionCongratulationregis(){
        return $this->render('congratulationregis');
    }

    public function actionSubcat() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];

                $searchPosModel = new DmposSearch();
                $pos = $searchPosModel->searchAllPosByPosParent($cat_id);

                foreach($pos as $value){
                    $out[] = ['id'=> $value['ID'], 'name' => $value['POS_NAME']];
                }


                //$out = $pos;
                // the getSubCatList function will query the database based on the
                // cat_id and return an array like below:
                // [
                //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
                //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
                // ]
                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    public function actionRegister()
    {

        $model = new User();

        if ($model->load(Yii::$app->request->post())) {

            //Get Accetoken user
            $param = ['email' => $model->EMAIL];  //'msisdn' => (int)$model->user_id,
            $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];
            $type = 'auth/manager_register_pre';
            $access_token = Yii::$app->params['ACCESS_TOKEN'];
            $dataCode = ApiController::actionCallApiByPost($param,$apiPath,$type,$access_token);

            if(isset($dataCode->data->public_code)){
                $paramSignUp = [
                    'POS_PARENT' => $model->POS_PARENT,
                    'username' => $model->USERNAME,
                    'password' => $model->newpass,
                    'email' => $model->EMAIL,
                    'private_code' => '1234',
                    'public_code' => $dataCode->data->public_code,
                ];

//                    echo '<pre>';
//                    var_dump($paramSignUp);
//                    echo '</pre>';
//                    die();
                $nameApiSignUp = 'auth/manager_register';

                $signUp = ApiController::actionCallApiByPost($paramSignUp,$apiPath,$nameApiSignUp,$access_token);

//                echo '<pre>';
//                var_dump($signUp);
//                echo '</pre>';
//                die();

                if(isset($signUp->data)){
                    //Yii::$app->user->setFlash('reLog', "Chúc mừng bạn đã đổi mật khẩu thành công");
                    //Yii::$app->user->logout();

                    //return $this->goHome();


                    return $this->redirect(\Yii::$app->urlManager->createUrl("usermanager/congratulation"));

                }else{

                    //Yii::$app->user->setFlash('error', $signUp->error->message. ".Xin vui lòng thử lại");
                    Yii::$app->getSession()->setFlash('error', $signUp->error->message. ". Xin vui lòng thử lại");

                    return $this->redirect(\Yii::$app->urlManager->createUrl("usermanager/register"));
                }
            }

        } else {
            //$this->layout = 'blank';


            return $this->render('register', [
                'model' => $model,
            ]);
        }
    }

}
