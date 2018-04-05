<?php

namespace backend\controllers;

use backend\models\DmposSearch;
use Yii;
use backend\models\Dmshipfee;
use backend\models\DmshipfeeSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DmshipfeeController implements the CRUD actions for Dmshipfee model.
 */
class DmshipfeeController extends Controller
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
     * Lists all Dmshipfee models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DmshipfeeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $searchDmPos = new DmposSearch();
        $allPos = $searchDmPos->searchAllPos();
        $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');

        $FeeType = [
            -2 => 'Ahamove quyết định',
            -1 => 'Nhà hàng liên hệ sau',
            0 => 'Miễn phí',
            -3 => 'Có chi phí',
        ];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'allPosMap' => $allPosMap,
            'allFee' => $FeeType,

        ]);
    }

    /**
     * Displays a single Dmshipfee model.
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
     * Creates a new Dmshipfee model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dmshipfee();

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            if(isset($model->FEE)){
                if($model->FEE == -3){
                    $model->FEE = $post['fee'];
                }
            }

            $model->save();
            Yii::$app->getSession()->setFlash('success', 'Đặt phí vận chuyển thành công!');
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {

            $searchDmPos = new DmposSearch();
            $allPos = $searchDmPos->searchAllPos();
            $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');

            return $this->render('create', [
                'model' => $model,
                'allPosMap' => $allPosMap,
            ]);
        }
    }

    /**
     * Updates an existing Dmshipfee model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();

            if($model->FEE == -3){
                    $model->FEE = $post['fee'];
            }

            $model->save();
            Yii::$app->getSession()->setFlash('success', 'Sửa phí vận chuyển thành công!');
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            $searchDmPos = new DmposSearch();
            $allPos = $searchDmPos->searchAllPos();
            $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');

            if($model->FEE <=0){
                $fee = 0;
            }else{
                $fee = $model->FEE;
            }

            return $this->render('update', [
                'model' => $model,
                'allPosMap' => $allPosMap,
                'fee' =>$fee,

            ]);
        }
    }

    /**
     * Deletes an existing Dmshipfee model.
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
     * Finds the Dmshipfee model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Dmshipfee the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dmshipfee::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
