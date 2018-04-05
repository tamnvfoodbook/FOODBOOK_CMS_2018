<?php

namespace backend\controllers;

use backend\models\Dmpos;
use Yii;
use backend\models\Coupon;
use backend\models\CouponSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\imagine\Image;
use yii\web\Response;

/**
 * CouponController implements the CRUD actions for COUPON model.
 */
class CouponController extends Controller
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
     * Lists all COUPON models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CouponSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single COUPON model.
     * @param integer $_id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $model->Coupon_Log_Date = date(Yii::$app->params['DATE_FORMAT'],$model->Coupon_Log_Date->sec);
        if($model->Active == 1){
            $model->Active = 'Active';
        }else{
            $model->Active = 'Deactive';
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new COUPON model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        // Get name member
        $posIdObj = Dmpos::find()
            ->select(['ID','POS_NAME','POS_PARENT'])
            ->asArray()
            ->all();
        $posIdList = ArrayHelper::map($posIdObj,'ID','POS_NAME','POS_PARENT');

        $model = new Coupon();


        if ($model->load(Yii::$app->request->post())) {
            $model->Coupon_Log_Date = new \MongoDate(strtotime(date('c')));
            $model->Denominations = (int)$model->Denominations;
            $model->save();
            return $this->redirect(['view', 'id' => (string)$model->_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'posIdList' => $posIdList,
            ]);
        }
    }

    /**
     * Updates an existing COUPON model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->Denominations = (int)$model->Denominations;
            $model->Active = (int)$model->Active;
            $oldModel = $model->oldAttributes;

            if($model->save()){
                    Yii::$app->session->setFlash('success', 'Sửa thành công');
                    DmquerylogController::actionCreateLog('UPDATE',get_class($model),$oldModel,$model->attributes);
                    return $this->redirect(['view', 'id' => (string)$model->_id]);
            }else{
                Yii::$app->session->setFlash('error', 'Hệ thống chưa xử lý được');
                return $this->redirect(['view', 'id' => (string)$model->_id]);
            }


        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing COUPON model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $insertLog = DmquerylogController::actionCreateLog('DELETE',get_class($model),$model->oldAttributes,null);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the COUPON model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return COUPON the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Coupon::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
