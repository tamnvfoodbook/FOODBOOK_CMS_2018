<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dmmembershippoint;

/**
 * DmmembershippointSearch represents the model behind the search form about `backend\models\Dmmembershippoint`.
 */
class DmmembershippointSearch extends Dmmembershippoint
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MEMBERSHIP_ID', 'EAT_COUNT', 'EAT_COUNT_FAIL'], 'integer'],
            [['POS_PARENT', 'EAT_FIRST_DATE', 'EAT_LAST_DATE'], 'safe'],
            [['AMOUNT', 'POINT'], 'number'],
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
        $query = Dmmembershippoint::find();

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
            'MEMBERSHIP_ID' => $this->MEMBERSHIP_ID,
            'AMOUNT' => $this->AMOUNT,
            'POINT' => $this->POINT,
            'EAT_FIRST_DATE' => $this->EAT_FIRST_DATE,
            'EAT_LAST_DATE' => $this->EAT_LAST_DATE,
            'EAT_COUNT' => $this->EAT_COUNT,
            'EAT_COUNT_FAIL' => $this->EAT_COUNT_FAIL,
        ]);

        $query->andFilterWhere(['like', 'POS_PARENT', $this->POS_PARENT]);

        return $dataProvider;
    }

    public function searchMemberByPosparent($posparent){
        $userPhone = Dmmembershippoint::find()
            ->select(['MEMBERSHIP_ID'])
            ->where(['POS_PARENT' => $posparent])
            ->asArray()
            ->all();
        return $userPhone;
    }
}
