<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dmconfig;

/**
 * DmconfigSearch represents the model behind the search form about `backend\models\Dmconfig`.
 */
class DmconfigSearch extends Dmconfig
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'SORT', 'ACTIVE'], 'integer'],
            [['KEYGROUP', 'KEYWORD', 'VALUES', 'DESC'], 'safe'],
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
        $query = Dmconfig::find();

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
            'ACTIVE' => $this->ACTIVE,
        ]);

        $query->andFilterWhere(['like', 'KEYGROUP', $this->KEYGROUP])
            ->andFilterWhere(['like', 'KEYWORD', $this->KEYWORD])
            ->andFilterWhere(['like', 'VALUES', $this->VALUES])
            ->andFilterWhere(['like', 'DESC', $this->DESC]);

        return $dataProvider;
    }

    public function searchConfigByKeygroup($keyword){
        $data = Dmconfig::find()
            ->where(['KEYGROUP' => $keyword])
            ->andWhere(['ACTIVE' => 1])
            ->orderBy(['SORT' => SORT_ASC])
            ->asArray()
            ->all();
        return $data;
    }
}
