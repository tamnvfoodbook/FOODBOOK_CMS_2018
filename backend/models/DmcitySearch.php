<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dmcity;

/**
 * DmcitySearch represents the model behind the search form about `backend\models\Dmcity`.
 */
class DmcitySearch extends Dmcity
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'SORT', 'ACTIVE'], 'integer'],
            [['CITY_NAME', 'GG_LOCALITY', 'AM_LOCALITY'], 'safe'],
            [['LONGITUDE', 'LATITUDE'], 'number'],
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
        $query = Dmcity::find();

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
            'LONGITUDE' => $this->LONGITUDE,
            'LATITUDE' => $this->LATITUDE,
        ]);

        $query->andFilterWhere(['=', 'CITY_NAME', $this->CITY_NAME])
            ->andFilterWhere(['=', 'GG_LOCALITY', $this->GG_LOCALITY])
            ->andFilterWhere(['=', 'AM_LOCALITY', $this->AM_LOCALITY]);

        return $dataProvider;
    }

    public function searchAllCity(){
        $city = Dmcity::find()
            ->asArray()
            ->all();
        return $city;
    }

    public function searchCityByName($name){
        $city = Dmcity::find()
            ->where(['like','GG_LOCALITY',trim($name)]) // Tên thành phố phải loại bỏ khoảng trắng ở đầu và cuối chuỗi trước khi so sánh
            //->asArray()
            ->one();
        return $city;
    }
    public function searchCityById($cityId){
        $city = Dmcity::find()
            ->where(['ID' => $cityId])
            ->one();
        return $city;
    }

}
