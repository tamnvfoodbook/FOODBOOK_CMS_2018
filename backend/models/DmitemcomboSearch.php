<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dmitemcombo;

/**
 * DmitemcomboSearch represents the model behind the search form about `backend\models\Dmitemcombo`.
 */
class DmitemcomboSearch extends Dmitemcombo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'POS_ID', 'QUANTITY', 'SORT'], 'integer'],
            [['ITEM_ID', 'COMBO_ITEM_ID_LIST', 'CREATED_AT'], 'safe'],
            [['TA_PRICE', 'OTS_PRICE', 'TA_DISCOUNT', 'OTS_DISCOUNT'], 'number'],
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
        $query = Dmitemcombo::find();

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
            'QUANTITY' => $this->QUANTITY,
            'TA_PRICE' => $this->TA_PRICE,
            'OTS_PRICE' => $this->OTS_PRICE,
            'TA_DISCOUNT' => $this->TA_DISCOUNT,
            'OTS_DISCOUNT' => $this->OTS_DISCOUNT,
            'SORT' => $this->SORT,
            'CREATED_AT' => $this->CREATED_AT,
        ]);

        $query->andFilterWhere(['like', 'ITEM_ID', $this->ITEM_ID])
            ->andFilterWhere(['like', 'COMBO_ITEM_ID_LIST', $this->COMBO_ITEM_ID_LIST]);

        return $dataProvider;
    }
}
