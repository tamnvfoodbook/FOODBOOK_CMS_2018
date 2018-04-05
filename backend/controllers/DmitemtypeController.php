<?php

namespace backend\controllers;

use backend\models\Dmitem;
use backend\models\DmitemSearch;
use backend\models\DmposSearch;
use backend\models\MgitemchangedSearch;
use Yii;
use backend\models\Dmitemtype;
use backend\models\DmitemtypeSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * DmitemtypeController implements the CRUD actions for Dmitemtype model.
 */
class DmitemtypeController extends Controller
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
     * Lists all Dmitemtype models.
     * @return mixed
     */
    public function actionIndex($id = null)
    {
        $searchModel = new DmitemtypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$id);
        $searchPosModel = new DmposSearch();
        $POS_ID_LIST = $searchPosModel->searchAllPos();
        $allPosMap= ArrayHelper::map($POS_ID_LIST,'ID','POS_NAME');

        if($id){
            return $this->render('index_with_pos', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'allPosMap' => $allPosMap,
            ]);
        }else{
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'allPosMap' => $allPosMap,
            ]);
        }

    }

    /**
     * Displays a single Dmitemtype model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $dmposSearch = new DmposSearch();
        $dmpos = $dmposSearch->searchAllPos();
        $allPosMap = ArrayHelper::map($dmpos,'ID','POS_NAME');
        $model->POS_ID = $allPosMap[$model->POS_ID];

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Dmitemtype model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dmitemtype();
        $dmposSearch = new DmposSearch();
        $dmpos = $dmposSearch->searchAllPos();
        $allPosMap = ArrayHelper::map($dmpos,'ID','POS_NAME');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if(is_array($model->ITEM_LIST)){
                $pos_parent = $dmposSearch->searchById($model->POS_ID);
                $posArr = $dmposSearch->searchAllActiveAndDeactiveByPosParent($pos_parent);
                $posMap = ArrayHelper::map($posArr,'ID','ID');
                $pos_list = implode(",",$posMap);
                $item_list = implode(",",$model->ITEM_LIST);

                $paramUpdateArr = [
                    'ITEM_TYPE_ID' => $model->ITEM_TYPE_ID,
                ];
                Dmitem::updateAll(
                    $paramUpdateArr
                    , 'POS_ID IN ('.$pos_list.') AND ID IN ('.$item_list.') ');

                Yii::$app->session->setFlash('success', 'Thêm loại món '.$model->ITEM_TYPE_NAME.' thành công và đã thêm loại món vào các món bạn đã chọn');
            }else{
                Yii::$app->session->setFlash('success', 'Thêm loại món '.$model->ITEM_TYPE_NAME.' thành công');
            }


            return $this->redirect(['view', 'id' => $model->ID]);

        } else {
            return $this->render('create', [
                'model' => $model,
                'allPosMap' => $allPosMap,
//                'itemMap' => $itemMap,
            ]);
        }
    }


    public function getSubCatList1($pos_id, $param1, $param2){
        $data = NULL;

        $searchItem = new DmitemSearch();
        $allItem = $searchItem->searchItemByPos($pos_id);
        /*$allItemMap = ArrayHelper::map($allItem,'ID','ITEM_NAME');
        echo '<pre>';
        var_dump($allItem);
        echo '</pre>';
        die();*/

        foreach($allItem as $key => $value){
            $data[] = ['id' => $value['ID'], 'name' => $value['ITEM_NAME']];
        }

        /*echo '<pre>';
        var_dump($data);
        echo '</pre>';
        die();*/

        /*$data = [
                ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
                ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
            ];*/
        return $data;
    }

    public function actionSubcat(){
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $param1 = null;
                $param2 = null;
                if (!empty($_POST['depdrop_params'])) {
                    $params = $_POST['depdrop_params'];
                    $param1 = $params[0]; // get the value of input-type-1
                    $param2 = $params[1]; // get the value of input-type-2
                }

                $out = self::getSubCatList1($cat_id, $param1, $param2);
                // the getSubCatList1 function will query the database based on the
                // cat_id, param1, param2 and return an array like below:
                // [
                //    'group1'=>[
                //        ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
                //        ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
                //    ],
                //    'group2'=>[
                //        ['id'=>'<sub-cat-id-3>', 'name'=>'<sub-cat-name3>'],
                //        ['id'=>'<sub-cat-id-4>', 'name'=>'<sub-cat-name4>']
                //    ]
                // ]


                //$selected = self::getDefaultSubCat($cat_id);
                //$selected
                // the getDefaultSubCat function will query the database
                // and return the default sub cat for the cat_id

                echo Json::encode(['output'=>$out, 'selected'=>'']);
                //echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    /**
     * Updates an existing Dmitemtype model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldModel = $model->oldAttributes;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $post = Yii::$app->request->post();
            DmquerylogController::actionCreateLog('UPDATE',get_class($model),$oldModel,$model->attributes);

            if(isset($post['btn_for_all'])){

                $dmposSearch = new DmposSearch();
                $pos_parent = $dmposSearch->searchById($model->POS_ID);
                $posArr = $dmposSearch->searchAllActiveAndDeactiveByPosParent($pos_parent);

                $posMap = ArrayHelper::map($posArr,'ID','ID');
                $pos_list = implode(",",$posMap);
                $paramUpdateArr = [
                    'ITEM_TYPE_NAME' => $model->ITEM_TYPE_NAME,
                    'SORT' => $model->SORT,
                    'ACTIVE' => (int)$model->ACTIVE,
                ];

                Dmitemtype::updateAll(
                    $paramUpdateArr
                    , 'POS_ID IN ('.$pos_list.') AND ITEM_TYPE_ID = "'.$model->ITEM_TYPE_ID.'" ');
            }

            Yii::$app->session->setFlash('success', 'Cập nhật loại món '.$model->ITEM_TYPE_NAME.' thành công');
            $mgItemUpdate = new MgitemchangedSearch();
            $mgItemUpdate->updatechange($model->POS_ID);


            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Dmitemtype model.
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
     * Finds the Dmitemtype model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Dmitemtype the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dmitemtype::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
