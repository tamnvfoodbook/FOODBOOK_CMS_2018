<?php

namespace backend\controllers;

use backend\models\Dmconfig;
use backend\models\DmconfigSearch;
use backend\models\DmposSearch;
use backend\models\Dmuserpartner;
use backend\models\DmuserpartnerSearch;
use backend\models\Dmzalopageconfig;
use backend\models\DmzalopageconfigSearch;
use backend\models\User;
use Yii;
use backend\models\Dmposparent;
use backend\models\DmposparentSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\FormatConverter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * DmposparentController implements the CRUD actions for Dmposparent model.
 */
class DmposparentController extends Controller
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
     * Lists all Dmposparent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DmposparentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMonitor()
    {
        $searchModel = new DmposparentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $partnerModel = new DmuserpartnerSearch();
        $allPartner = $partnerModel->searchAllpartner();
        $allPartnerMap = ArrayHelper::map($allPartner,'PARTNER_NAME','PARTNER_NAME');

        return $this->render('monitor', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'allPartnerMap' => $allPartnerMap,
        ]);
    }

    public function actionConnect()
    {
        $posparent = \Yii::$app->session->get('pos_parent');
        $model = $this->findModel($posparent);

        $configModelSearch = new DmconfigSearch();
        $configSMS = $configModelSearch->searchConfigByKeygroup('sms_partner');
        $configSMSMap = ArrayHelper::map($configSMS,'VALUES','DESC');


        if ($model->load(Yii::$app->request->post()) ) {
            $post = Yii::$app->request->post();
            if(isset($post['smsbrand'])){
                $model->SMS_PARTNER = $post['smsbrand'];
            };
//            echo '<pre>';
//            var_dump($model->SMS_PARTNER);
//            echo '</pre>';
//            die();
            $model->save();
        }

        return $this->render('connect', [
            'model' => $model,
            'configSMSMap' => $configSMSMap,
//            'allPartnerMap' => $allPartnerMap,
        ]);
    }

    /**
     * Displays a single Dmposparent model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $userModel = new User();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'userModel' => $userModel,
        ]);
    }
    public function actionPosview()
    {
        $posparent = \Yii::$app->session->get('pos_parent');

        $searchPosModel = new DmposSearch();
        $model = $this->findModel($posparent);
        if($model->POS_FEATURE){
            $pos = $searchPosModel->searchAllPosById($model->POS_FEATURE);
            $model->POS_FEATURE = $pos[0]['POS_NAME'];
        }
        return $this->render('posview', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Dmposparent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dmposparent();
        $configModelSearch = new DmconfigSearch();
        $configSMS = $configModelSearch->searchConfigByKeygroup('sms_partner');
        $configSMSMap = ArrayHelper::map($configSMS,'VALUES','DESC');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $pathServer = Yii::$app->params['POS_IMAGE_PATH'].'/posparent/';

            if(UploadedFile::getInstance($model,'IMAGE')){
                $fileImage = UploadedFile::getInstance($model,'IMAGE');
                // Convert chữ bỏ hết dấu của tên file
                $fileImage->name = FormatConverter::removesign($fileImage->name);

                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder Images
                DmposController::createDirectory('../../images/fb/posparent/');

                $fileImage->saveAs('../../images/fb/posparent/'.$fileImage->name);
                $model->IMAGE = $pathServer.$fileImage->name;
            }

            if(UploadedFile::getInstance($model,'img_member')){

                $fileImage = UploadedFile::getInstance($model,'img_member');
                // Convert chữ bỏ hết dấu của tên file
                $fileImage->name = $model->ID.'.jpg';

                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder Images
                DmposController::createDirectory('../../images/member_type/');

                $fileImage->saveAs('../../images/member_type/'.$fileImage->name);
                $model->img_member = $pathServer.$fileImage->name;
            }

            $model->ID = strtoupper($model->ID);

            $modelZaloConfig = self::findZaloConfigByposparent();
            $modelZaloConfig->ZALO_OA_KEY = $model->ZALO_OA_KEY;
            $modelZaloConfig->PAGE_ID = $model->ZALO_PAGE_ID;
            $modelZaloConfig->POS_PARENT = Yii::$app->session->get('pos_parent');
            $modelZaloConfig->save();
            $model->save();


            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            $dmPartnerModel  = new DmuserpartnerSearch();
            $allPartner = $dmPartnerModel->searchAllpartner();
            $partnerMap = ArrayHelper::map($allPartner,'PARTNER_NAME','PARTNER_NAME');
            $partnerIdMap = ArrayHelper::map($allPartner,'ID','PARTNER_NAME');





            return $this->render('create', [
                'model' => $model,
                'partnerMap' => $partnerMap,
                'partnerIdMap' => $partnerIdMap,
                'configSMSMap' => $configSMSMap,

            ]);
        }
    }

    protected function findZaloConfigByposparent()
    {
        $model = Dmzalopageconfig::find()->where(['POS_PARENT' => Yii::$app->session->get('pos_parent')])->one();
        if(!$model){
            $model = new Dmzalopageconfig();
        }
        return $model;
    }

    /**
     * Updates an existing Dmposparent model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $posModelSearch = new DmposSearch();
        $posModel = $posModelSearch->searchAllPosByPosParent($id);
        $posModelMap = ArrayHelper::map($posModel,'ID','POS_NAME');
        $posparent = \Yii::$app->session->get('pos_parent');
        $model->img_member = Yii::$app->params['BASE_IMAGE_PATH'].'/member_type/'.$id.'.jpg';

        $configModelSearch = new DmconfigSearch();
        $configSMS = $configModelSearch->searchConfigByKeygroup('sms_partner');
        $configSMSMap = ArrayHelper::map($configSMS,'VALUES','DESC');

//        echo '<pre>';
//        var_dump($posModelMap);
//        echo '</pre>';
//        die();


        if($model->DIRECT_LIST){
            $model->DIRECT_LIST = explode(",",$model->DIRECT_LIST);
        }


        if ($model->load(Yii::$app->request->post()) ) {
            $post = Yii::$app->request->post();
            $pathServer = Yii::$app->params['POS_IMAGE_PATH'].'/posparent/';

            if(UploadedFile::getInstance($model,'IMAGE')){
                $fileImage = UploadedFile::getInstance($model,'IMAGE');
                // Convert chữ bỏ hết dấu của tên file
                $fileImage->name = FormatConverter::removesign($fileImage->name);

                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder Images
                DmposController::createDirectory('../../images/fb/posparent/');

                $fileImage->saveAs('../../images/fb/posparent/'.$fileImage->name);
                $model->IMAGE = $pathServer.$fileImage->name;
            }else{
                if(isset($post['IMAGE-old'])){
                    $model->IMAGE = $post['IMAGE-old'];
                }
            }

            if($model->ZALO_PAGE_ID && $model->ZALO_OA_KEY){
                $zaloModelSearch = new DmzalopageconfigSearch();
                $zaloModel = $zaloModelSearch->checkZaloConfig($model->ID);
                if(!$zaloModel){
                    $zaloModel = new Dmzalopageconfig();
                    $zaloModel->POS_PARENT = $model->ID;
                }
                $zaloModel->PAGE_ID = $model->ZALO_PAGE_ID;
                $zaloModel->ZALO_OA_KEY = $model->ZALO_OA_KEY;
                $zaloModel->save();
            }


            if($model->DIRECT_LIST){
                $model->DIRECT_LIST = implode(",",$model->DIRECT_LIST);
            }

            if(UploadedFile::getInstance($model,'LOGO')){

                $fileImage = UploadedFile::getInstance($model,'LOGO');
                // Convert chữ bỏ hết dấu của tên file
                $fileImage->name = FormatConverter::removesign($fileImage->name);

                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder Images
                DmposController::createDirectory('../../images/fb/posparent/');

                $fileImage->saveAs('../../images/fb/posparent/'.$fileImage->name);
                $model->LOGO = $pathServer.$fileImage->name;
            }else{
                if(isset($post['LOGO-old'])){
                    $model->LOGO = $post['LOGO-old'];
                }
            }

            if(UploadedFile::getInstance($model,'img_member')){

                $fileImage = UploadedFile::getInstance($model,'img_member');
                // Convert chữ bỏ hết dấu của tên file
                $fileImage->name = $model->ID.'.jpg';

                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder Images
                DmposController::createDirectory('../../images/member_type/');

                $fileImage->saveAs('../../images/member_type/'.$fileImage->name);
                $model->img_member = $pathServer.$fileImage->name;
            }

            DmquerylogController::actionCreateLog('UPDATE',get_class($model),$model->oldAttributes,$model->attributes);

            $model->save();
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {

            $dmPartnerModel  = new DmuserpartnerSearch();
            $allPartner = $dmPartnerModel->searchAllpartner();
            $partnerMap = ArrayHelper::map($allPartner,'PARTNER_NAME','PARTNER_NAME');
            $partnerIdMap = ArrayHelper::map($allPartner,'ID','PARTNER_NAME');

            return $this->render('update', [
                'model' => $model,
                'partnerMap' => $partnerMap,
                'partnerIdMap' => $partnerIdMap,
                'posModelMap' => $posModelMap,
                'configSMSMap' => $configSMSMap,
            ]);
        }
    }
    public function actionPosupdate()
    {
        $posparent = \Yii::$app->session->get('pos_parent');
        $model = $this->findModel($posparent);

        $searchPosModel = new DmposSearch();
        $allPos = $searchPosModel->searchAllPosByPosParent($posparent);
        $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');

        if ($model->load(Yii::$app->request->post()) ) {
            $post = Yii::$app->request->post();
            $pathServer = Yii::$app->params['POS_IMAGE_PATH'].'/posparent/';

            if(UploadedFile::getInstance($model,'IMAGE')){
                $fileImage = UploadedFile::getInstance($model,'IMAGE');
                // Convert chữ bỏ hết dấu của tên file
                $fileImage->name = FormatConverter::removesign($fileImage->name);

                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder Images
                DmposController::createDirectory('../../images/fb/posparent/');

                $fileImage->saveAs('../../images/fb/posparent/'.$fileImage->name);
                $model->IMAGE = $pathServer.$fileImage->name;
            }else{
                if(isset($post['IMAGE-old'])){
                    $model->IMAGE = $post['IMAGE-old'];
                }
            }

            /*echo '<pre>';
            var_dump($model->LOGO);
            echo '</pre>';
            die();*/

            if(UploadedFile::getInstance($model,'LOGO')){

                $fileImage = UploadedFile::getInstance($model,'LOGO');
                // Convert chữ bỏ hết dấu của tên file
                $fileImage->name = FormatConverter::removesign($fileImage->name);

                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder Images
                DmposController::createDirectory('../../images/fb/posparent/');

                $fileImage->saveAs('../../images/fb/posparent/'.$fileImage->name);
                $model->LOGO = $pathServer.$fileImage->name;
            }else{
                if(isset($post['LOGO-old'])){
                    $model->LOGO = $post['LOGO-old'];
                }
            }

            DmquerylogController::actionCreateLog('UPDATE',get_class($model),$model->oldAttributes,$model->attributes);
            $model->save();
            if($model->save()){
                Yii::$app->session->setFlash('success', 'Chỉnh sửa thành công');
            }else{
                Yii::$app->session->setFlash('error', 'Chỉnh sửa lỗi! Vui lòng kiểm tra lại');
            }

            return $this->redirect(['posview']);
        } else {

            $dmPartnerModel  = new DmuserpartnerSearch();
            $allPartner = $dmPartnerModel->searchAllpartner();
            $partnerMap = ArrayHelper::map($allPartner,'PARTNER_NAME','PARTNER_NAME');

            return $this->render('_pos_form', [
                'model' => $model,
                'partnerMap' => $partnerMap,
                'allPosMap' => $allPosMap,
            ]);
        }
    }

    /**
     * Deletes an existing Dmposparent model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionReset($pos_parent)
    {
        $model = new User();

        if($model->load(Yii::$app->request->post())){


            $typeAcc = \Yii::$app->session->get('type_acc');
            if($typeAcc == 1){}
            $param = [
                'pos_parent' => $pos_parent,
                //'pos_id' => $id,
                'password' =>$model->oldpass
            ];

            $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];
            $apiName = 'cms/delete_pos_parent';

            $result = ApiController::getApiByMethod($apiName,$apiPath,$param,'POST');

//            echo '<pre>';
//            var_dump($result);
//            echo '</pre>';
//            die();

            if(isset($result->data)){
                Yii::$app->session->setFlash('success', 'Đặt lại dữ liệu thành công');
            }else{
                Yii::$app->session->setFlash('error', @$result->error->message);
            }
            return $this->redirect(['view', 'id' => $pos_parent]);
        }else{
            Yii::$app->session->setFlash('error', "Bạn chưa nhập Pass, xin vui lòng nhập mật khẩu");
            return $this->redirect(['view', 'id' => $pos_parent]);
        }

    }

    public function actionDelete($id)
    {

        $model = $this->findModel($id);
        DmquerylogController::actionCreateLog('DELETE',get_class($model),$model->oldAttributes,null);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Dmposparent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Dmposparent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dmposparent::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
