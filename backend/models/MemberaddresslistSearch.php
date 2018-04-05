<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Memberaddresslist;

/**
 * MemberaddresslistSearch represents the model behind the search form about `backend\models\Memberaddresslist`.
 */
class MemberaddresslistSearch extends Memberaddresslist
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['_id', 'user_id', 'alias_name', 'extend_address', 'full_address', 'city_id', 'district_id', 'created_at', 'longitude', 'latitude'], 'safe'],
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
        $query = Memberaddresslist::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', '_id', $this->_id])
            ->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'alias_name', $this->alias_name])
            ->andFilterWhere(['like', 'extend_address', $this->extend_address])
            ->andFilterWhere(['like', 'full_address', $this->full_address])
            ->andFilterWhere(['like', 'city_id', $this->city_id])
            ->andFilterWhere(['like', 'district_id', $this->district_id])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'longitude', $this->longitude])
            ->andFilterWhere(['like', 'latitude', $this->latitude]);

        return $dataProvider;
    }

    public function searchModel($id){
        $address = Memberaddresslist::find()
            ->select(['longitude','latitude'])
            ->where(['_id'=> $id])
            //->asArray()
            ->one();
        return $address;
    }

}
