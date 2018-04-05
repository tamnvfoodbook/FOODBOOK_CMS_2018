<?php

namespace backend\models;

use backend\controllers\ApiController;
use backend\controllers\ExtendController;
use backend\controllers\UsermanagerController;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Callcenterlog;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

/**
 * CallcenterlogSearch represents the model behind the search form about `backend\models\Callcenterlog`.
 */
class CallcenterlogSearch extends Callcenterlog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['_id', 'cid_name', 'source', 'destination', 'recording', 'start', 'tta', 'duration', 'pdd', 'mos', 'status'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */

    public function getData($params,$all,$posParentModel){

        $arrTime  = array();
        if(isset($params['CallcenterlogSearch']['dateTime'])){
            $dateTime = $params['CallcenterlogSearch']['dateTime'];
            $arrTime = explode(' - ',$dateTime);
            $startDate = implode("-", array_reverse(explode("/", $arrTime[0])));
            $endDate = implode("-", array_reverse(explode("/", $arrTime[1])));
        }else{
            $startDate = date('Y-m-d');
            $endDate = date('Y-m-d');
            //$dateTime = null;
        }

        if($all){
            $hangup_case = 'NORMAL_CLEARING';
        }else{
            $hangup_case = 'NORMAL_TEMPORARY_FAILURE;USER_BUSY;NO_ANSWER';
        }


        $callcenter_ext = \Yii::$app->session->get('callcenter_ext');
        $domain = '';
        if($callcenter_ext){
            $extendArr = explode('@',$callcenter_ext);
            $domain = $extendArr[1];
        }

        if($posParentModel->WS_SIP_SERVER == 'wss://webrtc.vht.com.vn:8080'){
            $ch = curl_init('https://vcall2.vht.com.vn/cdrs/json');
            $data = array('submission' => array(
            'api_key' => '0b98853b', // cap key ben VHT
            'api_secret' => 'c7c69f44',
                "domain_name" => $domain,
                'direction' => 'inbound',
                'hangup_cause' => $hangup_case,
                'date_range' => [
                    'from' => @$startDate.' 00:00',
                    'to' => @$endDate. ' 23:59',
                ]
            ));
        }else{
            $ch = curl_init('https://api.ccall.vn/cdrs/json');
            $data = array('submission' => array(
//            'api_key' => '0b98853b', // cap key ben VHT
//            'api_secret' => 'c7c69f44',

                'api_key' => $posParentModel->CC_API_KEY,
                'api_secret' => $posParentModel->CC_API_SECRET,

                "domain_name" => $domain,
                'direction' => 'inbound',
                'hangup_cause' => $hangup_case,
                'date_range' => [
                    'from' => @$startDate.' 00:00',
                    'to' => @$endDate. ' 23:59',
                ]
            ));
        }

        $data_string = json_encode($data);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );
        $result = curl_exec($ch);
//        echo '<pre>';
//        var_dump($result);
//        echo '</pre>';
//        die();


        if($result != null){
            $dataCallcenter = array();
            $json = json_decode($result, true);

            foreach((array)@$json['response'] as $value){
                $dataCallcenter[] = $value['Cdr'];
            }
            $dataProvider = new ArrayDataProvider([
                'allModels' => $dataCallcenter,
            ]);
        }else{
            $dataProvider = new ArrayDataProvider([
                'allModels' => null,
            ]);
        }
        return $dataProvider;
    }

    public function getDataccmonitor($params,$all,$posParentModel){


        // Khoảng thời gian để lấy record
        $arrTime  = array();
        if(isset($params['CallcenterlogSearch']['dateTime'])){
            $dateTime = $params['CallcenterlogSearch']['dateTime'];
            $arrTime = explode(' - ',$dateTime);
            $startDate = implode("-", array_reverse(explode("/", $arrTime[0])));
            $endDate = implode("-", array_reverse(explode("/", $arrTime[1])));
        }else{
            $startDate = date('Y-m-d');
            $endDate = date('Y-m-d');
        }

//        if($all){
//            $hangup_case = 'NORMAL_CLEARING';
//        }else{
//            $hangup_case = 'NORMAL_TEMPORARY_FAILURE;USER_BUSY;NO_ANSWER';
        $hangup_case = 'NORMAL_TEMPORARY_FAILURE;USER_BUSY;NO_ANSWER;NORMAL_CLEARING';  // Lấy các giá trinh Hangup case mà mình muốn
//        }

        // Lấy Domain và extend
        $callcenter_ext = \Yii::$app->session->get('callcenter_ext');
        $domain = '';
        if($callcenter_ext){
            $extendArr = explode('@',$callcenter_ext);
            $domain = $extendArr[1];
        }

        // Khai báo cấu trúc data để gọi API

        if($posParentModel->WS_SIP_SERVER == 'wss://webrtc.vht.com.vn:8080'){
            $ch = curl_init('https://vcall2.vht.com.vn/cdrs/json');
            $data = array('submission' => array(
            'api_key' => '0b98853b', // cap key ben VHT
            'api_secret' => 'c7c69f44',
                "domain_name" => $domain,
                'direction' => 'inbound',
                'hangup_cause' => $hangup_case,
                'date_range' => [
                    'from' => @$startDate.' 00:00',
                    'to' => @$endDate. ' 23:59',
                ]
            ));
        }else{

//            $ch = curl_init('https://api.ccall.vn/cdrs/json');
            $ch = curl_init('https://vcall2.vht.com.vn/cdrs/json');
            $data = array('submission' => array(
            /*'api_key' => 'c239ee6b', // cap key ben VHT
            'api_secret' => '5d62599a',*/

                'api_key' => $posParentModel->CC_API_KEY,
                'api_secret' => $posParentModel->CC_API_SECRET,

                "domain_name" => 'minhnhat.ipos.com.vn',
                'direction' => 'inbound',
                'hangup_cause' => $hangup_case,
                'date_range' => [
                    'from' => @$startDate.' 00:00',
                    'to' => @$endDate. ' 23:59',
                ]
            ));
        }

        $data_string = json_encode($data);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );
        $result = curl_exec($ch);  // Lấy được dữ liệu trả về từ service dữ liệu trả về là list các bản ghi

        /*echo '<pre>';
        var_dump($result);
        echo '</pre>';*/
//        die();

        // Xử lý định dạng cấu trúc dữ liệu theo ý mình mong muốn
        if($result != null){
            $dataCallcenter = array();
            $json = json_decode($result, true);

            if(isset($json['response'])){
                $memberModel = new DmmembershipSearch();
                $member = $memberModel->seachAllPhone();
                $memberMap = ArrayHelper::map($member,'ID','MEMBER_NAME');
                foreach((array)@$json['response'] as $value){
                    $phone = ExtendController::format_number_callcenter_vht_with_prenumber($value['Cdr']['cid_name']);

                    $key = $value['Cdr']['cid_name'].'-'.$value['Cdr']['start'];
                    $dataCallcenter[$key]['cid_name'] =  $value['Cdr']['cid_name'];
                    $dataCallcenter[$key]['start'] =  $value['Cdr']['start'];
                    $dataCallcenter[$key]['status'] =  $value['Cdr']['status'];
                    $dataCallcenter[$key]['destination'] =  $value['Cdr']['destination'];

                    if(isset($memberMap[$phone])){
                        $dataCallcenter[$key]['name'] =  $memberMap[$phone];
                    }else{
                        $dataCallcenter[$key]['name'] =  'Khách mới';
                    }

                    //$dataCallcenter[] = $value['Cdr'];

                }
            }

            $dataProvider = new ArrayDataProvider([
                'allModels' => $dataCallcenter,
            ]);
        }else{
            $dataProvider = new ArrayDataProvider([
                'allModels' => null,
            ]);
        }

//        echo '<pre>';
//        var_dump($result);
//        //var_dump($dataProvider);
//        echo '</pre>';
//        die();
        return $dataProvider;
    }



    public function search($params)
    {
        $query = Callcenterlog::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['like', '_id', $this->_id])
            ->andFilterWhere(['like', 'cid_name', $this->cid_name])
            ->andFilterWhere(['like', 'source', $this->source])
            ->andFilterWhere(['like', 'destination', $this->destination])
            ->andFilterWhere(['like', 'recording', $this->recording])
            ->andFilterWhere(['like', 'start', $this->start])
            ->andFilterWhere(['like', 'tta', $this->tta])
            ->andFilterWhere(['like', 'duration', $this->duration])
            ->andFilterWhere(['like', 'pdd', $this->pdd])
            ->andFilterWhere(['like', 'mos', $this->mos])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
