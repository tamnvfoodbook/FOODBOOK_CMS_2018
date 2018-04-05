<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dmdeliverypartner;

/**
 * DmdeliverypartnerSearch represents the model behind the search form about `backend\models\Dmdeliverypartner`.
 */
class DmdeliverypartnerSearch extends Dmdeliverypartner
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'NAME', 'URL', 'CONFIG_JSON'], 'safe'],
            [['ACTIVE'], 'integer'],
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
        $query = Dmdeliverypartner::find();

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
            'ACTIVE' => $this->ACTIVE,
        ]);

        $query->andFilterWhere(['like', 'ID', $this->ID])
            ->andFilterWhere(['like', 'NAME', $this->NAME])
            ->andFilterWhere(['like', 'URL', $this->URL])
            ->andFilterWhere(['like', 'CONFIG_JSON', $this->CONFIG_JSON]);

        return $dataProvider;
    }
}
