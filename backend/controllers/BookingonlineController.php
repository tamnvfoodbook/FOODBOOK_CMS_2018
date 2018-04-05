<?php

namespace backend\controllers;

use backend\models\DmmembershipSearch;
use backend\models\Dmpos;
use backend\models\DmposSearch;
use Yii;
use backend\models\Bookingonlinelog;
use backend\models\BookingonlinelogSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BookingonlineController implements the CRUD actions for Bookingonlinelog model.
 */
class BookingonlineController extends Controller
{
    public function behaviors()
    {
        date_default_timezone_set('Asia/Bangkok');
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
     * Lists all Bookingonlinelog models.
     * @return mixed
     */
    public function actionIndex()
    {

        if(!isset(Yii::$app->request->queryParams['BookingonlineSearch']['Created_At'])){
            $timeRanger = date('d/m/Y',strtotime("-1 week")).' - '.date('d/m/Y');
        }else{
            $timeRanger = Yii::$app->request->queryParams['BookingonlineSearch']['Created_At'];
        }
        
        $searchModel = new BookingonlinelogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$timeRanger);
//        $dataProvider->setPagination(false);
        $dataProvider->setSort(false);

        $searchPosModel = new DmposSearch();
        $allPos = $searchPosModel->searchAllPos();
        $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');

        // returns an array of Post objects
        $posts = $dataProvider->getModels();

        $User_Id = array();
        foreach($posts as $record) {
            $User_Id[] = $record->User_Id;
        }

//        echo '<pre>';
//        var_dump($User_Id);
//        echo '</pre>';

        $searchMemberModel = new DmmembershipSearch();
        $allMember = $searchMemberModel->searchMemberById($User_Id);
        $memberMap = ArrayHelper::map($allMember,'ID','MEMBER_NAME');
        $memberMapMyStatus = ArrayHelper::map($allMember,'ID','MY_STATUS');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'allPosMap' => $allPosMap,
            'memberMap' => $memberMap,
            'timeRanger' => $timeRanger,
            'allMemberMap' => $memberMap,
            'memberMapMyStatus' => $memberMapMyStatus
        ]);
    }

    public function actionIndexpos()
    {
        date_default_timezone_set('Asia/Bangkok');
        $searchPosModel = new DmposSearch();
        $ids = $searchPosModel->getIds();

        $searchModel = new BookingonlinelogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$ids);

        $allPos = $searchPosModel->searchAllPosById($ids);
        $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'allPosMap' => $allPosMap,
        ]);
    }

    /**
     * Displays a single Bookingonlinelog model.
     * @param integer $_id
     * @return mixed
     */
    public function actionView($id)
    {
        date_default_timezone_set('Asia/Bangkok');
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Bookingonlinelog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Bookingonlinelog();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => (string)$model->_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Bookingonlinelog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => (string)$model->_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Bookingonlinelog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Bookingonlinelog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return Bookingonlinelog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bookingonlinelog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
