<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Saleposmobile;

/**
 * SaleposmobileSearch represents the model behind the search form about `backend\models\Saleposmobile`.
 */
class SaleposmobileSearch extends Saleposmobile
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['_id', 'pos_id', 'pr_key', 'status', 'ticket_name', 'user_id', 'time_update', 'date_time', 'trans_type', 'data_sale_detail'], 'safe'],
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
        $query = Saleposmobile::find();

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
            ->andFilterWhere(['like', 'pos_id', $this->pos_id])
            ->andFilterWhere(['like', 'pr_key', $this->pr_key])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'ticket_name', $this->ticket_name])
            ->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'time_update', $this->time_update])
            ->andFilterWhere(['like', 'date_time', $this->date_time])
            ->andFilterWhere(['like', 'trans_type', $this->trans_type])
            ->andFilterWhere(['like', 'data_sale_detail', $this->data_sale_detail]);

        return $dataProvider;
    }

    public function searchAllSale($ids){
        $data = Saleposmobile::find()
            ->where(['pos_id' => $ids])
            ->asArray()
            ->all();
        return $data;
    }

    public function searchAllSaleByTime($ids,$start,$end){
        $data = Saleposmobile::find()
            ->where(['pos_id' => $ids])
            ->andwhere(['between','date_time',$start,$end])
            ->asArray()
            ->all()
            ;
        return $data;
    }
    public function testSum(){
        $collection = Yii::$app->mongodb->getCollection('SALE_POS_MOBILE');
        $result = $collection->aggregate(
            array( '$match' => array( 'pos_id' => 57 ) ),
            array( '$group' => array(
                '_id' => '$pos_id',
                'status' => array( '$sum' => '$status')
            ))
        );
        return $result;
    }
}
