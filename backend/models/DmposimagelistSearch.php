<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dmposimagelist;

/**
 * DmposimagelistSearch represents the model behind the search form about `backend\models\Dmposimagelist`.
 */
class DmposimagelistSearch extends Dmposimagelist
{
    /**
     * @inheritdoc
     */
    public $pos;

    public function rules()
    {
        return [
            [['ID', 'POS_ID', 'ACTIVE', 'SORT'], 'integer'],
            [['DESCRIPTION', 'IMAGE_PATH'], 'safe'],
            [['pos'], 'safe'],
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
        $query = Dmposimagelist::find();

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

        $query->andFilterWhere([
            'ID' => $this->ID,
            'POS_ID' => $this->POS_ID,
            'DM_POS_IMAGE_LIST.ACTIVE' => $this->ACTIVE,
            'SORT' => $this->SORT,
        ]);

        $query->andFilterWhere(['like', 'DESCRIPTION', $this->DESCRIPTION])
            ->andFilterWhere(['like', 'IMAGE_PATH', $this->IMAGE_PATH]);

        return $dataProvider;
    }
}
