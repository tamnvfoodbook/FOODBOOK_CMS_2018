<?php

namespace backend\controllers;

use backend\models\Dmitem;
use backend\models\DmitemSearch;
use backend\models\Dmitemtype;
use backend\models\DmitemtypemasterSearch;
use backend\models\DmitemtypeSearch;
use backend\models\DmposparentSearch;
use backend\models\DmposSearch;
use backend\models\MgitemchangedSearch;
use backend\models\User;
use backend\models\WmitemimagelistSearch;
use Yii;
use backend\models\Dmpos;
use backend\models\DmpositemSearch;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\FormatConverter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\imagine\Image;

use backend\models\DmcitySearch;

use common\models\LoginForm;

/**
 * DmpositemController implements the CRUD actions for Dmpos model.
 */
class DmpositemController extends Controller
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
        $searchModel = new DmpositemSearch();
        $userModel = new User();
        $type = \Yii::$app->session->get('type_acc');
        $searchPosModel = new DmposSearch();
        $POS_ID_LIST = $searchPosModel->getIds();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$POS_ID_LIST,$type);
        if($type != 1){
            $dataProvider->setSort(false);
            $allPos = $searchPosModel->searchAllPosById($POS_ID_LIST);
            $allPosMap= ArrayHelper::map($allPos,'POS_NAME','POS_NAME');
            return $this->render('index_pos', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'allPosMap' => $allPosMap,
                'userModel' => $userModel,
            ]);
        }else{
            $allPos = $searchPosModel->searchAllPos();
            $allPosMap= ArrayHelper::map($allPos,'POS_NAME','POS_NAME');
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'allPosMap' => $allPosMap,
            ]);
        }
    }

    public function actionLala()
    {
        self::checkAccessToken();

        $param = array();
        $reportByDay = ApiController::getReportData('report_by_day',$param);

        $searchModel = new DmpositemSearch();
        $searchPosModel = new DmposSearch();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $reportByDay->data,
        ]);

        /*        if(isset($reportByDay->data)){
                    $dataProvider->allModel = $reportByDay->data;
                }*/

//        $dataProvider = $searchModel->searchLala(Yii::$app->request->queryParams);

        $allPos = $searchPosModel->searchAllPos();
        $allPosMap= ArrayHelper::map($allPos,'POS_NAME','POS_NAME');
        return $this->render('index_lala', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'allPosMap' => $allPosMap,
        ]);

    }

    function checkAccessToken(){
        $lalaAC = \Yii::$app->session->get('lala_user_token');
        if($lalaAC === NULL){
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
                return $this->render('login_lala', [
                    'model' => $model,
                ]);
            }

        } else {
            return $this->render('login_lala', [
                'model' => $model,
            ]);
        }
    }

    public function actionCreateposlala()
    {
        self::checkAccessToken();

        $model = new Dmpos();
        //Get Accetoken user
        $param = array();
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS_MOBILE'];
        $apiName = 'common/list_currency';

        $dataCode = ApiController::getLalaApiByMethod($apiName,$apiPath,$param);

        $arrayCurrency = array();
        if(@$dataCode->data){
            $arrayCurrency = json_decode(json_encode($dataCode->data), true);
        }
        krsort($arrayCurrency);
        $allCurrencyMap = ArrayHelper::map($arrayCurrency,'id','name');

        $citySearch = new DmcitySearch();
        $city = $citySearch->searchAllCity();
        $cityMap = ArrayHelper::map($city,'ID','CITY_NAME');
        $country_codes = Yii::$app->params['country_codes'];


        if ($model->load(Yii::$app->request->post())) {

            $user_token = \Yii::$app->session->get('lala_user_token');
            $param = [
                'name' => $model->POS_NAME,
                'address' => $model->POS_ADDRESS,
                'phone' => $model->PHONE_NUMBER,
                'currency' => $model->CURRENCY,
                'decimal_number' => $model->DECIMAL_NUMBER,
                'decimal_money' => $model->DECIMAL_MONEY

            ];

            $apiPath = Yii::$app->params['CMS_API_PATH_IPOS_MOBILE'];
            $apiName = 'manager/add_pos';
            $regis = ApiController::getLalaApiByMethod($apiName,$apiPath,$param,'POST');

            if(isset($regis->data)){
                Yii::$app->session->setFlash('success', "Tạo nhà hàng ".$model->POS_NAME." thành công!" );
                return $this->redirect(['dmpositem/lala', 'id' => $regis->data]);
            }else{
                Yii::$app->session->setFlash('error', $regis->error->message);
                return $this->render('createpos', [
                    'model' => $model,
                    'allCurrencyMap' => $allCurrencyMap,
                    'cityMap' => $cityMap,
                    'country_codes' => $country_codes,
                ]);
            }


        } else {

            $model->DECIMAL_NUMBER = 1;
            $model->DECIMAL_MONEY = 1;
            return $this->render('createpos', [
                'model' => $model,
                'allCurrencyMap' => $allCurrencyMap,
                'cityMap' => $cityMap,
                'country_codes' => $country_codes,
            ]);
        }
    }



    /**
     * Displays a single Dmpos model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new DmitemSearch();
        $dataProvider = $searchModel->searchByPos(Yii::$app->request->queryParams,$id);
        $searchItemTypeMasterModel = new DmitemtypemasterSearch();
        $allItemTypeMaster = $searchItemTypeMasterModel->searchAllItemTypeMaster();
        $itemTypeMasterMap= ArrayHelper::map($allItemTypeMaster,'ID','ITEM_TYPE_MASTER_NAME','SORT');

        $searchItemTypeModel = new DmitemtypeSearch();
        $allItemType = $searchItemTypeModel->searchCategoryByPos($id);
        $itemTypeMap= ArrayHelper::map($allItemType,'ITEM_TYPE_ID','ITEM_TYPE_NAME');

        return $this->render('view', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'itemTypeMasterMap' => $itemTypeMasterMap,
            'itemTypeMap' => $itemTypeMap,
            'model' => $this->findModel($id),
        ]);
    }

    public function actionViewlala($id)
    {
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS_MOBILE'];

        $nameItem = 'manager/list_data';
        $paramItem = array(
            'pos_id' => $id,
            'table_name' => 'DM_ITEM',
        );


        $itemList = ApiController::getLalaApiByMethod($nameItem,$apiPath,$paramItem,'GET');

        $dataProvider = new ArrayDataProvider([
            'allModels' => $itemList->data,
        ]);

        $searchModel = new DmitemSearch();
//        $dataProvider = $searchModel->searchByPos(Yii::$app->request->queryParams,$id);
        $searchItemTypeMasterModel = new DmitemtypemasterSearch();
        $allItemTypeMaster = $searchItemTypeMasterModel->searchAllItemTypeMaster();
        $itemTypeMasterMap= ArrayHelper::map($allItemTypeMaster,'ID','ITEM_TYPE_MASTER_NAME','SORT');

        $searchItemTypeModel = new DmitemtypeSearch();
        $allItemType = $searchItemTypeModel->searchCategoryByPos($id);
        $itemTypeMap= ArrayHelper::map($allItemType,'ITEM_TYPE_ID','ITEM_TYPE_NAME');


        $namePos = 'manager/list_pos';
        $paramPos = array();
        $itemListPos = ApiController::getLalaApiByMethod($namePos,$apiPath,$paramPos,'GET');
        foreach($itemListPos->data as $pos){
            if($pos->id == $id ){
                $model = $pos;
                break;
            }
        }

        return $this->render('view_lala', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'itemTypeMasterMap' => $itemTypeMasterMap,
            'itemTypeMap' => $itemTypeMap,
            'model' => $model,
        ]);
    }

    public function actionItemtype($id)
    {
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS_MOBILE'];
        $name = 'manager/list_data';
        $paramItemType = array(
            'pos_id' => $id,
            'table_name' => 'DM_ITEM_TYPE',
        );

        $itemTypeList = ApiController::getLalaApiByMethod($name,$apiPath,$paramItemType,'GET');

        $searchModel = new DmitemtypeSearch();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $itemTypeList->data,
        ]);


        return $this->render('edit_item_type', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'pos_id' => $id,
//            'model' => $this->findModel($id),
        ]);
    }


    public function actionGetAllDataLala(){
        //Get Item by User
        $apiPath = Yii::$app->params['CMS_API_PATH_SHORT'];
        $name = 'ipcc/get_all_data';
//
        $paramItem = array();
        $itemList = ApiController::getLalaApiByMethod($name,$apiPath,$paramItem,'GET');

        $itemMap = ArrayHelper::map($itemList->data->list_item,'Id','Item_Type_Id');
        $itemTypeMap = ArrayHelper::map($itemList->data->list_item_type,'Item_Type_Id','sort');

        foreach($itemList->data->list_item as $key => $item){
            $item->Item_Type_Id_Sort = @$itemTypeMap[$item->Item_Type_Id];
            $itemList->data->list_item[$key] = $item;
        }

        ArrayHelper::multisort($itemList->data->list_item, ['Item_Type_Id_Sort','Sort'], [SORT_ASC,SORT_ASC]);

        return $itemList;
    }



    public function actionWifimana($id)
    {
        $searchModel = new WmitemimagelistSearch();
        $dataProvider = $searchModel->searchByPosId(Yii::$app->request->queryParams,$id);

        return $this->render('wifimana', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    public function actionSyncitem($posId)
    {
        $dataCampain = array();
        $apiName = 'ipcc/sync_item';
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];

        $access_token = Yii::$app->params['ACCESS_TOKEN'];
        $user_token = \Yii::$app->session->get('user_token');

        $paramCommnet = [
            'access_token' => $access_token,
            'session_token' => $user_token,
            'pos_parent' => Yii::$app->session->get('pos_parent'),
            'pos_id' => $posId,
        ];
        $data = ApiController::getApiByMethod($apiName,$apiPath,$paramCommnet,'GET');
        if(isset($data->data)){
            Yii::$app->session->setFlash('success', 'Đồng bộ thành công');
        }else{
            Yii::$app->session->setFlash('error', @$data->error->message);
        }

        return $this->redirect(['index']);
    }



    public function actionCreateparentitem($POS_ID)
    {
        $model = new Dmitem();

        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS_MOBILE'];
        $access_token = Yii::$app->params['ACCESS_TOKEN'];
        $user_token = \Yii::$app->session->get('user_token');

        //Check Auto genagen Id
        $posparent = \Yii::$app->session->get('pos_parent');
        $posparentModel = new DmposparentSearch();
        $posparent = $posparentModel->searchPosparentById($posparent);
        $autoGenId = $posparent->AUTO_GENERATE_ID;


        $searchModelItemMaster = new DmitemtypemasterSearch();
        $modelItemTypeMaster = $searchModelItemMaster->searchAllItemTypeMaster();
        $itemTypeMasterMap = ArrayHelper::map($modelItemTypeMaster,'ID','ITEM_TYPE_MASTER_NAME','SORT');


        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();

            $pathServer = Yii::$app->params['ITEM_IMAGE_PATH'].'/'.$POS_ID.'/';
            $pathServerThumb = Yii::$app->params['ITEM_IMAGE_PATH'].'/thumbs/'.$POS_ID.'/';

            if(UploadedFile::getInstance($model,'ITEM_IMAGE_PATH')){
                $fileImage = UploadedFile::getInstance($model,'ITEM_IMAGE_PATH');

                // Convert chữ bỏ hết dấu của tên file
                $fileImage->name = FormatConverter::removesign($fileImage->name);

                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder Images
                DmposController::createDirectory('../../images/fb/items/'.$POS_ID.'/');

                $fileImage->saveAs('../../images/fb/items/'.$POS_ID.'/'.$fileImage->name);
                $model->ITEM_IMAGE_PATH = $pathServer.$fileImage->name;

                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder Images Thumbs
                DmposController::createDirectory('../../images/fb/items/thumbs/'.$POS_ID.'/');
                Image::thumbnail('../../images/fb/items/'.$POS_ID.'/'.$fileImage->name, 400, 400)->save('../../images/fb/items/thumbs/'.$POS_ID.'/'.$fileImage->name, ['quality' => 80]);
                $model->ITEM_IMAGE_PATH_THUMB = $pathServerThumb.$fileImage->name;
//                var_dump($model->ITEM_IMAGE_PATH);
//                die();
            }else{
                if(isset($post['ITEM_IMAGE_PATH-old'])){
                    $model->ITEM_IMAGE_PATH = $post['ITEM_IMAGE_PATH-old'];
                    $model->ITEM_IMAGE_PATH_THUMB = $post['ITEM_IMAGE_PATH_THUMB-old'];
                }
            }

            if(UploadedFile::getInstance($model,'ITEM_IMAGE_PATH_THUMB')){
                $fileImage = UploadedFile::getInstance($model,'ITEM_IMAGE_PATH_THUMB');
                // Convert chữ bỏ hết dấu của tên file
                $fileImage->name = FormatConverter::removesign($fileImage->name);
                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder
                DmposController::createDirectory('../../images/fb/items/'.$POS_ID.'/');
                $fileImage->saveAs('../../images/fb/items/'.$POS_ID.'/'.$fileImage->name);
                $model->ITEM_IMAGE_PATH_THUMB = $pathServer.$fileImage->name;


            }else{
                if(isset($post['ITEM_IMAGE_PATH_THUMB-old'])){
                    $model->FB_IMAGE_PATH = $post['ITEM_IMAGE_PATH_THUMB-old'];
                }
            }
            $model->POS_ID = $POS_ID;

            if($model->IS_PARENT){
                $model->ITEM_ID_BARCODE = $model->ITEM_ID;
            }

            if(is_array($model->ITEM_ID_EAT_WITH)){
                $model->ITEM_ID_EAT_WITH = implode(",",$model->ITEM_ID_EAT_WITH);
            }else{
                $model->ITEM_ID_EAT_WITH = NULL;
            }


            if($model->save()){
                if($model->IS_PARENT){
                    $model->ITEM_ID_BARCODE = $model->ITEM_ID;
                    $update = [
                        'IS_SUB' => '1',
                        'ITEM_ID_BARCODE' => $model->ITEM_ID
                    ];
                    Dmitem::updateAll($update, ['ITEM_ID' => $model->LIST_SUB_ITEM ]);
                }

                Yii::$app->session->setFlash('success', 'Tạo món '.$model->ITEM_NAME.' thành công');
            }else{
                Yii::$app->session->setFlash('error', 'Tạo món '.$model->ITEM_NAME.' lỗi');
            }

            return $this->redirect(['view', 'id' => $POS_ID]);



            /*if(isset($post['pos'])){
                $headers = array();
                $headers[] = 'access_token: '.$access_token;
                $headers[] = 'token: '.$user_token;
                $arrPosSelect = array_filter($post['pos']);
                array_push($arrPosSelect,$POS_ID);
                $posIdList = implode(',',$arrPosSelect);

                $paramAddItem = array(
                    'pos_id_list' => $posIdList,
                    'table_name' => 'DM_ITEM',
                    'data_id' => $model->ITEM_ID,
                    'data' => json_encode($itemData),
                );

                $add = ApiController::getApiByMethod($name,$apiPath,$paramAddItem,$headers,'POST');

                if(isset($add->data)){
                    Yii::$app->session->setFlash('success', 'Tạo món '.$model->ITEM_NAME.' thành công và đã tạo cho các nhà hàng đã chọn');
                }else{
                    Yii::$app->session->setFlash('error', $add->error->message);
                }

            }else{

                $paramAddItem = array(
                    'pos_id_list' => $POS_ID,
                    'table_name' => 'DM_ITEM',
                    'data_id' => $model->ITEM_ID,
                    'data' => json_encode($itemData),
                );

                $add = ApiController::getApiByMethod($name,$apiPath,$paramAddItem,$headers,'POST');

                if(isset($add->data)){
                    Yii::$app->session->setFlash('success', 'Tạo món '.$model->ITEM_NAME.' thành công');
                }else{
                    Yii::$app->session->setFlash('error', $add->error->message);
                }
            }*/



        } else {

            $searchPosModel = new DmposSearch();
            $id = $searchPosModel->getIds();
            $allPos = $searchPosModel->searchAllPosById($id);
            $allPosMap= ArrayHelper::map($allPos,'ID','POS_NAME');
            unset($allPosMap[$POS_ID]);

            $itemSearch = new DmitemSearch();
            $items = $itemSearch->searchItemByPos($POS_ID);
            $itemMap = ArrayHelper::map($items,'ITEM_ID','ITEM_NAME');

            $itemEatWithObj = $itemSearch->searchItemEatWith($POS_ID);
            $itemEatWith = ArrayHelper::map($itemEatWithObj,'ITEM_ID','ITEM_NAME');


            $searchItemTypeModel = new DmitemtypeSearch();
            $allItemType = $searchItemTypeModel->searchCategoryByPos($id);
            $itemTypeMap = ArrayHelper::map($allItemType,'ITEM_TYPE_ID','ITEM_TYPE_NAME');
            $model->SORT = 1000;
            $model->ALLOW_TAKE_AWAY = 1;
            $model->ACTIVE = 1;

            return $this->render('_form_parent_item', [
                'model' => $model,
                'itemTypeMap' => $itemTypeMap,
                'POS_ID' => $POS_ID,
                'autoGenId' => $autoGenId,
                'allPosMap' => $allPosMap,
                'allPos' => $allPos,
                'itemMap' => $itemMap,
                'itemEatWith' => $itemEatWith,
                'itemTypeMasterMap' => $itemTypeMasterMap,
            ]);

        }
    }

    public function actionCreateitemlala($POS_ID)
    {

        $model = new Dmitem();
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS_MOBILE'];
        $access_token = Yii::$app->params['ACCESS_TOKEN'];
        $user_token = \Yii::$app->session->get('user_token');

        //Check Auto genagen Id
        $nameGetPosparent = 'manager/get_pos_parent';
        $paramPosparent = array();

        $posparent = ApiController::getLalaApiByMethod($nameGetPosparent,$apiPath,$paramPosparent,'GET');
        $autoGenId = $posparent->data->auto_generate_id;

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            $pathServer = Yii::$app->params['ITEM_IMAGE_PATH'].'/'.$POS_ID.'/';
            $pathServerThumb = Yii::$app->params['ITEM_IMAGE_PATH'].'/thumbs/'.$POS_ID.'/';
            if($post['img-link']){
                $model->ITEM_IMAGE_PATH = $post['img-link'];
                $model->ITEM_IMAGE_PATH_THUMB = $post['img-link'];
            }else{
                if(UploadedFile::getInstance($model,'ITEM_IMAGE_PATH')){
                    $fileImage = UploadedFile::getInstance($model,'ITEM_IMAGE_PATH');

                    // Convert chữ bỏ hết dấu của tên file
                    $fileImage->name = FormatConverter::removesign($fileImage->name);

                    //Kiểm tra thư mục, nếu chưa có thì tạo ra folder Images
                    DmposController::createDirectory('../../images/fb/items/'.$POS_ID.'/');

                    $fileImage->saveAs('../../images/fb/items/'.$POS_ID.'/'.$fileImage->name);
                    $model->ITEM_IMAGE_PATH = $pathServer.$fileImage->name;

                    //Kiểm tra thư mục, nếu chưa có thì tạo ra folder Images Thumbs
                    DmposController::createDirectory('../../images/fb/items/thumbs/'.$POS_ID.'/');
                    Image::thumbnail('../../images/fb/items/'.$POS_ID.'/'.$fileImage->name, 400, 400)->save('../../images/fb/items/thumbs/'.$POS_ID.'/'.$fileImage->name, ['quality' => 80]);
                    $model->ITEM_IMAGE_PATH_THUMB = $pathServerThumb.$fileImage->name;
//                var_dump($model->ITEM_IMAGE_PATH);
//                die();
                }else{
                    if(isset($post['ITEM_IMAGE_PATH-old'])){
                        $model->ITEM_IMAGE_PATH = $post['ITEM_IMAGE_PATH-old'];
                        $model->ITEM_IMAGE_PATH_THUMB = $post['ITEM_IMAGE_PATH_THUMB-old'];
                    }
                }
            }



            $name = 'manager/add_data';
            if($model->STOCK_QUANTITY){
                $model->IS_STOCK = 1;
            }

            if($model->SORT == ''){
                $model->SORT = 1000;
            }


            $itemData = array(
                'pos_id' => $POS_ID,
                'item_name' => $model->ITEM_NAME,
                'item_id' => strtoupper($model->ITEM_ID),
                'item_type_id' => $model->ITEM_TYPE_ID,
                'item_image_path' => $model->ITEM_IMAGE_PATH,
                'item_image_path_thumb' => $model->ITEM_IMAGE_PATH_THUMB,
                'description' => $model->DESCRIPTION,
                'ots_price' => $model->OTS_PRICE,
                'ta_price' => $model->TA_PRICE,
                'active' => $model->ACTIVE,
                'vat_tax_rate' => $model->VAT_TAX_RATE/100,
                'stock_quantity' => $model->STOCK_QUANTITY,
                'is_stock' => $model->IS_STOCK,
                'allow_take_away' => $model->ALLOW_TAKE_AWAY,
                'sort' => $model->SORT,
                'is_gift' => $model->IS_GIFT,
                'point' => (int)$model->POINT,
            );


            $headers = array();
            $headers[] = 'access_token: '.$access_token;
            $headers[] = 'token: '.$user_token;


            if(isset($post['pos'])){

                $arrPosSelect = array_filter($post['pos']);
                array_push($arrPosSelect,$POS_ID);
                $posIdList = implode(',',$arrPosSelect);

                $paramAddItem = array(
                    'pos_id_list' => $posIdList,
                    'table_name' => 'DM_ITEM',
                    'data_id' => $model->ITEM_ID,
                    'data' => json_encode($itemData,JSON_UNESCAPED_UNICODE),
                );

                $add = ApiController::getLalaApiByMethod($name,$apiPath,$paramAddItem,'POST');

                if(isset($add->data)){
                    Yii::$app->session->setFlash('success', 'Tạo món '.$model->ITEM_NAME.' thành công và đã tạo cho các nhà hàng đã chọn');
                }else{
                    Yii::$app->session->setFlash('error', $add->error->message);
                }

            }else{


                $paramAddItem = array(
                    'pos_id_list' => $POS_ID,
                    'table_name' => 'DM_ITEM',
                    'data_id' => $model->ITEM_ID,
                    'data' => json_encode($itemData,JSON_UNESCAPED_UNICODE),
                );

                $add = ApiController::getLalaApiByMethod($name,$apiPath,$paramAddItem,'POST');

                if(isset($add->data)){
                    Yii::$app->session->setFlash('success', 'Tạo món '.$model->ITEM_NAME.' thành công');
                }else{
                    Yii::$app->session->setFlash('error', $add->error->message);
                }

            }


            return $this->redirect(['viewlala', 'id' => $POS_ID]);
        } else {

            $searchPosModel = new DmposSearch();
            $id = $searchPosModel->getIds();
            $allPos = $searchPosModel->searchAllPosById($id);
            $allPosMap= ArrayHelper::map($allPos,'ID','POS_NAME');
            unset($allPosMap[$POS_ID]);


            //Get Item by User
            $name = 'manager/list_data';
            $paramItemType = array(
                'pos_id' => $POS_ID,
                'table_name' => 'DM_ITEM_TYPE',
            );

            $itemTypeList = ApiController::getLalaApiByMethod($name,$apiPath,$paramItemType,'GET');


            $listItemType = array();

            if(isset($itemTypeList->data)){
                $listItemType = json_decode(json_encode($itemTypeList->data),true);
            }

            $itemTypeMap = ArrayHelper::map($listItemType,'item_type_id','item_type_name');

            return $this->render('create_item_lala', [
                'model' => $model,
                'itemTypeMap' => $itemTypeMap,
                'POS_ID' => $POS_ID,
                'autoGenId' => $autoGenId,
                'allPosMap' => $allPosMap,
                'allPos' => $allPos,
            ]);

        }
    }

    public function actionCreatetypelala($POS_ID){

        $model = new Dmitemtype();
        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            $tableName = 'DM_ITEM_TYPE';
            $itemData = [
                'item_type_id' => strtoupper($model->ITEM_TYPE_ID),
                'item_type_name' => $model->ITEM_TYPE_NAME,
                'active' => $model->ACTIVE
            ];

            if(isset($post['sync'])){

                $arrPosSelect = array();
                if(isset($post['pos'])){
                    $arrPosSelect = array_filter($post['pos']);
                }

                array_push($arrPosSelect,$POS_ID);
                $posIdList = implode(',',$arrPosSelect);

                $add = ApiController::pmAddData($posIdList,$tableName,$itemData,$model->ITEM_TYPE_ID);

                if(isset($add->data)){
                    Yii::$app->session->setFlash('success', 'Tạo loại món '.$model->ITEM_TYPE_NAME.' thành công và đã tạo cho các nhà hàng đã chọn');
                }else{
                    Yii::$app->session->setFlash('error', 'Tạo loại món lỗi');
                }

            }else{

                $add = ApiController::pmAddData($POS_ID,$tableName,$itemData);


                if(isset($add->data)){
                    Yii::$app->session->setFlash('success', 'Tạo loại món '.$model->ITEM_TYPE_NAME.' thành công');
                }else{
                    Yii::$app->session->setFlash('error', 'Tạo loại món lỗi');
                }


            }

            return $this->redirect(['itemtype', 'id' => $POS_ID]);

        } else {

            $apiPath = Yii::$app->params['CMS_API_PATH_IPOS_MOBILE'];
            //Check Auto genagen Id
            $nameGetPosparent = 'manager/get_pos_parent';
            $paramPosparent = array();

            $posparent = ApiController::getLalaApiByMethod($nameGetPosparent,$apiPath,$paramPosparent,'GET');
            $autoGenId = $posparent->data->auto_generate_id;


            $searchPosModel = new DmposSearch();
            $id = $searchPosModel->getIds();
            $allPos = $searchPosModel->searchAllPosById($id);
            $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');
//            echo '<pre>';
//            var_dump($allPosMap);
//            echo '</pre>';
            unset($allPosMap[$POS_ID]);

//            echo '<pre>';
//            var_dump($allPosMap);
//            echo '</pre>';
//            die();


            return $this->render('create_item_type', [
                'model' => $model,
                'autoGenId' => $autoGenId,
                'allPosMap' => $allPosMap,
                'allPos' => $allPos,
                'POS_ID' => $POS_ID,
            ]);
        }
    }



    public function actionUpdateitemlala($id,$POS_ID)
    {
        $model = new Dmitem();
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS_MOBILE'];
        $access_token = Yii::$app->params['ACCESS_TOKEN_LALA'];
        $user_token = \Yii::$app->session->get('user_token');

        //Check Auto genagen Id
        $nameGetPosparent = 'manager/get_pos_parent';
        $paramPosparent = array();

        $posparent = ApiController::getLalaApiByMethod($nameGetPosparent,$apiPath,$paramPosparent,'GET');
        $autoGenId = $posparent->data->auto_generate_id;

        $name = 'manager/list_data';
        $paramItem = array(
            'pos_id' => $POS_ID,
            'table_name' => 'DM_ITEM',
        );

        $itemList = ApiController::getLalaApiByMethod($name,$apiPath,$paramItem,'GET');

        if(isset($itemList->data)){
            foreach($itemList->data as $item){
                if($item->id == $id){
                    $model->ID = $item->id;
                    $model->POS_ID = $item->pos_id;
                    $model->ITEM_NAME = $item->item_name;
                    $model->ITEM_ID = $item->item_id;
                    $model->ITEM_TYPE_ID = $item->item_type_id;
                    $model->ITEM_IMAGE_PATH = $item->item_image_path;
                    $model->DESCRIPTION = $item->description;
                    $model->OTS_PRICE = $item->ots_price;
                    $model->TA_PRICE = $item->ta_price;
                    $model->ACTIVE = $item->active;
                    $model->VAT_TAX_RATE = $item->vat_tax_rate;
                    $model->STOCK_QUANTITY = $item->stock_quantity;
                    $model->IS_STOCK = $item->is_stock;
                    $model->ALLOW_TAKE_AWAY = $item->allow_take_away;
                    $model->ALLOW_TAKE_AWAY = $item->allow_take_away;
                    $model->SORT = $item->sort;
                }
            }
        }




        if ($model->load(Yii::$app->request->post())) {

            $post = Yii::$app->request->post();
            $pathServer = Yii::$app->params['ITEM_IMAGE_PATH'].'/'.$POS_ID.'/';
            $pathServerThumb = Yii::$app->params['ITEM_IMAGE_PATH'].'/thumbs/'.$POS_ID.'/';
            if($post['img-link']){
                $model->ITEM_IMAGE_PATH = $post['img-link'];
                $model->ITEM_IMAGE_PATH_THUMB = $post['img-link'];
            }else{
                if(UploadedFile::getInstance($model,'ITEM_IMAGE_PATH')){
                    $fileImage = UploadedFile::getInstance($model,'ITEM_IMAGE_PATH');

                    // Convert chữ bỏ hết dấu của tên file
                    $fileImage->name = FormatConverter::removesign($fileImage->name);

                    //Kiểm tra thư mục, nếu chưa có thì tạo ra folder Images
                    DmposController::createDirectory('../../images/fb/items/'.$POS_ID.'/');

                    $fileImage->saveAs('../../images/fb/items/'.$POS_ID.'/'.$fileImage->name);
                    $model->ITEM_IMAGE_PATH = $pathServer.$fileImage->name;

                    //Kiểm tra thư mục, nếu chưa có thì tạo ra folder Images Thumbs
                    DmposController::createDirectory('../../images/fb/items/thumbs/'.$POS_ID.'/');
                    Image::thumbnail('../../images/fb/items/'.$POS_ID.'/'.$fileImage->name, 400, 400)->save('../../images/fb/items/thumbs/'.$POS_ID.'/'.$fileImage->name, ['quality' => 80]);
                    $model->ITEM_IMAGE_PATH_THUMB = $pathServerThumb.$fileImage->name;
//                var_dump($model->ITEM_IMAGE_PATH);
//                die();
                }else{
                    if(isset($post['ITEM_IMAGE_PATH-old'])){
                        $model->ITEM_IMAGE_PATH = $post['ITEM_IMAGE_PATH-old'];
                    }
                }
            }



            $name = 'manager/updated_data';
            if($model->STOCK_QUANTITY){
                $model->IS_STOCK = 1;
            }

            if($model->SORT == ''){
                $model->SORT = 1000;
            }


            $itemData = array(
                'pos_id' => $POS_ID,
                'item_name' => $model->ITEM_NAME,
                'item_id' => strtoupper($model->ITEM_ID),
                'item_type_id' => $model->ITEM_TYPE_ID,
                'item_image_path' => $model->ITEM_IMAGE_PATH,
                'item_image_path_thumb' => $model->ITEM_IMAGE_PATH_THUMB,
                'description' => $model->DESCRIPTION,
                'ots_price' => $model->OTS_PRICE,
                'ta_price' => $model->TA_PRICE,
                'active' => $model->ACTIVE,
                'vat_tax_rate' => $model->VAT_TAX_RATE/100,
                'stock_quantity' => $model->STOCK_QUANTITY,
                'is_stock' => $model->IS_STOCK,
                'allow_take_away' => $model->ALLOW_TAKE_AWAY,
                'sort' => $model->SORT,
                'is_gift' => $model->IS_GIFT,
                'point' => (int)$model->POINT,
            );


            $headers = array();
            $headers[] = 'access_token: '.$access_token;
            $headers[] = 'token: '.$user_token;


            if(isset($post['pos'])){

                $arrPosSelect = array_filter($post['pos']);
                array_push($arrPosSelect,$POS_ID);
                $posIdList = implode(',',$arrPosSelect);

                $paramAddItem = array(
                    'pos_id_list' => $posIdList,
                    'table_name' => 'DM_ITEM',
                    'data_id' => $model->ITEM_ID,
                    'data' => json_encode($itemData,JSON_UNESCAPED_UNICODE),
                );

                $add = ApiController::getLalaApiByMethod($name,$apiPath,$paramAddItem,'POST');

                if(isset($add->data)){
                    Yii::$app->session->setFlash('success', 'Tạo món '.$model->ITEM_NAME.' thành công và đã tạo cho các nhà hàng đã chọn');
                }else{
                    Yii::$app->session->setFlash('error', $add->error->message);
                }

            }else{


                $paramAddItem = array(
                    'pos_id_list' => $POS_ID,
                    'table_name' => 'DM_ITEM',
                    'data_id' => $model->ITEM_ID,
                    'data' => json_encode($itemData,JSON_UNESCAPED_UNICODE),
                );

                $add = ApiController::getLalaApiByMethod($name,$apiPath,$paramAddItem,'POST');

                if(isset($add->data)){
                    Yii::$app->session->setFlash('success', 'Tạo món '.$model->ITEM_NAME.' thành công');
                }else{
                    Yii::$app->session->setFlash('error', $add->error->message);
                }

            }


            return $this->redirect(['viewlala', 'id' => $POS_ID]);
        } else {

            $searchPosModel = new DmposSearch();
            $ids = $searchPosModel->getIds();
            $allPos = $searchPosModel->searchAllPosById($ids);
            $allPosMap= ArrayHelper::map($allPos,'ID','POS_NAME');
            unset($allPosMap[$POS_ID]);

            //Get Item by User
            $name = 'manager/list_data';
            $paramItemType = array(
                'pos_id' => $POS_ID,
                'table_name' => 'DM_ITEM_TYPE',
            );

            $itemTypeList = ApiController::getLalaApiByMethod($name,$apiPath,$paramItemType,'GET');


            $listItemType = array();

            if(isset($itemTypeList->data)){
                $listItemType = json_decode(json_encode($itemTypeList->data),true);
            }

            $itemTypeMap = ArrayHelper::map($listItemType,'item_type_id','item_type_name');

            return $this->render('update_item_lala', [
                'model' => $model,
                'itemTypeMap' => $itemTypeMap,
                'POS_ID' => $POS_ID,
                'autoGenId' => $autoGenId,
                'allPosMap' => $allPosMap,
                'allPos' => $allPos,
            ]);
        }
    }





    /**
     * Updates an existing Dmpos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */

    public function actionUpdate($ID, $POS_ID)
    {
        //$model = $this->findModel($ID);
        $model = Dmitem::find()->where(['ID' => $ID])->andWhere(['POS_ID' => $POS_ID])->one();
        $itemSearch = new DmitemSearch();
        $items = $itemSearch->searchItemByPos($POS_ID);
        $itemMap = ArrayHelper::map($items,'ITEM_ID','ITEM_NAME');

        $subItems = $itemSearch->searchItemByParentItem($model->ITEM_ID);
        $model->LIST_SUB_ITEM = ArrayHelper::map($subItems,'ITEM_ID','ITEM_ID');


        $searchPosModel = new DmposSearch();
        $allPos = $searchPosModel->searchAllPosById($POS_ID);
        $allPosMap= ArrayHelper::map($allPos,'ID','POS_NAME');
        unset($allPosMap[$POS_ID]);
        if($model->IS_PARENT){

        }

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();

            $pathServer = Yii::$app->params['ITEM_IMAGE_PATH'].'/'.$POS_ID.'/';
            $pathServerThumb = Yii::$app->params['ITEM_IMAGE_PATH'].'/thumbs/'.$POS_ID.'/';

            if(UploadedFile::getInstance($model,'ITEM_IMAGE_PATH')){
                $fileImage = UploadedFile::getInstance($model,'ITEM_IMAGE_PATH');

                // Convert chữ bỏ hết dấu của tên file
                $fileImage->name = FormatConverter::removesign($fileImage->name);
//                echo $fileImage->name;
//                die();
                //$fileImage->saveAs($realPath.'img/campaign/'.$fileImage->name);

                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder Images
                DmposController::createDirectory('../../images/fb/items/'.$POS_ID.'/');

                $fileImage->saveAs('../../images/fb/items/'.$POS_ID.'/'.$fileImage->name);
                $model->ITEM_IMAGE_PATH = $pathServer.$fileImage->name;

                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder Images Thumbs
                DmposController::createDirectory('../../images/fb/items/thumbs/'.$POS_ID.'/');
                Image::thumbnail('../../images/fb/items/'.$POS_ID.'/'.$fileImage->name, 185, 185)->save('../../images/fb/items/thumbs/'.$POS_ID.'/'.$fileImage->name, ['quality' => 80]);
                $model->ITEM_IMAGE_PATH_THUMB = $pathServerThumb.$fileImage->name;
//                var_dump($model->ITEM_IMAGE_PATH);
//                die();
            }else{
                if(isset($post['ITEM_IMAGE_PATH-old'])){
                    $model->ITEM_IMAGE_PATH = $post['ITEM_IMAGE_PATH-old'];
                }
            }

            if(UploadedFile::getInstance($model,'FB_IMAGE_PATH')){
                $fileImage = UploadedFile::getInstance($model,'FB_IMAGE_PATH');

                // Convert chữ bỏ hết dấu của tên file
                $fileImage->name = FormatConverter::removesign($fileImage->name);
                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder
                DmposController::createDirectory('../../images/fb/items/'.$POS_ID.'/');
                $fileImage->saveAs('../../images/fb/items/'.$POS_ID.'/'.$fileImage->name);
                $model->FB_IMAGE_PATH = $pathServer.$fileImage->name;

                DmposController::createDirectory('../../images/fb/items/thumbs'.$POS_ID.'/');
                Image::thumbnail('../../images/fb/items/'.$POS_ID.'/'.$fileImage->name, 185, 185)->save('../../images/fb/items/thumbs/'.$POS_ID.'/'.$fileImage->name, ['quality' => 80]);
                $model->ITEM_IMAGE_PATH_THUMB = $pathServerThumb.$fileImage->name;
            }else{
                if(isset($post['FB_IMAGE_PATH-old'])){
                    $model->FB_IMAGE_PATH = $post['FB_IMAGE_PATH-old'];
                }

            }

            if(is_array($model->ITEM_ID_EAT_WITH)){
                $model->ITEM_ID_EAT_WITH = implode(",",$model->ITEM_ID_EAT_WITH);
            }else{
                $model->ITEM_ID_EAT_WITH = NULL;
            }


            if(isset($post['btn_for_all'])){
                $dmposSearch = new DmposSearch();
                $pos_parent = $dmposSearch->searchById($model->POS_ID);
                $posArr = $dmposSearch->searchAllActiveAndDeactiveByPosParent($pos_parent);

                $posMap = ArrayHelper::map($posArr,'ID','ID');
                $pos_list = implode(",",$posMap);
                $paramUpdateArr = [
                    'ITEM_IMAGE_PATH' => $model->ITEM_IMAGE_PATH,
                    'ITEM_IMAGE_PATH_THUMB' => $model->ITEM_IMAGE_PATH_THUMB,
//                        'FB_IMAGE_PATH' => $model->FB_IMAGE_PATH,
//                        'FB_IMAGE_PATH_THUMB' => $model->FB_IMAGE_PATH_THUMB,
                    'ACTIVE' => (int)$model->ACTIVE,
                    'ITEM_TYPE_MASTER_ID' => $model->ITEM_TYPE_MASTER_ID,
                    'ITEM_TYPE_ID' => $model->ITEM_TYPE_ID,
                    'ITEM_ID_EAT_WITH' => $model->ITEM_ID_EAT_WITH,
                    'DESCRIPTION' => $model->DESCRIPTION,

                ];

                if($model->IS_FEATURED){
                    $paramUpdateArr['IS_FEATURED'] = $model->IS_FEATURED;
                }
                Dmitem::updateAll(
                    $paramUpdateArr
                    , 'POS_ID IN ('.$pos_list.') AND ITEM_ID = "'.$model->ITEM_ID.'" ');
            }

            $sumday = 0;
//            echo '<pre>';
//            var_dump($model->TIME_SALE_DATE_WEEK);
//            echo '</pre>';
//            die();
            foreach((array)$model->TIME_SALE_DATE_WEEK as $day){
                $sumday = pow(2,$day)+ $sumday;
            }
            $model->TIME_SALE_DATE_WEEK = $sumday;



            $sumhour = 0;
            foreach((array)$model->TIME_SALE_HOUR_DAY as $hour){
                $sumhour = pow(2,$hour)+ $sumhour;
            }
            $model->TIME_SALE_HOUR_DAY = $sumhour;

//            echo '<pre>';
//            var_dump($model->TIME_SALE_HOUR_DAY);
//            echo '</pre>';
            //die();

            $oldModel = $model->oldAttributes;

            if($model->save()){
                DmquerylogController::actionCreateLog('UPDATE',get_class($model),$oldModel,$model->attributes);
                Yii::$app->session->setFlash('success', 'Cập nhật món '.$model->ITEM_NAME.' thành công');
                $mgItemUpdate = new MgitemchangedSearch();
                $mgItemUpdate->updatechange($model->POS_ID);


                if($model->IS_PARENT){
                    //Chuyển tất cả các món con về trạng thái bình thường, sau đó mới cập nhật lại nó là món con
                    $listOldSubItem = DmitemSearch::searchItemByParentItem($model->ITEM_ID);
                    $subItemMap = ArrayHelper::map($listOldSubItem,'ITEM_ID','ITEM_ID');
                    $resetSubItem = [
                        'IS_SUB' => '0',
                        'ITEM_ID_BARCODE' => NULL
                    ];
                    Dmitem::updateAll($resetSubItem, ['ITEM_ID' => $subItemMap ]);

                    //Sau đó mới cập nhật các giá trị mới vào
                    $update = [
                        'IS_SUB' => '1',
                        'ITEM_ID_BARCODE' => $model->ITEM_ID
                    ];
                    Dmitem::updateAll($update, ['ITEM_ID' => $model->LIST_SUB_ITEM ]);
                }
            }else{
                Yii::$app->session->setFlash('error', 'Cập nhật món lỗi');
            }

            return $this->redirect(['view', 'id' => $model->POS_ID/*, 'POS_ID' => $model->POS_ID*/]);
        } else {

            $timesaleBinArray = DmpositemController::DecToBin($model->TIME_SALE_DATE_WEEK,7); // 7 ngày
            $houraleBinArray = DmpositemController::DecToBin($model->TIME_SALE_HOUR_DAY,24); //24

            $searchModelItemMaster = new DmitemtypemasterSearch();
            $modelItemTypeMaster = $searchModelItemMaster->searchAllItemTypeMaster();
            $itemTypeMasterMap = ArrayHelper::map($modelItemTypeMaster,'ID','ITEM_TYPE_MASTER_NAME','SORT');

            $searchModelItemType = new DmitemtypeSearch();
            $modelItemType = $searchModelItemType->searchCategoryByPos($POS_ID);
            $itemTypeMap = ArrayHelper::map($modelItemType,'ITEM_TYPE_ID','ITEM_TYPE_NAME');


            $searchModel = new DmitemSearch();
            $modelItem = $searchModel->searchItemdetail($ID,$POS_ID);
            $itemEatWithObj = $searchModel->searchItemEatWith($POS_ID);
            $itemEatWith = ArrayHelper::map($itemEatWithObj,'ITEM_ID','ITEM_NAME');

            return $this->render('update', [
                'model' => $model,
                'modelItem' => $modelItem,
                'itemEatWith' => $itemEatWith,
                'timesaleBinArray' => $timesaleBinArray,
                'houraleBinArray' => $houraleBinArray,
                'itemTypeMasterMap' => $itemTypeMasterMap,
                'itemTypeMap' => $itemTypeMap,
                'itemMap' => $itemMap,
                'allPos' => $allPos,
                'POS_ID' => $POS_ID,
            ]);
        }
    }
    public function actionPosUpdate($ID, $POS_ID)
    {
        //$model = $this->findModel($ID);
        $model = Dmitem::find()->where(['ID' => $ID])->andWhere(['POS_ID' => $POS_ID])->one();
        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();

            $pathServer = Yii::$app->params['ITEM_IMAGE_PATH'].'/'.$POS_ID.'/';
            $pathServerThumb = Yii::$app->params['ITEM_IMAGE_PATH'].'/thumbs/'.$POS_ID.'/';

            if(UploadedFile::getInstance($model,'ITEM_IMAGE_PATH')){
                $fileImage = UploadedFile::getInstance($model,'ITEM_IMAGE_PATH');

                // Convert chữ bỏ hết dấu của tên file
                $fileImage->name = FormatConverter::removesign($fileImage->name);
//                echo $fileImage->name;
//                die();
                //$fileImage->saveAs($realPath.'img/campaign/'.$fileImage->name);

                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder Images
                DmposController::createDirectory('../../images/fb/items/'.$POS_ID.'/');

                $fileImage->saveAs('../../images/fb/items/'.$POS_ID.'/'.$fileImage->name);
                $model->ITEM_IMAGE_PATH = $pathServer.$fileImage->name;

                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder Images Thumbs
                DmposController::createDirectory('../../images/fb/items/thumbs/'.$POS_ID.'/');
                Image::thumbnail('../../images/fb/items/'.$POS_ID.'/'.$fileImage->name, 185, 185)->save('../../images/fb/items/thumbs/'.$POS_ID.'/'.$fileImage->name, ['quality' => 80]);
                $model->ITEM_IMAGE_PATH_THUMB = $pathServerThumb.$fileImage->name;
//                var_dump($model->ITEM_IMAGE_PATH);
//                die();
            }else{
                if(isset($post['ITEM_IMAGE_PATH-old'])){
                    $model->ITEM_IMAGE_PATH = $post['ITEM_IMAGE_PATH-old'];
                }
            }

            if(UploadedFile::getInstance($model,'FB_IMAGE_PATH')){
                $fileImage = UploadedFile::getInstance($model,'FB_IMAGE_PATH');

                // Convert chữ bỏ hết dấu của tên file
                $fileImage->name = FormatConverter::removesign($fileImage->name);
                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder
                DmposController::createDirectory('../../images/fb/items/'.$POS_ID.'/');
                $fileImage->saveAs('../../images/fb/items/'.$POS_ID.'/'.$fileImage->name);
                $model->FB_IMAGE_PATH = $pathServer.$fileImage->name;

                DmposController::createDirectory('../../images/fb/items/thumbs'.$POS_ID.'/');
                Image::thumbnail('../../images/fb/items/'.$POS_ID.'/'.$fileImage->name, 185, 185)->save('../../images/fb/items/thumbs/'.$POS_ID.'/'.$fileImage->name, ['quality' => 80]);
                $model->ITEM_IMAGE_PATH_THUMB = $pathServerThumb.$fileImage->name;
            }else{
                if(isset($post['FB_IMAGE_PATH-old'])){
                    $model->FB_IMAGE_PATH = $post['FB_IMAGE_PATH-old'];
                }

            }

            if(is_array($model->ITEM_ID_EAT_WITH)){
                $model->ITEM_ID_EAT_WITH = implode(",",$model->ITEM_ID_EAT_WITH);
            }else{
                $model->ITEM_ID_EAT_WITH = NULL;
            }


            if(isset($post['btn_for_all'])){
                $dmposSearch = new DmposSearch();
                $pos_parent = $dmposSearch->searchById($model->POS_ID);
                $posArr = $dmposSearch->searchAllActiveAndDeactiveByPosParent($pos_parent);

                $posMap = ArrayHelper::map($posArr,'ID','ID');
                $pos_list = implode(",",$posMap);
                $paramUpdateArr = [
                    'ITEM_IMAGE_PATH' => $model->ITEM_IMAGE_PATH,
                    'ITEM_IMAGE_PATH_THUMB' => $model->ITEM_IMAGE_PATH_THUMB,
//                        'FB_IMAGE_PATH' => $model->FB_IMAGE_PATH,
//                        'FB_IMAGE_PATH_THUMB' => $model->FB_IMAGE_PATH_THUMB,
                    'ACTIVE' => (int)$model->ACTIVE,
                    'ITEM_TYPE_MASTER_ID' => $model->ITEM_TYPE_MASTER_ID,
                    'ITEM_TYPE_ID' => $model->ITEM_TYPE_ID,
                    'ITEM_ID_EAT_WITH' => $model->ITEM_ID_EAT_WITH,
                    'DESCRIPTION' => $model->DESCRIPTION,

                ];

                if($model->IS_FEATURED){
                    $paramUpdateArr['IS_FEATURED'] = $model->IS_FEATURED;
                }
                Dmitem::updateAll(
                    $paramUpdateArr
                    , 'POS_ID IN ('.$pos_list.') AND ITEM_ID = "'.$model->ITEM_ID.'" ');
            }

            $sumday = 0;
//            echo '<pre>';
//            var_dump($model->TIME_SALE_DATE_WEEK);
//            echo '</pre>';
//            die();
            foreach((array)$model->TIME_SALE_DATE_WEEK as $day){
                $sumday = pow(2,$day)+ $sumday;
            }
            $model->TIME_SALE_DATE_WEEK = $sumday;



            $sumhour = 0;
            foreach((array)$model->TIME_SALE_HOUR_DAY as $hour){
                $sumhour = pow(2,$hour)+ $sumhour;
            }
            $model->TIME_SALE_HOUR_DAY = $sumhour;

//            echo '<pre>';
//            var_dump($model->TIME_SALE_HOUR_DAY);
//            echo '</pre>';
            //die();

            $oldModel = $model->oldAttributes;

            if($model->save()){
                DmquerylogController::actionCreateLog('UPDATE',get_class($model),$oldModel,$model->attributes);
                Yii::$app->session->setFlash('success', 'Cập nhật món '.$model->ITEM_NAME.' thành công');
                $mgItemUpdate = new MgitemchangedSearch();
                $mgItemUpdate->updatechange($model->POS_ID);
            }else{
                Yii::$app->session->setFlash('error', 'Cập nhật món lỗi');
            }

            return $this->redirect(['view', 'id' => $model->POS_ID/*, 'POS_ID' => $model->POS_ID*/]);
        } else {

            $timesaleBinArray = DmpositemController::DecToBin($model->TIME_SALE_DATE_WEEK,7); // 7 ngày
            $houraleBinArray = DmpositemController::DecToBin($model->TIME_SALE_HOUR_DAY,24); //24

            $searchModelItemMaster = new DmitemtypemasterSearch();
            $modelItemTypeMaster = $searchModelItemMaster->searchAllItemTypeMaster();
            $itemTypeMasterMap = ArrayHelper::map($modelItemTypeMaster,'ID','ITEM_TYPE_MASTER_NAME','SORT');

            $searchModelItemType = new DmitemtypeSearch();
            $modelItemType = $searchModelItemType->searchCategoryByPos($POS_ID);
            $itemTypeMap = ArrayHelper::map($modelItemType,'ITEM_TYPE_ID','ITEM_TYPE_NAME');


            $searchModel = new DmitemSearch();
            $modelItem = $searchModel->searchItemdetail($ID,$POS_ID);
            $itemEatWithObj = $searchModel->searchItemEatWith($POS_ID);
            $itemEatWith = ArrayHelper::map($itemEatWithObj,'ITEM_ID','ITEM_NAME');

            return $this->render('update', [
                'model' => $model,
                'modelItem' => $modelItem,
                'itemEatWith' => $itemEatWith,
                'timesaleBinArray' => $timesaleBinArray,
                'houraleBinArray' => $houraleBinArray,
                'itemTypeMasterMap' => $itemTypeMasterMap,
                'itemTypeMap' => $itemTypeMap,
            ]);
        }
    }

    public function actionMultieatwith($POS_ID)
    {
        $model = new Dmitem();

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();

            $pathServer = Yii::$app->params['ITEM_IMAGE_PATH'].'/'.$POS_ID.'/';
            $pathServerThumb = Yii::$app->params['ITEM_IMAGE_PATH'].'/thumbs/'.$POS_ID.'/';

            if(UploadedFile::getInstance($model,'ITEM_IMAGE_PATH')){
                $fileImage = UploadedFile::getInstance($model,'ITEM_IMAGE_PATH');

                // Convert chữ bỏ hết dấu của tên file
                $fileImage->name = FormatConverter::removesign($fileImage->name);
//                echo $fileImage->name;
//                die();
                //$fileImage->saveAs($realPath.'img/campaign/'.$fileImage->name);

                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder Images
                DmposController::createDirectory('../../images/fb/items/'.$POS_ID.'/');

                $fileImage->saveAs('../../images/fb/items/'.$POS_ID.'/'.$fileImage->name);
                $model->ITEM_IMAGE_PATH = $pathServer.$fileImage->name;

                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder Images Thumbs
                DmposController::createDirectory('../../images/fb/items/thumbs/'.$POS_ID.'/');
                Image::thumbnail('../../images/fb/items/'.$POS_ID.'/'.$fileImage->name, 185, 185)->save('../../images/fb/items/thumbs/'.$POS_ID.'/'.$fileImage->name, ['quality' => 80]);
                $model->ITEM_IMAGE_PATH_THUMB = $pathServerThumb.$fileImage->name;
//                var_dump($model->ITEM_IMAGE_PATH);
//                die();
            }else{
                if(isset($post['ITEM_IMAGE_PATH-old'])){
                    $model->ITEM_IMAGE_PATH = $post['ITEM_IMAGE_PATH-old'];
                }
            }

            if(UploadedFile::getInstance($model,'FB_IMAGE_PATH')){
                $fileImage = UploadedFile::getInstance($model,'FB_IMAGE_PATH');

                // Convert chữ bỏ hết dấu của tên file
                $fileImage->name = FormatConverter::removesign($fileImage->name);
                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder
                DmposController::createDirectory('../../images/fb/items/'.$POS_ID.'/');
                $fileImage->saveAs('../../images/fb/items/'.$POS_ID.'/'.$fileImage->name);
                $model->FB_IMAGE_PATH = $pathServer.$fileImage->name;

                DmposController::createDirectory('../../images/fb/items/thumbs'.$POS_ID.'/');
                Image::thumbnail('../../images/fb/items/'.$POS_ID.'/'.$fileImage->name, 185, 185)->save('../../images/fb/items/thumbs/'.$POS_ID.'/'.$fileImage->name, ['quality' => 80]);
                $model->ITEM_IMAGE_PATH_THUMB = $pathServerThumb.$fileImage->name;
            }else{
                if(isset($post['FB_IMAGE_PATH-old'])){
                    $model->FB_IMAGE_PATH = $post['FB_IMAGE_PATH-old'];
                }

            }

            if(is_array($model->ITEM_ID_EAT_WITH)){
                $model->ITEM_ID_EAT_WITH = implode(",",$model->ITEM_ID_EAT_WITH);
            }else{
                $model->ITEM_ID_EAT_WITH = NULL;
            }


            if(isset($post['btn_for_all'])){
                $dmposSearch = new DmposSearch();
                $pos_parent = $dmposSearch->searchById($model->POS_ID);
                $posArr = $dmposSearch->searchAllActiveAndDeactiveByPosParent($pos_parent);

                $posMap = ArrayHelper::map($posArr,'ID','ID');
                $pos_list = implode(",",$posMap);
                $paramUpdateArr = [
                    'ITEM_IMAGE_PATH' => $model->ITEM_IMAGE_PATH,
                    'ITEM_IMAGE_PATH_THUMB' => $model->ITEM_IMAGE_PATH_THUMB,
//                        'FB_IMAGE_PATH' => $model->FB_IMAGE_PATH,
//                        'FB_IMAGE_PATH_THUMB' => $model->FB_IMAGE_PATH_THUMB,
                    'ACTIVE' => (int)$model->ACTIVE,
                    'ITEM_TYPE_MASTER_ID' => $model->ITEM_TYPE_MASTER_ID,
                    'ITEM_TYPE_ID' => $model->ITEM_TYPE_ID,
                    'ITEM_ID_EAT_WITH' => $model->ITEM_ID_EAT_WITH,
                ];

                if($model->IS_FEATURED){
                    $paramUpdateArr['IS_FEATURED'] = $model->IS_FEATURED;
                }
                Dmitem::updateAll(
                    $paramUpdateArr
                    , 'POS_ID IN ('.$pos_list.') AND ITEM_ID = "'.$model->ITEM_ID.'" ');
            }

            $sumday = 0;
//            echo '<pre>';
//            var_dump($model->TIME_SALE_DATE_WEEK);
//            echo '</pre>';
//            die();
            foreach((array)$model->TIME_SALE_DATE_WEEK as $day){
                $sumday = pow(2,$day)+ $sumday;
            }
            $model->TIME_SALE_DATE_WEEK = $sumday;



            $sumhour = 0;
            foreach((array)$model->TIME_SALE_HOUR_DAY as $hour){
                $sumhour = pow(2,$hour)+ $sumhour;
            }
            $model->TIME_SALE_HOUR_DAY = $sumhour;



            $oldModel = $model->oldAttributes;

            if($model->save()){
                DmquerylogController::actionCreateLog('UPDATE',get_class($model),$oldModel,$model->attributes);
                Yii::$app->session->setFlash('success', 'Cập nhật món '.$model->ITEM_NAME.' thành công');
            }else{
                Yii::$app->session->setFlash('error', 'Cập nhật món lỗi');
            }

            return $this->redirect(['view', 'id' => $model->POS_ID/*, 'POS_ID' => $model->POS_ID*/]);
        } else {

            $searchModel = new DmitemSearch();
            $items = $searchModel->searchMainItemByPos($POS_ID);
            $itemsMap = ArrayHelper::map($items,'ID','ITEM_NAME');
            $itemEatWithObj = $searchModel->searchItemEatWith($POS_ID);
            $itemEatWith = ArrayHelper::map($itemEatWithObj,'ITEM_ID','ITEM_NAME');


            return $this->render('multi_eatwith', [
                'model' => $model,
                'itemsMap' => $itemsMap,
                'itemEatWith' => $itemEatWith,
            ]);
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


    protected function findModelitemtype($id)
    {
        if (($model = Dmitemtype::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    static  function DecToBin($time,$count = 7){
        //var_dump(pow(2,4) & 254);
        $mapvalue = NULL;
        for ($i = 1; $i <= $count; $i++) {
            //var_dump(pow(2,$i) & $time);
            if((pow(2,$i) & $time) > 0){
                $mapvalue[] = $i;
            };
        }
        return $mapvalue;
    }

}
