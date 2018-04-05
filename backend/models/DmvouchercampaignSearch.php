<?php

namespace backend\models;

use backend\controllers\ApiController;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dmvouchercampaign;

/**
 * DmvouchercampaignSearch represents the model behind the search form about `backend\models\Dmvouchercampaign`.
 */
class DmvouchercampaignSearch extends Dmvouchercampaign
{
    /**
     * @inheritdoc
     */

    public $city;
    public $pos;

    public function rules()
    {
        return [
            [['ID', 'CITY_ID', 'POS_ID', 'QUANTITY_PER_DAY', 'TIME_HOUR_DAY', 'TIME_DATE_WEEK', 'DISCOUNT_TYPE', 'IS_ALL_ITEM', 'ACTIVE', 'MANAGER_ID', 'AFFILIATE_ID', 'AFFILIATE_DISCOUNT_TYPE'], 'integer'],
            [['VOUCHER_NAME', 'VOUCHER_DESCRIPTION', 'POS_PARENT', 'DATE_CREATED', 'DATE_UPDATED', 'DATE_START', 'DATE_END', 'ITEM_TYPE_ID_LIST', 'MANAGER_NAME', 'IS_COUPON'], 'safe'],
            [['AMOUNT_ORDER_OVER', 'DISCOUNT_AMOUNT', 'DISCOUNT_EXTRA', 'CAMPAIGN_TYPE', 'AFFILIATE_DISCOUNT_AMOUNT', 'AFFILIATE_DISCOUNT_EXTRA'], 'number'],
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
        $query = Dmvouchercampaign::find();

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
        $query->joinWith('pos');

        $dataProvider->sort->attributes['pos'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['DM_POS.POS_NAME' => SORT_ASC],
            'desc' => ['DM_POS.POS_NAME' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ID' => $this->ID,
            'DM_VOUCHER_CAMPAIGN.CITY_ID' => $this->CITY_ID,
            'POS_ID' => $this->POS_ID,
            'QUANTITY_PER_DAY' => $this->QUANTITY_PER_DAY,
            'DATE_CREATED' => $this->DATE_CREATED,
            'DATE_UPDATED' => $this->DATE_UPDATED,
            'DATE_START' => $this->DATE_START,
            'DATE_END' => $this->DATE_END,
            'TIME_HOUR_DAY' => $this->TIME_HOUR_DAY,
            'TIME_DATE_WEEK' => $this->TIME_DATE_WEEK,
            'AMOUNT_ORDER_OVER' => $this->AMOUNT_ORDER_OVER,
            'DISCOUNT_TYPE' => $this->DISCOUNT_TYPE,
            'DISCOUNT_AMOUNT' => $this->DISCOUNT_AMOUNT,
            'DISCOUNT_EXTRA' => $this->DISCOUNT_EXTRA,
            'IS_ALL_ITEM' => $this->IS_ALL_ITEM,
            'ACTIVE' => $this->ACTIVE,
            'MANAGER_ID' => $this->MANAGER_ID,
            'AFFILIATE_ID' => $this->AFFILIATE_ID,
            'AFFILIATE_DISCOUNT_TYPE' => $this->AFFILIATE_DISCOUNT_TYPE,
            'AFFILIATE_DISCOUNT_AMOUNT' => $this->AFFILIATE_DISCOUNT_AMOUNT,
            'AFFILIATE_DISCOUNT_EXTRA' => $this->AFFILIATE_DISCOUNT_EXTRA,
        ]);

        $query
            ->andFilterWhere(['like', 'VOUCHER_NAME', $this->VOUCHER_NAME])
            ->andFilterWhere(['like', 'VOUCHER_DESCRIPTION', $this->VOUCHER_DESCRIPTION])
            ->andFilterWhere(['like', 'DM_VOUCHER_CAMPAIGN.POS_PARENT', $this->POS_PARENT])
            ->andFilterWhere(['like', 'ITEM_TYPE_ID_LIST', $this->ITEM_TYPE_ID_LIST])
            ->andFilterWhere(['like', 'MANAGER_NAME', $this->MANAGER_NAME])
            ->orderBy(['DATE_CREATED' => SORT_DESC])
        ;

        return $dataProvider;
    }

    public function searchCampainApi($params)
    {

        $this->load($params);

        if ($this->DATE_START) {
            $dateArr = explode(' - ', $this->DATE_START);

            $date_start_tmp = str_replace('/', '-', $dateArr[0]);
            $start_date = date("Y-m-d H:i:s", strtotime($date_start_tmp));

            $date_end_tmp = str_replace('/', '-', $dateArr[1]);
            $end_date = date("Y-m-d 23:59:59", strtotime($date_end_tmp));
        }

        $apiName = 'ipcc/get_campaign_of_pos_parent';
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];
        $paramCommnet = [
            'campaign_name' => $this->VOUCHER_NAME,
            'campaign_type' => $this->CAMPAIGN_TYPE,
            'active' => $this->ACTIVE,
            'date_create_start' => @$start_date,
            'date_create_end' => @$end_date,
        ];
        $result = ApiController::getApiByMethod($apiName,$apiPath,$paramCommnet,'GET');

        return @$result->data;
    }

    public function searchAllCampainByPosParent($posParent){
        $data = Dmvouchercampaign::find()
            ->select(['ID','VOUCHER_NAME'])
            ->where(['POS_PARENT' => $posParent])
            ->asArray()
            ->all();

        return $data;
    }
}
