<?php

namespace backend\controllers;

use backend\models\DmposSearch;
use Yii;
use backend\models\Wmslideimagelist;
use backend\models\WmslideimagelistSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\FormatConverter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\imagine\Image;

/**
 * WmslideimagelistController implements the CRUD actions for Wmslideimagelist model.
 */
class WmslideimagelistController extends Controller
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
     * Lists all Wmslideimagelist models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $searchPosModel = new DmposSearch();
        ApiController::actionCheckPosPermision($id);

        $searchModel = new WmslideimagelistSearch();
        $dataProvider = $searchModel->searchByPosId(Yii::$app->request->queryParams,$id);


        $pos = $searchPosModel->searchById($id);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'pos' => $pos,
        ]);
    }

    /**
     * Displays a single Wmslideimagelist model.
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
     * Creates a new Wmslideimagelist model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($POS_ID)
    {
        ApiController::actionCheckPosPermision($POS_ID);
        $model = new Wmslideimagelist();

        if ($model->load(Yii::$app->request->post())) {
            $pathServer = Yii::$app->params['POS_IMAGE_PATH'];
            if(\yii\web\UploadedFile::getInstance($model,'IMAGE_PATH')){
                $fileImage = \yii\web\UploadedFile::getInstance($model,'IMAGE_PATH');
                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder
                DmposController::createDirectory('../../images/fb/pos/');
                // Convert chữ bỏ hết dấu của tên file
                $fileImage->name = FormatConverter::removesign($fileImage->name);
                $fileImage->saveAs('../../images/fb/pos/'.$fileImage->name);
                $model->IMAGE_PATH = $pathServer.'/pos/'.$fileImage->name;

//                DmposController::createDirectory('../../images/fb/pos/slide');
//                Image::thumbnail('../../images/fb/pos/'.$fileImage->name, 563, 1000)->save('../../images/fb/pos/slide/'.$fileImage->name, ['quality' => 90]);
//                $model->IMAGE_PATH = $pathServer.'/pos/slide/'.$fileImage->name;
            }
            $model->save();

            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            $searchPosModel = new DmposSearch();
            $allPos = $searchPosModel->searchAllPos();
            $allPosMap= ArrayHelper::map($allPos,'ID','POS_NAME');
            $model->POS_ID = $POS_ID;
            return $this->render('create', [
                'model' => $model,
                'allPosMap' => $allPosMap,
            ]);
        }
    }

    /**
     * Updates an existing Wmslideimagelist model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $model = $this->findModel($id);
        ApiController::actionCheckPosPermision($model->POS_ID);

        if ($model->load(Yii::$app->request->post())) {
            $pathServer = Yii::$app->params['POS_IMAGE_PATH'];
            if(\yii\web\UploadedFile::getInstance($model,'IMAGE_PATH')){
                $fileImage = \yii\web\UploadedFile::getInstance($model,'IMAGE_PATH');

                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder
                DmposController::createDirectory('../../images/fb/pos/');
                // Convert chữ bỏ hết dấu của tên file
                $fileImage->name = FormatConverter::removesign($fileImage->name);
                $fileImage->saveAs('../../images/fb/pos/'.$fileImage->name);
                $model->IMAGE_PATH = $pathServer.'/pos/'.$fileImage->name;

//                DmposController::createDirectory('../../images/fb/pos/slide');
//                Image::thumbnail('../../images/fb/pos/'.$fileImage->name, 563, 1000)->save('../../images/fb/pos/slide/'.$fileImage->name, ['quality' => 90]);
//                $model->IMAGE_PATH = $pathServer.'/pos/slide/'.$fileImage->name;
            }else{
                if(isset($post['image-old'])){
                    $model->IMAGE_PATH = $post['image-old'];
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
     * Deletes an existing Wmslideimagelist model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $this->findModel($id)->delete();

        return $this->redirect(['index','id' => $model->POS_ID]);
    }

    /**
     * Finds the Wmslideimagelist model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Wmslideimagelist the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Wmslideimagelist::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

//    public function actionCheckPosPermision($posId,$redirectLink){
//        $type = \Yii::$app->session->get('type_acc');
//        if($type != 1){
//            $searchPosModel = new DmposSearch();
//            $ids = $searchPosModel->getIds();
//            if(!in_array($posId,$ids)){
//                Yii::$app->getSession()->setFlash('error', 'Tài khoản của bạn không có quyền truy cập nhà hàng này!!');
//                return $this->redirect('index.php?r='.$redirectLink,302);
//            }
//        }
//    }
}
