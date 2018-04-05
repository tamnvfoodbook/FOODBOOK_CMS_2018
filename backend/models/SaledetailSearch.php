<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\mongodb\Query;

/**
 * SALEDETAILSearch represents the model behind the search form about `backend\models\SALEDETAIL`.
 */
class SaledetailSearch extends Saledetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['_id', 'Pos_Id', 'Pos_Parent', 'Fr_Key', 'Amount', 'Price_Sale', 'Tran_Id', 'Created_At'], 'safe'],
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
        $query = SALEDETAIL::find();

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
            ->andFilterWhere(['like', 'Pos_Id', $this->Pos_Id])
            ->andFilterWhere(['like', 'Pos_Parent', $this->Pos_Parent])
            ->andFilterWhere(['like', 'Fr_Key', $this->Fr_Key])
            ->andFilterWhere(['like', 'Amount', $this->Amount])
            ->andFilterWhere(['like', 'Price_Sale', $this->Price_Sale])
            ->andFilterWhere(['like', 'Tran_Id', $this->Tran_Id])
            ->andFilterWhere(['like', 'Created_At', $this->Created_At]);

        return $dataProvider;
    }

    public function searchByTime($ids,$start,$end,$type = null){
        $start_month =  date('Y-m-d', $start->sec);
        $end_month =  date('Y-m-d', $end->sec);

        $start_month_time    = (new \DateTime($start_month))->modify('first day of this month');
        $end_month_time      = (new \DateTime($end_month))->modify('first day of next month');
        $interval = \DateInterval::createFromDateString('1 month');
        $period   = new \DatePeriod($start_month_time, $interval, $end_month_time);

        $monthArr = array();
        foreach ($period as $dt) {
            array_push($monthArr,$dt->format("Ym"));
        }




        $dataArr = array();
        foreach($monthArr as $month){
            $query = new Query();
            if($type){
                $query
                    ->select(['_id','Sale_Date','Pos_Id','Amount','Fr_Key'])
                    ->where(['Pos_Parent' => \Yii::$app->session->get('pos_parent')])
                    ->andwhere(['Pos_Id' => array_values($ids)])
                    ->andwhere(['between','Sale_Date',$start,$end])
                    ->andwhere(['Tran_Id' => $type])
                    ->from('SALE_DETAIL_'.$month);
            }else{
                $query
                    ->where(['Pos_Parent' => \Yii::$app->session->get('pos_parent')])
                    ->where(['Pos_Id' => array_values($ids)])
                    ->andwhere(['between','Sale_Date',$start,$end])
                    ->from('SALE_DETAIL_'.$month);
            }

            $data = $query->all();
            $dataArr = array_merge($data,$dataArr);

        }

        return $dataArr;
    }
}
