<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dmshipfee;

/**
 * DmshipfeeSearch represents the model behind the search form about `backend\models\Dmshipfee`.
 */
class DmshipfeeSearch extends Dmshipfee
{
    /**
     * @inheritdoc
     */

    public $pos;

    public function rules()
    {
        return [
            [['ID', 'POS_ID'], 'integer'],
            [['FROM_KM', 'TO_KM', 'FROM_AMOUNT', 'TO_AMOUNT', 'FEE'], 'number'],
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
        $query = Dmshipfee::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith('pos');


        $dataProvider->sort->attributes['pos'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['DM_POS.POS_NAME' => SORT_ASC],
            'desc' => ['DM_POS.POS_NAME' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if($this->FEE == -3){
            $query->andFilterWhere([
                '>', 'FEE',0
        ]);
        }else{
            $query->andFilterWhere([
                'FEE' => $this->FEE,
            ]);
        }

        $query->andFilterWhere([
            'ID' => $this->ID,
            'POS_ID' => $this->POS_ID,
            'FROM_KM' => $this->FROM_KM,
            'TO_KM' => $this->TO_KM,
            'FROM_AMOUNT' => $this->FROM_AMOUNT,
            'TO_AMOUNT' => $this->TO_AMOUNT,
            //'FEE' => $this->FEE,
        ]);

        return $dataProvider;
    }
}
