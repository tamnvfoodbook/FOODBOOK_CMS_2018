<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dmpolicyimage;

/**
 * DmpolicyimageSearch represents the model behind the search form about `backend\models\Dmpolicyimage`.
 */
class DmpolicyimageSearch extends Dmpolicyimage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'SORT', 'ACTIVE','CITY_ID'], 'integer'],
            [['IMAGE_LINK', 'DESCRIPTION', 'DESCRIPTION_URL', 'DATE_CREATED', 'DATE_START', 'DATE_END'], 'safe'],
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
        $query = Dmpolicyimage::find();

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
            'SORT' => $this->SORT,
            'DATE_CREATED' => $this->DATE_CREATED,
            'DATE_START' => $this->DATE_START,
            'DATE_END' => $this->DATE_END,
            'ACTIVE' => $this->ACTIVE,
            'CITY_ID' => $this->CITY_ID,
        ]);

        $query->andFilterWhere(['like', 'IMAGE_LINK', $this->IMAGE_LINK])
            ->andFilterWhere(['like', 'DESCRIPTION', $this->DESCRIPTION])
            ->andFilterWhere(['like', 'DESCRIPTION_URL', $this->DESCRIPTION_URL]);

        return $dataProvider;
    }
}
