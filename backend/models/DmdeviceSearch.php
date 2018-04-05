<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dmdevice;

/**
 * DmdeviceSearch represents the model behind the search form about `backend\models\Dmdevice`.
 */
class DmdeviceSearch extends Dmdevice
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'DEVICE_TYPE', 'MSISDN', 'ACTIVE'], 'integer'],
            [['DEVICE_ID', 'PUSH_ID', 'LAST_UPDATED', 'VERSION', 'CREATED_AT', 'MODEL', 'LANGUAGE'], 'safe'],
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
        $query = Dmdevice::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        if ( ! is_null($this->LAST_UPDATED) && strpos($this->LAST_UPDATED, ' - ') !== false ) {
            list($start_date, $end_date) = explode(' - ', $this->LAST_UPDATED);
            $start = date('Y-m-d H:i:s', strtotime($start_date));

            //$end_date = date();
            $date = new \DateTime($end_date);
            $date->add(new \DateInterval('P1D')); // Cộng thêm 1 ngày vào ngày cuối cùng để đảm bảo tới 24 giờ của ngày*/
            $end = $date->format('Y-m-d H:i:s');
            $query->andFilterWhere(['between', 'LAST_UPDATED', $start, $end]);
        }

        if ( ! is_null($this->CREATED_AT) && strpos($this->CREATED_AT, ' - ') !== false ) {
            list($start_date, $end_date) = explode(' - ', $this->CREATED_AT);
            $start = date('Y-m-d H:i:s', strtotime($start_date));

            //$end_date = date();
            $date = new \DateTime($end_date);
            $date->add(new \DateInterval('P1D')); // Cộng thêm 1 ngày vào ngày cuối cùng để đảm bảo tới 24 giờ của ngày*/
            $end = $date->format('Y-m-d H:i:s');
            $query->andFilterWhere(['between', 'CREATED_AT', $start, $end]);
        }


        $query->andFilterWhere([
            'ID' => $this->ID,
            'DEVICE_TYPE' => $this->DEVICE_TYPE,
            'MSISDN' => $this->MSISDN,
            //'LAST_UPDATED' => $this->LAST_UPDATED,
            'ACTIVE' => $this->ACTIVE,
            'CREATED_AT' => $this->CREATED_AT,
        ]);

        $query
            ->andFilterWhere(['=', 'DEVICE_ID', $this->DEVICE_ID])
            //->andFilterWhere(['like', 'PUSH_ID', $this->PUSH_ID])
            ->andFilterWhere(['=', 'VERSION', $this->VERSION])
            ->andFilterWhere(['=', 'MODEL', $this->MODEL])
            ->andFilterWhere(['=', 'LANGUAGE', $this->LANGUAGE]);

        return $dataProvider;
    }
}
