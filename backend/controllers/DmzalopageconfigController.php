<?php

namespace backend\controllers;

use backend\models\Dmconfig;
use Yii;
use backend\models\Dmzalopageconfig;
use backend\models\DmzalopageconfigSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\FormatConverter;

/**
 * DmzalopageconfigController implements the CRUD actions for Dmzalopageconfig model.
 */
class DmzalopageconfigController extends Controller
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
     * Lists all Dmzalopageconfig models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DmzalopageconfigSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Dmzalopageconfig model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionZalofunction()
    {
        $model = $this->findModelByposparent();
        $model->JSON_FUNCTION = json_decode($model->JSON_FUNCTION);
        $items = array();

        foreach($model->JSON_FUNCTION as $key => $value){
            $childern = array();
            foreach($value as $keychildren =>  $children){
                $label = $keychildren;
                if(@Yii::$app->params['CONFIG_ZALO_FUNTION'][$keychildren]){
                    $label =  Yii::$app->params['CONFIG_ZALO_FUNTION'][$keychildren];
                }
                $childern[] = ['label' => $label, 'icon'=>'info-sign', 'url'=>'#'.$key.'-'.$keychildren ];
            }

            $items[] = [
                'label' => $key,
                'icon' => 'circle-arrow-right',
                'items' => $childern
            ];
        }

        /*echo '<pre>';
        var_dump($items);
        echo '</pre>';
        die();*/


        if ($model->load(Yii::$app->request->post())) {

            $str = ltrim($model->FUNCTION_NAME,'#');
            $strArray =  explode("-",$str);
            $model->JSON_FUNCTION->$strArray[0]->$strArray[1]->type = $model->TYPE_FUNCTION;

            $model->JSON_FUNCTION->$strArray[0]->$strArray[1]->content = $model->DESCRIPTION;

            if($model->TYPE_FUNCTION == 2){
                $model->JSON_FUNCTION->$strArray[0]->$strArray[1]->title = $model->TITLE;
                $pathServer = Yii::$app->params['POS_IMAGE_PATH'].'/config/';

                if(UploadedFile::getInstance($model,'IMAGE_PATH')){
                    $fileImage = UploadedFile::getInstance($model,'IMAGE_PATH');
                    // Convert chữ bỏ hết dấu của tên file
                    $fileImage->name = FormatConverter::removesign($fileImage->name);
                    //Kiểm tra thư mục, nếu chưa có thì tạo ra folder Images
                    DmposController::createDirectory('../../images/fb/config/');

                    $fileImage->saveAs('../../images/fb/config/'.$fileImage->name);
                    $model->IMAGE_PATH = $pathServer.$fileImage->name;
                }

                $model->JSON_FUNCTION->$strArray[0]->$strArray[1]->image = $model->IMAGE_PATH;
            }

            $model->JSON_FUNCTION = json_encode($model->JSON_FUNCTION,JSON_UNESCAPED_UNICODE);

            $model->save();

            return $this->redirect(['zalofunction']);
        } else {
            return $this->render('zalo_function', [
                'model' => $model,
                'items' => $items,
            ]);
        }
    }


    /**
     * Creates a new Dmzalopageconfig model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dmzalopageconfig();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['zalofunction']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Dmzalopageconfig model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->PAGE_ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Dmzalopageconfig model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    public function actionNull()
    {
        return $this->render('null');

    }

    /**
     * Finds the Dmzalopageconfig model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Dmzalopageconfig the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dmzalopageconfig::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findModelByposparent()
    {
        $model = Dmzalopageconfig::find()->where(['POS_PARENT' => Yii::$app->session->get('pos_parent')])->one();
        /*echo '<pre>';
        var_dump($model->JSON_FUNCTION);
        echo '</pre>';
        die();*/

        /*echo '<pre>';
        var_dump($model);
        var_dump(Yii::$app->session->get('pos_parent'));
        echo '</pre>';
        die();*/

        if($model){

            if (($model->JSON_FUNCTION) !== '' && ($model->JSON_FUNCTION) !== null) {
                return $model;
            } else {
                $modelConfig = Dmconfig::find()->where(['KEYWORD' => 'zalo_json_function'])->one();
                $model->JSON_FUNCTION = $modelConfig->VALUES;
                return $model;
            }
        }else{

            Yii::$app->getSession()->setFlash('error', "Hiện tại hệ thống nhà hàng chưa đăng kí Zalo, xin vui lòng liên hệ với Foodbook để được thiết lập Zalo");
            return $this->redirect(['null']);
        }
    }
}
