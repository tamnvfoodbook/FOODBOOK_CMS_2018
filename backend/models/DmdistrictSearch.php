<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dmdistrict;

/**
 * DmdistrictSearch represents the model behind the search form about `backend\models\Dmdistrict`.
 */
class DmdistrictSearch extends Dmdistrict
{
    /**
     * @inheritdoc
     */
    public $city;

    public function rules()
    {
        return [
            [['ID', 'CITY_ID', 'SORT'], 'integer'],
            [['DISTRICT_NAME'], 'safe'],
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
        $query = Dmdistrict::find();

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
            'CITY_ID' => $this->CITY_ID,
            'SORT' => $this->SORT,
        ]);

        $query->andFilterWhere(['like', 'DISTRICT_NAME', $this->DISTRICT_NAME]);

        return $dataProvider;
    }

    public function searchAllDistrict()
    {
        $district = Dmdistrict::find()
            ->asArray()
            ->all();
        return $district;
    }

    public function searchDistrictByName($name, $city_id)
    {
        $district = Dmdistrict::find()
            ->where(['like', 'DISTRICT_NAME', trim($name)])
            ->andWhere(['like', 'CITY_ID', $city_id])
            //->asArray()
            ->one();
        return $district;
    }

    public function searchDistrictByCityId($city_id)
    {
//        var_dump($city_id);
//        die();
        $district = Dmdistrict::find()
            ->where(['CITY_ID' => $city_id])
            ->asArray()
            ->all();
        return $district;
    }
}

