<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dmposmasterrelate;

/**
 * DmposmasterrelateSearch represents the model behind the search form about `backend\models\Dmposmasterrelate`.
 */
class DmposmasterrelateSearch extends Dmposmasterrelate
{
    /**
     * @inheritdoc
     */
    public $pos;
    public $posmaster;
    public $city;


    public function rules()
    {
        return [
            [['ID', 'POS_ID', 'POS_MASTER_ID', 'SORT'], 'integer'],
            [['pos','posmaster','city'], 'safe'],
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

        $query = Dmposmasterrelate::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith('pos');
        $query->joinWith('posmaster');

        $dataProvider->sort->attributes['pos'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['DM_POS.POS_NAME' => SORT_ASC],
            'desc' => ['DM_POS.POS_NAME' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['posmaster'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['DM_POS_MASTER.POS_MASTER_NAME' => SORT_ASC],
            'desc' => ['DM_POS_MASTER.POS_MASTER_NAME' => SORT_DESC],
        ];
//        $dataProvider->sort->attributes['city'] = [
//            // The tables are the ones our relation are configured to
//            // in my case they are prefixed with "tbl_"
//            'asc' => ['DM_CITY.CITY_NAME' => SORT_ASC],
//            'desc' => ['DM_CITY.CITY_NAME' => SORT_DESC],
//        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


//        die();
        $query->andFilterWhere([
            'DM_POS_MASTER_RELATE.ID' => $this->ID,
            'POS_ID' => $this->POS_ID,
            'DM_POS.CITY_ID' => $this->city,
            'DM_POS_MASTER_RELATE.POS_MASTER_ID' => $this->POS_MASTER_ID,
            'DM_POS_MASTER_RELATE.SORT' => $this->SORT,
        ]);

        return $dataProvider;
    }
}
