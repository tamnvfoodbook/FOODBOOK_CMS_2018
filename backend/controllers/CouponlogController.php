<?php

namespace backend\controllers;

use backend\models\Coupon;
use backend\models\CouponSearch;
use backend\models\Dmposparent;
use backend\models\DmposparentSearch;
use backend\models\DmposSearch;
use backend\models\User;
use backend\models\UserSearch;
use Yii;
use backend\models\Couponlog;
use backend\models\Dmpos;
use backend\models\Dmmembership;
use backend\models\CouponlogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * CouponlogController implements the CRUD actions for Couponlog model.
 */
class CouponlogController extends Controller
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
     * Lists all Couponlog models.
     * @return mixed
     */
    public function actionIndex()
    {

        $type = \Yii::$app->session->get('type_acc');

        $searchModel = new CouponlogSearch();
        if($type != 1){
            $searchPosModel = new DmposSearch();
            $ids = $searchPosModel->getIds();

            $dataProviderPos = $searchModel->search(Yii::$app->request->queryParams,'COUPON_TYPE_POS',$ids);
            $dataProviderParent = $searchModel->search(Yii::$app->request->queryParams,'COUPON_TYPE_POS_PARENT',$ids);
            $dataProviderFb = $searchModel->search(Yii::$app->request->queryParams,'COUPON_TYPE_FOODBOOK',$ids);

        }else{
            $dataProviderPos = $searchModel->search(Yii::$app->request->queryParams,'COUPON_TYPE_POS');
            $dataProviderParent = $searchModel->search(Yii::$app->request->queryParams,'COUPON_TYPE_POS_PARENT');
            $dataProviderFb = $searchModel->search(Yii::$app->request->queryParams,'COUPON_TYPE_FOODBOOK');
        }


        $searchPosModel = new DmposSearch();
        $allPos = $searchPosModel->searchAllPos();
        $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProviderPos' => $dataProviderPos,
            'dataProviderParent' => $dataProviderParent,
            'dataProviderFb' => $dataProviderFb,
            'allPosMap' => $allPosMap,
        ]);
    }

    /**
     * Displays a single Couponlog model.
     * @param integer $_id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new CouponlogSearch();
        $model = $searchModel->findOneCouponLog($id);

        if($model->Active == 1 ){
            $model->Active = 'Active';
        }else{
            if($model->Payment_At){
                $model->Active = 'Deactive ('.date('Y-m-d',$model->Payment_At->sec).')';
            }else{
                $model->Active = 'Deactive';
            }

        }

        $model->Coupon_Log_Start  = date('d/m/Y', ($model->Coupon_Log_Start->sec));
        $model->Coupon_Log_End  = date('d/m/Y', ($model->Coupon_Log_End->sec));
        $model->Coupon_Log_Date  = date('d/m/Y',($model->Coupon_Log_Date->sec));

        return $this->render('view',[ 'model' => $model ]);
    }

    /**
     * Creates a new Couponlog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public  function preparData(){
        $posModel = new DmposSearch();
        $allPos = $posModel->searchAllPos();
        $posNameMap = ArrayHelper::map($allPos,'ID','POS_NAME');

        $userSearchModel = new UserSearch();
        $userObj = $userSearchModel->searchAllUser();

        foreach($userObj as $key => $value){
            $userObj[$key]['MEMBER_NAME'] = $userObj[$key]['MEMBER_NAME'].'('.$userObj[$key]['PHONE_NUMBER'].')';
        }
        $posNameUserMap = ArrayHelper::map($userObj,'ID','MEMBER_NAME');

        $posparentSearchModel = new DmposparentSearch();
        $posParentObj = $posparentSearchModel->searchAllParent();
        $posParentMap = ArrayHelper::map($posParentObj,'ID','DESCRIPTION');

        $couponSearchModel = new CouponSearch();
        $CouponObj = $couponSearchModel->searchAllCoupon();

        foreach($CouponObj as $key => $Coupon){
            $CouponObj[$key]['id'] = $Coupon['_id']->__toString().'-'.$CouponObj[$key]['Denominations'].'-'.$CouponObj[$key]['Coupon_Name'];
        }

        $CouponList = ArrayHelper::map($CouponObj,'id','Coupon_Name','Denominations');
        ksort($CouponList);



        $posIdListSes = \Yii::$app->session->get('pos_id_list');
        if($posIdListSes == NULL || $posIdListSes == ''){
            $couponType = [
                'COUPON_TYPE_POS' => 'COUPON TYPE POS',
                'COUPON_TYPE_POS_PARENT' => 'COUPON TYPE POS PARENT',
            ];
        }else{
            $couponType = [
                'COUPON_TYPE_POS' => 'COUPON TYPE POS',
            ];
        }

        return $data = [
            'posNameMap' => $posNameMap,
            'posNameUserMap' => $posNameUserMap,
            'couponList' => $CouponList,
            'posParentMap' => $posParentMap,
            'couponType' => $couponType,
        ];
    }
    public function actionCreate()
    {
        $model = new Couponlog();
        $dataCouponlog = CouponlogController::preparData();
        $dataCouponlog['model'] = $model;


        if ($model->load(Yii::$app->request->post())) {

            $post = Yii::$app->request->post();

            $model->Type = $post['Couponlog']['Type'];
//            echo '<pre>';
//            var_dump($model->User_Id);
//            echo '</pre>';
//            die();

            foreach($model->User_Id as $value){
                $Couponlog = new Couponlog();
                $Couponlog->Coupon_Log_Date = new \MongoDate(strtotime($model->Coupon_Log_Date));

                $cutTimeStart = substr($model->Coupon_Log_Start,0,10); // Cắt đầu chuỗi lấy time start
                $cutTimeEnd = substr($model->Coupon_Log_Start,-10);   // Cắt đầu chuỗi lấy time End
                $Couponlog->Coupon_Log_Start = new \MongoDate(strtotime($cutTimeStart));
                $Couponlog->Coupon_Log_End = new \MongoDate(strtotime($cutTimeEnd));
                $Couponlog->Active = (int)$model->Active;
                $Couponlog->Pr_Key = 0;
                $Couponlog->Type = $model->Type;
                $Couponlog->Pos_Parent = $model->Pos_Parent;
//                if(!isset($post['Image'])){
//                    $Couponlog->Image = $post['ImageFb'];
//                }else{
//                    $Couponlog->Image = $post['Image'];
//                }

                if($model->Type === 'COUPON_TYPE_POS_PARENT'){
                    $Couponlog->Coupon_Name = $model->Coupon_Name;
                    $Couponlog->Pos_Id = 1;
                }else if($model->Type === 'COUPON_TYPE_POS'){
                    $Couponlog->Coupon_Name = $post['Coupon_Name_Pos'];
                    $Couponlog->Pos_Id = (int)$model->Pos_Id;
                }else if($model->Type === 'COUPON_TYPE_FOODBOOK'){
                    $Couponlog->Pos_Id = 1;
                    $Couponlog->Pos_Parent = 'FOODBOOK';
                    $Couponlog->Coupon_Name = 'Áp dụng cho toàn hệ thống Foodbook';
                }

                $arrayCouponIdDenominations = explode("-", $model->Coupon_Id);
                $Couponlog->Coupon_Id = $arrayCouponIdDenominations[0];
                $Couponlog->Denominations = (int)$arrayCouponIdDenominations[1];
//                $Couponlog->Share_Quantity = (int)$model->Share_Quantity;

                $Couponlog->User_Id = (int)$value;
                $Couponlog->User_Id_Parent = 1;
                $Couponlog->Payment_At = 0;
                $Couponlog->save();

            }

            return $this->redirect(['index']);
        } else {

            return $this->render('create', $dataCouponlog);
        }
    }

    /**
     * Updates an existing Couponlog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldModel = $model->oldAttributes;


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            DmquerylogController::actionCreateLog('UPDATE',get_class($model),$oldModel,$model->attributes);
            return $this->redirect(['view', 'id' => (string)$model->_id]);
        } else {
            $data = CouponlogController::preparData();

            return $this->render('update', [
                'model' => $model,
                'posNameMap' => $data['posNameMap'],
                'posNameUserMap' => $data['posNameUserMap'],
                'CouponList' => $data['CouponList'],
                'posParentMap' => $data['posParentMap'],
                'managerMap' => $data['managerMap'],
            ]);
        }
    }

    /**
     * Deletes an existing Couponlog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
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
     * Finds the Couponlog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return Couponlog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Couponlog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    // Ajax function
    public function actionFiltepos($id) {
        if ($id){
            $itemObj = Dmpos::find()
                ->select(['ID','POS_NAME','IMAGE_PATH'])
                ->where(['ID' => $id])
                ->asArray()
                ->one();
        echo '<label>Tên Coupon</label>';
        echo '<input type="text" name="Coupon_Name_Pos" value="Áp dụng cho: '.$itemObj['POS_NAME'].' " class = "form-control" />';
        echo '<br>';
        echo '<input type="image" name="Image_Pos" src="'.$itemObj['IMAGE_PATH'].'" style="width: 100px; height: 100px"/>';
        echo '<input type="hidden" name="Image" value="'.$itemObj['IMAGE_PATH'].'" />';
        echo '<br>';
        }
    }

    // Ajax function
    public function actionFilteparent($id) {
        if ($id){
            $itemObj = Dmposparent::find()
                ->select(['ID','DESCRIPTION','IMAGE'])
                ->where(['ID' => $id])
                ->asArray()
                ->one();
        echo '<label>Tên Coupon</label>';
        echo '<input type="text" name="Coupon_Name" value="Áp dụng cho: '.$itemObj['DESCRIPTION'].' " class = "form-control" />';
        echo '<br>';
        echo '<input type="image" name="Image_PosParent" src="'.$itemObj['IMAGE'].'" style="width: 100px; height: 100px" alt=" Ảnh '.$itemObj['DESCRIPTION'].'..."/>';
        echo '<input type="hidden" name="Image" value="'.$itemObj['IMAGE'].'" />';
        echo '<br>';
        }
    }
}
