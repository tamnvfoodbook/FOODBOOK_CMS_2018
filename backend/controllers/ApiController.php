<?php

namespace backend\controllers;
use backend\controllers\OrderonlinelogController;

use backend\models\DmposSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use yii\web\Controller;

class ApiController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'rules' => [
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }


    public function getApiByMethod($name,$apiPath,$param,$method = 'GET'){
        //Set Header $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];
        $access_token = Yii::$app->params['ACCESS_TOKEN'];
        $user_token = \Yii::$app->session->get('user_token');
        $headers = array();
        $headers[] = 'access_token: '.$access_token;
        $headers[] = 'token: '.$user_token;

        // Set body parameter

        $api_request_url = $apiPath.$name;

        /*
  Set the Request Url (without Parameters) here
*/
        /*
          Which Request Method do I want to use ?
          DELETE, GET, POST or PUT
        */
        $method_name = $method;


        /*
          Let's set all Request Parameters (api_key, token, user_id, etc)
        */
        $api_request_parameters = $param;



        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        if ($method_name == 'DELETE')
        {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($api_request_parameters));
        }

        if ($method_name == 'GET')
        {
            $api_request_url .= '?' . http_build_query($api_request_parameters);

        }

        if ($method_name == 'POST')
        {
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($api_request_parameters));
        }

        if ($method_name == 'PUT')
        {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($api_request_parameters));
        }

        /*
          Here you can set the Response Content Type you prefer to get :
          application/json, application/xml, text/html, text/plain, etc
        */

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        /*echo '<pre>';
    var_dump($header);
    //var_dump($api_request_url);
    echo '</pre>';
    die();*/




        /*
          Let's give the Request Url to Curl
        */
        curl_setopt($ch, CURLOPT_URL, $api_request_url);

        /*
          Yes we want to get the Response Header
          (it will be mixed with the response body but we'll separate that after)
        */
        //curl_setopt($ch, CURLOPT_HEADER, TRUE);

        /*
          Allows Curl to connect to an API server through HTTPS
        */
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        /*
          Let's get the Response !
        */
        $api_response = curl_exec($ch);
//        var_dump($api_response);

        /*
          We need to get Curl infos for the header_size and the http_code
        */
        //$api_response_info = curl_getinfo($ch);

        /*
          Don't forget to close Curl
        */

        $info = curl_getinfo($ch);

//        Yii::info('TIME Request API' . $api_request_url);
//        Yii::info(@$info['total_time']);
        curl_close($ch);

        $data = json_decode($api_response);
        Yii::error($name);
        Yii::error($api_response);
        if($data != NULL){
            if(isset($data->error) && ($data->error->code === 1400)){
                self::actionLogout();
            }
        }

        return json_decode($api_response);
    }


    public static function postJsonDataFromApi($apiPath,$func, $query){

        $access_token = Yii::$app->params['ACCESS_TOKEN'];
        $user_token = \Yii::$app->session->get('user_token');

        $url_source = $apiPath.$func."?access_token=".$access_token."&session_token=".$user_token;
        $data = json_encode($query);
        $response = self::postDataFromCurl($url_source, $data);
        $result = null;
        if(isset($response["error"])){
            $result = $response["error"];
        }elseif(isset($response["data"])){
            $result = $response["data"];
        }
        return $result;
    }

    private static function postDataFromCurl($url_source, $data)
    {
        $ch = curl_init($url_source);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        $response = json_decode($response, true);
        return $response;
    }

    public static function postObjDataFromApi($apiPath,$func, $query){


        $access_token = Yii::$app->params['ACCESS_TOKEN'];
        $user_token = \Yii::$app->session->get('user_token');

        $url_source = $apiPath.$func."?access_token=".$access_token."&session_token=".$user_token;
        $data = json_encode($query,JSON_UNESCAPED_UNICODE);
        $response = self::postObjDataFromCurl($url_source, $data);
        return $response;
    }

    private static function postObjDataFromCurl($url_source, $data)
    {
        $ch = curl_init($url_source);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        $response = json_decode($response);
        return $response;
    }


    public static function getDataFromApi($ip_server_cms,$func, $query){
        $url_source = $ip_server_cms.$func;

        $access_token = Yii::$app->params['ACCESS_TOKEN'];
        $user_token = \Yii::$app->session->get('user_token');
        $query['access_token'] = $access_token;
        $query['session_token'] = $user_token;

        $response = self::getDataFromCurl($url_source, $query);

        /*echo '<pre>';
        var_dump($query);
        var_dump($response);
        echo '</pre>';
        die();*/

        $result = null;
        if(isset($response["error"])){
            $result = $response["error"];
        }elseif(isset($response["data"])){
            $result = $response["data"];
        }
        return $result;
    }

    private static function getDataFromCurl($url_source, $params)
    {
        $ch = curl_init($url_source);
        if( count($params) > 0 ) {
            $query = http_build_query($params);
            curl_setopt($ch, CURLOPT_URL, "$url_source?$query");
        } else {
            curl_setopt($ch, CURLOPT_URL, $url_source);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $response = curl_exec($ch);
        $response = json_decode($response, true);
        return $response;
    }


    public static function getObjDataFromApi($ip_server_cms,$func, $query){
        $url_source = $ip_server_cms.$func;

        $access_token = Yii::$app->params['ACCESS_TOKEN'];
        $user_token = \Yii::$app->session->get('user_token');
        $query['access_token'] = $access_token;
        $query['session_token'] = $user_token;
        $response = self::getDataObjFromCurl($url_source, $query);

        return $response;
    }

    private static function getDataObjFromCurl($url_source, $params)
    {
        $access_token = Yii::$app->params['ACCESS_TOKEN'];
        $user_token = \Yii::$app->session->get('user_token');

        $headers = array();
        $headers[] = 'access_token: '.$access_token;
        $headers[] = 'token: '.$user_token;

        $ch = curl_init($url_source);
        if( count($params) > 0 ) {
            $query = http_build_query($params);
            curl_setopt($ch, CURLOPT_URL, "$url_source?$query");
        } else {
            curl_setopt($ch, CURLOPT_URL, $url_source);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        return json_decode($response);
    }


    static  function pmAddData($posId,$tableName,$itemData,$dataId = NULL){

        $paramAddItem = array(
            'data_id' => $dataId,
            'pos_id_list' => $posId,
            'table_name' => $tableName,
            'data' => json_encode($itemData,JSON_UNESCAPED_UNICODE),
        );


        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS_MOBILE'];
        $name = 'manager/add_data';

        $addItem = self::getLalaApiByMethod($name,$apiPath,$paramAddItem,'POST');
        return $addItem;
    }

    static function getReportData($reportByTime,$arrPara = array()){
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS_MOBILE'].'report/';
        $data = self::getLalaApiByMethod($reportByTime,$apiPath,$arrPara,'POST');
        return $data;
    }


    static function pmUpdateData($dataId,$posId,$tableName,$itemData){

        $paramAddItem = array(
            'data_id' => $dataId,
            'pos_id_list' => $posId,
            'table_name' => $tableName,
            'data' => json_encode($itemData),
        );

        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS_MOBILE'];
        $name = 'manager/updated_data';

        $addItem = self::getLalaApiByMethod($name,$apiPath,$paramAddItem,'POST');

        Yii::error($name);
        Yii::error($paramAddItem);
        Yii::error($addItem);

        return $addItem;
    }



    public function getLalaApiByMethod($name,$apiPath,$param,$method = 'GET'){
        //Set Header $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];
        $access_token = Yii::$app->params['ACCESS_TOKEN_LALA'];
        $user_token = \Yii::$app->session->get('lala_user_token');
        $headers = array();
        $headers[] = 'access_token: '.$access_token;
        $headers[] = 'token: '.$user_token;

        // Set body parameter

        $api_request_url = $apiPath.$name;


        /*
  Set the Request Url (without Parameters) here
*/
        /*
          Which Request Method do I want to use ?
          DELETE, GET, POST or PUT
        */
        $method_name = $method;


        /*
          Let's set all Request Parameters (api_key, token, user_id, etc)
        */
        $api_request_parameters = $param;



        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        if ($method_name == 'DELETE')
        {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($api_request_parameters));
        }

        if ($method_name == 'GET')
        {
            $api_request_url .= '?' . http_build_query($api_request_parameters);

        }

        if ($method_name == 'POST')
        {
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($api_request_parameters));
        }

        if ($method_name == 'PUT')
        {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($api_request_parameters));
        }

        /*
          Here you can set the Response Content Type you prefer to get :
          application/json, application/xml, text/html, text/plain, etc
        */

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        /*echo '<pre>';
    var_dump($header);
    //var_dump($api_request_url);
    echo '</pre>';
    die();*/




        /*
          Let's give the Request Url to Curl
        */
        curl_setopt($ch, CURLOPT_URL, $api_request_url);

        /*
          Yes we want to get the Response Header
          (it will be mixed with the response body but we'll separate that after)
        */
        //curl_setopt($ch, CURLOPT_HEADER, TRUE);

        /*
          Allows Curl to connect to an API server through HTTPS
        */
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        /*
          Let's get the Response !
        */
        $api_response = curl_exec($ch);
//        var_dump($api_response);

        /*
          We need to get Curl infos for the header_size and the http_code
        */
        //$api_response_info = curl_getinfo($ch);

        /*
          Don't forget to close Curl
        */

        $info = curl_getinfo($ch);
        Yii::info('TIME Request API' . $api_request_url);
        Yii::info(@$info['total_time']);
        curl_close($ch);
        $data = json_decode($api_response);


        Yii::error($name);
        Yii::error($api_response);
        if($data != NULL){
            if(isset($data->error) && ($data->error->code === 1400)){
                self::actionLogout();
            }
        }

        return json_decode($api_response);
    }

    static  function actionLalaLogin($param,$apiPath,$type,$access_token){
        $vars = http_build_query($param);
        $url = $apiPath.$type;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$vars);  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = array();
        $headers[] = 'access_token: '.$access_token;


        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $server_output = curl_exec ($ch);
        Yii::info($server_output);

        curl_close ($ch);

        $data = json_decode($server_output);
        return $data;
    }


    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionCallApiByPost($param,$apiPath,$type,$access_token){
        $vars = http_build_query($param);
        $url = $apiPath.$type;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$vars);  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = array();
        $headers[] = 'access_token: '.$access_token;


        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $server_output = curl_exec ($ch);


        $data = json_decode($server_output);
        if($data != NULL){
            if(isset($data->error) && ($data->error->code === 1400)){
                self::actionLogout();
            }
        }

        curl_close ($ch);

        return json_decode($server_output);
    }

    static  function actionCheckPosPermision($posId,$redirectLink = null){
        $type = \Yii::$app->session->get('type_acc');
        if($type != 1){
            $searchPosModel = new DmposSearch();
            $ids = $searchPosModel->getIds();
            if(!in_array($posId,$ids)){
                //Yii::$app->getSession()->setFlash('error', 'Tài khoản của bạn không có quyền truy cập nhà hàng này!!');
                throw new ForbiddenHttpException("Tài khoản của bạn không có quyền truy cập nhà hàng này");
                //return $this->redirect('index.php?r='.$redirectLink,302);
            }
        }
    }


    // lam cho sdt co dang 84xxxxxxxxx
    /*public static fixPhoneNumbTo84($str) {
        if ($str == null || $str.equals("") || $str.length() < 3)
        return "";

        $x = "0123456789";
        for (int i = 0; i < str.length(); i++) {
            if (x.indexOf("" + str.charAt(i)) < 0) {
                str = str.replace("" + str.charAt(i), "");
                i--;
            }
        }

        if (str.startsWith("084")) {
            $str = $str.substring(1);
        } else if ($str.startsWith("0")) {
            $str = "84" + str.substring(1);
        } else if (!str.startsWith("84")) {
            $str = "84" + $str;
        }

        return trim($str);
    }

    public static String fixPhoneNumb(String str) {
        String fixPhoneNumbTo84 = fixPhoneNumbTo84(str);
      if (fixPhoneNumbTo84.length() < 3) {
          return "";
      }

      return fixPhoneNumbTo84.substring(2);
     }

     public static String fixPhoneNumbTo0(String str) {
        String fixPhoneNumb = fixPhoneNumb(str);

      return "0" + fixPhoneNumb;
     }*/

}
