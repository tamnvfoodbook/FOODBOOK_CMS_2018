<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dmmembershiptype;

/**
 * DmmembershiptypeSearch represents the model behind the search form about `backend\models\Dmmembershiptype`.
 */
class DmmembershiptypeSearch extends Dmmembershiptype
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'ACTIVE'], 'integer'],
            [['POS_PARENT', 'MEMBERSHIP_TYPE_ID', 'MEMBERSHIP_TYPE_NAME', 'MEMBERSHIP_TYPE_IMAGE'], 'safe'],
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
        $query = Dmmembershiptype::find();

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
            'ACTIVE' => $this->ACTIVE,
        ]);

        $query->andFilterWhere(['like', 'POS_PARENT', $this->POS_PARENT])
            ->andFilterWhere(['like', 'MEMBERSHIP_TYPE_ID', $this->MEMBERSHIP_TYPE_ID])
            ->andFilterWhere(['like', 'MEMBERSHIP_TYPE_NAME', $this->MEMBERSHIP_TYPE_NAME])
            ->andFilterWhere(['like', 'MEMBERSHIP_TYPE_IMAGE', $this->MEMBERSHIP_TYPE_IMAGE]);

        return $dataProvider;
    }

    public function allType($posParent){
        $config = Dmmembershiptype::find()
            ->where(['POS_PARENT' => $posParent])
            ->asArray()->all();
        return $config;
    }
}
