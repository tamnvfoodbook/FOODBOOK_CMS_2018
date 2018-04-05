<?php

namespace backend\controllers;

use backend\models\Dmconfig;
use Yii;
use backend\models\Dmfacebookpageconfig;
use backend\models\DmfacebookpageconfigSearch;
use yii\data\ArrayDataProvider;
use yii\helpers\FormatConverter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * DmfacebookpageconfigController implements the CRUD actions for Dmfacebookpageconfig model.
 */
class DmfacebookpageconfigController extends Controller
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
     * Lists all Dmfacebookpageconfig models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DmfacebookpageconfigSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdatemenu($id,$subId = null)
    {
        $model = $this->findMenuByposparent();
        $model->PERSISTENT_MENU = json_decode($model->PERSISTENT_MENU,true);
        $data = $model->PERSISTENT_MENU['persistent_menu'][0]['call_to_actions'][$id];
        $tmpData = $model->PERSISTENT_MENU;
        $model->TITLE = $data['title'];
        $model->TYPE_MENU = $data['type'];

        $actionData = array();
        foreach((array)$data['call_to_actions'] as $key => $value){
            $value['id'] = $key;
            $actionData[$key] = $value;
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $actionData,
        ]);

        if($subId != null){
            $modelActionMenu = $data['call_to_actions'][$subId];

            $model->TITLE = $modelActionMenu['title'];
            $model->FUNCTION_NAME = $modelActionMenu['payload'];

            if($model->load(Yii::$app->request->post())){

                $tmpData['persistent_menu'][0]['call_to_actions'][$id]['call_to_actions'][$subId]['title'] = $model->TITLE;
                $tmpData['persistent_menu'][0]['call_to_actions'][$id]['call_to_actions'][$subId]['payload'] = $model->FUNCTION_NAME;
                $model->PERSISTENT_MENU = $tmpData;

                $model->PERSISTENT_MENU = json_encode($model->PERSISTENT_MENU,JSON_UNESCAPED_UNICODE);

                $apiPath = Yii::$app->params['CMS_API_PATH_SHORT'];
                $name = 'partner/setup_page';


                $param = [
                    'pos_parent' => $model->POS_PARENT,
                    'page_id' => $model->PAGE_ID,
                    'json_menu' => $model->PERSISTENT_MENU
                ];

                $result = ApiController::getApiByMethod($name,$apiPath,$param,'POST');


                if($model->save()){
                    Yii::$app->session->setFlash('success', 'Sửa thành công');
                }else{
                    Yii::$app->session->setFlash('error', 'Sửa lỗi');
                }


                return $this->redirect(['menu',
                    'parentId' => $id,
                    'subId' => $subId,
                ]);

            }else {
                return $this->renderPartial('form_update_menu', [
                    'model' => $model,
                    'prarentId' => $id,
                    'subId' => $subId,
                ]);
            }
        }else{
            return $this->renderPartial('action_menu', [
                'model' => $model,
                'dataProvider' => $dataProvider,
                'prarentId' => $id,
                'subId' => $subId,
            ]);
        }


    }

    public function actionMenu($parentId = null, $subId = null)
    {
        $model = $this->findMenuByposparent();
        $model->PERSISTENT_MENU = json_decode($model->PERSISTENT_MENU,true);
        $data = array();
        foreach((array)$model->PERSISTENT_MENU['persistent_menu'][0]['call_to_actions'] as $key => $value){
            $value['id'] = $key;
            $data[$key] = $value;
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
        ]);


        if($parentId != null){

            $actionData = array();
            foreach((array)@$data[$parentId]['call_to_actions'] as $key => $value){
                $value['id'] = $key;
                $actionData[$key] = $value;
            }

            $dataProviderChildren = new ArrayDataProvider([
                'allModels' => $actionData,
            ]);

        }


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

            $model->JSON_FUNCTION = json_encode($model->JSON_FUNCTION);

            $model->save();

            return $this->redirect(['facefunction']);
        } else {
            return $this->render('menu_facebook', [
                'model' => $model,
                'dataProvider' => $dataProvider,
                'dataProviderChildren' => @$dataProviderChildren,
                'parentId' => $parentId,
            ]);
        }
    }

    /**
     * Displays a single Dmfacebookpageconfig model.
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
     * Creates a new Dmfacebookpageconfig model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = $this->findMenuByposparent();
        $model->PERSISTENT_MENU = json_decode($model->PERSISTENT_MENU,true);
        $data = array();
        foreach((array)$model->PERSISTENT_MENU['persistent_menu'][0]['call_to_actions'] as $key => $value){
            $value['id'] = $key;
            $data[$key] = $value;
        }




        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->PAGE_ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Dmfacebookpageconfig model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findMenuByposparent();
        $model->PERSISTENT_MENU = json_decode($model->PERSISTENT_MENU,true);
        $tmpData = $model->PERSISTENT_MENU;
        $data = array();
        foreach((array)$model->PERSISTENT_MENU['persistent_menu'][0]['call_to_actions'] as $key => $value){
            $value['id'] = $key;
            $data[$key] = $value;
        }

        $model->TITLE = $data[$id]['title'];



        if($model->load(Yii::$app->request->post())){

            $tmpData['persistent_menu'][0]['call_to_actions'][$id]['title'] = $model->TITLE;
            $model->PERSISTENT_MENU = $tmpData;

            $model->PERSISTENT_MENU = json_encode($model->PERSISTENT_MENU,JSON_UNESCAPED_UNICODE);


            $apiPath = Yii::$app->params['CMS_API_PATH_SHORT'];
            $access_token = Yii::$app->params['ACCESS_TOKEN'];
            $name = 'partner/setup_page';


            $param = [
                'pos_parent' => $model->POS_PARENT,
                'page_id' => $model->PAGE_ID,
                'json_menu' => $model->PERSISTENT_MENU
            ];

            $result = ApiController::getApiByMethod($name,$apiPath,$param,'POST');



            if(isset($result->data)){
                if($model->save()){
                    Yii::$app->session->setFlash('success', 'Sửa thành công');
                }else{
                    Yii::$app->session->setFlash('error', 'Sửa lỗi');
                }
            }else{
                Yii::$app->session->setFlash('error', 'Sửa lỗi');
            }

            return $this->redirect(['menu',
                'parentId' => $id,
            ]);

        } else {
            return $this->renderPartial('form_update_menu_parent', [
                'model' => $model,
            ]);
        }
    }



    public function actionHide($id)
    {
        $model = $this->findMenuByposparent();
        $model->PERSISTENT_MENU = json_decode($model->PERSISTENT_MENU,true);
        $tmpData = $model->PERSISTENT_MENU;
        if(!isset($tmpData['persistent_menu'][0]['call_to_actions'][$id]) || @$tmpData['persistent_menu'][0]['call_to_actions'][$id]['active'] == 0){
            $tmpData['persistent_menu'][0]['call_to_actions'][$id]['active'] = 1;
        }else{
            $tmpData['persistent_menu'][0]['call_to_actions'][$id]['active'] = 0;
        }

        $model->PERSISTENT_MENU = $tmpData;

        /*echo '<pre>';
        var_dump($model->PERSISTENT_MENU);
        echo '</pre>';
        die();*/
        $model->PERSISTENT_MENU = json_encode($model->PERSISTENT_MENU,JSON_UNESCAPED_UNICODE);

        $apiPath = Yii::$app->params['CMS_API_PATH_SHORT'];
        $access_token = Yii::$app->params['ACCESS_TOKEN'];
        $name = 'partner/setup_page';

        $param = [
            'pos_parent' => $model->POS_PARENT,
            'page_id' => $model->PAGE_ID,
            'json_menu' => $model->PERSISTENT_MENU
        ];

        $result = ApiController::getApiByMethod($name,$apiPath,$param,'POST');

        if($model->save()){
            Yii::$app->session->setFlash('success', 'Sửa thành công');
        }else{
            Yii::$app->session->setFlash('error', 'Sửa lỗi');
        }

        return $this->redirect(['menu',
            'parentId' => $id,
        ]);

    }
    public function actionHidechil($parentId = null, $id = null)
    {
        $model = $this->findMenuByposparent();
        $model->PERSISTENT_MENU = json_decode($model->PERSISTENT_MENU,true);
        $tmpData = $model->PERSISTENT_MENU;

        /*echo '<pre>';
        var_dump($tmpData['persistent_menu'][0]['call_to_actions'][$parentId]['call_to_actions'][$id]['active']);
        echo '</pre>';*/

        if(!isset($tmpData['persistent_menu'][0]['call_to_actions'][$parentId]['call_to_actions'][$id]['active']) || @$tmpData['persistent_menu'][0]['call_to_actions'][$parentId]['call_to_actions'][$id]['active'] == 0){
            $tmpData['persistent_menu'][0]['call_to_actions'][$parentId]['call_to_actions'][$id]['active'] = 1;
        }else{
            $tmpData['persistent_menu'][0]['call_to_actions'][$parentId]['call_to_actions'][$id]['active'] = 0;
        }

        $model->PERSISTENT_MENU = $tmpData;

        $model->PERSISTENT_MENU = json_encode($model->PERSISTENT_MENU,JSON_UNESCAPED_UNICODE);

        $apiPath = Yii::$app->params['CMS_API_PATH_SHORT'];
        $access_token = Yii::$app->params['ACCESS_TOKEN'];
        $name = 'partner/setup_page';

        $param = [
            'pos_parent' => $model->POS_PARENT,
            'page_id' => $model->PAGE_ID,
            'json_menu' => $model->PERSISTENT_MENU
        ];

        $result = ApiController::getApiByMethod($name,$apiPath,$param,'POST');

        if($model->save()){
            Yii::$app->session->setFlash('success', 'Sửa thành công');
        }else{
            Yii::$app->session->setFlash('error', 'Sửa lỗi');
        }


        return $this->redirect(['menu',
            'parentId' => $parentId,
        ]);

    }

    public function actionFacefunction()
    {
        $model = $this->findFuncByposparent();
        $faceFunctionString = $model->JSON_FUNCTION;
        $model->JSON_FUNCTION = json_decode($model->JSON_FUNCTION);
        $faceFunctionData = $model->JSON_FUNCTION;


        $items = array();

        foreach($model->JSON_FUNCTION as $key => $value){
            /*echo '<pre>';
            var_dump($faceFunctionString);
            echo '</pre>';
            die();*/

            if(substr($key, 0, 4) == 'func'){
                foreach($value as $keychid => $children){



                    $node = array();
                    if(@$children->type == 1){
                        $label = $keychid;
                        $node[] = ['label' => $label, 'icon'=>'info-sign', 'url'=>'#'.$key.'-'.$keychid ];
                    }else{
                        foreach((array)@$children->template->elements as $keychildrentype2 =>  $valueMenu){
                            $label = $valueMenu->title;
                            $node[] = ['label' => $label, 'icon'=>'info-sign', 'url'=>'#'.$key.'-'.$keychid.'-'.$keychildrentype2 ];
                            /*echo '<pre>';
                            var_dump($node);
                            echo '</pre>';*/
                        }
                    }

                    $items[$keychid] = [
                        'label' => $key,
                        'icon' => 'circle-arrow-right',
                        'items' => @$node
                    ];

                }

            /*echo '<pre>';
            var_dump($node);
            echo '</pre>';*/




            }
        }

        /*echo '<pre>';
        var_dump($items);
        echo '</pre>';
        die();*/


        if ($model->load(Yii::$app->request->post())) {

            $str = ltrim($model->FUNCTION_NAME,'#');
            $strArray =  explode("-",$str);

            $faceFunctionData->$strArray[0]->$strArray[1]->type = $model->TYPE_FUNCTION;

            if($model->TYPE_FUNCTION ==1){
                $faceFunctionData->$strArray[0]->$strArray[1]->content = $model->DESCRIPTION;
            }else if($model->TYPE_FUNCTION == 2){

                $faceFunctionData->$strArray[0]->$strArray[1]->template->elements[0]->title = $model->TITLE;
                $faceFunctionData->$strArray[0]->$strArray[1]->template->elements[0]->subtitle = $model->DESCRIPTION;

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
                $faceFunctionData->$strArray[0]->$strArray[1]->template->elements[0]->image = $model->IMAGE_PATH;

            }

            $model->JSON_FUNCTION = json_encode($faceFunctionData,JSON_UNESCAPED_UNICODE);

            $model->save();

            /*echo '<pre>';
            var_dump($model->save());
            echo '</pre>';
            die();*/

            return $this->redirect(['facefunction']);
        } else {
//            $specialChars = array("\r", "\n", "\n1");
//            $replaceChars = array("", "", "");
            /*echo '<pre>';
            var_dump($model->JSON_FUNCTION);
            echo '</pre>';*/

//            $model->JSON_FUNCTION = str_replace($specialChars, $replaceChars, json_encode($model->JSON_FUNCTION));
//            $model->JSON_FUNCTION = self::cleanString(json_encode($model->JSON_FUNCTION));
//            echo '<pre>';
//            var_dump($model->JSON_FUNCTION);
//            echo '</pre>';
//            die();

            return $this->render('face_function', [
                'model' => $model,
                'items' => $items,
                'faceFunctionString' => $faceFunctionString,
            ]);
        }

    }

    function cleanString($text) {
        $utf8 = array(
            '/[áàâãªä]/u'   =>   'a',
            '/[ÁÀÂÃÄ]/u'    =>   'A',
            '/[ÍÌÎÏ]/u'     =>   'I',
            '/[íìîï]/u'     =>   'i',
            '/[éèêë]/u'     =>   'e',
            '/[ÉÈÊË]/u'     =>   'E',
            '/[óòôõºö]/u'   =>   'o',
            '/[ÓÒÔÕÖ]/u'    =>   'O',
            '/[úùûü]/u'     =>   'u',
            '/[ÚÙÛÜ]/u'     =>   'U',
            '/ç/'           =>   'c',
            '/Ç/'           =>   'C',
            '/ñ/'           =>   'n',
            '/Ñ/'           =>   'N',
            '/–/'           =>   '-', // UTF-8 hyphen to "normal" hyphen
            '/[’‘‹›‚]/u'    =>   ' ', // Literally a single quote
            '/[“”«»„]/u'    =>   ' ', // Double quote
            '/ /'           =>   ' ', // nonbreaking space (equiv. to 0x160)
        );
        return preg_replace(array_keys($utf8), array_values($utf8), $text);
    }

    /**
     * Deletes an existing Dmfacebookpageconfig model.
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
     * Finds the Dmfacebookpageconfig model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Dmfacebookpageconfig the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dmfacebookpageconfig::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findMenuByposparent()
    {
        $model = Dmfacebookpageconfig::find()->where(['POS_PARENT' => Yii::$app->session->get('pos_parent')])->one();

        if($model){
            if (($model->PERSISTENT_MENU) !== null) {
                return $model;
            } else {
                $modelConfig = Dmconfig::find()->where(['KEYWORD' => 'facebook_json_function'])->one();

                $model->PERSISTENT_MENU = $modelConfig->VALUES;
                return $model;
            }
        }else{
            Yii::$app->getSession()->setFlash('error', "Hiện tại hệ thống nhà hàng chưa đăng kí Facebook trên Foodbook, xin vui lòng liên hệ với Foodbook để được thiết lập");
            return $this->redirect(['null']);
        }
    }
    protected function findFuncByposparent()
    {
        $model = Dmfacebookpageconfig::find()->where(['POS_PARENT' => Yii::$app->session->get('pos_parent')])->one();

        if($model){
            if (($model->JSON_FUNCTION) !== null) {
                return $model;
            } else {
                $modelConfig = Dmconfig::find()->where(['KEYWORD' => 'facebook_json_function'])->one();
                $model->JSON_FUNCTION = $modelConfig->VALUES;
                return $model;
            }
        }else{
            Yii::$app->getSession()->setFlash('error', "Hiện tại hệ thống nhà hàng chưa đăng kí Facebook trên Foodbook, xin vui lòng liên hệ với Foodbook để được thiết lập hệ thống");
            return $this->redirect(['null']);
        }
    }

}
