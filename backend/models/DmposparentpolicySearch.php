<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dmposparentpolicy;

/**
 * DmposparentpolicySearch represents the model behind the search form about `backend\models\Dmposparentpolicy`.
 */
class DmposparentpolicySearch extends Dmposparentpolicy
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'EXCHANGE_POINT'], 'integer'],
            [['POS_PARENT', 'DESCRIPTION'], 'safe'],
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
        $query = Dmposparentpolicy::find();

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
            'EXCHANGE_POINT' => $this->EXCHANGE_POINT,
        ]);

        $query->andFilterWhere(['like', 'POS_PARENT', $this->POS_PARENT])
            ->andFilterWhere(['like', 'DESCRIPTION', $this->DESCRIPTION]);

        return $dataProvider;
    }
}
