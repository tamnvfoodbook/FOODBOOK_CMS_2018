<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dmmemberactionlog;

/**
 * DmmemberactionlogSearch represents the model behind the search form about `backend\models\Dmmemberactionlog`.
 */
class DmmemberactionlogSearch extends Dmmemberactionlog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'USER_ID', 'SPIN_RESULT', 'LOG_TYPE', 'AMOUNT', 'PAYMENT_METHOD', 'WITHDRAW_STATE'], 'integer'],
            [['CREATED_AT', 'DESCRIPTION', 'POS_PARENT', 'VOUCHER_LOG', 'RECEIVER_PHONE', 'BANK_ACCOUNT', 'UPDATED_AT'], 'safe'],
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
        $query = Dmmemberactionlog::find();

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
            'CREATED_AT' => $this->CREATED_AT,
            'USER_ID' => $this->USER_ID,
            'SPIN_RESULT' => $this->SPIN_RESULT,
            'LOG_TYPE' => $this->LOG_TYPE,
            'AMOUNT' => $this->AMOUNT,
            'PAYMENT_METHOD' => $this->PAYMENT_METHOD,
            'UPDATED_AT' => $this->UPDATED_AT,
            'WITHDRAW_STATE' => $this->WITHDRAW_STATE,
        ]);

        $query->andFilterWhere(['like', 'DESCRIPTION', $this->DESCRIPTION])
            ->andFilterWhere(['like', 'POS_PARENT', $this->POS_PARENT])
            ->andFilterWhere(['like', 'VOUCHER_LOG', $this->VOUCHER_LOG])
            ->andFilterWhere(['like', 'RECEIVER_PHONE', $this->RECEIVER_PHONE])
            ->andFilterWhere(['like', 'BANK_ACCOUNT', $this->BANK_ACCOUNT]);

        return $dataProvider;
    }
}
