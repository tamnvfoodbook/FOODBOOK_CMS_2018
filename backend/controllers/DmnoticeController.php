<?php

namespace backend\controllers;

use backend\models\DmposSearch;
use backend\models\User;
use Yii;
use backend\models\Dmnotice;
use backend\models\DmnoticeSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DmnoticeController implements the CRUD actions for Dmnotice model.
 */
class DmnoticeController extends Controller
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
     * Lists all Dmnotice models.
     * @return mixed
     */
    public function actionIndex()
    {
        self::checkAccessToken();
        $searchModel = new DmnoticeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $posSearchModel = new DmposSearch();
        $dmPos = $posSearchModel->searchAllPos();
        $allPosMap = ArrayHelper::map($dmPos,'ID','POS_NAME');


        return $this->render('index', [
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

            /*echo '<pre>';
            var_dump($model);
            var_dump($param);
            var_dump($dataCode);
            echo '</pre>';
            die();*/

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
     * Displays a single Dmnotice model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Dmnotice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dmnotice();
        $user_token = \Yii::$app->session->get('lala_user_token');
        $lala_pos_parent = \Yii::$app->session->get('lala_pos_parent');

        $searchPosModel = new DmposSearch();
        $allPos = $searchPosModel->searchAllLalaPos();
        $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME','POS_PARENT');
        /*echo '<pre>';
        var_dump($allPos);
        var_dump($allPosMap);
        echo '</pre>';
        die();*/


        if ($model->load(Yii::$app->request->post())) {

            $apiPath = Yii::$app->params['CMS_API_PATH_IPOS_MOBILE'];
            $nameNotice = 'manager/create_notice';
            if($model->IS_ALL_POS){
                $model->LIST_POS = '';
            }else{
                $model->LIST_POS = implode(',',$model->LIST_POS);
            }

            $param = array(
                'title' => $model->TITLE,
                'content' => $model->CONTENT,
                'full_content_url' => $model->FULL_CONTENT_URL,
                'is_all_pos' => (int)$model->IS_ALL_POS,
                'list_pos' => $model->LIST_POS
            );

            $notices = ApiController::getLalaApiByMethod($nameNotice,$apiPath,$param,'GET');

            if(isset($notices->data)){
                Yii::$app->session->setFlash('success', 'Thêm thành công');
                return $this->redirect(['index']);
            }else{
                if(isset($notices->error)){
                    Yii::$app->session->setFlash('error', 'Thêm lỗi '.@$notices->error->message);
                }else{
                    Yii::$app->session->setFlash('error', 'Lỗi kết nối máy chủ');
                }
                return $this->redirect(['index']);
            }


        } else {
            return $this->render('create', [
                'model' => $model,
                'lala_pos_parent' => $lala_pos_parent,
                'user_token' => $user_token,
                'allPosMap' => $allPosMap,
            ]);
        }
    }

    /**
     * Updates an existing Dmnotice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $model = new Dmnotice();
        $user_token = \Yii::$app->session->get('lala_user_token');
        $lala_pos_parent = \Yii::$app->session->get('lala_pos_parent');



        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS_MOBILE'];
        $nameNotice = 'manager/get_notice';
        $param = array();

        $notices = ApiController::getLalaApiByMethod($nameNotice,$apiPath,$param,'GET');
        foreach((array)$notices->data as $data){

            if($data->id == $id){
                $model->ID = $data->id;
                $model->TITLE = $data->title;
                $model->CONTENT = $data->content;
                $model->CREATED_AT = $data->created_at;
                $model->FULL_CONTENT_URL = $data->full_content_url;
                $model->IS_ALL_POS = $data->is_all_pos;
//                $model->POS_PARENT = $data->pos_parent;
                if($data->list_pos){
                    $model->LIST_POS = explode(',',$data->list_pos);
                }
                break;
            }

        }


        $searchPosModel = new DmposSearch();
        $allPos = $searchPosModel->searchAllPosByPosParent($lala_pos_parent);
        $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');

        if ($model->load(Yii::$app->request->post())) {
            $apiPath = Yii::$app->params['CMS_API_PATH_IPOS_MOBILE'];
            $nameNotice = 'manager/update_notice';
            if($model->IS_ALL_POS){
                $model->LIST_POS = '';
            }else{
                $model->LIST_POS = implode(',',$model->LIST_POS);
            }

            $param = array(
                'id' => $model->ID,
                'title' => $model->TITLE,
                'content' => $model->CONTENT,
                'full_content_url' => $model->FULL_CONTENT_URL,
                'is_all_pos' => (int)$model->IS_ALL_POS,
                'list_pos' => $model->LIST_POS
            );

            $notices = ApiController::getLalaApiByMethod($nameNotice,$apiPath,$param,'GET');


            if(isset($notices->data)){
                Yii::$app->session->setFlash('success', 'Sửa thành công');
                return $this->redirect(['index']);
            }else{
                if(isset($notices->error)){
                    Yii::$app->session->setFlash('error', 'Sửa lỗi '.@$notices->error->message);
                }else{
                    Yii::$app->session->setFlash('error', 'Lỗi kết nối máy chủ');
                }
                return $this->redirect(['index']);
            }

        } else {
            return $this->render('update', [
                'model' => $model,
                'allPosMap' => $allPosMap,
            ]);
        }
    }

    public function actionPush($id)
    {

        $model = new Dmnotice();

        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS_MOBILE'];
        $nameNotice = 'manager/broadcast_notice';
        $param = array(
            'id' => $id
        );

        $notices = ApiController::getLalaApiByMethod($nameNotice,$apiPath,$param,'GET');

        if(isset($notices->data)){
            Yii::$app->session->setFlash('success', 'Gửi thành công');
            return $this->redirect(['index']);
        }else{
            if(isset($notices->error)){
                Yii::$app->session->setFlash('error', 'Gửi lỗi '.@$notices->error->message);
            }else{
                Yii::$app->session->setFlash('error', 'Lỗi kết nối máy chủ');
            }
            return $this->redirect(['index']);
        }

        return $this->render('index');

    }

    /**
     * Deletes an existing Dmnotice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Dmnotice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Dmnotice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dmnotice::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
