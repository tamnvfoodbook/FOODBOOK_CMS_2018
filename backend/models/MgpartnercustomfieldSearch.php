<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Mgpartnercustomfield;

/**
 * MgpartnercustomfieldSearch represents the model behind the search form about `backend\models\Mgpartnercustomfield`.
 */
class MgpartnercustomfieldSearch extends Mgpartnercustomfield
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['_id', 'partner_id', 'partner_name', 'pos_id', 'pos_parent', 'pos_name', 'tags', 'time_delivery', 'image_url', 'image_thumb_url', 'active', 'created_at'], 'safe'],
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
        $query = Mgpartnercustomfield::find();

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
            ->andFilterWhere(['like', 'partner_id', $this->partner_id])
            ->andFilterWhere(['like', 'partner_name', $this->partner_name])
            ->andFilterWhere(['like', 'pos_id', $this->pos_id])
            ->andFilterWhere(['like', 'pos_parent', $this->pos_parent])
            ->andFilterWhere(['like', 'pos_name', $this->pos_name])
            ->andFilterWhere(['like', 'tags', $this->tags])
            ->andFilterWhere(['like', 'time_delivery', $this->time_delivery])
            ->andFilterWhere(['like', 'image_url', $this->image_url])
            ->andFilterWhere(['like', 'image_thumb_url', $this->image_thumb_url])
            ->andFilterWhere(['like', 'active', $this->active])
            ->andFilterWhere(['like', 'created_at', $this->created_at]);

        return $dataProvider;
    }
}
