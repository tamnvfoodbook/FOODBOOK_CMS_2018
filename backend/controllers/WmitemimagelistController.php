<?php

namespace backend\controllers;


use backend\models\DmposSearch;
use yii\imagine\Image;
use Yii;
use backend\models\Wmitemimagelist;
use backend\models\WmitemimagelistSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\FormatConverter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * WmitemimagelistController implements the CRUD actions for Wmitemimagelist model.
 */
class WmitemimagelistController extends Controller
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
     * Lists all Wmitemimagelist models.
     * @return mixed
     */
    public function actionIndex($id)
    {

        $searchPosModel = new DmposSearch();
        ApiController::actionCheckPosPermision($id);

        $type = \Yii::$app->session->get('type_acc');

        if($type != 1){
            $ids = $searchPosModel->getIds();
            if(!in_array($id,$ids)){
                Yii::$app->getSession()->setFlash('error', 'Tài khoản của bạn không có quyền truy cập nhà hàng này!!');
                return $this->redirect('index.php?r=dmpositem',302);
            }
        }

        $searchModel = new WmitemimagelistSearch();
        $dataProvider = $searchModel->searchByPosId(Yii::$app->request->queryParams,$id);

        $pos = $searchPosModel->searchById($id);

        if($type == 1){
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'pos' => $pos,
            ]);
        }else{
            $allPos = $searchPosModel->searchAllPosById($id);
            $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');

            return $this->render('index_pos', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'pos' => $pos,
                'allPosMap' => $allPosMap,
            ]);
        }

    }

    /**
     * Displays a single Wmitemimagelist model.
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
     * Creates a new Wmitemimagelist model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($POS_ID)
    {
        ApiController::actionCheckPosPermision($POS_ID);
        $model = new Wmitemimagelist();

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

//                DmposController::createDirectory('../../images/fb/pos/wifi');
//                Image::thumbnail('../../images/fb/pos/'.$fileImage->name, 480, 270)->save('../../images/fb/pos/wifi/'.$fileImage->name, ['quality' => 90]);
//                $model->IMAGE_PATH = $pathServer.'/pos/wifi/'.$fileImage->name;
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
     * Updates an existing Wmitemimagelist model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $model = $this->findModel($id);

        ApiController::actionCheckPosPermision($model->POS_ID);

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            $pathServer = Yii::$app->params['POS_IMAGE_PATH'];

            if(\yii\web\UploadedFile::getInstance($model,'IMAGE_PATH')){
                $fileImage = \yii\web\UploadedFile::getInstance($model,'IMAGE_PATH');

                //Kiểm tra thư mục, nếu chưa có thì tạo ra folder
                DmposController::createDirectory('../../images/fb/pos/');

                // Convert chữ bỏ hết dấu của tên file
                $fileImage->name = FormatConverter::removesign($fileImage->name);
                $fileImage->saveAs('../../images/fb/pos/'.$fileImage->name);
                $model->IMAGE_PATH = $pathServer.'/pos/'.$fileImage->name;

//                DmposController::createDirectory('../../images/fb/pos/wifi');
//                Image::thumbnail('../../images/fb/pos/'.$fileImage->name, 480, 270)->save('../../images/fb/pos/wifi/'.$fileImage->name, ['quality' => 90]);
//                $model->IMAGE_PATH = $pathServer.'/pos/wifi/'.$fileImage->name;
            }else{
                if(isset($post['image-old'])){
                    $model->IMAGE_PATH = $post['image-old'];
                }
            }

            DmquerylogController::actionCreateLog('DELETE',get_class($model),$model->oldAttributes,null);
            $model->save();

            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Wmitemimagelist model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        ApiController::actionCheckPosPermision($model->POS_ID);
        DmquerylogController::actionCreateLog('DELETE',get_class($model),$model->oldAttributes,null);
        $this->findModel($id)->delete();

        return $this->redirect(['index','id' => $model->POS_ID]);
    }

    /**
     * Finds the Wmitemimagelist model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Wmitemimagelist the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Wmitemimagelist::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
