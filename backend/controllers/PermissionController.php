<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use backend\models\DMPOS;
use backend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;


/**
 * PermissionController implements the CRUD actions for User model.
 */
class PermissionController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $posParent = \Yii::$app->session->get('pos_parent');
        $type = \Yii::$app->session->get('type_acc');
        if($type == 1) {
            $userData = User::find()
            //->select(['id','username','full_name','pos_parrent','pos_id_list'])
            ->asArray()
            ->all();

            $dmPos= DMPOS::find()
            ->select(['ID','POS_NAME'])
            ->where(['POS_PARENT' => $posParent])
            ->asArray()
            ->all();

            $user = ArrayHelper::map($userData,'ID','USERNAME');
            $pos = ArrayHelper::map($dmPos,'POS_NAME','ID');
            var_dump($pos);
            die();

        }else{
            $dmPos = DMPOS::find()
            ->select(['ID','POS_NAME'])
            ->where(['POS_PARENT' => $posParent])
            ->asArray()
            ->all();

            $userData = User::find()
            //->select(['id','username','USERNAME','POS_PARENT','pos_id_list'])
            ->where(['POS_PARENT' => $posParent])
            ->asArray()
            ->all();

            $user = ArrayHelper::map($userData,'id','full_name');        
            $pos = ArrayHelper::map($dmPos,'ID','POS_NAME'); 
        }
        
               

        if ($posParent === 'root') {
            return $this->render('root', [
                'pos' => $pos,
                'user' => $user,            
            ]);
        }else{
            return $this->render('index', [
                'pos' => $pos,
                'user' => $user,            
            ]);
        }       
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
