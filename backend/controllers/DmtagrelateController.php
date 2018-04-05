<?php

namespace backend\controllers;

use Yii;
use backend\models\Dmtagrelate;
use backend\models\DmtagrelateSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DmtagrelateController implements the CRUD actions for Dmtagrelate model.
 */
class DmtagrelateController extends Controller
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
     * Lists all Dmtagrelate models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DmtagrelateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Dmtagrelate model.
     * @param string $TAG_ID
     * @param string $POS_ID
     * @return mixed
     */
    public function actionView($TAG_ID, $POS_ID)
    {
        return $this->render('view', [
            'model' => $this->findModel($TAG_ID, $POS_ID),
        ]);
    }

    /**
     * Creates a new Dmtagrelate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dmtagrelate();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'TAG_ID' => $model->TAG_ID, 'POS_ID' => $model->POS_ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Dmtagrelate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $TAG_ID
     * @param string $POS_ID
     * @return mixed
     */
    public function actionUpdate($TAG_ID, $POS_ID)
    {
        $model = $this->findModel($TAG_ID, $POS_ID);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'TAG_ID' => $model->TAG_ID, 'POS_ID' => $model->POS_ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Dmtagrelate model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $TAG_ID
     * @param string $POS_ID
     * @return mixed
     */
    public function actionDelete($TAG_ID, $POS_ID)
    {
        $this->findModel($TAG_ID, $POS_ID)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Dmtagrelate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $TAG_ID
     * @param string $POS_ID
     * @return Dmtagrelate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($TAG_ID, $POS_ID)
    {
        if (($model = Dmtagrelate::findOne(['TAG_ID' => $TAG_ID, 'POS_ID' => $POS_ID])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
