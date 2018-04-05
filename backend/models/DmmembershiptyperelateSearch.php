<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dmmembershiptyperelate;

/**
 * DmmembershiptyperelateSearch represents the model behind the search form about `backend\models\Dmmembershiptyperelate`.
 */
class DmmembershiptyperelateSearch extends Dmmembershiptyperelate
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'MEMBERSHIP_ID'], 'integer'],
            [['POS_PARENT', 'MEMBERSHIP_TYPE_ID', 'CREATED_AT', 'DOB'], 'safe'],
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
        $query = Dmmembershiptyperelate::find();

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
            'MEMBERSHIP_ID' => $this->MEMBERSHIP_ID,
            'CREATED_AT' => $this->CREATED_AT,
            'DOB' => $this->DOB,
        ]);

        $query->andFilterWhere(['like', 'POS_PARENT', $this->POS_PARENT])
            ->andFilterWhere(['like', 'MEMBERSHIP_TYPE_ID', $this->MEMBERSHIP_TYPE_ID]);

        return $dataProvider;
    }

    public function allType($posParent){
        $config = Dmmembershiptyperelate::find()
            ->where(['POS_PARENT' => $posParent])
            ->asArray()->all();
        return $config;
    }
}
