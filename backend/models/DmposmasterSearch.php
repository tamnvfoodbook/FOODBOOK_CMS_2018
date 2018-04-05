<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dmposmaster;

/**
 * DmposmasterSearch represents the model behind the search form about `backend\models\Dmposmaster`.
 */
class DmposmasterSearch extends Dmposmaster
{
    /**
     * @inheritdoc
     */
    public $city;
    public function rules()
    {
        return [
            [['ID', 'IS_COLLECTION', 'ACTIVE', 'FOR_BREAKFAST', 'FOR_LUNCH', 'FOR_DINNER', 'FOR_MIDNIGHT', 'SORT', 'CITY_ID'], 'integer'],
            [['POS_MASTER_NAME', 'DESCRIPTION', 'IMAGE_PATH', 'TIME_START', 'DAY_ON'], 'safe'],
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
        $query = Dmposmaster::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith('city');

        $dataProvider->sort->attributes['city'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['DM_CITY.CITY_NAME' => SORT_ASC],
            'desc' => ['DM_CITY.CITY_NAME' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ID' => $this->ID,
            'IS_COLLECTION' => $this->IS_COLLECTION,
            'ACTIVE' => $this->ACTIVE,
            'FOR_BREAKFAST' => $this->FOR_BREAKFAST,
            'FOR_LUNCH' => $this->FOR_LUNCH,
            'FOR_DINNER' => $this->FOR_DINNER,
            'FOR_MIDNIGHT' => $this->FOR_MIDNIGHT,
            'SORT' => $this->SORT,
            'DM_POS_MASTER.CITY_ID' => $this->CITY_ID,
        ]);

        $query->andFilterWhere(['like', 'POS_MASTER_NAME', $this->POS_MASTER_NAME])
            ->andFilterWhere(['like', 'DESCRIPTION', $this->DESCRIPTION])
            ->andFilterWhere(['like', 'IMAGE_PATH', $this->IMAGE_PATH])
            ->andFilterWhere(['like', 'TIME_START', $this->TIME_START])
            ->andFilterWhere(['like', 'DAY_ON', $this->DAY_ON]);

        return $dataProvider;
    }



    public function searchAllPosmaster(){
        $posmaster = Dmposmaster::find()
            ->with('city')
            ->asArray()
            ->all();
//        echo '<pre>';
//        var_dump($posmaster);
//        echo '</pre>';
//        die();
        return $posmaster;
    }
}
