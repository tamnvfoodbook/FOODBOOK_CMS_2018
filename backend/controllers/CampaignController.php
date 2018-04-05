<?php

namespace backend\controllers;

use backend\models\CouponSearch;
use backend\models\Dmcity;
use backend\models\DmcitySearch;
use backend\models\Dmitem;
use backend\models\DmitemSearch;
use backend\models\DmposSearch;
use Yii;
use backend\models\Campaign;
use backend\models\Coupon;
use backend\models\User;
use backend\models\Dmpos;

use backend\models\CampaignSearch;
use yii\helpers\FormatConverter;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * CampaignController implements the CRUD actions for Campaign model.
 */
class CampaignController extends Controller
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
     * Lists all Campaign models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CampaignSearch();


        $type = \Yii::$app->session->get('type_acc');

        if($type != 1){
            $searchPosModel = new DmposSearch();
            $ids = $searchPosModel->getIds();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$ids);
        }else{
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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


    /**
     * Displays a single Campaign model.
     * @param integer $_id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $itemObj = Dmitem::find()
            ->select(['ID','ITEM_NAME'])
            ->where(['ID' =>$model->Item_Id_List])
            ->asArray()
            ->all();
        $itemMap = ArrayHelper::map($itemObj,'ID','ITEM_NAME');
        $model->Item_Id_List = implode(", ",$itemMap);

        $posObj = Dmpos::find()
            ->select(['ID','POS_NAME'])
            ->orderBy(['POS_NAME' => SORT_ASC])
            ->where(['ID' =>$model->Pos_Id])
            ->asArray()
            ->all();
        $posMap = ArrayHelper::map($posObj,'ID','POS_NAME');
        $model->Pos_Id = implode(", ",$posMap);

        $cityObj = Dmcity::find()
            ->select(['ID','CITY_NAME'])
            ->where(['ID' =>$model->City_Id])
            ->asArray()
            ->one();

        $model->City_Id = $cityObj['CITY_NAME'];

        $CouponObj = Coupon::find()
            ->select(['_id','Coupon_Name'])
            ->where(['_id' =>$model->Coupon_Id])
            ->asArray()
            ->one();

        $model->Coupon_Id = $CouponObj['Coupon_Name'];

        $model->Campaign_Start  = date('d/m/Y', ($model->Campaign_Start->sec));
        $model->Campaign_End  = date('d/m/Y', ($model->Campaign_End->sec));
        $model->Campaign_Created_At  = date('d/m/Y',($model->Campaign_Created_At->sec));

        if($model->Active){
            $model->Active = 'Active';
        }else{
            $model->Active = 'Deative';
        }


        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Campaign model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function preparData(){
        $posNameObjSearch = new DmposSearch();
        $posNameObj = $posNameObjSearch->searchAllPos();

        foreach($posNameObj as $key => $value){
            $posNameObj[$key]['POS_NAME'] = $posNameObj[$key]['POS_NAME'].' - '.$posNameObj[$key]['ID'];
            $posNameObj[$key]['ID'] = $posNameObj[$key]['ID'].'-'.$posNameObj[$key]['CITY_ID'];
        }
        $posNameMap = ArrayHelper::map($posNameObj,'ID','POS_NAME');

        $itemModelSearch = new DmitemSearch();
        $itemObj = $itemModelSearch->searchAllItem();
        $itemMap = ArrayHelper::map($itemObj,'ID','ITEM_NAME');


        $couponModelSearch = new CouponSearch();
        $CouponObj = $couponModelSearch->searchAllCoupon();

        foreach($CouponObj as $key => $Coupon){
            $CouponObj[$key]['id'] = $Coupon['_id']->__toString();
        }

        $CouponList = ArrayHelper::map($CouponObj,'id','Coupon_Name','Denominations');

        return $data = [
            'posNameMap' => $posNameMap,
            'itemMap' => $itemMap,
            'couponList' => $CouponList,
        ];

    }

    public function actionCreate()
    {
        $model = new Campaign();
        $data = CampaignController::preparData();
        $data['model'] = $model;

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();

            $pathServer = Yii::$app->params['POS_IMAGE_PATH'];

            if(\yii\web\UploadedFile::getInstance($model,'Image')){
                $fileImage = \yii\web\UploadedFile::getInstance($model,'Image');
                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder
                DmposController::createDirectory('../../images/fb/campaign/');
                // Convert chữ bỏ hết dấu của tên file
                $fileImage->name = FormatConverter::removesign($fileImage->name);
                $fileImage->saveAs('../../images/fb/campaign/'.$fileImage->name);
                $model->Image = $pathServer.'/campaign/'.$fileImage->name;
            }


            if(\yii\web\UploadedFile::getInstance($model,'Image_Logo')){
                $fileImage_Logo = \yii\web\UploadedFile::getInstance($model,'Image_Logo');
                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder
                DmposController::createDirectory('../../images/fb/logo/');

                //Convert tên file
                $fileImage_Logo->name = FormatConverter::removesign($fileImage_Logo->name);
                $fileImage_Logo->saveAs('../../images/fb/logo/'.$fileImage_Logo->name);

                $model->Image_Logo = $pathServer.'/logo/'.$fileImage_Logo->name;
            }


            $model->Campaign_Created_At = new \MongoDate(strtotime($model->Campaign_Created_At));

            $cutTimeStart = substr($model->Campaign_Start,0,10); // Cắt đầu chuỗi lấy time start
            $cutTimeEnd = substr($model->Campaign_Start,-10);   // Cắt đầu chuỗi lấy time End

            $model->Campaign_Start = new \MongoDate(strtotime($cutTimeStart));
            $model->Campaign_End = new \MongoDate(strtotime($cutTimeEnd));
            $model->Active = (int)$model->Active;

            $model->Campaign_Type = 'Coupon_TYPE_FOODBOOK';
            $model->Sort = (int)$model->Sort;



            if(isset($post['optionItem'])){
                $model->Item_Id_List = array_map('intval',$post['optionItem']);
            }



            if(isset($post['campaign-pos_id']) && $post['campaign-pos_id'] != Null){
                $arrayPosIdandCityId = explode("-", $post['campaign-pos_id']);
                $model->Pos_Id = (int)$arrayPosIdandCityId[0];
                $model->City_Id = (int)$arrayPosIdandCityId[1];
            }

            $model->Show_Price_Bottom = (int)$model->Show_Price_Bottom;

            $model->save();

            return $this->redirect(['index']);
        } else {

            return $this->render('create', $data );
        }
    }


    /**
     * Updates an existing Campaign model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $data = CampaignController::preparData();
        $data['model'] = $model;
        $data['id'] = (string)$model->_id;


        $itemObj = Dmitem::find()
            ->select(['ID','ITEM_NAME'])
            ->where(['POS_ID'=> $model->Pos_Id])
            ->asArray()
            ->all();
        $itemMap = ArrayHelper::map($itemObj,'ID','ITEM_NAME');
        $data['itemMap'] = $itemMap;
//        echo '<pre>';
//        var_dump($data);
//        echo '</pre>';
//        die();

        $model->Campaign_Start = date('m/d/Y',$model->Campaign_Start->sec). ' - ' .date('m/d/Y',$model->Campaign_End->sec);

        if ($model->load(Yii::$app->request->post())){
            $post = Yii::$app->request->post();

            $pathServer = Yii::$app->params['POS_IMAGE_PATH'];

            if(\yii\web\UploadedFile::getInstance($model,'Image')){
                $fileImage = \yii\web\UploadedFile::getInstance($model,'Image');
                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder
                DmposController::createDirectory('../../images/fb/campaign/');

                // Convert chữ bỏ hết dấu của tên file
                $fileImage->name = FormatConverter::removesign($fileImage->name);
                $fileImage->saveAs('../../images/fb/campaign/'.$fileImage->name);
                $model->Image = $pathServer.'/campaign/'.$fileImage->name;
            }else{
                if(isset($post['ImageOld'])){
                    $model->Image = $post['ImageOld'];
                }
            }

            if(\yii\web\UploadedFile::getInstance($model,'Image_Logo')){
                $fileImage_Logo = \yii\web\UploadedFile::getInstance($model,'Image_Logo');
                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder
                DmposController::createDirectory('../../images/fb/logo/');

                // Convert chữ bỏ hết dấu của tên file
                $fileImage_Logo->name = FormatConverter::removesign($fileImage_Logo->name);

                $fileImage_Logo->saveAs('../../images/fb/logo/'.$fileImage_Logo->name);

                $model->Image_Logo = $pathServer.'/logo/'.$fileImage_Logo->name;
            }else{
                if(isset($post['Image_Logo_Old'])){
                    $model->Image_Logo = $post['Image_Logo_Old'];
                }
            }

            $model->Campaign_Created_At = new \MongoDate(strtotime($model->Campaign_Created_At));

            $cutTimeStart = substr($model->Campaign_Start,0,10); // Cắt đầu chuỗi lấy time start
            $cutTimeEnd = substr($model->Campaign_Start,-10);   // Cắt đầu chuỗi lấy time End


            $model->Campaign_Start = new \MongoDate(strtotime($cutTimeStart));
            $model->Campaign_End = new \MongoDate(strtotime($cutTimeEnd));
            if($model->Campaign_Type_Row == 'Campaign_TYPE_ROW_NOLINE'){
                $model->Image_Line = NULL;
            }

            $model->Active = (int)$model->Active;

            if(isset($post['optionItem'])){

                foreach($post['optionItem'] as $item){
                    $tmpItem[] = (int)$item;
                }
                $model->Item_Id_List = $tmpItem;
            }else{
                $model->Item_Id_List = null;
            }


            if(isset($post['campaign-pos_id']) && $post['campaign-pos_id'] != Null){
                $arrayPosIdandCityId = explode("-", $post['campaign-pos_id']);
                $model->Pos_Id = (int)$arrayPosIdandCityId[0];
                $model->City_Id = (int)$arrayPosIdandCityId[1];
            }

            $model->Show_Price_Bottom = (int)$model->Show_Price_Bottom;
            $model->Sort = (int)$model->Sort;

//            echo '<pre>';
//            var_dump($model);
//            echo '</pre>';

            $model->save();


            return $this->redirect(['view',
                'id' => (string)$model->_id,
            ]);
        } else {
            return $this->render('update',[
                'model' => $model,
                'posNameMap' => $data['posNameMap'],
                'itemMap' => $data['itemMap'],
                'couponList' => $data['couponList'],
            ]);
        }
    }

    /**
     * Deletes an existing Campaign model.
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
     * Finds the Campaign model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return Campaign the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Campaign::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSubcat1($id) {
        $itemMap = NULL;
        if ($id){
            $ids = array_map('intval', explode(',', $id));

            $itemObj = Dmitem::find()->select(['ID','ITEM_NAME','POS_ID'])->where(['POS_ID' => $ids[0]])->asArray()->all();
            $itemMap = ArrayHelper::map($itemObj,'ID','ITEM_NAME');

            foreach($itemMap as $key => $value){
                echo '<option value="'.$key.'">'.$value.'</option>';
            }

        }
    }
}
