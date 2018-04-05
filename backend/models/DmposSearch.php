<?php


namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dmpos;

/**
 * DmposSearch represents the model behind the search form about `backend\models\Dmpos`.
 */
class DmposSearch extends Dmpos
{
    /**
     * @inheritdoc
     */

    public $city;
    public $district;
    public $partner;
    public $giftpoint;


    public function rules()
    {
        return [
            [['ID', 'ACTIVE', 'DISTRICT_ID', 'CITY_ID', 'ESTIMATE_PRICE_MAX', 'ESTIMATE_PRICE', 'IS_CAR_PARKING', 'IS_VISA', 'IS_STICKY', 'SORT', 'IS_ORDER', 'IS_BOOKING', 'IS_ORDER_ONLINE', 'WORKSTATION_ID', 'MIN_ORDER_PRICE', 'IS_HOT', 'POS_MASTER_ID', 'IS_ACTIVE_SHAREFB_EVENT', 'SHAREFB_EVENT_RATE', 'IS_SHOW_ITEM_TYPE', 'IS_AHAMOVE_ACTIVE', 'ORDER_NUMBER_SERVER', 'ORDER_TIME_AVERAGE', 'ORDER_TIME_MIN', 'ORDER_TIME_MAX'], 'integer'],
            [['DEVICE_ID','VAT_TAX_RATE', 'POS_NAME', 'POS_PARENT', 'POS_ADDRESS', 'DESCRIPTION', 'OPEN_TIME', 'PHONE_NUMBER', 'WIFI_PASSWORD', 'IMAGE_PATH', 'IMAGE_PATH_THUMB', 'WIFI_SERVICE_PATH', 'LAST_READY', 'WEBSITE_URL', 'MORE_INFO', 'WS_ORDER_ONLINE', 'PHONE_MANAGER'], 'safe'],
            [['district','city','partner','giftpoint','CREATED_AT','TIME_START_FB','TIME_END_FB','TIME_START','TIME_END','IS_POS_MOBILE'], 'safe'],
            [['POS_LONGITUDE', 'POS_LATITUDE', 'POS_RADIUS_DETAL', 'SHIP_PRICE'], 'number'],
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
    public function search($params)
    {
        $query = Dmpos::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith('city');

        $dataProvider->sort->attributes['city'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['DM_CITY.CITY_NAME' => SORT_ASC],
            'desc' => ['DM_CITY.CITY_NAME' => SORT_DESC],
        ];

        $query->joinWith('district');

        $dataProvider->sort->attributes['district'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['DM_DISTRICT.DISTRICT_NAME' => SORT_ASC],
            'desc' => ['DM_DISTRICT.DISTRICT_NAME' => SORT_DESC],
        ];

        $query->joinWith('partner');
        $dataProvider->sort->attributes['partner'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['DM_POS_PARENT.SOURCE' => SORT_ASC],
            'desc' => ['DM_POS_PARENT.SOURCE' => SORT_DESC],
        ];


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
//        echo '<pre>';
//        var_dump($this->partner);
//        echo '</pre>';

        $query->andFilterWhere([
            'DM_POS.ID' => $this->ID,
            'DM_POS.ACTIVE' => $this->ACTIVE,
            'DM_POS_PARENT.SOURCE' => $this->partner,
            'POS_LONGITUDE' => $this->POS_LONGITUDE,
            'POS_LATITUDE' => $this->POS_LATITUDE,
            'DISTRICT_ID' => $this->DISTRICT_ID,
            //'CITY_ID' => $this->CITY_ID,
            'ESTIMATE_PRICE_MAX' => $this->ESTIMATE_PRICE_MAX,
            'ESTIMATE_PRICE' => $this->ESTIMATE_PRICE,
            'IS_CAR_PARKING' => $this->IS_CAR_PARKING,
            'IS_VISA' => $this->IS_VISA,
            'IS_STICKY' => $this->IS_STICKY,
            'SORT' => $this->SORT,
            'LAST_READY' => $this->LAST_READY,
            'IS_ORDER' => $this->IS_ORDER,
            'IS_BOOKING' => $this->IS_BOOKING,
            'IS_ORDER_ONLINE' => $this->IS_ORDER_ONLINE,
            'POS_RADIUS_DETAL' => $this->POS_RADIUS_DETAL,
            'SHIP_PRICE' => $this->SHIP_PRICE,
            'WORKSTATION_ID' => $this->WORKSTATION_ID,
            'MIN_ORDER_PRICE' => $this->MIN_ORDER_PRICE,
            'IS_HOT' => $this->IS_HOT,
            'POS_MASTER_ID' => $this->POS_MASTER_ID,
            'IS_ACTIVE_SHAREFB_EVENT' => $this->IS_ACTIVE_SHAREFB_EVENT,
            'SHAREFB_EVENT_RATE' => $this->SHAREFB_EVENT_RATE,
            'IS_SHOW_ITEM_TYPE' => $this->IS_SHOW_ITEM_TYPE,
            'IS_AHAMOVE_ACTIVE' => $this->IS_AHAMOVE_ACTIVE,
            'ORDER_NUMBER_SERVER' => $this->ORDER_NUMBER_SERVER,
            'ORDER_TIME_AVERAGE' => $this->ORDER_TIME_AVERAGE,
            'ORDER_TIME_MIN' => $this->ORDER_TIME_MIN,
            'ORDER_TIME_MAX' => $this->ORDER_TIME_MAX,
            'IS_POS_MOBILE' => $this->IS_POS_MOBILE,
        ]);

        $query->andFilterWhere(['like', 'DEVICE_ID', $this->DEVICE_ID])
            ->andFilterWhere(['like', 'POS_NAME', $this->POS_NAME])
            ->andFilterWhere(['like', 'POS_PARENT', $this->POS_PARENT])
            ->andFilterWhere(['like', 'POS_ADDRESS', $this->POS_ADDRESS])
            ->andFilterWhere(['like', 'DESCRIPTION', $this->DESCRIPTION])
            ->andFilterWhere(['like', 'OPEN_TIME', $this->OPEN_TIME])
            ->andFilterWhere(['like', 'PHONE_NUMBER', $this->PHONE_NUMBER])
            ->andFilterWhere(['like', 'WIFI_PASSWORD', $this->WIFI_PASSWORD])
            ->andFilterWhere(['like', 'IMAGE_PATH', $this->IMAGE_PATH])
            ->andFilterWhere(['like', 'IMAGE_PATH_THUMB', $this->IMAGE_PATH_THUMB])
            ->andFilterWhere(['like', 'WIFI_SERVICE_PATH', $this->WIFI_SERVICE_PATH])
            ->andFilterWhere(['like', 'WEBSITE_URL', $this->WEBSITE_URL])
            ->andFilterWhere(['like', 'MORE_INFO', $this->MORE_INFO])
            ->andFilterWhere(['like', 'WS_ORDER_ONLINE', $this->WS_ORDER_ONLINE])
            ->andFilterWhere(['like', 'PHONE_MANAGER', $this->PHONE_MANAGER])
            ->andFilterWhere(['like', 'DM_POS.CITY_ID', $this->CITY_ID])
            //->andFilterWhere(['like', 'DM_DISTRICT.ID', $this->district])
            ->orderBy(['ID' => SORT_DESC]);

        if ( ! is_null($this->CREATED_AT) && strpos($this->CREATED_AT, ' - ') !== false ) {
            list($start_date, $end_date) = explode(' - ', $this->CREATED_AT);
            $query->andFilterWhere(['between', 'CREATED_AT', $start_date, $end_date]);
            //$this->created_at = null;
        }

        return $dataProvider;
    }
    public function searchMonitor($params,$type = NULL)
    {
        $query = Dmpos::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith('city');

        $dataProvider->sort->attributes['city'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['DM_CITY.CITY_NAME' => SORT_ASC],
            'desc' => ['DM_CITY.CITY_NAME' => SORT_DESC],
        ];


        $query->joinWith('partner');
        $dataProvider->sort->attributes['partner'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['DM_POS_PARENT.SOURCE' => SORT_ASC],
            'desc' => ['DM_POS_PARENT.SOURCE' => SORT_DESC],
        ];


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
//        echo '<pre>';
//        var_dump($this->partner);
//        echo '</pre>';

        $query->andFilterWhere([
            'DM_POS.ID' => $this->ID,
            'DM_POS_PARENT.SOURCE' => $this->partner,
        ]);

//        $today = date('Y-m-d');
//        $before2day = date("Y-m-d", strtotime("-2 day"));

        $query
            ->andFilterWhere(['=', 'POS_PARENT', $this->POS_PARENT])
            ->andFilterWhere(['=', 'DM_POS.CITY_ID', $this->CITY_ID])
        //    ->andFilterWhere(['between', 'DM_POS.CREATED_AT', $before2day, $today])
        ;



        if ( ! is_null($this->CREATED_AT) && strpos($this->CREATED_AT, ' - ') !== false ) {
            list($start_date, $end_date) = explode(' - ', $this->CREATED_AT);
            $query->andFilterWhere(['between', 'DM_POS.CREATED_AT', $start_date, $end_date]);
            //$this->created_at = null;
        }
        if ( ! is_null($this->TIME_START_FB) && strpos($this->TIME_START_FB, ' - ') !== false ) {
            list($start_date, $end_date) = explode(' - ', $this->TIME_START_FB);
            $query->andFilterWhere(['between', 'DM_POS.TIME_START_FB', $start_date, $end_date]);
            //$this->created_at = null;
        }
        if ( ! is_null($this->TIME_END_FB) && strpos($this->TIME_END_FB, ' - ') !== false ) {
            list($start_date, $end_date) = explode(' - ', $this->TIME_END_FB);
            $query->andFilterWhere(['between', 'DM_POS.TIME_END_FB', $start_date, $end_date]);
            //$this->created_at = null;
        }
        if ( ! is_null($this->TIME_START) && strpos($this->TIME_START, ' - ') !== false ) {
            list($start_date, $end_date) = explode(' - ', $this->TIME_START);
            $query->andFilterWhere(['between', 'DM_POS.TIME_START', $start_date, $end_date]);
            //$this->created_at = null;
        }
        if ( ! is_null($this->TIME_END) && strpos($this->TIME_END, ' - ') !== false ) {
            list($start_date, $end_date) = explode(' - ', $this->TIME_END);
            $query->andFilterWhere(['between', 'DM_POS.TIME_END', $start_date, $end_date]);
            //$this->created_at = null;
        }

        if($this->ACTIVE != null){
            $query->andFilterWhere([
                'DM_POS.ACTIVE' => $this->ACTIVE,
            ])->orderBy(['TIME_END' => SORT_DESC]);
        }else{
            if($type){
                $query->andFilterWhere([
                    'DM_POS_PARENT.POS_TYPE' => [1],
                ])->orderBy(['TIME_END_FB' => SORT_DESC]);
            }else{
                $query->andFilterWhere([
                    'DM_POS_PARENT.POS_TYPE' => [2],
                ])->orderBy(['TIME_END' => SORT_ASC]);
            }

        }

        return $dataProvider;
    }

    public function searchReady($params)
    {
        $query = Dmpos::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith('partner');
        $dataProvider->sort->attributes['partner'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['DM_POS_PARENT.IS_GIFT_POINT' => SORT_ASC],
            'desc' => ['DM_POS_PARENT.IS_GIFT_POINT' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'DM_POS.ID' => $this->ID,
//            'DM_POS.ACTIVE' => 1,
            'DM_POS_PARENT.IS_GIFT_POINT' => $this->partner,
            'POS_LONGITUDE' => $this->POS_LONGITUDE,
            'POS_LATITUDE' => $this->POS_LATITUDE,
            'DISTRICT_ID' => $this->DISTRICT_ID,
            //'CITY_ID' => $this->CITY_ID,
            'ESTIMATE_PRICE_MAX' => $this->ESTIMATE_PRICE_MAX,
            'ESTIMATE_PRICE' => $this->ESTIMATE_PRICE,
            'IS_CAR_PARKING' => $this->IS_CAR_PARKING,
            'IS_VISA' => $this->IS_VISA,
            'IS_STICKY' => $this->IS_STICKY,
            'SORT' => $this->SORT,
            'LAST_READY' => $this->LAST_READY,
            'IS_ORDER' => $this->IS_ORDER,
            'IS_BOOKING' => $this->IS_BOOKING,
            'IS_ORDER_ONLINE' => $this->IS_ORDER_ONLINE,
            'POS_RADIUS_DETAL' => $this->POS_RADIUS_DETAL,
            'SHIP_PRICE' => $this->SHIP_PRICE,
            'WORKSTATION_ID' => $this->WORKSTATION_ID,
            'MIN_ORDER_PRICE' => $this->MIN_ORDER_PRICE,
            'IS_HOT' => $this->IS_HOT,
            'POS_MASTER_ID' => $this->POS_MASTER_ID,
            'IS_ACTIVE_SHAREFB_EVENT' => $this->IS_ACTIVE_SHAREFB_EVENT,
            'SHAREFB_EVENT_RATE' => $this->SHAREFB_EVENT_RATE,
            'IS_SHOW_ITEM_TYPE' => $this->IS_SHOW_ITEM_TYPE,
            'IS_AHAMOVE_ACTIVE' => $this->IS_AHAMOVE_ACTIVE,
            'ORDER_NUMBER_SERVER' => $this->ORDER_NUMBER_SERVER,
            'ORDER_TIME_AVERAGE' => $this->ORDER_TIME_AVERAGE,
            'ORDER_TIME_MIN' => $this->ORDER_TIME_MIN,
            'ORDER_TIME_MAX' => $this->ORDER_TIME_MAX,
            'IS_POS_MOBILE' => $this->IS_POS_MOBILE,
        ]);

        $query->andFilterWhere(['like', 'DEVICE_ID', $this->DEVICE_ID])
            ->andFilterWhere(['like', 'POS_NAME', $this->POS_NAME])
            ->andFilterWhere(['like', 'POS_PARENT', $this->POS_PARENT])
            ->andFilterWhere(['like', 'POS_ADDRESS', $this->POS_ADDRESS])
            ->andFilterWhere(['like', 'DESCRIPTION', $this->DESCRIPTION])
            ->andFilterWhere(['like', 'OPEN_TIME', $this->OPEN_TIME])
            ->andFilterWhere(['like', 'PHONE_NUMBER', $this->PHONE_NUMBER])
            ->andFilterWhere(['like', 'WIFI_PASSWORD', $this->WIFI_PASSWORD])
            ->andFilterWhere(['like', 'IMAGE_PATH', $this->IMAGE_PATH])
            ->andFilterWhere(['like', 'IMAGE_PATH_THUMB', $this->IMAGE_PATH_THUMB])
            ->andFilterWhere(['like', 'WIFI_SERVICE_PATH', $this->WIFI_SERVICE_PATH])
            ->andFilterWhere(['like', 'WEBSITE_URL', $this->WEBSITE_URL])
            ->andFilterWhere(['like', 'MORE_INFO', $this->MORE_INFO])
            ->andFilterWhere(['like', 'WS_ORDER_ONLINE', $this->WS_ORDER_ONLINE])
            ->andFilterWhere(['like', 'PHONE_MANAGER', $this->PHONE_MANAGER])
            ->andFilterWhere(['like', 'DM_POS.CITY_ID', $this->CITY_ID])
            //->andFilterWhere(['like', 'DM_DISTRICT.ID', $this->district])
            ->orderBy(['LAST_READY' => SORT_ASC]);

        return $dataProvider;
    }

    public function searchById($id){
        $pos = Dmpos::find()
            ->select(['ID','POS_LONGITUDE','POS_LATITUDE','IS_CALL_CENTER','IS_POS_MOBILE','IS_AHAMOVE_ACTIVE','POS_NAME','POS_PARENT'])
            ->where(['id'=>$id])
            ->asArray()
            ->one();
        return $pos;
    }

    public function searchAllPosById($id){
        $pos = Dmpos::find()
            ->select(['ID','POS_NAME','POS_LONGITUDE','POS_LATITUDE','PHONE_NUMBER'])
            ->where(['id'=>$id])
            ->asArray()
            ->all();
        return $pos;
    }
    public function searchAllPosByListId($idList){
        $ids = array_map('intval', explode(',', $idList));
        $pos = Dmpos::find()
            ->select(['ID','POS_NAME','POS_LONGITUDE','POS_LATITUDE'])
            ->where(['id'=>$ids])
            ->asArray()
            ->all();

        return $pos;
    }
    public function searchPosNameListByListId($idList){
        $ids = array_map('intval', explode(',', $idList));
        $pos = Dmpos::find()
            ->select(['ID','POS_NAME','POS_LONGITUDE','POS_LATITUDE'])
            ->where(['id'=>$ids])
            ->asArray()
            ->all();
        $listPos = '';
        foreach((array)$pos as $value){
            if($listPos){
                $listPos = $value['POS_NAME'] . ', ' . $listPos;
            }else{
                $listPos = $value['POS_NAME'];
            }
        }
        return $listPos;
    }
    public function searchPosByListId($idList){
        $ids = array_map('intval', explode(',', $idList));
        $pos = Dmpos::find()
            ->select(['ID','POS_NAME','POS_LONGITUDE','POS_LATITUDE'])
            ->where(['id'=>$ids])
            ->asArray()
            ->all();
        return $pos;
    }

    public function searchAllPosByPosParent($posParent){
        $pos = Dmpos::find()
            ->select(['ID','POS_NAME','POS_LONGITUDE','POS_LATITUDE','POS_PARENT'])
            ->where(['POS_PARENT'=>$posParent])
            ->andWhere(['ACTIVE'=> [1,2]])
            ->asArray()
            ->all();
        return $pos;
    }
    public function searchAllActiveAndDeactiveByPosParent($posParent){
        $pos = Dmpos::find()
            ->select(['ID','POS_NAME','POS_LONGITUDE','POS_LATITUDE','POS_PARENT'])
            ->where(['POS_PARENT'=>$posParent])
            ->asArray()
            ->all();
        return $pos;
    }

    public function countAllPosByPosParent($posParent){
        $pos = Dmpos::find()
            ->where(['POS_PARENT'=>$posParent])
            ->count();
        return $pos;
    }
    public function searchAllLalaPos(){
        $pos = Dmpos::find()
            ->where(['IS_POS_MOBILE'=> 2])
            ->asArray()
            ->all();
        return $pos;
    }

    public function searchAllPos(){
        $type = \Yii::$app->session->get('type_acc');
        if($type != 1){
            $ids = $this->getIds();
            $pos = Dmpos::find()
                ->select(['ID','POS_NAME','POS_LONGITUDE','POS_LATITUDE','CITY_ID','POS_PARENT','IS_ORDER_LATER'])
                ->where(['ID' => $ids])
                ->asArray()
                ->all();
        }else{
            $pos = Dmpos::find()
                ->select(['ID','POS_NAME','POS_LONGITUDE','POS_LATITUDE','CITY_ID','POS_PARENT','IS_ORDER_LATER'])
                ->asArray()
                ->all();
        }
        return $pos;
    }
    public function searchAllPosForCampagin(){
        $pos_parent = \Yii::$app->session->get('pos_parent');
        $pos = Dmpos::find()
            ->select(['ID','POS_NAME','POS_LONGITUDE','POS_LATITUDE','CITY_ID','POS_PARENT','IS_ORDER_LATER','ACTIVE'])
            ->where(['POS_PARENT' => $pos_parent])
            ->asArray()
            ->all();
        return $pos;
    }

    public function searchAllPosActive(){
        $type = \Yii::$app->session->get('type_acc');
        if($type != 1){
            $ids = $this->getIds();
            $pos = Dmpos::find()
                ->select(['ID','POS_NAME','POS_LONGITUDE','POS_LATITUDE','CITY_ID','POS_PARENT','IS_ORDER_LATER'])
                ->where(['ID' => $ids])
                ->andWhere(['ACTIVE' => 1])
                ->asArray()
                ->all();
        }else{
            $pos = Dmpos::find()
                ->select(['ID','POS_NAME','POS_LONGITUDE','POS_LATITUDE','CITY_ID','POS_PARENT','IS_ORDER_LATER'])
                ->where(['ACTIVE' => 1])
                ->asArray()
                ->all();
        }

        return $pos;
    }


    public function searchAllItemSameMasterId($posId){
        $pos = Dmpos::find()
            ->where(['ID' => $posId])
            ->one();

        $data = Dmpos::find()
            ->with(['city'])
            ->select(['DM_POS.ID','POS_NAME','CITY_ID'])
            ->where(['POS_MASTER_ID' => $pos->POS_MASTER_ID])
            ->andWhere(['NOT LIKE','DM_POS.ID',$posId])
            ->asArray()
            ->all();

//        echo '<pre>';
//        var_dump($data);
//        echo '</pre>';
//        die();
        return $data;
    }


    public function searchPosActive(){
        $pos = Dmpos::find()
            ->where(['ACTIVE'=> 1])
            ->select(['ID','POS_NAME'])
            ->asArray()
            ->all();
        return $pos;
    }

    public function getIds(){
        $typeAcc = \Yii::$app->session->get('type_acc');
        $posParent = \Yii::$app->session->get('pos_parent');
        $ids = array();
        if($typeAcc == 3){
            $posIdList = \Yii::$app->session->get('pos_id_list');
            if($posIdList){
                $ids = array_map('intval', explode(',',$posIdList));
            }
        }else if($typeAcc == 2){
            $pos = $this->searchAllPosByPosParent($posParent);
            foreach((array)$pos as $value){
                $ids[] = (int)$value['ID'];
            }
        }elseif($typeAcc == 1){
            $pos = $this->searchAllPos();
            foreach((array)$pos as $value){
                $ids[] = (int)$value['ID'];
            }
        }
        return $ids;
    }
}
