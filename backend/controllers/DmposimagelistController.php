<?php

namespace backend\controllers;

use backend\models\DmposSearch;
use Yii;
use backend\models\Dmposimagelist;
use backend\models\DmposimagelistSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\FormatConverter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\imagine\Image;
use yii\web\UploadedFile;

/**
 * DmposimagelistController implements the CRUD actions for Dmposimagelist model.
 */
class DmposimagelistController extends Controller
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
     * Lists all Dmposimagelist models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DmposimagelistSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

//        $searchPosModel = new DmposSearch();
//        $allPos = $searchPosModel->searchAllPos();
//        $allPosMap= ArrayHelper::map($allPos,'ID','POS_NAME');

        $searchPosModel = new DmposSearch();
        $allPos = $searchPosModel->searchAllPos();
        $allPosMap= ArrayHelper::map($allPos,'ID','POS_NAME');


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'allPosMap' => $allPosMap,
        ]);
    }

    /**
     * Displays a single Dmposimagelist model.
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
     * Creates a new Dmposimagelist model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dmposimagelist();

        if ($model->load(Yii::$app->request->post())) {

            $post = Yii::$app->request->post();
            $POS_ID = $model->POS_ID;

            $pathServer = Yii::$app->params['POS_IMAGE_PATH'];

            if(UploadedFile::getInstance($model,'IMAGE_PATH')){
                $fileImage = UploadedFile::getInstance($model,'IMAGE_PATH');
                // Convert chữ bỏ hết dấu của tên file
                $fileImage->name = FormatConverter::removesign($fileImage->name);

                //$fileImage->saveAs($realPath.'img/campaign/'.$fileImage->name);

                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder Images
                DmposController::createDirectory('../../images/fb/pos/'.$POS_ID.'/');

                $fileImage->saveAs('../../images/fb/pos/'.$POS_ID.'/'.$fileImage->name);
                $model->IMAGE_PATH = $pathServer.'/pos/'.$POS_ID.'/'.$fileImage->name;

            }

            $model->save();

            return $this->redirect(['view', 'id' => $model->ID]);
        } else {


            $searchPosModel = new DmposSearch();
            $allPos = $searchPosModel->searchAllPos();
            $allPosMap= ArrayHelper::map($allPos,'ID','POS_NAME');

            return $this->render('create', [
                'model' => $model,
                'allPosMap' => $allPosMap,
            ]);
        }
    }

    /**
     * Updates an existing Dmposimagelist model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            $POS_ID = $model->POS_ID;

            $pathServer = Yii::$app->params['POS_IMAGE_PATH'];

            if(UploadedFile::getInstance($model,'IMAGE_PATH')){
                $fileImage = UploadedFile::getInstance($model,'IMAGE_PATH');
                // Convert chữ bỏ hết dấu của tên file
                $fileImage->name = FormatConverter::removesign($fileImage->name);
                //$fileImage->saveAs($realPath.'img/campaign/'.$fileImage->name);

                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder Images
                DmposController::createDirectory('../../images/fb/pos/'.$POS_ID.'/');

                $fileImage->saveAs('../../images/fb/pos/'.$POS_ID.'/'.$fileImage->name);
                $model->IMAGE_PATH = $pathServer.'/pos/'.$POS_ID.'/'.$fileImage->name;

            }else{

                if(isset($post['image-old'])){
                    $model->IMAGE_PATH = $post['image-old'];
                }
                //echo $model->IMAGE_PATH;
                //die();
            }

            DmquerylogController::actionCreateLog('UPDATE',get_class($model),$model->oldAttributes,$model->attributes);
            $model->save();

            return $this->redirect(['view', 'id' => $model->ID]);
        } else {

            $searchPosModel = new DmposSearch();
            $allPos = $searchPosModel->searchAllPos();
            $allPosMap= ArrayHelper::map($allPos,'ID','POS_NAME');


            return $this->render('update', [
                'model' => $model,
                'allPosMap' => $allPosMap,
            ]);
        }
    }

    /**
     * Deletes an existing Dmposimagelist model.
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
     * Finds the Dmposimagelist model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Dmposimagelist the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dmposimagelist::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
