<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Coupon;

/**
 * CouponSearch represents the model behind the search form about `backend\models\COUPON`.
 */
class CouponSearch extends Coupon
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['_id', 'className', 'Pos_Id', 'Coupon_Name', 'Coupon_Log_Date', 'Denominations', 'Active'], 'safe'],
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
        $query = Coupon::find();

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
            //->andFilterWhere(['like', '_id', $this->_id])
            //->andFilterWhere(['like', 'className', $this->className])
            ->andFilterWhere(['=', 'Pos_Id', $this->Pos_Id])
            ->andFilterWhere(['=', 'Coupon_Name', $this->Coupon_Name])
            ->andFilterWhere(['=', 'Coupon_Log_Date', $this->Coupon_Log_Date])
            ->andFilterWhere(['=', 'Denominations', $this->Denominations])
            ->andFilterWhere(['=', 'Active', $this->Active]);

        return $dataProvider;
    }

    public function searchAllCoupon(){
        $couponObj = Coupon::find()
            ->select(['_id','Coupon_Name','Denominations'])
            ->asArray()
            ->all();
        return $couponObj;
    }
}
