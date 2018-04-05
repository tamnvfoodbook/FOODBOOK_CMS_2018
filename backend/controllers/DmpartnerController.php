<?php

namespace backend\controllers;

use Yii;
use backend\models\Dmpartner;
use backend\models\DmpartnerSearch;
use yii\helpers\FormatConverter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * DmpartnerController implements the CRUD actions for Dmpartner model.
 */
class DmpartnerController extends Controller
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
     * Lists all Dmpartner models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DmpartnerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Dmpartner model.
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
     * Creates a new Dmpartner model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dmpartner();

        if ($model->load(Yii::$app->request->post())) {

            $pathServer = Yii::$app->params['POS_IMAGE_PATH'].'/partner/';
            if(UploadedFile::getInstance($model,'AVATAR_IMAGE')){
                $fileImage = UploadedFile::getInstance($model,'AVATAR_IMAGE');

                // Convert chữ bỏ hết dấu của tên file
                $fileImage->name = FormatConverter::removesign($fileImage->name);

                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder Images
                DmposController::createDirectory('../../images/fb/partner/');

                $fileImage->saveAs('../../images/fb/partner/'.$fileImage->name);
                $model->AVATAR_IMAGE = $pathServer.$fileImage->name;
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
     * Updates an existing Dmpartner model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $post = Yii::$app->request->post();
            $pathServer = Yii::$app->params['POS_IMAGE_PATH'].'/partner/';
            if(UploadedFile::getInstance($model,'AVATAR_IMAGE')){
                $fileImage = UploadedFile::getInstance($model,'AVATAR_IMAGE');

                // Convert chữ bỏ hết dấu của tên file
                $fileImage->name = FormatConverter::removesign($fileImage->name);

                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder Images
                DmposController::createDirectory('../../images/fb/partner/');

                $fileImage->saveAs('../../images/fb/partner/'.$fileImage->name);
                $model->AVATAR_IMAGE = $pathServer.$fileImage->name;

            }else{
                if(isset($post['AVATAR_IMAGE-old'])){
                    $model->AVATAR_IMAGE = $post['AVATAR_IMAGE-old'];
                }
            }

            $model->save();

            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Dmpartner model.
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
     * Finds the Dmpartner model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Dmpartner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dmpartner::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
