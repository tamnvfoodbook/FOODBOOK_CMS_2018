<?php

namespace backend\controllers;

use backend\models\Dmposparent;
use backend\models\DmposparentSearch;
use Yii;
use backend\models\Dmuserpartner;
use backend\models\DmuserpartnerSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DmuserpartnerController implements the CRUD actions for Dmuserpartner model.
 */
class DmuserpartnerController extends Controller
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
     * Lists all Dmuserpartner models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DmuserpartnerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Dmuserpartner model.
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
     * Creates a new Dmuserpartner model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dmuserpartner();
        $posParentModel = new DmposparentSearch();
        $posParents  = $posParentModel->searchAllParent();

        $posParentMap = ArrayHelper::map($posParents,'ID','NAME');
//        echo '<pre>';
//        var_dump($posParentMap);
//        echo '</pre>';
//        die();

        if ($model->load(Yii::$app->request->post())) {

            $apiName = 'cms/create_user_partner';
            $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];
            if(is_array($model->LIST_POS_PARENT)){
                $model->LIST_POS_PARENT = implode(",",$model->LIST_POS_PARENT);
            }

            $paramCommnet = array_change_key_case($model->attributes, CASE_LOWER);
            $data = ApiController::getApiByMethod($apiName,$apiPath,$paramCommnet,'POST');
            if(isset($data->data)){
                Yii::$app->session->setFlash('success', 'Tạo đối tác'.$model->PARTNER_NAME.' thành công');
                return $this->redirect(['index']);
            }else{
                if(isset($data->error)){
                    Yii::$app->session->setFlash('error', 'Tạo sự kiện lỗi '.@$data->error->message);
                }else{
                    Yii::$app->session->setFlash('error', 'Lỗi kết nối máy chủ');
                }
                return $this->render('create', [
                    'model' => $model,
                    'posParentMap' => $posParentMap,
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'posParentMap' => $posParentMap,
            ]);
        }
    }
    /**
     * Updates an existing Dmuserpartner model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $posParentModel = new DmposparentSearch();
        $posParents  = $posParentModel->searchAllParent();
//        echo '<pre>';
//        var_dump($posParents);
//        echo '</pre>';
//        die();

        $posParentMap = ArrayHelper::map($posParents,'ID','NAME');
//        echo '<pre>';
//        var_dump($posParentMap);
//        echo '</pre>';
//        die();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->PARTNER_NAME]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'posParentMap' => $posParentMap,
            ]);
        }
    }

    /**
     * Deletes an existing Dmuserpartner model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Dmuserpartner model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Dmuserpartner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dmuserpartner::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
