<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Orderrate;

/**
 * OrderrateSearch represents the model behind the search form about `backend\models\Orderrate`.
 */
class OrderrateSearch extends Orderrate
{
    /**
     * @inheritdoc
     */

    public $pos;
    public $reson;


    public function rules()
    {
        return [
            [['_id', 'pos_id', 'pos_parent', 'dmShift', 'member_id', 'created_at', 'score','reson', 'reson_bad_food', 'reson_expensive_price', 'reson_bad_service', 'reson_bad_shipper', 'reson_other', 'reson_note', 'published'], 'safe'],
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
        $query = Orderrate::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->with('pos');

        $dataProvider->sort->attributes['pos'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['DM_POS.POS_NAME' => SORT_ASC],
            'desc' => ['DM_POS.POS_NAME' => SORT_DESC],
        ];

        if($this->member_id){
            $query
                ->andFilterWhere(['=', 'member_id',(int)$this->member_id]);
        }

//        if(!$this->score){
//            $query
//                ->andFilterWhere(['between', 'score', 1,3]);
//        }


        if($this->reson){
            //var_dump($this->reson);
            if($this->reson === '1'){
                $query->where(['reson_bad_food' => 1]);
            }elseif($this->reson === '2'){
                $query->where(['reson_expensive_price' => 1]);
            }elseif($this->reson === '3'){
                $query->where(['reson_bad_service' => 1]);
            }elseif($this->reson === '4'){
                $query->where(['reson_bad_shipper' => 1]);
            }elseif($this->reson === '5'){
                $query->where(['reson_other' => 1]);
            }
        }



        if(!$this->reson_note){
            $query
                ->andWhere(['!=', 'reson_note', '']);
        }

        $type = \Yii::$app->session->get('type_acc');
        if($type != 1){
            $posParent = \Yii::$app->session->get('pos_parent');
            $query
                ->andFilterWhere(['=', 'pos_parent', $posParent]);
        }else{
            $query
                ->andFilterWhere(['=', 'pos_parent', $this->pos_parent]);
        }

        $query->andFilterWhere(['like', '_id', $this->_id])
            ->andFilterWhere(['=', 'pos_id', $this->pos_id])
            //->andFilterWhere(['like', 'dmShift', $this->dmShift])
            //->andFilterWhere(['like', 'member_id',$this->member_id])
           // ->andFilterWhere(['like', 'created_at', $this->created_at])
            //->andFilterWhere(['like', 'score', $this->score])
//            ->andFilterWhere(['like', 'reson_bad_food', $this->reson_bad_food])
//            ->andFilterWhere(['like', 'reson_expensive_price', $this->reson_expensive_price])
//            ->andFilterWhere(['like', 'reson_bad_service', $this->reson_bad_service])
//            ->andFilterWhere(['like', 'reson_bad_shipper', $this->reson_bad_shipper])
//            ->andFilterWhere(['like', 'reson_other', $this->reson_other])
            ->andFilterWhere(['like', 'reson_note', $this->reson_note])
            ->orderBy(['created_at' => SORT_DESC])
            //->andFilterWhere(['like', 'published', $this->published]);
        ;

        if ( ! is_null($this->created_at) && strpos($this->created_at, ' - ') !== false ) {
            list($start_date, $end_date) = explode(' - ', $this->created_at);
            $start = new \MongoDate(strtotime($start_date));

            $end_date = new \DateTime($end_date);
            $end_date->add(new \DateInterval('P1D')); // Cộng thêm 1 ngày vào ngày cuối cùng để đảm bảo tới 24 giờ của ngày
            $end_date = $end_date->format( \DateTime::ISO8601 );
            $end = new \MongoDate(strtotime($end_date));
            $query->andFilterWhere(['between', 'created_at', $start, $end]);
        }

        return $dataProvider;
    }

    public function searchAllRateByTime($ids,$start,$end){
        date_default_timezone_set('Asia/Bangkok');

        $RateObj = Orderrate::find()
            ->select(['_id','className','pos_id','pos_parent','member_id','created_at','score','reson_bad_food','reson_expensive_price','reson_bad_service','reson_bad_shipper','reson_other','reson_note','published'])
            ->where(['pos_id' => array_values($ids)])
            ->andwhere(['between','created_at',$start,$end])
            ->andwhere(['>','score',0])
            ->asArray()
            ->all();

        return $RateObj;
    }

    public function reportRate($start,$end){
        $posModel = new DmposSearch();
        $ids = $posModel->getIds();

        $RateObj = Orderrate::find()
            ->select(['_id','className','pos_id','pos_parent','member_id','created_at','score','reson_bad_food','reson_expensive_price','reson_bad_service','reson_bad_shipper','reson_other','reson_note','published'])
            ->where(['pos_id' => array_values($ids)])
            ->andwhere(['between','created_at',$start,$end])
            ->andwhere(['>','score',0])
            ->all();

        $data = array();
        foreach((array)$RateObj as $value){
//            echo '<pre>';
//            var_dump($value);
//            echo '</pre>';
//            die();

            if(!isset($data[$value->pos_id])){
                $data[$value->pos_id]['pos_id'] = $value->pos_id;
                $data[$value->pos_id]['score'] = $value->score;
                $data[$value->pos_id]['rate_average'] = $value->score;
                $data[$value->pos_id]['count_rate'] = 1;
                $data[$value->pos_id]['reson_bad_food'] = $value->reson_bad_food;
                $data[$value->pos_id]['reson_expensive_price'] = $value->reson_expensive_price;
                $data[$value->pos_id]['reson_bad_service'] = $value->reson_bad_service;
                $data[$value->pos_id]['reson_bad_shipper'] = $value->reson_bad_shipper;
                $data[$value->pos_id]['reson_other'] = $value->reson_other;
            }else{
                $data[$value->pos_id]['score'] = $value->score + $data[$value->pos_id]['score'];
                $data[$value->pos_id]['reson_bad_food'] = $value->reson_bad_food + $data[$value->pos_id]['reson_bad_food'];
                $data[$value->pos_id]['count_rate']++;
                $data[$value->pos_id]['rate_average'] = $data[$value->pos_id]['score']/$data[$value->pos_id]['count_rate'];
                $data[$value->pos_id]['reson_expensive_price'] = $value->reson_expensive_price + $data[$value->pos_id]['reson_expensive_price'];
                $data[$value->pos_id]['reson_bad_service'] = $value->reson_bad_service + $data[$value->pos_id]['reson_bad_service'];
                $data[$value->pos_id]['reson_bad_shipper'] = $value->reson_bad_shipper + $data[$value->pos_id]['reson_bad_shipper'];
                $data[$value->pos_id]['reson_other'] = $value->reson_other + $data[$value->pos_id]['reson_other'];
            }
        }

//        echo '<pre>';
//        var_dump($data);
//        echo '</pre>';
//        die();
        return $data;
    }
}
