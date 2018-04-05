<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Wmitemimagelist;

/**
 * WmitemimagelistSearch represents the model behind the search form about `backend\models\Wmitemimagelist`.
 */
class WmitemimagelistSearch extends Wmitemimagelist
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'POS_ID', 'ACTIVE', 'SORT'], 'integer'],
            [['NAME', 'DESCRIPTION', 'IMAGE_PATH'], 'safe'],
            [['PRICE'], 'number'],
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
        $query = Wmitemimagelist::find();

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
            'POS_ID' => $this->POS_ID,
            'PRICE' => $this->PRICE,
            'ACTIVE' => $this->ACTIVE,
            'SORT' => $this->SORT,
        ]);

        $query->andFilterWhere(['like', 'NAME', $this->NAME])
            ->andFilterWhere(['like', 'DESCRIPTION', $this->DESCRIPTION])
            ->andFilterWhere(['like', 'IMAGE_PATH', $this->IMAGE_PATH]);

        return $dataProvider;
    }

    public function searchByPosId($params,$id)
    {
        $query = Wmitemimagelist::find();

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
            'POS_ID' => $id,
            'PRICE' => $this->PRICE,
            'ACTIVE' => $this->ACTIVE,
            'SORT' => $this->SORT,
        ]);

        $query->andFilterWhere(['like', 'NAME', $this->NAME])
            ->andFilterWhere(['like', 'DESCRIPTION', $this->DESCRIPTION])
            ->andFilterWhere(['like', 'IMAGE_PATH', $this->IMAGE_PATH]);

        return $dataProvider;
    }
}
