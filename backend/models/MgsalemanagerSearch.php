<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Mgsalemanager;

/**
 * MgsalemanagerSearch represents the model behind the search form about `backend\models\Mgsalemanager`.
 */
class MgsalemanagerSearch extends Mgsalemanager
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['_id', 'pos_name', 'pos_type', 'channels', 'pos_parent', 'pos_id', 'tran_id', 'tran_date', 'created_at', 'discount_extra', 'discount_extra_amount', 'service_charge', 'service_charge_amount', 'coupon_amount', 'coupon_code', 'ship_fee_amount', 'discount_amount_on_item', 'original_amount', 'vat_amount', 'bill_amount', 'total_amount', 'membership_name', 'membership_id', 'sale_note', 'tran_no', 'sale_type', 'hour', 'pos_city', 'pos_district'], 'safe'],
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
        $query = Mgsalemanager::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', '_id', $this->_id])
            ->andFilterWhere(['like', 'pos_name', $this->pos_name])
            ->andFilterWhere(['like', 'pos_type', $this->pos_type])
            ->andFilterWhere(['like', 'channels', $this->channels])
            ->andFilterWhere(['like', 'pos_parent', $this->pos_parent])
            ->andFilterWhere(['like', 'pos_id', $this->pos_id])
            ->andFilterWhere(['like', 'tran_id', $this->tran_id])
            ->andFilterWhere(['like', 'tran_date', $this->tran_date])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'discount_extra', $this->discount_extra])
            ->andFilterWhere(['like', 'discount_extra_amount', $this->discount_extra_amount])
            ->andFilterWhere(['like', 'service_charge', $this->service_charge])
            ->andFilterWhere(['like', 'service_charge_amount', $this->service_charge_amount])
            ->andFilterWhere(['like', 'coupon_amount', $this->coupon_amount])
            ->andFilterWhere(['like', 'coupon_code', $this->coupon_code])
            ->andFilterWhere(['like', 'ship_fee_amount', $this->ship_fee_amount])
            ->andFilterWhere(['like', 'discount_amount_on_item', $this->discount_amount_on_item])
            ->andFilterWhere(['like', 'original_amount', $this->original_amount])
            ->andFilterWhere(['like', 'vat_amount', $this->vat_amount])
            ->andFilterWhere(['like', 'bill_amount', $this->bill_amount])
            ->andFilterWhere(['like', 'total_amount', $this->total_amount])
            ->andFilterWhere(['like', 'membership_name', $this->membership_name])
            ->andFilterWhere(['like', 'membership_id', $this->membership_id])
            ->andFilterWhere(['like', 'sale_note', $this->sale_note])
            ->andFilterWhere(['like', 'tran_no', $this->tran_no])
            ->andFilterWhere(['like', 'sale_type', $this->sale_type])
            ->andFilterWhere(['like', 'hour', $this->hour])
            ->andFilterWhere(['like', 'pos_city', $this->pos_city])
            ->andFilterWhere(['like', 'pos_district', $this->pos_district]);

        return $dataProvider;
    }
}
