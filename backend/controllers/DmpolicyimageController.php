<?php

namespace backend\controllers;

use backend\models\DMCITY;
use backend\models\DmcitySearch;
use backend\models\DmposparentSearch;
use Yii;
use backend\models\Dmpolicyimage;
use backend\models\DmpolicyimageSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\FormatConverter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\imagine\Image;

/**
 * DmpolicyimageController implements the CRUD actions for Dmpolicyimage model.
 */
class DmpolicyimageController extends Controller
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
     * Lists all Dmpolicyimage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DmpolicyimageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $cityModel = new DmcitySearch();
        $city = $cityModel->searchAllCity();
        $cityMap = ArrayHelper::map($city,'ID','CITY_NAME');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'cityMap' => $cityMap,
        ]);
    }

    /**
     * Displays a single Dmpolicyimage model.
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
     * Creates a new Dmpolicyimage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dmpolicyimage();
        $cityModel = new DmcitySearch();
        $city = $cityModel->searchAllCity();
        $cityMap = ArrayHelper::map($city,'ID','CITY_NAME');

        $posParentModel = new DmposparentSearch();
        $posparent = $posParentModel->searchAllParent();
        $posparentMap = ArrayHelper::map($posparent,'ID','NAME');

        if ($model->load(Yii::$app->request->post())) {
            $model->DATE_CREATED= date('Y-m-d H:i:s');
            $model->DATE_START = date("Y-m-d",strtotime($model->DATE_START));
            $model->DATE_END = date("Y-m-d 23:59:59",strtotime($model->DATE_END));

            $model->LIST_POS_PARENT = implode(",",(array)$model->LIST_POS_PARENT);

            $pathServer = Yii::$app->params['POS_IMAGE_PATH'].'/checkin/';
            if(UploadedFile::getInstance($model,'IMAGE_LINK')){
                $fileImage = UploadedFile::getInstance($model,'IMAGE_LINK');

                // Convert chữ bỏ hết dấu của tên file
                $fileImage->name = FormatConverter::removesign($fileImage->name);

                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder Images
                DmposController::createDirectory('../../images/fb/checkin/');

                $fileImage->saveAs('../../images/fb/checkin/'.$fileImage->name);
                $model->IMAGE_LINK = $pathServer.$fileImage->name;

            }else{
                if(isset($post['IMAGE_LINK-old'])){
                    $model->IMAGE_LINK = $post['IMAGE_LINK-old'];
                }
            }

            if($model->save()){
                return $this->redirect(['view', 'id' => $model->ID]);
            }else{
//                var_dump($model->errors);
//                die();
                return $this->render('create', [
                    'model' => $model,
                    'cityMap' => $cityMap,
                    'posparentMap' => $posparentMap,
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'cityMap' => $cityMap,
                'posparentMap' => $posparentMap,
            ]);
        }
    }

    /**
     * Updates an existing Dmpolicyimage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $cityModel = new DmcitySearch();
        $city = $cityModel->searchAllCity();
        $cityMap = ArrayHelper::map($city,'ID','CITY_NAME');
        $posParentModel = new DmposparentSearch();
        $posparent = $posParentModel->searchAllParent();
        $posparentMap = ArrayHelper::map($posparent,'ID','NAME');

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();

            $model->DATE_START = date("Y-m-d",strtotime($model->DATE_START));
            $model->DATE_END = date("Y-m-d 23:59:59",strtotime($model->DATE_END));
            $model->LIST_POS_PARENT = implode(",",(array)$model->LIST_POS_PARENT);

//            echo '<pre>';
//            var_dump($model->LIST_POS_PARENT);
//            echo '</pre>';
//            die();

            $pathServer = Yii::$app->params['POS_IMAGE_PATH'].'/checkin/';
            if(UploadedFile::getInstance($model,'IMAGE_LINK')){
                $fileImage = UploadedFile::getInstance($model,'IMAGE_LINK');

                // Convert chữ bỏ hết dấu của tên file
                $fileImage->name = FormatConverter::removesign($fileImage->name);
//                echo $fileImage->name;
//                die();
                //$fileImage->saveAs($realPath.'img/campaign/'.$fileImage->name);

                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder Images
                DmposController::createDirectory('../../images/fb/checkin/');

                $fileImage->saveAs('../../images/fb/checkin/'.$fileImage->name);
                $model->IMAGE_LINK = $pathServer.$fileImage->name;

            }else{
                $model->IMAGE_LINK = @$post['IMAGE_LINK-old'];
            }

            if($model->save()){
                return $this->redirect(['view', 'id' => $model->ID]);
            }else{
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'cityMap' => $cityMap,
                'posparentMap' => $posparentMap,
            ]);
        }
    }

    /**
     * Deletes an existing Dmpolicyimage model.
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
     * Finds the Dmpolicyimage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Dmpolicyimage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dmpolicyimage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
