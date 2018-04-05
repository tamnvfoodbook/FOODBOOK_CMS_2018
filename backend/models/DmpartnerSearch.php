<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dmpartner;

/**
 * DmpartnerSearch represents the model behind the search form about `backend\models\Dmpartner`.
 */
class DmpartnerSearch extends Dmpartner
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'ACTIVE'], 'integer'],
            [['PARTNER_NAME', 'DESCRIPTION', 'AVATAR_IMAGE'], 'safe'],
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
        $query = Dmpartner::find();

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
            'ACTIVE' => $this->ACTIVE,
        ]);

        $query->andFilterWhere(['like', 'PARTNER_NAME', $this->PARTNER_NAME])
            ->andFilterWhere(['like', 'DESCRIPTION', $this->DESCRIPTION])
            ->andFilterWhere(['like', 'AVATAR_IMAGE', $this->AVATAR_IMAGE]);

        return $dataProvider;
    }




}
