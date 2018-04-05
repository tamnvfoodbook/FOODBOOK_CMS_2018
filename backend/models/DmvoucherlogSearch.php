<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dmvoucherlog;

/**
 * DmvoucherlogSearch represents the model behind the search form about `backend\models\Dmvoucherlog`.
 */
class DmvoucherlogSearch extends Dmvoucherlog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['VOUCHER_CODE', 'VOUCHER_CAMPAIGN_NAME', 'VOUCHER_DESCRIPTION', 'POS_PARENT', 'DATE_CREATED', 'DATE_START', 'DATE_END', 'DATE_HASH', 'ITEM_TYPE_ID_LIST', 'BUYER_INFO', 'USED_DATE', 'USED_MEMBER_INFO', 'USED_SALE_TRAN_ID'], 'safe'],
            [['VOUCHER_CAMPAIGN_ID', 'POS_ID', 'DISCOUNT_TYPE', 'IS_ALL_ITEM', 'STATUS', 'AFFILIATE_ID', 'AFFILIATE_DISCOUNT_TYPE', 'USED_POS_ID'], 'integer'],
            [['AMOUNT_ORDER_OVER', 'DISCOUNT_AMOUNT', 'DISCOUNT_EXTRA', 'AFFILIATE_DISCOUNT_AMOUNT', 'AFFILIATE_DISCOUNT_EXTRA', 'AFFILIATE_USED_TOTAL_AMOUNT', 'USED_DISCOUNT_AMOUNT', 'USED_BILL_AMOUNT'], 'number'],
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
        $query = Dmvoucherlog::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
      /*  echo '<pre>';
        var_dump($this);
        echo '</pre>';*/
//        die();

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }



        if($this->USED_DATE){
            //$query->andFilterWhere(['DATE(USED_DATE)' => 'DATE(DATE_START)']);
            $query->where('DATE(USED_DATE) = DATE(DATE_START)');
        }

        $type = \Yii::$app->session->get('type_acc');
        $posparent = \Yii::$app->session->get('pos_parent');
        if($type == 1){
            $query->andFilterWhere([
                'POS_PARENT'=> $this->POS_PARENT,
                'STATUS'=> $this->STATUS
            ]);
        }else{
            $query->andFilterWhere([
                'POS_PARENT' => $posparent,
                'STATUS' => 2, // Lấy các Voucher đã sử dụng
            ]);
        }


        if($this->VOUCHER_CAMPAIGN_ID){
            $query->andFilterWhere(['VOUCHER_CAMPAIGN_ID' => (int)$this->VOUCHER_CAMPAIGN_ID]);
        }
        if($this->USED_POS_ID){
            $query->andFilterWhere(['USED_POS_ID' => $this->USED_POS_ID]);
        }



        $query->andFilterWhere([
            'VOUCHER_CAMPAIGN_ID' => $this->VOUCHER_CAMPAIGN_ID,
            'POS_ID' => $this->POS_ID,

            'DATE_CREATED' => $this->DATE_CREATED,
            'DATE_START' => $this->DATE_START,
            'DATE_END' => $this->DATE_END,
            'AMOUNT_ORDER_OVER' => $this->AMOUNT_ORDER_OVER,
            'DISCOUNT_TYPE' => $this->DISCOUNT_TYPE,
            'DISCOUNT_AMOUNT' => $this->DISCOUNT_AMOUNT,
            'DISCOUNT_EXTRA' => $this->DISCOUNT_EXTRA,
            'IS_ALL_ITEM' => $this->IS_ALL_ITEM,
            'AFFILIATE_ID' => $this->AFFILIATE_ID,
            'AFFILIATE_DISCOUNT_TYPE' => $this->AFFILIATE_DISCOUNT_TYPE,
            'AFFILIATE_DISCOUNT_AMOUNT' => $this->AFFILIATE_DISCOUNT_AMOUNT,
            'AFFILIATE_DISCOUNT_EXTRA' => $this->AFFILIATE_DISCOUNT_EXTRA,
            'AFFILIATE_USED_TOTAL_AMOUNT' => $this->AFFILIATE_USED_TOTAL_AMOUNT,
            'USED_DISCOUNT_AMOUNT' => $this->USED_DISCOUNT_AMOUNT,
            'USED_BILL_AMOUNT' => $this->USED_BILL_AMOUNT,
//            'USED_POS_ID' => $this->USED_POS_ID,
        ]);

        $query->andFilterWhere(['like', 'VOUCHER_CODE', $this->VOUCHER_CODE])
            ->andFilterWhere(['like', 'VOUCHER_CAMPAIGN_NAME', $this->VOUCHER_CAMPAIGN_NAME])
            ->andFilterWhere(['like', 'VOUCHER_DESCRIPTION', $this->VOUCHER_DESCRIPTION])
            ->andFilterWhere(['like', 'DATE_HASH', $this->DATE_HASH])
            ->andFilterWhere(['like', 'ITEM_TYPE_ID_LIST', $this->ITEM_TYPE_ID_LIST])
            ->andFilterWhere(['like', 'BUYER_INFO', $this->BUYER_INFO])
            ->andFilterWhere(['like', 'USED_MEMBER_INFO', $this->USED_MEMBER_INFO])
            ->andFilterWhere(['like', 'USED_SALE_TRAN_ID', $this->USED_SALE_TRAN_ID])
            ->orderBy(['DATE_CREATED' => SORT_DESC]);
        ;
//        var_dump($query->createCommand()->sql);
//        die();

        return $dataProvider;
    }
    public function searchReport($params)
    {
        $query = Dmvoucherlog::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
      /*  echo '<pre>';
        var_dump($this);
        echo '</pre>';*/
//        die();

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }



        $query->select('USED_POS_ID,COUNT(*) AS COUNT_BILL,SUM(USED_DISCOUNT_AMOUNT) AS SUM_DISCOUNT_AMOUNT,SUM(USED_BILL_AMOUNT) AS SUM_USED_BILL_AMOUNT ,AVG(USED_DISCOUNT_AMOUNT) AS AVG_USED_DISCOUNT_AMOUNT,AVG(USED_BILL_AMOUNT) AS AVG_USED_BILL_AMOUNT');

        if($this->USED_DATE){
            //$query->andFilterWhere(['DATE(USED_DATE)' => 'DATE(DATE_START)']);
            $query->where('DATE(USED_DATE) = DATE(DATE_START)');
        }

        if($this->DATE_HASH){
            $dateArr = explode(' - ', $this->DATE_HASH);
            $date_start_tmp = str_replace('/', '-', $dateArr[0]);
            $start_date = date("Y-m-d H:i:s", strtotime($date_start_tmp));
            $date_end_tmp = str_replace('/', '-', $dateArr[1]);
            $end_date = date("Y-m-d 23:59:59", strtotime($date_end_tmp));
            $query->andWhere(['between','USED_DATE',$start_date,$end_date]);
        }

        $posparent = \Yii::$app->session->get('pos_parent');
        $query->andFilterWhere([
            'POS_PARENT' => $posparent,
            'STATUS' => 2, // Lấy các Voucher đã sử dụng
        ]);


        if($this->VOUCHER_CAMPAIGN_ID){
            $query->andFilterWhere(['VOUCHER_CAMPAIGN_ID' => (int)$this->VOUCHER_CAMPAIGN_ID]);
        }
        if($this->USED_POS_ID){
            $query->andFilterWhere(['USED_POS_ID' => $this->USED_POS_ID]);
        }

        $query->andFilterWhere([
            'VOUCHER_CAMPAIGN_ID' => $this->VOUCHER_CAMPAIGN_ID,
            'DATE_CREATED' => $this->DATE_CREATED,
            'DATE_START' => $this->DATE_START,
            'DATE_END' => $this->DATE_END,
//            'USED_POS_ID' => $this->USED_POS_ID,
        ]);

        $query->andFilterWhere(['=', 'VOUCHER_CODE', $this->VOUCHER_CODE])
            ->orderBy(['DATE_CREATED' => SORT_DESC])->groupBy('USED_POS_ID');

        $query->all();


        return $dataProvider;
    }

    public function searchReportVoucher($pram){
        $this->load($pram);
        $data = Dmvoucherlog::find()
            ->select('USED_POS_ID,COUNT(*) AS COUNT_BILL,SUM(USED_DISCOUNT_AMOUNT) AS SUM_DISCOUNT_AMOUNT,SUM(USED_BILL_AMOUNT) AS SUM_USED_BILL_AMOUNT ,AVG(USED_DISCOUNT_AMOUNT) AS AVG_USED_DISCOUNT_AMOUNT,AVG(USED_BILL_AMOUNT) AS AVG_USED_BILL_AMOUNT')
//            ->where(['VOUCHER_CODE'=> $this->VOUCHER_CODE])
//            ->andWhere(['POS_PARENT'=> Yii::$app->session->get('pos_parent')])
            ->orderBy(['DATE_CREATED' => SORT_DESC])->groupBy('USED_POS_ID')->all();
        return $data;
    }

    public function searchCheckvoucher($pram){
        $this->load($pram);
        $data = Dmvoucherlog::find()
            ->where(['VOUCHER_CODE'=> $this->VOUCHER_CODE])
            ->andWhere(['POS_PARENT'=> Yii::$app->session->get('pos_parent')])
            //->asArray()
            ->one();
        return $data;
    }

    public function searchCheckWithCode($vouchercode){
        $data = Dmvoucherlog::find()
            ->where(['VOUCHER_CODE'=> $vouchercode])
            ->andWhere(['POS_PARENT'=> Yii::$app->session->get('pos_parent')])
            //->asArray()
            ->one();
        return $data;
    }

    public function searchCheckvoucher1($params)
    {
        $query = Dmvoucherlog::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
      /*  echo '<pre>';
        var_dump($this);
        echo '</pre>';*/
//        die();

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if($this->USED_DATE){
            //$query->andFilterWhere(['DATE(USED_DATE)' => 'DATE(DATE_START)']);
            $query->where('DATE(USED_DATE) = DATE(DATE_START)');
        }

        $type = \Yii::$app->session->get('type_acc');
        $posparent = \Yii::$app->session->get('pos_parent');
        if($type == 1){
            $query->andFilterWhere([
                'POS_PARENT'=> $this->POS_PARENT,
                'STATUS'=> $this->STATUS
            ]);
        }else{
            $query->andFilterWhere([
                'POS_PARENT' => $posparent,
                'STATUS' => 2, // Lấy các Voucher đã sử dụng
            ]);
        }


        if($this->VOUCHER_CAMPAIGN_ID){
            $query->andFilterWhere(['VOUCHER_CAMPAIGN_ID' => (int)$this->VOUCHER_CAMPAIGN_ID]);
        }
        if($this->USED_POS_ID){
            $query->andFilterWhere(['USED_POS_ID' => $this->USED_POS_ID]);
        }



        $query->andFilterWhere([
            'VOUCHER_CAMPAIGN_ID' => $this->VOUCHER_CAMPAIGN_ID,
            'POS_ID' => $this->POS_ID,

            'DATE_CREATED' => $this->DATE_CREATED,
            'DATE_START' => $this->DATE_START,
            'DATE_END' => $this->DATE_END,
            'AMOUNT_ORDER_OVER' => $this->AMOUNT_ORDER_OVER,
            'DISCOUNT_TYPE' => $this->DISCOUNT_TYPE,
            'DISCOUNT_AMOUNT' => $this->DISCOUNT_AMOUNT,
            'DISCOUNT_EXTRA' => $this->DISCOUNT_EXTRA,
            'IS_ALL_ITEM' => $this->IS_ALL_ITEM,
            'AFFILIATE_ID' => $this->AFFILIATE_ID,
            'AFFILIATE_DISCOUNT_TYPE' => $this->AFFILIATE_DISCOUNT_TYPE,
            'AFFILIATE_DISCOUNT_AMOUNT' => $this->AFFILIATE_DISCOUNT_AMOUNT,
            'AFFILIATE_DISCOUNT_EXTRA' => $this->AFFILIATE_DISCOUNT_EXTRA,
            'AFFILIATE_USED_TOTAL_AMOUNT' => $this->AFFILIATE_USED_TOTAL_AMOUNT,
            'USED_DISCOUNT_AMOUNT' => $this->USED_DISCOUNT_AMOUNT,
            'USED_BILL_AMOUNT' => $this->USED_BILL_AMOUNT,
//            'USED_POS_ID' => $this->USED_POS_ID,
        ]);

        $query->andFilterWhere(['=', 'VOUCHER_CODE', $this->VOUCHER_CODE])
            ->andFilterWhere(['like', 'VOUCHER_CAMPAIGN_NAME', $this->VOUCHER_CAMPAIGN_NAME])
            ->andFilterWhere(['like', 'VOUCHER_DESCRIPTION', $this->VOUCHER_DESCRIPTION])
            ->andFilterWhere(['like', 'ITEM_TYPE_ID_LIST', $this->ITEM_TYPE_ID_LIST])
            ->andFilterWhere(['like', 'BUYER_INFO', $this->BUYER_INFO])
            ->andFilterWhere(['like', 'USED_MEMBER_INFO', $this->USED_MEMBER_INFO])
            ->andFilterWhere(['like', 'USED_SALE_TRAN_ID', $this->USED_SALE_TRAN_ID])
            ->orderBy(['DATE_CREATED' => SORT_DESC]);
        ;
//        var_dump($query->createCommand()->sql);
//        die();

        return $dataProvider;
    }

}
