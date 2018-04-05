<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dmquerylog;

/**
 * DmquerylogSearch represents the model behind the search form about `backend\models\Dmquerylog`.
 */
class DmquerylogSearch extends Dmquerylog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'USER_MANAGER_ID'], 'integer'],
            [['CREATED_AT', 'ACTION_QUERY', 'TABLE_NAME', 'DATA_OLD', 'DATA_NEW', 'USER_MANAGER_NAME'], 'safe'],
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
        $query = Dmquerylog::find();

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
            'CREATED_AT' => $this->CREATED_AT,
            'USER_MANAGER_ID' => $this->USER_MANAGER_ID,
        ]);

        $query->andFilterWhere(['like', 'ACTION_QUERY', $this->ACTION_QUERY])
            ->andFilterWhere(['like', 'TABLE_NAME', $this->TABLE_NAME])
            ->andFilterWhere(['like', 'DATA_OLD', $this->DATA_OLD])
            ->andFilterWhere(['like', 'DATA_NEW', $this->DATA_NEW])
            ->andFilterWhere(['like', 'USER_MANAGER_NAME', $this->USER_MANAGER_NAME]);

        return $dataProvider;
    }
}
