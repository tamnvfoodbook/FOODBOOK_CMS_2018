<?php

namespace backend\controllers;

use backend\models\DmposparentSearch;
use backend\models\DmposSearch;
use common\models\User;
use Yii;
use backend\models\Pmemployee;
use backend\models\PmemployeeSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PmemployeeController implements the CRUD actions for Pmemployee model.
 */
class PmemployeeController extends Controller
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
     * Lists all Pmemployee models.
     * @return mixed
     */
    public function actionIndex()
    {
        self::checkAccessToken();
        $searchModel = new PmemployeeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $type = \Yii::$app->session->get('type_acc');

        $searchPosModel = new DmposSearch();
        $id = $searchPosModel->getIds();
        $allPos = $searchPosModel->searchAllPosById($id);
        $allPosMap= ArrayHelper::map($allPos,'ID','POS_NAME');


        if($type == 1 ){
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'allPosMap' => $allPosMap,
            ]);
        }else{
            $dataProvider->setSort(false);
            return $this->render('index_pos', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'allPosMap' => $allPosMap,
            ]);
        }


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

    /**
     * Displays a single Pmemployee model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $pmEmModel = new Pmemployee();
        $model->PERMISTION = $pmEmModel->getPermisforcontrol($model->PERMISTION);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Pmemployee model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Pmemployee();

        if ($model->load(Yii::$app->request->post())) {

            $sumPermit = 0;
            foreach((array)$model->PERMISTION as $key => $day){
                //Lấy giá trị Key để biết được là giá trị nào
                $sumPermit = pow(2,$key)+ $sumPermit;
            }
            $model->PERMISTION = $sumPermit;

            //Get Accetoken user
            $param = [
                'name' => $model->NAME,
                'permistion' => $model->PERMISTION,
                'pos_id' => $model->POS_ID,
            ];
            $apiPath = Yii::$app->params['CMS_API_PATH_IPOS_MOBILE'];
            $apiName = 'manager/add_employee';
            $dataCode = ApiController::getLalaApiByMethod($apiName,$apiPath,$param,'POST');


            if(isset($dataCode->data)){
                Yii::$app->getSession()->setFlash('success', 'Bạn đã tạo thành công nhân viên '.$model->NAME.' với mật khẩu mặc định " ipos "!');
                return $this->redirect(['index']);
            }else{
                if(@$dataCode->error){
                    Yii::$app->getSession()->setFlash('error', $dataCode->error->message);
                }else{
                    Yii::$app->getSession()->setFlash('error', 'Lỗi kết nối!!');
                }
                return $this->redirect(['creat']);
            }

        } else {
            $posParent = \Yii::$app->session->get('pos_parent');
            $posParentSearch = new DmposparentSearch();
            $posParentModel = $posParentSearch->searchPosparentById($posParent);

            $searchPosModel = new DmposSearch();
            $ids = $searchPosModel->getIds();
            $allPos = $searchPosModel->searchAllPosById($ids);
            $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');

            $permitArray = DmpositemController::DecToBin($model->PERMISTION,7); // 4 QUYỀN

            return $this->render('create', [
                'model' => $model,
                'allPosMap' => $allPosMap,
                'permitArray' => $permitArray,
                'autogenId' => $posParentModel->AUTO_GENERATE_ID,
            ]);
        }
    }

    /**
     * Updates an existing Pmemployee model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $sumPermit = 0;
            foreach((array)$model->PERMISTION as $key => $day){
                //Lấy giá trị Key để biết được là giá trị nào Chứ không như bên kia l
                $sumPermit = pow(2,$key)+ $sumPermit;
            }

            $model->PERMISTION = $sumPermit;
            $save = $model->save();

            if($save){
                Yii::$app->getSession()->setFlash('success', 'Bạn đã cập nhật thành công nhân viên '.$model->NAME.'!');
//                return $this->redirect(['index']);
                return $this->redirect(['view', 'id' => $model->ID]);
            }else{
                Yii::$app->getSession()->setFlash('error', 'Cập nhật bị lỗi, vui lòng nhập lại dữ liệu!!');
                return $this->redirect(['update','id' => $id]);
            }

            //return $this->redirect(['view', 'id' => $model->ID]);

        } else {
            $posParent = \Yii::$app->session->get('pos_parent');
            $posParentSearch = new DmposparentSearch();
            $posParentModel = $posParentSearch->searchPosparentById($posParent);

            $searchPosModel = new DmposSearch();
            $ids = $searchPosModel->getIds();
            $allPos = $searchPosModel->searchAllPosById($ids);
            $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');

            $permitArray = DmpositemController::DecToBin($model->PERMISTION,7); // 4 QUYỀN


            return $this->render('update', [
                'model' => $model,
                'allPosMap' => $allPosMap,
                'permitArray' => $permitArray,
                'autogenId' => $posParentModel->AUTO_GENERATE_ID,
            ]);

        }
    }

    /**
     * Deletes an existing Pmemployee model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionResetemploypassword($NAME,$EM_ID)
    {
        //Get Accetoken user
        $param = [
            'name' => $NAME,
            'employee_id' => $EM_ID,
        ];
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS_MOBILE'];
        $apiName = 'manager/reset_employee_pwd';

        $access_token = Yii::$app->params['ACCESS_TOKEN'];

        $user_token = \Yii::$app->session->get('user_token');

        $headers = array();
        $headers[] = 'access_token: '.$access_token;
        $headers[] = 'token: '.$user_token;
        $dataCode = ApiController::getApiByMethod($apiName,$apiPath,$param,$headers,'POST');
        if(isset($dataCode->data)){
            Yii::$app->getSession()->setFlash('success', 'Bạn đã đặt lại mật khẩu thành công cho nhân viên "'.$NAME.'" ! Xin vui lòng thử lại với mật khẩu " ipos "');
            return $this->render('view', [
                'model' => $this->findModel($EM_ID),
            ]);
        }else{
            Yii::$app->getSession()->setFlash('error', 'Đặt lại mật khẩu lỗi ! '.$dataCode->error->message);
            return $this->redirect(['index']);
        }

    }
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Pmemployee model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Pmemployee the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pmemployee::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
