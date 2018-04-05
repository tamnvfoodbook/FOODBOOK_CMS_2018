<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dmtagrelate;

/**
 * DmtagrelateSearch represents the model behind the search form about `backend\models\Dmtagrelate`.
 */
class DmtagrelateSearch extends Dmtagrelate
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TAG_ID', 'POS_ID', 'PIORITY'], 'integer'],
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
        $query = Dmtagrelate::find();

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
            'TAG_ID' => $this->TAG_ID,
            'POS_ID' => $this->POS_ID,
            'PIORITY' => $this->PIORITY,
        ]);

        return $dataProvider;
    }
}
