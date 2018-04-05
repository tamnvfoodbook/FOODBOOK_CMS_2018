<?php

namespace backend\controllers;

use backend\models\DmcitySearch;
use Yii;
use backend\models\Dmposmaster;
use backend\models\DmposmasterSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\FormatConverter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DmposmasterController implements the CRUD actions for Dmposmaster model.
 */
class DmposmasterController extends Controller
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
     * Lists all Dmposmaster models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DmposmasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $key = Yii::$app->params['KEY_ALL_CITY'];
        $allCityMap = \Yii::$app->cache->get($key);
        // \Yii::$app->cache->delete($key);

        if ($allCityMap === false) {
            $searchCityModel = new DmcitySearch();
            $allCity = $searchCityModel->searchAllCity();
            $allCityMap = ArrayHelper::map($allCity,'ID','CITY_NAME');
            \Yii::$app->cache->set($key, $allCityMap, 4200); // time in seconds to store cache
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'allCityMap' => $allCityMap,
        ]);
    }

    /**
     * Displays a single Dmposmaster model.
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
     * Creates a new Dmposmaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dmposmaster();

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();

            $pathServer = Yii::$app->params['POS_IMAGE_PATH'];

            if(\yii\web\UploadedFile::getInstance($model,'IMAGE_PATH')){
                $fileImage = \yii\web\UploadedFile::getInstance($model,'IMAGE_PATH');
                // Convert chữ bỏ hết dấu của tên file
                $fileImage->name = FormatConverter::removesign($fileImage->name);
                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder
                DmposController::createDirectory('../../images/fb/posmaster/');

                $fileImage->saveAs('../../images/fb/posmaster/'.$fileImage->name);
                $model->IMAGE_PATH = $pathServer.'/posmaster/'.$fileImage->name;

            }

            $model->save();

            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            $key_city = 'cityMap';
            $cityMap = \Yii::$app->cache->get($key_city);
            if ($cityMap === false) {
                $searchCityModel = new DmcitySearch();
                $allCityModel = $searchCityModel->searchAllCity();
                $cityMap = ArrayHelper::map($allCityModel,'ID','CITY_NAME');
                \Yii::$app->cache->set($key_city, $cityMap, 43200); // time in seconds to store cache
            }

            return $this->render('create', [
                'model' => $model,
                'cityMap' => $cityMap,
            ]);
        }
    }

    /**
     * Updates an existing Dmposmaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $post = Yii::$app->request->post();

            $pathServer = Yii::$app->params['POS_IMAGE_PATH'];

            if(\yii\web\UploadedFile::getInstance($model,'IMAGE_PATH')){
                $fileImage = \yii\web\UploadedFile::getInstance($model,'IMAGE_PATH');
                // Convert chữ bỏ hết dấu của tên file
                $fileImage->name = FormatConverter::removesign($fileImage->name);
                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder
                DmposController::createDirectory('../../images/fb/posmaster/');

                $fileImage->saveAs('../../images/fb/posmaster/'.$fileImage->name);
                $model->IMAGE_PATH = $pathServer.'/posmaster/'.$fileImage->name;

            }else{
                if(isset($post['image-old'])){
                    $model->IMAGE_PATH = $post['image-old'];
                }
            }

            DmquerylogController::actionCreateLog('UPDATE',get_class($model),$model->oldAttributes,$model->attributes);
            $model->save();


            return $this->redirect(['view', 'id' => $model->ID]);
        } else {

        $key_city = 'cityMap';
        $cityMap = \Yii::$app->cache->get($key_city);
        if ($cityMap === false) {
            $searchCityModel = new DmcitySearch();
            $allCityModel = $searchCityModel->searchAllCity();
            $cityMap = ArrayHelper::map($allCityModel,'ID','CITY_NAME');
            \Yii::$app->cache->set($key_city, $cityMap, 43200); // time in seconds to store cache
        }

            return $this->render('update', [
                'model' => $model,
                'cityMap' => $cityMap,
            ]);
        }
    }

    /**
     * Deletes an existing Dmposmaster model.
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
     * Finds the Dmposmaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Dmposmaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dmposmaster::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
