<?php

namespace backend\controllers;

use backend\models\DmitemtypemasterSearch;
use backend\models\Dmpos;
use backend\models\DmposSearch;
use Yii;
use backend\models\Dmitem;
use backend\models\DmitemSearch;
use backend\models\DmitemupdateSearch;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DmitemController implements the CRUD actions for Dmitem model.
 */
class DmitemController extends Controller
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
     * Lists all Dmitem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DmitemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $searchPosModel = new DmposSearch();
        $allPos = $searchPosModel->searchAllPos();
        $allPosMap= ArrayHelper::map($allPos,'ID','POS_NAME');

        $searchItemTypeMasterModel = new DmitemtypemasterSearch();
        $allItemTypeMaster = $searchItemTypeMasterModel->searchAllItemTypeMaster();
        $itemTypeMasterMap= ArrayHelper::map($allItemTypeMaster,'ID','ITEM_TYPE_MASTER_NAME');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'itemTypeMasterMap' => $itemTypeMasterMap,
            'allPosMap' => $allPosMap,
        ]);
    }

    public function actionItemsupdate()
    {
        $searchModel = new DmitemupdateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $searchPosModel = new DmposSearch();
        $allPos = $searchPosModel->searchAllPos();
        $allPosMap= ArrayHelper::map($allPos,'ID','POS_NAME');

        $searchItemTypeMasterModel = new DmitemtypemasterSearch();
        $allItemTypeMaster = $searchItemTypeMasterModel->searchAllItemTypeMaster();
        $itemTypeMasterMap= ArrayHelper::map($allItemTypeMaster,'ID','ITEM_TYPE_MASTER_NAME');

        return $this->render('itemsupdate', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'itemTypeMasterMap' => $itemTypeMasterMap,
            'allPosMap' => $allPosMap,
        ]);
    }



    /**
     * Displays a single Dmitem model.
     * @param string $ID
     * @param string $POS_ID
     * @return mixed
     */
    public function actionView($ID, $POS_ID)
    {
        return $this->render('view', [
            'model' => $this->findModel($ID, $POS_ID),
        ]);
    }

    /**
     * Creates a new Dmitem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */



    public function actionCreate()
    {
        $model = new Dmitem();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ID' => $model->ID, 'POS_ID' => $model->POS_ID]);
        } else {

            //$searchPosparent =

            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    public function actionReportitem()
    {
        $posModel = new DmposSearch();
        $pos = $posModel->searchAllPosActive();
        $posMapId = ArrayHelper::map($pos,'ID','ID');
        $posMap = ArrayHelper::map($pos,'ID','POS_NAME');

        $itemModelSearch = new DmitemSearch();
        $itemReport = $itemModelSearch->searchAllItemReport($posMapId);
        $itemReportJustUpdate = $itemModelSearch->searchAllItemReportJustUpdate($posMapId);
        $itemReportJustUpdateMap = ArrayHelper::map($itemReportJustUpdate,'POS_ID','justupdate');
//        echo '<pre>';
//        var_dump($itemReportJustUpdateMap);
//        echo '</pre>';
//        die();
        $data = array();
        foreach($itemReport as $item){
            if(!isset($data[$item['POS_ID']])){
                $data[$item['POS_ID']]['POS_ID'] = $item['POS_ID'];
                $data[$item['POS_ID']]['TOTAL'] = 0;
                $data[$item['POS_ID']]['LAST_UPDATED'] = @$itemReportJustUpdateMap[$item['POS_ID']];
            }
            $data[$item['POS_ID']]['TOTAL'] = $item['allItem']+ $data[$item['POS_ID']]['TOTAL'];

            if($item['ACTIVE'] == 1){
                $data[$item['POS_ID']]['ACTIVE'] = $item['allItem'];
            }else if($item['ACTIVE'] == 2){
                $data[$item['POS_ID']]['UPDATED'] = $item['allItem'];
            }else{
                $data[$item['POS_ID']]['DEACTIVE'] = $item['allItem'];
            }


        }

//        echo '<pre>';
//        var_dump($data);
//        echo '</pre>';
//        die();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 10,
            ],
            //'sort' => ['defaultOrder' => ['UPDATED'=>SORT_ASC]],
        ]);






//        echo '<pre>';
//        var_dump($itemReport);
//        echo '</pre>';


        return $this->render('report', [
            'allPosMap' => $posMap,
            'itemReport' => $itemReport,
            'dataProvider' => $dataProvider,
        ]);


    }

    /**
     * Updates an existing Dmitem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $ID
     * @param string $POS_ID
     * @return mixed
     */
    public function actionUpdate($ID, $POS_ID)
    {
        $model = $this->findModel($ID, $POS_ID);
        $oldModel = $model->oldAttributes;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            DmquerylogController::actionCreateLog('UPDATE',get_class($model),$oldModel,$model->attributes);
            return $this->redirect(['view', 'ID' => $model->ID, 'POS_ID' => $model->POS_ID]);
        } else {
            $model->ACTIVE = 1;
            if($model->save()){
                Yii::$app->session->setFlash('success', 'Món Acvite thành công');
            }else{
                Yii::$app->session->setFlash('success', 'Cập nhật món lỗi');
            }
            return $this->redirect(['index']);
        }
    }

    /**
     * Deletes an existing Dmitem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $ID
     * @param string $POS_ID
     * @return mixed
     */
    public function actionDelete($ID, $POS_ID)
    {
        $model = $this->findModel($ID, $POS_ID);
        DmquerylogController::actionCreateLog('DELETE',get_class($model),$model->oldAttributes,null);

        $this->findModel($ID, $POS_ID)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Dmitem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $ID
     * @param string $POS_ID
     * @return Dmitem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID, $POS_ID)
    {
        if (($model = Dmitem::findOne(['ID' => $ID, 'POS_ID' => $POS_ID])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function findModelByPos($ID, $POS_ID)
    {
        if (($model = Dmitem::findOne(['ID' => $ID, 'POS_ID' => $POS_ID])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSetactive(){
        $post = Yii::$app->request->post();
        if(isset($post['selection'])){
            $tmpItem = 0; // Dung để đếm số món thành công
            foreach($post['selection'] as $key => $value){
                $arrayValue = json_decode($value);
                $model = $this->findModel($arrayValue->ID,$arrayValue->POS_ID);
                $model->ACTIVE = (int)$post['set_value'];
                if($model->update(false,['ACTIVE'])){
                    $tmpItem++;
                }
            }
            Yii::$app->session->setFlash('success', $tmpItem.' Món Acvite thành công');
        }
        if(isset($post['checkupdate_page'])){
            return $this->redirect(['itemsupdate']);
        }else{
            return $this->redirect(['index']);
        }


    }
}
