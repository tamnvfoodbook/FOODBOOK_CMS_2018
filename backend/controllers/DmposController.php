<?php

namespace backend\controllers;

use backend\models\DmcitySearch;
use backend\models\Dmdeliverypartner;
use backend\models\Dmdistrict;
use backend\models\DmdistrictSearch;
use backend\models\Dmposmaster;
use backend\models\DmposmasterSearch;
use backend\models\DmposparentSearch;
use backend\models\DmuserpartnerSearch;
use backend\models\MgitemchangedSearch;
use backend\models\User;
use backend\models\UserSearch;
use Yii;
use backend\models\Dmpos;
use backend\models\DmposSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\FormatConverter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\imagine\Image;

/**
 * DmposController implements the CRUD actions for Dmpos model.
 */
class DmposController extends Controller
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
     * Lists all Dmpos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DmposSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $searchPosparentModel = new DmposparentSearch();
        $allPosparent = $searchPosparentModel->searchAllParent();
        $allPosparentMap = ArrayHelper::map($allPosparent,'ID','NAME');


        $searchCityModel = new DmcitySearch();
        $allCity = $searchCityModel->searchAllCity();
        $allCityMap = ArrayHelper::map($allCity,'ID','CITY_NAME');

        $searchDistrictyModel = new DmdistrictSearch();
        $allDistrict = $searchDistrictyModel->searchAllDistrict();
        $allDistrictMap = ArrayHelper::map($allDistrict,'ID','DISTRICT_NAME');

        $searchPosModel = new DmposSearch();
        $allPos = $searchPosModel->searchAllPos();
        $allPosMap = ArrayHelper::map($allPos,'POS_NAME','POS_NAME');

        $partnerModel = new DmuserpartnerSearch();
        $allPartner = $partnerModel->searchAllpartner();
        $allPartnerMap = ArrayHelper::map($allPartner,'PARTNER_NAME','PARTNER_NAME');


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'allPosparentMap' => $allPosparentMap,
            'allDistrictMap' => $allDistrictMap,
            'allCityMap' => $allCityMap,
            'allPosMap' => $allPosMap,
            'partnerMap' => $allPartnerMap,
            //'allPosMasterMap' => $allPosMasterMap,
        ]);
    }

    public function actionMonitorfb($type = null)
    {
        if($type != null && $type != 'fb'){
            $type = 'fb';
        }

        $searchPosparentModel = new DmposparentSearch();
        $allPosparent = $searchPosparentModel->searchAllParent();
        $allPosparentMap = ArrayHelper::map($allPosparent,'ID','NAME');

        $searchModel = new DmposSearch();
        $dataProvider = $searchModel->searchMonitor(Yii::$app->request->queryParams,$type);


        $partnerModel = new DmuserpartnerSearch();
        $allPartner = $partnerModel->searchAllpartner();
        $allPartnerMap = ArrayHelper::map($allPartner,'PARTNER_NAME','PARTNER_NAME');


        $searchCityModel = new DmcitySearch();
        $allCity = $searchCityModel->searchAllCity();
        $allCityMap = ArrayHelper::map($allCity,'ID','CITY_NAME');


        $searchPosModel = new DmposSearch();
        $allPos = $searchPosModel->searchAllPos();
        $allPosMap = ArrayHelper::map($allPos,'POS_NAME','POS_NAME');

//        $searchPosMasterModel = new DmposmasterSearch();
//        $allPosMaster = $searchPosMasterModel->searchAllPosmaster();
//        $allPosMasterMap = ArrayHelper::map($allPosMaster,'ID','POS_MASTER_NAME');


        return $this->render($type.'_monitor', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'allPosparentMap' => $allPosparentMap,
            'allCityMap' => $allCityMap,
            'allPosMap' => $allPosMap,
            'allPartnerMap' => $allPartnerMap,
        ]);
    }

    public function actionReady()
    {
        $searchModel = new DmposSearch();
        $dataProvider = $searchModel->searchReady(Yii::$app->request->queryParams);

        $searchPosparentModel = new DmposparentSearch();
        $allPosparent = $searchPosparentModel->searchAllParent();
        $allPosparentMap = ArrayHelper::map($allPosparent,'ID','NAME');

        $searchPosModel = new DmposSearch();
        $allPos = $searchPosModel->searchAllPos();
        $allPosMap = ArrayHelper::map($allPos,'POS_NAME','POS_NAME');


        return $this->render('ready', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'allPosparentMap' => $allPosparentMap,
            'allPosMap' => $allPosMap,
        ]);
    }

    /**
     * Displays a single Dmpos model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Creates a new Dmpos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dmpos();

        if ($model->load(Yii::$app->request->post())) {

            $pathServer = Yii::$app->params['ITEM_IMAGE_PATH'];

            if(\yii\web\UploadedFile::getInstance($model,'IMAGE_PATH')){
                $fileImage = \yii\web\UploadedFile::getInstance($model,'IMAGE_PATH');
                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder
                DmposController::createDirectory('../../images/pos/');
                // Convert chữ bỏ hết dấu của tên file
                $fileImage->name = FormatConverter::removesign($fileImage->name);

                $fileImage->saveAs('../../images/pos/'.$fileImage->name);
                $model->IMAGE_PATH = $pathServer.'/pos/'.$fileImage->name;

//                DmposController::createDirectory('../../images/pos/thumbs');
//                Image::thumbnail('../../images/pos/'.$fileImage->name, 200, 200)->save('../../images/pos/thumbs/'.$fileImage->name, ['quality' => 80]);

            }

            if(\yii\web\UploadedFile::getInstance($model,'IMAGE_PATH_THUMB')){
                $fileImageThumb = \yii\web\UploadedFile::getInstance($model,'IMAGE_PATH_THUMB');
                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder
                DmposController::createDirectory('../../images/fb/pos/thumbs');
                // Convert chữ bỏ hết dấu của tên file
                $fileImageThumb->name = FormatConverter::removesign($fileImageThumb->name);
                $fileImageThumb->saveAs('../../images/fb/pos/'.$fileImageThumb->name);
                $model->IMAGE_PATH_THUMB = $pathServer.'/pos/'.$fileImageThumb->name;

            }

            $model->save();

            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            //Lấy tất cả cac posparent
            $searchParent = new DmposparentSearch();
            $posparents = $searchParent->searchAllParent();

            // Lấy tất cả các City
            $searchCity = new DmcitySearch();
            $city = $searchCity->searchAllCity();

            // Lấy tất cả các Lấy tất cả các District
            $searchDistrict = new DmdistrictSearch();
            $district = $searchDistrict->searchAllDistrict();

            // Lấy tất cả các Lấy tất cả các Posmaster
            $searchPosmaster = new DmposmasterSearch();
            $posmaster = $searchPosmaster->searchAllPosmaster();


            $searchDelivery = new Dmdeliverypartner();
            $allDelivery = $searchDelivery->searchAll();
            $allDeliveryMap = ArrayHelper::map($allDelivery,'ID','NAME');

            return $this->render('create', [
                'model' => $model,
                'posparents' => $posparents,
                'city' => $city,
                'district' => $district,
                'posmaster' => $posmaster,
                'allDeliveryMap' => $allDeliveryMap,
            ]);
        }
    }

    /**
     * Updates an existing Dmpos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->VAT_TAX_RATE = $model->VAT_TAX_RATE*100;

        if($model->DELIVERY_SERVICES){
            $model->DELIVERY_SERVICES = explode(",",$model->DELIVERY_SERVICES);
        }

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            $model->VAT_TAX_RATE = $model->VAT_TAX_RATE/100;

            $pathServer = Yii::$app->params['POS_IMAGE_PATH'];

            if(\yii\web\UploadedFile::getInstance($model,'IMAGE_PATH')){
                $fileImage = \yii\web\UploadedFile::getInstance($model,'IMAGE_PATH');
                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder
                DmposController::createDirectory('../../images/fb/pos/');
                // Convert chữ bỏ hết dấu của tên file
                $fileImage->name = FormatConverter::removesign($fileImage->name);
                $fileImage->saveAs('../../images/fb/pos/'.$fileImage->name);
                $model->IMAGE_PATH = $pathServer.'/pos/'.$fileImage->name;

                //DmposController::createDirectory('../../images/fb/pos/thumbs');
                //Image::thumbnail('../../images/fb/pos/'.$fileImage->name, 200, 200)->save('../../images/fb/pos/thumbs/'.$fileImage->name, ['quality' => 80]);
                //$model->IMAGE_PATH_THUMB = $pathServer.'/pos/thumbs/'.$fileImage->name;
            }else{
                if(isset($post['image-old'])){
                    $model->IMAGE_PATH = $post['image-old'];
                }
            }

            if(\yii\web\UploadedFile::getInstance($model,'IMAGE_PATH_THUMB')){
                $fileImageThumb = \yii\web\UploadedFile::getInstance($model,'IMAGE_PATH_THUMB');
                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder
                DmposController::createDirectory('../../images/fb/pos/thumbs');
                // Convert chữ bỏ hết dấu của tên file
                $fileImageThumb->name = FormatConverter::removesign($fileImageThumb->name);
                $fileImageThumb->saveAs('../../images/fb/pos/'.$fileImageThumb->name);
                $model->IMAGE_PATH_THUMB = $pathServer.'/pos/'.$fileImageThumb->name;

            }else{
                if(isset($post['image-thumb-old'])){
                    $model->IMAGE_PATH_THUMB = $post['image-thumb-old'];
                }
            }

            if($model->TIME_START){
                $arrTime = explode("-",$model->TIME_START);

                $date_start_tmp = str_replace('/', '-', $arrTime[0]);
                $model->TIME_START = date("Y-m-d H:i:s", strtotime($date_start_tmp));

                $date_end_tmp = str_replace('/', '-', $arrTime[1]);
                $model->TIME_END = date("Y-m-d H:i:s", strtotime($date_end_tmp));
            }

            if($model->DELIVERY_SERVICES){
                $model->DELIVERY_SERVICES = implode(",",$model->DELIVERY_SERVICES);
            }


            $newEndDate = $model->TIME_END;
            $oldEndDate = $model->oldAttributes['TIME_END'];

            if($model->TIME_START_FB){
                $arrTime = explode("-",$model->TIME_START_FB);
                $date_start_tmp = str_replace('/', '-', $arrTime[0]);
                $model->TIME_START_FB = date("Y-m-d H:i:s", strtotime($date_start_tmp));

                $date_end_tmp = str_replace('/', '-', $arrTime[1]);
                $model->TIME_END_FB = date("Y-m-d H:i:s", strtotime($date_end_tmp));
            }

            $newEndDateFb = $model->TIME_END_FB;
            $oldEndDateFb = $model->oldAttributes['TIME_END_FB'];
            $oldModel = $model->oldAttributes;

            if($model->save()){
                DmquerylogController::actionCreateLog('UPDATE',get_class($model),$oldModel,$model->attributes);

                $apiName = 'ipcc/sync_pos';
                $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];

                $access_token = Yii::$app->params['ACCESS_TOKEN'];
                $user_token = \Yii::$app->session->get('user_token');

                $paramGetCampaign = [
                    'pos_parent' => $model->POS_PARENT,
                    'pos_id' => $model->ID,
                    'access_token' => $access_token,
                    'session_token' => $user_token
                ];
                $sync = ApiController::getApiByMethod($apiName,$apiPath,$paramGetCampaign,'GET');
                if(isset($sync->data)){
                    Yii::$app->session->setFlash("success", "Sửa và đồng bộ thành công");
                }else{
                    if(isset($sync->error)){
                        Yii::$app->session->setFlash("warning", "Sửa thành công nhưng lỗi đồng bộ - ".$sync->error->message );
                    }else{
                        Yii::$app->session->setFlash("error", "Sửa thành công nhưng không thể kết nối tới máy chủ đồng bộ' ");
                    }
                }


                if($newEndDateFb !==  $oldEndDateFb && $model->TIME_END_FB != '1970-01-01 00:00:00'){
                    $userModelSearch = new UserSearch;
                    $user = $userModelSearch->searchAllUseRootByPosparent($model->POS_PARENT);
                    foreach((array)$user as $userInfo ){
                        $sendEmail = \Yii::$app->mailer->compose('changedateend', ['dateEnd' => date(Yii::$app->params['DATE_FORMAT'],strtotime($model->TIME_END_FB)),'systemName' => 'Foodbook.vn','posName'=> $model->POS_NAME ])
                            ->setFrom(['mobile@ipos.vn' => 'Hệ thống Foodbook.vn'])
                            ->setTo($userInfo->EMAIL)
                            ->setSubject('Foodbook thông báo thay đổi ngày hết hạn sử dụng.' )
                            ->send();
                    }
                }

                if($newEndDate !==  $oldEndDate && $model->TIME_END != '1970-01-01 00:00:00'){
                    $userModelSearch = new UserSearch;
                    $user = $userModelSearch->searchAllUseRootByPosparent($model->POS_PARENT);
                    foreach((array)$user as $userInfo ){
                        $sendEmail = \Yii::$app->mailer->compose('changedateend', ['dateEnd' => date(Yii::$app->params['DATE_FORMAT'],strtotime($model->TIME_END)),'systemName' => 'iPos.vn','posName'=> $model->POS_NAME])
                            ->setFrom(['mobile@ipos.vn' => 'Hệ thống iPos.vn'])
                            ->setTo($userInfo->EMAIL)
                            ->setSubject('Ipos thông báo thay đổi ngày hết hạn sử dụng.' )
                            ->send();
                    }
                }

                $mgItemUpdate = new MgitemchangedSearch();
                $mgItemUpdate->updatechange($model->ID,$model->POS_PARENT);
            }
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {




            $model->TIME_START = date('d-m-Y',strtotime(@$model->TIME_START));
            $model->TIME_END = date('d-m-Y',strtotime(@$model->TIME_END));
            $model->TIME_START_FB = date('d-m-Y',strtotime(@$model->TIME_START_FB));
            $model->TIME_END_FB = date('d-m-Y',strtotime(@$model->TIME_END_FB));
            //Lấy tất cả cac posparent
            $searchParent = new DmposparentSearch();
            $posparents = $searchParent->searchAllParent();

            // Lấy tất cả các City
            $searchCity = new DmcitySearch();
            $city = $searchCity->searchAllCity();

            // Lấy tất cả các Lấy tất cả các District
            $searchDistrict = new DmdistrictSearch();
            $district = $searchDistrict->searchAllDistrict();

            // Lấy tất cả các Lấy tất cả các Posmaster
            $searchPosmaster = new DmposmasterSearch();
            $posmaster = $searchPosmaster->searchAllPosmaster();

            $country_codes = Yii::$app->params['country_codes'];

            $searchDelivery = new Dmdeliverypartner();
            $allDelivery = $searchDelivery->searchAll();
            $allDeliveryMap = ArrayHelper::map($allDelivery,'ID','NAME');


            $type = \Yii::$app->session->get('type_acc');
            if($type != 1){
                return $this->render('update_pos', [
                    'model' => $model,
                    'posparents' => $posparents,
                    'city' => $city,
                    'district' => $district,
                    'posmaster' => $posmaster,
                    'country_codes' => $country_codes,
                    'allDeliveryMap' => $allDeliveryMap,
                ]);
            }else{
                return $this->render('update', [
                    'model' => $model,
                    'posparents' => $posparents,
                    'city' => $city,
                    'district' => $district,
                    'posmaster' => $posmaster,
                    'country_codes' => $country_codes,
                    'allDeliveryMap' => $allDeliveryMap,
                ]);
            }


        }
    }

    /**
     * Deletes an existing Dmpos model.
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
     * Finds the Dmpos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Dmpos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dmpos::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public static function createDirectory($path, $mode = 0775, $recursive = true)
    {
        if (is_dir($path)) {
            return true;
        }

        $parentDir = dirname($path);

        if ($recursive && !is_dir($parentDir)) {
            static::createDirectory($parentDir, $mode, true);
        }

        try {
            if (!mkdir($path, $mode)) {
                return false;
            }
        } catch (\Exception $e) {
            if (!is_dir($path)) {// https://github.com/yiisoft/yii2/issues/9288
                throw new \yii\base\Exception("Failed to create directory \"$path\": " . $e->getMessage(), $e->getCode(), $e);
            }
        }

        try {
            return chmod($path, $mode);
        } catch (\Exception $e) {
            throw new \yii\base\Exception("Failed to change permissions for directory \"$path\": " . $e->getMessage(), $e->getCode(), $e);
        }

    }

    public function getSubCatList1($cat_id, $param1, $param2){
        $data = NULL;

        $searchDistrictyModel = new DmdistrictSearch();
        $allDistrict = $searchDistrictyModel->searchDistrictByCityId($cat_id);
        $allDistrictMap = ArrayHelper::map($allDistrict,'ID','DISTRICT_NAME');

        foreach($allDistrictMap as $key => $value){
            $data[] = ['id' => $key, 'name' => $value];
        }

        /*$data = [
                ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
                ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
            ];*/
        return $data;
    }

    public function actionSubcat(){
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
}
