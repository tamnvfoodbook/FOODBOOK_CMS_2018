<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dmpos;
use backend\models\Dmitem;

/**
 * DmpositemSearch represents the model behind the search form about `backend\models\Dmpos`.
 */
class DmpositemSearch extends Dmpos
{
    /**
     * @inheritdoc
     */
    // Tao bien de sau nay dung de query
    public $city;
    public $pos;
    public $itemTypeMaster;

    public function rules()
    {
        return [
            [['ID', 'ACTIVE', 'DISTRICT_ID', 'CITY_ID', 'ESTIMATE_PRICE_MAX', 'ESTIMATE_PRICE', 'IS_CAR_PARKING', 'IS_VISA', 'IS_STICKY', 'SORT', 'IS_ORDER', 'IS_BOOKING', 'IS_ORDER_ONLINE', 'WORKSTATION_ID', 'MIN_ORDER_PRICE', 'IS_HOT', 'POS_MASTER_ID', 'IS_ACTIVE_SHAREFB_EVENT', 'SHAREFB_EVENT_RATE', 'IS_SHOW_ITEM_TYPE', 'IS_AHAMOVE_ACTIVE', 'ORDER_NUMBER_SERVER', 'ORDER_TIME_AVERAGE', 'ORDER_TIME_MIN', 'ORDER_TIME_MAX'], 'integer'],
            [['DEVICE_ID', 'POS_NAME', 'POS_PARENT', 'POS_ADDRESS', 'DESCRIPTION', 'OPEN_TIME', 'PHONE_NUMBER', 'WIFI_PASSWORD', 'IMAGE_PATH', 'IMAGE_PATH_THUMB', 'WIFI_SERVICE_PATH', 'LAST_READY', 'WEBSITE_URL', 'MORE_INFO', 'WS_ORDER_ONLINE', 'PHONE_MANAGER'], 'safe'],
            [['POS_LONGITUDE', 'POS_LATITUDE', 'POS_RADIUS_DETAL', 'SHIP_PRICE'], 'number'],
            [['city','itemTypeMaster'], 'safe'],
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
    public function search($params,$POS_ID_LIST = null,$type)
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


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // Lọc, nếu như không có pos_Id_list thì sẽ mặc định đang là tài khoản Foodbook, sẽ hiển thị tất cả các nhà hàng
        // Còn nếu là tài khoản thường, nếu như không lọc thì
//        echo '<pre>';
//        var_dump($POS_ID_LIST);
//        echo '</pre>';
//        die();

        if($type != 1){
            if($this->ID){
                $query->andFilterWhere([
                    'DM_POS.ID' => $this->ID,
                ]);
            }else{
//        echo '<pre>';
//        var_dump($POS_ID_LIST);
//        echo '</pre>';
//                die();
        //die();
                $query->where([
                    'DM_POS.ID' => $POS_ID_LIST,
                ]);
            }
        }else{
            $query->andFilterWhere([
                'DM_POS.ID' => $this->ID,
            ]);
        }


        $query->andFilterWhere([
            //'ID' => $this->ID,
            'ACTIVE' => $this->ACTIVE,
            'POS_LONGITUDE' => $this->POS_LONGITUDE,
            'POS_LATITUDE' => $this->POS_LATITUDE,
            'DISTRICT_ID' => $this->DISTRICT_ID,
            'CITY_ID' => $this->CITY_ID,
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
        ]);

        $query
            ->andFilterWhere(['like', 'DEVICE_ID', $this->DEVICE_ID])
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
            ->andFilterWhere(['=', 'DM_CITY.CITY_NAME', $this->city])
            ->orderBy(['LAST_READY' => SORT_ASC])
        ;

        return $dataProvider;
    }

    public function searchLala($params)
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


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // Lọc, nếu như không có pos_Id_list thì sẽ mặc định đang là tài khoản Foodbook, sẽ hiển thị tất cả các nhà hàng
        // Còn nếu là tài khoản thường, nếu như không lọc thì
//        echo '<pre>';
//        var_dump($POS_ID_LIST);
//        echo '</pre>';
//        die();

        $query->andFilterWhere([
            'DM_POS.ID' => $this->ID,
        ]);


        $query->andFilterWhere([
            //'ID' => $this->ID,
            'ACTIVE' => $this->ACTIVE,
            'IS_POS_MOBILE' => 2,
            'POS_LONGITUDE' => $this->POS_LONGITUDE,
            'POS_LATITUDE' => $this->POS_LATITUDE,
            'DISTRICT_ID' => $this->DISTRICT_ID,
            'CITY_ID' => $this->CITY_ID,
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
        ]);

        $query
            ->andFilterWhere(['like', 'DEVICE_ID', $this->DEVICE_ID])
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
            ->andFilterWhere(['=', 'DM_CITY.CITY_NAME', $this->city])
            ->orderBy(['LAST_READY' => SORT_ASC])
        ;

        return $dataProvider;
    }

    public function searchItem($id)
    {

        $query = Dmitem::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith('pos');


        $query->andFilterWhere([
            'ID' => $this->ID,
            'POS_ID' => $this->POS_ID,
            'ITEM_MASTER_ID' => $this->ITEM_MASTER_ID,
            'ITEM_TYPE_MASTER_ID' => $this->ITEM_TYPE_MASTER_ID,
            'OTS_PRICE' => $this->OTS_PRICE,
            'TA_PRICE' => $this->TA_PRICE,
            'POINT' => $this->POINT,
            'IS_GIFT' => $this->IS_GIFT,
            'SHOW_ON_WEB' => $this->SHOW_ON_WEB,
            'SHOW_PRICE_ON_WEB' => $this->SHOW_PRICE_ON_WEB,
            'DM_ITEM.ACTIVE' => $this->ACTIVE,
            'SPECIAL_TYPE' => $this->SPECIAL_TYPE,
            'LAST_UPDATED' => $this->LAST_UPDATED,
            'ALLOW_TAKE_AWAY' => $this->ALLOW_TAKE_AWAY,
            'IS_EAT_WITH' => $this->IS_EAT_WITH,
            'REQUIRE_EAT_WITH' => $this->REQUIRE_EAT_WITH,
            'IS_FEATURED' => $this->IS_FEATURED,
        ]);

        $query
            ->andFilterWhere(['like', 'ITEM_ID', $this->ITEM_ID])
            ->andFilterWhere(['like', 'ITEM_TYPE_ID', $this->ITEM_TYPE_ID])
            ->andFilterWhere(['like', 'ITEM_NAME', $this->ITEM_NAME])
            ->andFilterWhere(['like', 'ITEM_IMAGE_PATH_THUMB', $this->ITEM_IMAGE_PATH_THUMB])
            ->andFilterWhere(['like', 'ITEM_IMAGE_PATH', $this->ITEM_IMAGE_PATH])
            ->andFilterWhere(['like', 'DESCRIPTION', $this->DESCRIPTION])
            ->andFilterWhere(['like', 'FB_IMAGE_PATH', $this->FB_IMAGE_PATH])
            ->andFilterWhere(['like', 'FB_IMAGE_PATH_THUMB', $this->FB_IMAGE_PATH_THUMB])
            ->andFilterWhere(['like', 'ITEM_ID_EAT_WITH', $this->ITEM_ID_EAT_WITH])
            ->andFilterWhere(['like', 'DM_POS.POS_NAME', $this->pos]);

        return $dataProvider;
    }

}
