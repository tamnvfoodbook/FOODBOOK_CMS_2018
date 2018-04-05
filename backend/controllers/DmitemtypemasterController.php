<?php

namespace backend\controllers;

use Yii;
use backend\models\Dmitemtypemaster;
use backend\models\DmitemtypemasterSearch;
use yii\helpers\FormatConverter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DmitemtypemasterController implements the CRUD actions for Dmitemtypemaster model.
 */
class DmitemtypemasterController extends Controller
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
     * Lists all Dmitemtypemaster models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DmitemtypemasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Dmitemtypemaster model.
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
     * Creates a new Dmitemtypemaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dmitemtypemaster();

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            $pathServer = Yii::$app->params['ITEM_IMAGE_PATH'];

            if(\yii\web\UploadedFile::getInstance($model,'IMAGE_PATH')){
                $fileImage = \yii\web\UploadedFile::getInstance($model,'IMAGE_PATH');
                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder
                DmposController::createDirectory('../../images/fb/MASTER-ITEM');

                // Convert chữ bỏ hết dấu của tên file
                $fileImage->name = FormatConverter::removesign($fileImage->name);

                $fileImage->saveAs('../../images/fb/MASTER-ITEM/'.$fileImage->name);
                $model->IMAGE_PATH = $pathServer.'/MASTER-ITEM/'.$fileImage->name;
            }else{
                if(isset($post['image-old'])){
                    $model->IMAGE_PATH = $post['image-old'];
                }
            }
            $model->save();

            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Dmitemtypemaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            $pathServer = Yii::$app->params['ITEM_IMAGE_PATH'];

            if(\yii\web\UploadedFile::getInstance($model,'IMAGE_PATH')){
                $fileImage = \yii\web\UploadedFile::getInstance($model,'IMAGE_PATH');
                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder
                DmposController::createDirectory('../../images/fb/MASTER-ITEM');
                // Convert chữ bỏ hết dấu của tên file
                $fileImage->name = FormatConverter::removesign($fileImage->name);
                $fileImage->saveAs('../../images/fb/MASTER-ITEM/'.$fileImage->name);
                $model->IMAGE_PATH = $pathServer.'/MASTER-ITEM/'.$fileImage->name;
            }else{
                if(isset($post['image-old'])){
                    $model->IMAGE_PATH = $post['image-old'];
                }
            }
//            echo '<pre>';
//            var_dump($model->IMAGE_PATH);
//            echo '</pre>';
//            die();

            DmquerylogController::actionCreateLog('UPDATE',get_class($model),$model->oldAttributes,$model->attributes);

            $model->save();
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Dmitemtypemaster model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
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
     * Finds the Dmitemtypemaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Dmitemtypemaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dmitemtypemaster::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
