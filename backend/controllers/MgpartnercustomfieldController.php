<?php

namespace backend\controllers;

use backend\models\DmpartnerSearch;
use backend\models\Dmposparent;
use backend\models\DmposparentSearch;
use backend\models\DmposSearch;
use backend\models\DmuserpartnerSearch;
use yii\imagine\Image;
use Yii;
use backend\models\Mgpartnercustomfield;
use backend\models\MgpartnercustomfieldSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\FormatConverter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MgpartnercustomfieldController implements the CRUD actions for Mgpartnercustomfield model.
 */
class MgpartnercustomfieldController extends Controller
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
     * Lists all Mgpartnercustomfield models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MgpartnercustomfieldSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $searchPosModel = new DmposSearch();
        $allPos = $searchPosModel->searchAllPos();
        $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'allPosMap' => $allPosMap,
        ]);
    }

    /**
     * Displays a single Mgpartnercustomfield model.
     * @param integer $_id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $searchPosModel = new DmposSearch();
        $allPos = $searchPosModel->searchAllPos();
        $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');
//        $model->pos_id = $allPosMap[$model->pos_id];
        if($model->tags){
            $model->tags = implode($model->tags,',');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Mgpartnercustomfield model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Mgpartnercustomfield();
        $partnerModel = new DmuserpartnerSearch();
        $parners = $partnerModel->searchAllpartner();
        $partnerMap = ArrayHelper::map($parners,'ID','PARTNER_NAME');

        $searchPosModel = new DmposSearch();
        $allPos = $searchPosModel->searchAllPos();
        $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');
        $posParentMap = ArrayHelper::map($allPos,'ID','POS_PARENT');


        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();

            $pathServer = Yii::$app->params['POS_IMAGE_PATH'];

            if(\yii\web\UploadedFile::getInstance($model,'image_url')){
                $fileImageThumb = \yii\web\UploadedFile::getInstance($model,'image_url');
                // Convert chữ bỏ hết dấu của tên file
                $fileImageThumb->name = FormatConverter::removesign($fileImageThumb->name);
                $fileImageThumb->saveAs('../../images/fb/pos/'.$fileImageThumb->name);
                $model->image_url = $pathServer.'/pos/'.$fileImageThumb->name;
            }
            $model->partner_name = $partnerMap[$model->partner_id];
            $model->pos_parent = $posParentMap[$model->pos_id];
            $model->partner_id = (int)$model->partner_id;
            $model->pos_id = (int)$model->pos_id;
            $model->active = (int)$model->active;
            $model->created_at = new \MongoDate();
            $model->updated_at = new \MongoDate();

            if(\yii\web\UploadedFile::getInstance($model,'image_thumb_url')){
                $fileImageThumb = \yii\web\UploadedFile::getInstance($model,'image_thumb_url');
                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder
                DmposController::createDirectory('../../images/fb/pos/thumbs');
                // Convert chữ bỏ hết dấu của tên file
                $fileImageThumb->name = FormatConverter::removesign($fileImageThumb->name);
                $fileImageThumb->saveAs('../../images/fb/pos/'.$fileImageThumb->name);
                $model->image_thumb_url = $pathServer.'/pos/'.$fileImageThumb->name;

            }


            $model->save();
            return $this->redirect(['view', 'id' => (string)$model->_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'partnerMap' => $partnerMap,
                'allPosMap' => $allPosMap,
            ]);
        }
    }

    /**
     * Updates an existing Mgpartnercustomfield model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $partnerModel = new DmuserpartnerSearch();
        $parners = $partnerModel->searchAllpartner();
        $partnerMap = ArrayHelper::map($parners,'ID','PARTNER_NAME');

        $searchPosModel = new DmposSearch();
        $allPos = $searchPosModel->searchAllPos();
        $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');
        $posParentMap = ArrayHelper::map($allPos,'ID','POS_PARENT');

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            $pathServer = Yii::$app->params['POS_IMAGE_PATH'];
            if(\yii\web\UploadedFile::getInstance($model,'image_url')){
                $fileImageThumb = \yii\web\UploadedFile::getInstance($model,'image_url');
                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder
                // Convert chữ bỏ hết dấu của tên file
                $fileImageThumb->name = FormatConverter::removesign($fileImageThumb->name);
                $fileImageThumb->saveAs('../../images/fb/pos/'.$fileImageThumb->name);
                $model->image_url = $pathServer.'/pos/'.$fileImageThumb->name;
            }else{
                if(isset($post['image_url-old'])){
                    $model->image_url = $post['image_url-old'];
                }
            }
            $model->partner_name = $partnerMap[$model->partner_id];

            $model->pos_parent = $posParentMap[$model->pos_id];

            if(\yii\web\UploadedFile::getInstance($model,'image_thumb_url')){
                $fileImageThumb = \yii\web\UploadedFile::getInstance($model,'image_thumb_url');
                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder
                DmposController::createDirectory('../../images/fb/pos/thumbs');
                // Convert chữ bỏ hết dấu của tên file
                $fileImageThumb->name = FormatConverter::removesign($fileImageThumb->name);
                $fileImageThumb->saveAs('../../images/fb/pos/'.$fileImageThumb->name);
                $model->image_thumb_url = $pathServer.'/pos/'.$fileImageThumb->name;

            }else{
                if(isset($post['image_thumb_url-old'])){
                    $model->image_thumb_url = $post['image_thumb_url-old'];
                }
            }

            $model->partner_id = (int)$model->partner_id;
            $model->pos_id = (int)$model->pos_id;
            $model->active = (int)$model->active;
            $model->updated_at = new \MongoDate();

            $model->save();
            return $this->redirect(['view', 'id' => (string)$model->_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'partnerMap' => $partnerMap,
                'allPosMap' => $allPosMap,
            ]);
        }
    }

    /**
     * Deletes an existing Mgpartnercustomfield model.
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
     * Finds the Mgpartnercustomfield model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return Mgpartnercustomfield the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mgpartnercustomfield::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
