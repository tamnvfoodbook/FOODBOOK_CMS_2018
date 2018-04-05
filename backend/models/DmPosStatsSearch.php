<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\DmPosStats;

/**
 * DmPosStatsSearch represents the model behind the search form about `backend\models\DmPosStats`.
 */
class DmPosStatsSearch extends DmPosStats
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'POS_ID', 'CREATED_AT', 'SUM_USER_CHECKIN', 'SUM_USER_ORDER_ONLINE', 'SUM_USER_ORDER_OFF', 'SUM_COUPON_USED', 'SUM_COUPON_AVAILABLE', 'SUM_USER_SHARED_FB', 'SUM_USER_WISHLIST'], 'integer'],
            [['POS_PARENT'], 'safe'],
            [['SUM_PRICE_ONLINE', 'SUM_PRICE_OFF', 'SUM_COUPON_PRICE'], 'number'],
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
        $query = DmPosStats::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ID' => $this->ID,
            'POS_ID' => $this->POS_ID,
            'CREATED_AT' => $this->CREATED_AT,
            'SUM_USER_CHECKIN' => $this->SUM_USER_CHECKIN,
            'SUM_USER_ORDER_ONLINE' => $this->SUM_USER_ORDER_ONLINE,
            'SUM_PRICE_ONLINE' => $this->SUM_PRICE_ONLINE,
            'SUM_USER_ORDER_OFF' => $this->SUM_USER_ORDER_OFF,
            'SUM_PRICE_OFF' => $this->SUM_PRICE_OFF,
            'SUM_COUPON_USED' => $this->SUM_COUPON_USED,
            'SUM_COUPON_PRICE' => $this->SUM_COUPON_PRICE,
            'SUM_COUPON_AVAILABLE' => $this->SUM_COUPON_AVAILABLE,
            'SUM_USER_SHARED_FB' => $this->SUM_USER_SHARED_FB,
            'SUM_USER_WISHLIST' => $this->SUM_USER_WISHLIST,
        ]);

        $query->andFilterWhere(['like', 'POS_PARENT', $this->POS_PARENT]);

        return $dataProvider;
    }
}
