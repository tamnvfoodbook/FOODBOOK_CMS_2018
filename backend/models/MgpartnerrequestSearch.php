<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Mgpartnerrequest;

/**
 * MgpartnerrequestSearch represents the model behind the search form about `backend\models\Mgpartnerrequest`.
 */
class MgpartnerrequestSearch extends Mgpartnerrequest
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['_id', 'partner_name', 'request_at', 'response_at', 'request_data', 'response_data', 'has_exception', 'tag'], 'safe'],
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
        $query = Mgpartnerrequest::find();

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
            ->andFilterWhere(['like', 'partner_name', $this->partner_name])
            ->andFilterWhere(['like', 'request_at', $this->request_at])
            ->andFilterWhere(['like', 'response_at', $this->response_at])
            ->andFilterWhere(['like', 'request_data', $this->request_data])
            ->andFilterWhere(['like', 'response_data', $this->response_data])
            ->andFilterWhere(['like', 'has_exception', $this->has_exception])
            ->andFilterWhere(['like', 'tag', $this->tag]);

        return $dataProvider;
    }
}
