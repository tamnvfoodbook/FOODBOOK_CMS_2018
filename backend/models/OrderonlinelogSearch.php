<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\mongodb\Query;
use backend\models\Orderonlinelog;

/**
 * OrderonlinelogSearch represents the model behind the search form about `backend\models\Orderonlinelog`.
 */
class OrderonlinelogSearch extends Orderonlinelog
{
    /**
     * @inheritdoc
     */
    public $pos;
    public $memberaddresslist;

    public function rules()
    {
        return [
            [['_id', 'foodbook_code', 'coupon_log_id', 'pos_id', 'order_data_item', 'pos_workstation', 'user_id', 'duration', 'user_phone', 'isFromFoodbook', 'to_address', 'address_id', 'username', 'status', 'ahamove_code', 'supplier_id', 'supplier_name', 'shared_link', 'distance', 'total_fee', 'note', 'payment_method', 'payment_info', 'created_at', 'updated_at'], 'safe'],
            [['memberaddresslist','ship_price_real','orders_purpose','province','district','manager_id','created_by'], 'safe'],
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
    public function search($params,$ids = NULL,$posParent = NULL)
    {
        $query = Orderonlinelog::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->with('pos');
        $query->with('memberaddresslist');
        //$query->with('typeorder');

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

        //date_default_timezone_set('Asia/Bangkok');
        $dateTime = new \DateTime("00:00:00");
        //$dateTime->sub(new \DateInterval("P1D"));
        $DAY = $dateTime->format( \DateTime::ISO8601 );
        $today = new \MongoDate(strtotime($DAY));

        $type = \Yii::$app->session->get('type_acc');

        if($type == 3){
            //$ids = $searchPosModel->getIds();
            //$order = $searchModel->searchAllOrderTodayById($ids);
        }elseif($type == 2){
            $posParent = \Yii::$app->session->get('pos_parent');
//            echo '<pre>';
//            var_dump($posParent);
//            echo '</pre>';
            $query->where(['pos_parent' => $posParent]);
        }elseif($type == 1){
            //$query->andWhere(['$nin', 'status', ['COMPLETED','FAILED','CANCELLED','RES_DELIVERY']]);
        }

        $query
            //->where(['isCallCenterConfirmed' => 0,'status' => 'CANCELLED'])
            //->where('isCallCenterConfirmed != :isCallCenterConfirmed and status != :status', ['isCallCenterConfirmed'=>0, 'status'=>'CANCELLED'])
            //->where(['NOT','isCallCenterConfirmed','0'])
            //->andWhere(['NOT','status','CANCELLED'])
            //->where(['AND', ['NOT','isCallCenterConfirmed','0'], ['NOT','status','CANCELLED']])
//            ->andWhere(['$nin', 'created_by', ['IPOS_MOBILE_MANAGER_IOS','IPCC_ANDROID']])
            //->andWhere(['$nin', 'status', ['COMPLETED','FAILED','CANCELLED','RES_DELIVERY']])
            ->andWhere(['status' => 'WAIT_CONFIRM'])
            ->andFilterWhere(['$gte','created_at', $today])
            //->andFilterWhere(['like', '_id', $this->_id])
            //->andFilterWhere(['like', 'foodbook_code', $this->foodbook_code])
            ->andFilterWhere(['=', 'coupon_log_id', $this->coupon_log_id])
            ////->andFilterWhere(['like', 'pos_id', $this->pos_id])
            //->andFilterWhere(['like', 'order_data_item', $this->order_data_item])
            //->andFilterWhere(['like', 'pos_workstation', $this->pos_workstation])
            ->andFilterWhere(['=', 'user_id', $this->user_id])
            ->andFilterWhere(['=', 'duration', $this->duration])
            ->andFilterWhere(['=', 'user_phone', $this->user_phone])
            ->andFilterWhere(['=', 'isFromFoodbook', $this->isFromFoodbook])
            ->andFilterWhere(['=', 'to_address', $this->to_address])
            ->andFilterWhere(['=', 'address_id', $this->address_id])
            ->andFilterWhere(['=', 'username', $this->username])
            ->andFilterWhere(['=', 'status', $this->status])
            ->andFilterWhere(['=', 'ahamove_code', $this->ahamove_code])
            ->andFilterWhere(['=', 'supplier_id', $this->supplier_id])
            ->andFilterWhere(['=', 'supplier_name', $this->supplier_name])
            ->andFilterWhere(['=', 'shared_link', $this->shared_link])
            ->andFilterWhere(['=', 'distance', $this->distance])
            ->andFilterWhere(['=', 'total_fee', $this->total_fee])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['=', 'payment_method', $this->payment_method])
            ->andFilterWhere(['=', 'payment_info', $this->payment_info])
            ->andFilterWhere(['=', 'created_at', $this->created_at])

            ->andFilterWhere(['=', 'updated_at', $this->updated_at])
            ->andFilterWhere(['=', 'DM_POS.POS_NAME', $this->pos])
            ->orderBy(['created_at' => SORT_DESC])
        ;

        if($ids){
            $query->andFilterWhere(['pos_id' => $ids]);
        }

        return $dataProvider;
    }


    public function searchStatic($params,$ids = NULL,$posParent = NULL)
    {
        $query = Orderonlinelog::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->with('pos');
        $query->with('memberaddresslist');
        //$query->with('typeorder');

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        $dateTime = new \DateTime("00:00:00");
        //$dateTime->sub(new \DateInterval("P1D"));
        $DAY = $dateTime->format( \DateTime::ISO8601 );

        $today = new \MongoDate(strtotime($DAY));

        $query
            //->where(['isCallCenterConfirmed' => 0,'status' => 'CANCELLED'])
            //->where('isCallCenterConfirmed != :isCallCenterConfirmed and status != :status', ['isCallCenterConfirmed'=>0, 'status'=>'CANCELLED'])
            //->where(['NOT','isCallCenterConfirmed','0'])
            //->andWhere(['NOT','status','CANCELLED'])
            //->where(['AND', ['NOT','isCallCenterConfirmed','0'], ['NOT','status','CANCELLED']])

            //->where(['$nin', 'status', ['COMPLETED','FAILED','CANCELLED']])
            ->where(['$in', 'status', ['CANCELLED','RES_DELIVERY','AHA_CANCELLED']])
//            ->andFilterWhere(['$gte','created_at', $today])
//            ->andFilterWhere(['$gte','updated_at', $today])
            //->andFilterWhere(['like', '_id', $this->_id])
            //->andFilterWhere(['like', 'foodbook_code', $this->foodbook_code])
            ->andFilterWhere(['=', 'coupon_log_id', $this->coupon_log_id])
            ////->andFilterWhere(['like', 'pos_id', $this->pos_id])
            //->andFilterWhere(['like', 'order_data_item', $this->order_data_item])
            ->andFilterWhere(['=', 'user_id', $this->user_id])
            ->andFilterWhere(['=', 'duration', $this->duration])
            ->andFilterWhere(['=', 'user_phone', $this->user_phone])
            ->andFilterWhere(['=', 'isFromFoodbook', $this->isFromFoodbook])
            ->andFilterWhere(['=', 'to_address', $this->to_address])
            ->andFilterWhere(['=', 'address_id', $this->address_id])
            ->andFilterWhere(['=', 'username', $this->username])
            ->andFilterWhere(['=', 'status', $this->status])

            ->andFilterWhere(['like', 'ahamove_code', $this->ahamove_code])
            ->andFilterWhere(['like', 'supplier_id', $this->supplier_id])
            ->andFilterWhere(['like', 'supplier_name', $this->supplier_name])
            ->andFilterWhere(['like', 'shared_link', $this->shared_link])
            ->andFilterWhere(['like', 'distance', $this->distance])
            ->andFilterWhere(['like', 'total_fee', $this->total_fee])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'payment_method', $this->payment_method])
            ->andFilterWhere(['like', 'payment_info', $this->payment_info])
            ->andFilterWhere(['like', 'created_at', $this->created_at])

            ->andFilterWhere(['like', 'updated_at', $this->updated_at])
            ->andFilterWhere(['like', 'DM_POS.POS_NAME', $this->pos])
            ->orderBy(['created_at' => SORT_DESC])
        ;

        if($ids){
            $query->andFilterWhere(['pos_id' => $ids]);
        }

        return $dataProvider;
    }

    public function searchByMember($params,$userId = NULL)
    {
        $query = Orderonlinelog::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->with('pos');
        $query->with('memberaddresslist');
        //$query->with('typeorder');

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

//        date_default_timezone_set('Asia/Bangkok');
//        $dateTime = new \DateTime("00:00:00");
//        $dateTime->sub(new \DateInterval("P1D"));
//        $DAY = $dateTime->format( \DateTime::ISO8601 );
//        $today = new \MongoDate(strtotime($DAY));

        $query
            //->where(['$nin', 'status', ['COMPLETED','FAILED','CANCELLED']])
            //->andFilterWhere(['$gte','created_at', $today])
            ->andFilterWhere(['like', '_id', $this->_id])
            //->andFilterWhere(['like', 'foodbook_code', $this->foodbook_code])
            ->andFilterWhere(['like', 'coupon_log_id', $this->coupon_log_id])
            ////->andFilterWhere(['like', 'pos_id', $this->pos_id])
            ->andFilterWhere(['like', 'order_data_item', $this->order_data_item])
            ->andFilterWhere(['like', 'pos_workstation', $this->pos_workstation])
            //->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'duration', $this->duration])
            ->andFilterWhere(['like', 'user_phone', $this->user_phone])
            ->andFilterWhere(['like', 'isFromFoodbook', $this->isFromFoodbook])
            ->andFilterWhere(['like', 'to_address', $this->to_address])
            ->andFilterWhere(['like', 'address_id', $this->address_id])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'ahamove_code', $this->ahamove_code])
            ->andFilterWhere(['like', 'supplier_id', $this->supplier_id])
            ->andFilterWhere(['like', 'supplier_name', $this->supplier_name])
            ->andFilterWhere(['like', 'shared_link', $this->shared_link])
            ->andFilterWhere(['like', 'distance', $this->distance])
            ->andFilterWhere(['like', 'total_fee', $this->total_fee])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'payment_method', $this->payment_method])
            ->andFilterWhere(['like', 'payment_info', $this->payment_info])
            ->andFilterWhere(['like', 'created_at', $this->created_at])

            ->andFilterWhere(['like', 'updated_at', $this->updated_at])
            ->andFilterWhere(['like', 'DM_POS.POS_NAME', $this->pos])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(1)
        ;

        if($userId){
            $query->andFilterWhere(['user_id' => (int)$userId]);
        }

        return $dataProvider;
    }


    public function searchCancel($params)
    {
        $query = Orderonlinelog::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->with('pos');
        $query->with('memberaddresslist');

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

        date_default_timezone_set('Asia/Bangkok');
        $dateTime = new \DateTime("00:00:00");
        $dateTime->sub(new \DateInterval("P1D"));
        $DAY = $dateTime->format( \DateTime::ISO8601 );
        $today = new \MongoDate(strtotime($DAY));
//        echo '<pre>';
//        var_dump($dateTime);
//        var_dump($today);
//        var_dump(date('d-m-Y h:i:s',$today->sec));
//        echo '</pre>';
        //die();

        $query
            //->where(['isCallCenterConfirmed' => 0,'status' => 'CANCELLED'])
            //->where('isCallCenterConfirmed != :isCallCenterConfirmed and status != :status', ['isCallCenterConfirmed'=>0, 'status'=>'CANCELLED'])
            //->where(['NOT','isCallCenterConfirmed','0'])
            //->andWhere(['NOT','status','CANCELLED'])
            //->where(['AND', ['NOT','isCallCenterConfirmed','0'], ['NOT','status','CANCELLED']])

            ->where(['$nin', 'status', ['COMPLETED','FAILED']])
            ->andFilterWhere(['$gte','created_at', $today])
            ->andFilterWhere(['like', '_id', $this->_id])
            ->andFilterWhere(['like', 'foodbook_code', $this->foodbook_code])
            ->andFilterWhere(['like', 'coupon_log_id', $this->coupon_log_id])
            ->andFilterWhere(['like', 'pos_id', $this->pos_id])
            ->andFilterWhere(['like', 'order_data_item', $this->order_data_item])
            ->andFilterWhere(['like', 'pos_workstation', $this->pos_workstation])
            ->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'duration', $this->duration])
            ->andFilterWhere(['like', 'user_phone', $this->user_phone])
            ->andFilterWhere(['like', 'isFromFoodbook', $this->isFromFoodbook])
            ->andFilterWhere(['like', 'to_address', $this->to_address])
            ->andFilterWhere(['like', 'address_id', $this->address_id])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'status', $this->status])

            ->andFilterWhere(['like', 'status', 'CANCELLED'])
            //->andWhere(['NOT', 'status', 'FAILED'])
//            ->orWhere(['like', 'status', 'CANCELLED'])
//            ->orWhere(['like','isCallCenterConfirmed','1'])

            ->andFilterWhere(['like', 'ahamove_code', $this->ahamove_code])
            ->andFilterWhere(['like', 'supplier_id', $this->supplier_id])
            ->andFilterWhere(['like', 'supplier_name', $this->supplier_name])
            ->andFilterWhere(['like', 'shared_link', $this->shared_link])
            ->andFilterWhere(['like', 'distance', $this->distance])
            ->andFilterWhere(['like', 'total_fee', $this->total_fee])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'payment_method', $this->payment_method])
            ->andFilterWhere(['like', 'payment_info', $this->payment_info])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            //->andWhere(['$gte','created_at', $today])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at])
            ->andFilterWhere(['like', 'DM_POS.POS_NAME', $this->pos])
            ->orderBy(['created_at' => SORT_DESC])
        ;

        return $dataProvider;
    }



    public function searchAllorder($params)
    {
        $query = Orderonlinelog::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->with('pos');
        $query->with('memberaddresslist');

        $dataProvider->sort->attributes['pos'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['DM_POS.POS_NAME' => SORT_ASC],
            'desc' => ['DM_POS.POS_NAME' => SORT_DESC],
        ];


        $this->load($params);

        if($this->pos_id){
            $this->pos_id = intval($this->pos_id);
        }
        if($this->user_id){
            $this->user_id = intval($this->user_id);
        }

        if($this->isFromFoodbook != NULL){
            $this->isFromFoodbook = (int)$this->isFromFoodbook;
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        date_default_timezone_set('Asia/Bangkok');

        $query
            ->andFilterWhere(['like', '_id', $this->_id])
            ->andFilterWhere(['like', 'foodbook_code', $this->foodbook_code])
            ->andFilterWhere(['like', 'coupon_log_id', $this->coupon_log_id])
            ->andFilterWhere(['like', 'order_data_item', $this->order_data_item])
            ->andFilterWhere(['like', 'pos_workstation', $this->pos_workstation])
            //->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['user_id' => $this->user_id])
            ->andFilterWhere(['like', 'duration', $this->duration])
            ->andFilterWhere(['like', 'user_phone', $this->user_phone])
            ->andFilterWhere(['isFromFoodbook' => $this->isFromFoodbook])
            ->andFilterWhere(['like', 'to_address', $this->to_address])
            ->andFilterWhere(['like', 'address_id', $this->address_id])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'status', $this->status])

            ->andFilterWhere(['like', 'ahamove_code', $this->ahamove_code])
            ->andFilterWhere(['like', 'supplier_id', $this->supplier_id])
            ->andFilterWhere(['like', 'supplier_name', $this->supplier_name])
            ->andFilterWhere(['like', 'shared_link', $this->shared_link])
            ->andFilterWhere(['like', 'distance', $this->distance])
            ->andFilterWhere(['like', 'total_fee', $this->total_fee])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'payment_method', $this->payment_method])
            ->andFilterWhere(['like', 'payment_info', $this->payment_info])
            //->andFilterWhere(['like', 'created_at', $this->created_at])
            //->andWhere(['$gte','created_at', $today])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at])

            ->andFilterWhere(['pos_id' => $this->pos_id])
            ->orderBy(['created_at' => SORT_DESC])
        ;

        if ( ! is_null($this->created_at) && strpos($this->created_at, ' - ') !== false ) {
            list($start_date, $end_date) = explode(' - ', $this->created_at);
            $start = new \MongoDate(strtotime($start_date));

            $end_date = new \DateTime($end_date);
            $end_date->add(new \DateInterval('P1D')); // Cộng thêm 1 ngày vào ngày cuối cùng để đảm bảo tới 24 giờ của ngày
            $end_date = $end_date->format( \DateTime::ISO8601 );
            $end = new \MongoDate(strtotime($end_date));
            $query->andFilterWhere(['between', 'created_at', $start, $end]);
            //$this->created_at = null;
        }

        return $dataProvider;
    }
    public function searchWaitorder($params)
    {
        $query = Orderonlinelog::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->with('pos');
        $query->with('memberaddresslist');

        $dataProvider->sort->attributes['pos'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['DM_POS.POS_NAME' => SORT_ASC],
            'desc' => ['DM_POS.POS_NAME' => SORT_DESC],
        ];


        $this->load($params);

        if($this->pos_id){
            $this->pos_id = intval($this->pos_id);
        }
        if($this->user_id){
            $this->user_id = intval($this->user_id);
        }

        if($this->isFromFoodbook != NULL){
            $this->isFromFoodbook = (int)$this->isFromFoodbook;
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $dateTime = new \DateTime();
        $dateTime->sub(new \DateInterval("PT0H5M0S"));
        $DAY = $dateTime->format( \DateTime::ISO8601 );
        $today = new \MongoDate(strtotime($DAY));


        $start_date = date('m/d/Y',strtotime("-2 day"));
        $end_date = date('m/d/Y',strtotime("+1 day"));
        $start = new \MongoDate(strtotime($start_date));
        $end = new \MongoDate(strtotime($end_date));

        $query->where(['between', 'created_at', $start, $end]);


        $query
            ->where(['status' => 'WAIT_CONFIRM'])
            //->andWhere(['$lte','created_at', $today])
            ->andWhere(['between', 'created_at', $start, $end])
            ->andFilterWhere(['like', '_id', $this->_id])
            ->andFilterWhere(['like', 'foodbook_code', $this->foodbook_code])
            ->andFilterWhere(['like', 'coupon_log_id', $this->coupon_log_id])
            ->andFilterWhere(['like', 'order_data_item', $this->order_data_item])
            ->andFilterWhere(['like', 'pos_workstation', $this->pos_workstation])
            //->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['user_id' => $this->user_id])
            ->andFilterWhere(['like', 'duration', $this->duration])
            ->andFilterWhere(['like', 'user_phone', $this->user_phone])
            ->andFilterWhere(['isFromFoodbook' => $this->isFromFoodbook])
            ->andFilterWhere(['like', 'to_address', $this->to_address])
            ->andFilterWhere(['like', 'address_id', $this->address_id])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'status', $this->status])

            ->andFilterWhere(['like', 'ahamove_code', $this->ahamove_code])
            ->andFilterWhere(['like', 'supplier_id', $this->supplier_id])
            ->andFilterWhere(['like', 'supplier_name', $this->supplier_name])
            ->andFilterWhere(['like', 'shared_link', $this->shared_link])
            ->andFilterWhere(['like', 'distance', $this->distance])
            ->andFilterWhere(['like', 'total_fee', $this->total_fee])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'payment_method', $this->payment_method])
            ->andFilterWhere(['like', 'payment_info', $this->payment_info])
            //->andFilterWhere(['like', 'created_at', $this->created_at])
            //->andWhere(['$gte','created_at', $today])
            //->andFilterWhere(['like', 'updated_at', $this->updated_at])
            ->andFilterWhere(['pos_id' => $this->pos_id])
            ->orderBy(['created_at' => SORT_DESC])
        ;


//            $end_date = new \DateTime($this->created_at);
//            $end_date->add(new \DateInterval('P1D')); // Cộng thêm 1 ngày vào ngày cuối cùng để đảm bảo tới 24 giờ của ngày
//            $end_date = $end_date->format( \DateTime::ISO8601 );

//        echo '<pre>';
//        var_dump($this->created_at);
//        var_dump($this->updated_at);
//        var_dump($end_date);
//        echo '</pre>';
        //die();
            //$end = new \MongoDate(strtotime($end_date));
            //$query->andFilterWhere(['>', 'created_at', $end]);
            //$this->created_at = null;

//        if ( ! is_null($this->created_at) && strpos($this->created_at, ' - ') !== false ) {
//            list($start_date, $end_date) = explode(' - ', $this->created_at);
//            $start = new \MongoDate(strtotime($start_date));
//
//            $end_date = new \DateTime($end_date);
//            $end_date->add(new \DateInterval('P1D')); // Cộng thêm 1 ngày vào ngày cuối cùng để đảm bảo tới 24 giờ của ngày
//            $end_date = $end_date->format( \DateTime::ISO8601 );
//            $end = new \MongoDate(strtotime($end_date));
//            $query->andFilterWhere(['between', 'created_at', $start, $end]);
//            //$this->created_at = null;
//        }
        return $dataProvider;
    }


    public function searchAllorderbypos($params,$ids,$dateRanger)
    {
        date_default_timezone_set('Asia/Bangkok');
        $query = Orderonlinelog::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $this->load($params);


        if($this->user_id){
            $this->user_id = intval($this->user_id);
        }


        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        if($this->isFromFoodbook != NULL){
            $this->isFromFoodbook = (int)$this->isFromFoodbook;
        }


        if($this->pos_id){
            $query->andFilterWhere(['pos_id' => intval($this->pos_id)]);
        }else{
            $query->andFilterWhere(['pos_id' => $ids]);
        }

        $query
            ->andFilterWhere(['like', '_id', $this->_id])
            ->andFilterWhere(['like', 'foodbook_code', $this->foodbook_code])
            ->andFilterWhere(['like', 'coupon_log_id', $this->coupon_log_id])
            ->andFilterWhere(['like', 'order_data_item', $this->order_data_item])
//            ->andFilterWhere(['like', 'pos_workstation', $this->pos_workstation])
            //->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['user_id' => $this->user_id])
            ->andFilterWhere(['like', 'duration', $this->duration])
            ->andFilterWhere(['like', 'user_phone', $this->user_phone])
            ->andFilterWhere(['isFromFoodbook' => $this->isFromFoodbook])
            ->andFilterWhere(['like', 'to_address', $this->to_address])
            ->andFilterWhere(['like', 'address_id', $this->address_id])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'status', $this->status])

//            ->andFilterWhere(['like', 'ahamove_code', $this->ahamove_code])
//            ->andFilterWhere(['like', 'supplier_id', $this->supplier_id])
//            ->andFilterWhere(['like', 'supplier_name', $this->supplier_name])
//            ->andFilterWhere(['like', 'shared_link', $this->shared_link])
//            ->andFilterWhere(['like', 'distance', $this->distance])
            ->andFilterWhere(['like', 'total_fee', $this->total_fee])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'payment_method', $this->payment_method])
//            ->andFilterWhere(['like', 'payment_info', $this->payment_info])
            //->andFilterWhere(['like', 'created_at', $this->created_at])
            //->andWhere(['$gte','created_at', $today])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at])
            ->andFilterWhere(['=', 'province', $this->province])
            ->andFilterWhere(['=', 'created_by', $this->created_by])
            ->andFilterWhere(['=', 'district', $this->district])

//            ->andFilterWhere(['pos_id' => $this->pos_id])

            ->orderBy(['created_at' => SORT_DESC])
        ;

        if($this->orders_purpose){
            $query
                ->andFilterWhere(['orders_purpose' => (int)$this->orders_purpose]);
        }
        if($this->manager_id){
            $query
                ->andFilterWhere(['manager_id' => (int)$this->manager_id]);
        }

//        die();
        if ( ! is_null($dateRanger) && strpos($dateRanger, ' - ') !== false ){
            list($start_date, $end_date) = explode(' - ', $dateRanger);
            //$date_start_tmp = str_replace('/', '-', $start_date);
            //$start_date = date('m/d/Y',strtotime($start_date));

            //$date_end_tmp = str_replace('/', '-', $end_date);
            //$end_date = date('m/d/Y',strtotime($end_date));

            $startTmp = \DateTime::createFromFormat('d/m/Y', $start_date);
            $starDateTmp = $startTmp->format('Y-m-d'); // => 2013-12-24
            $start = new \MongoDate(strtotime($starDateTmp));

//            $end_date = new \DateTime($end_date);
//            $end_date->add(new \DateInterval('P1D')); // Cộng thêm 1 ngày vào ngày cuối cùng để đảm bảo tới 24 giờ của ngày
//            $end_date = $end_date->format( \DateTime::ISO8601 );
            $date = \DateTime::createFromFormat('d/m/Y', $end_date);
            $end_date = $date->format('Y-m-d 23:59:59'); // => 2013-12-24
            $end = new \MongoDate(strtotime($end_date));

//            echo '<pre>';
//            var_dump(date('Y-m-d',($start->sec)));
//            var_dump(date('Y-m-d H:i:s',($end->sec)));
//            echo '</pre>';

            $query->andFilterWhere(['between', 'created_at', $start, $end]);
            //$this->created_at = null;
        }

        return $dataProvider;
    }

    public function searchAllOrderbyTime($ids,$dateRanger){
        date_default_timezone_set('Asia/Bangkok');


            list($start_date, $end_date) = explode(' - ', $dateRanger);
            //$date_start_tmp = str_replace('/', '-', $start_date);
            //$start_date = date('m/d/Y',strtotime($start_date));

            //$date_end_tmp = str_replace('/', '-', $end_date);
            //$end_date = date('m/d/Y',strtotime($end_date));

            $startTmp = \DateTime::createFromFormat('d/m/Y', $start_date);
            $starDateTmp = $startTmp->format('Y-m-d'); // => 2013-12-24
            $start = new \MongoDate(strtotime($starDateTmp));

//            $end_date = new \DateTime($end_date);
//            $end_date->add(new \DateInterval('P1D')); // Cộng thêm 1 ngày vào ngày cuối cùng để đảm bảo tới 24 giờ của ngày
//            $end_date = $end_date->format( \DateTime::ISO8601 );
            $date = \DateTime::createFromFormat('d/m/Y', $end_date);
            $end_date = $date->format('Y-m-d 23:59:59'); // => 2013-12-24
            $end = new \MongoDate(strtotime($end_date));


        $oders = Orderonlinelog::find()
            ->where(['between', 'created_at', $start, $end])
            ->andWhere(['pos_id' => $ids])
//            ->asArray()
            ->all();
        return $oders;
    }

    public function reportAll($params,$ids,$dateRanger)
    {
        date_default_timezone_set('Asia/Bangkok');
        $query = Orderonlinelog::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $this->load($params);



        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        if($this->pos_id){
            $query->andFilterWhere(['pos_id' => intval($this->pos_id)]);
        }else{
            $query->andFilterWhere(['pos_id' => $ids]);
        }

        $query
            ->orderBy(['created_at' => SORT_DESC])
        ;


//        die();
        if ( ! is_null($dateRanger) && strpos($dateRanger, ' - ') !== false ){
            list($start_date, $end_date) = explode(' - ', $dateRanger);
            //$date_start_tmp = str_replace('/', '-', $start_date);
            //$start_date = date('m/d/Y',strtotime($start_date));

            //$date_end_tmp = str_replace('/', '-', $end_date);
            //$end_date = date('m/d/Y',strtotime($end_date));

            $startTmp = \DateTime::createFromFormat('d/m/Y', $start_date);
            $starDateTmp = $startTmp->format('Y-m-d'); // => 2013-12-24
            $start = new \MongoDate(strtotime($starDateTmp));

//            $end_date = new \DateTime($end_date);
//            $end_date->add(new \DateInterval('P1D')); // Cộng thêm 1 ngày vào ngày cuối cùng để đảm bảo tới 24 giờ của ngày
//            $end_date = $end_date->format( \DateTime::ISO8601 );
            $date = \DateTime::createFromFormat('d/m/Y', $end_date);
            $end_date = $date->format('Y-m-d 23:59:59'); // => 2013-12-24
            $end = new \MongoDate(strtotime($end_date));

//            echo '<pre>';
//            var_dump(date('Y-m-d',($start->sec)));
//            var_dump(date('Y-m-d H:i:s',($end->sec)));
//            echo '</pre>';

            $query->andFilterWhere(['between', 'created_at', $start, $end]);
            //$this->created_at = null;
        }


        return $dataProvider;
    }
    public function searchClausereport($field,$ids,$timeRanger)
    {
        list($start_date, $end_date) = explode(' - ', $timeRanger);
        $startTmp = \DateTime::createFromFormat('d/m/Y', $start_date);
        $starDateTmp = $startTmp->format('Y-m-d'); // => 2013-12-24
        $start = new \MongoDate(strtotime($starDateTmp));

        $date = \DateTime::createFromFormat('d/m/Y', $end_date);
        $end_date = $date->format('Y-m-d 23:59:59'); // => 2013-12-24
        $end = new \MongoDate(strtotime($end_date));
        //$this->created_at = null;

        $query = new Query;
        $data = $query->from('ORDER_ONLINE_LOG')
            ->where(['pos_id' => $ids])
            ->andWhere(['between', 'created_at', $start, $end])
            ->distinct($field);
        $result = array();
        foreach((array)$data as $value){
            $result[$value] = $value;
        }
        return $result;
    }


    public function checkNewOrder(){
        $type = \Yii::$app->session->get('type_acc');
        $dateTime = new \DateTime("00:00:00");
        //$dateTime->sub(new \DateInterval("P1D"));
        $DAY = $dateTime->format( \DateTime::ISO8601 );
        $today = new \MongoDate(strtotime($DAY));

        if($type != 1){
            $posModel = new DmposSearch();
            $posIds = $posModel->getIds();
            $booked = Orderonlinelog::find()
                ->where(['$gte','created_at', $today])
                ->andWhere(['pos_id' => $posIds])
                ->asArray()
                ->all();
        }else{
            $booked = Orderonlinelog::find()
                ->asArray()
                ->all();
        }

//        echo '<pre>';
//        var_dump($DAY);
//        var_dump($today);
//        var_dump($booked);
//        echo '</pre>';
//        die();

        $countOrder = 0;
        foreach($booked as $booking){
            $time = date(Yii::$app->params['DATE_TIME_FORMAT_2'],$booking['created_at']->sec);
            $nowTime = date(Yii::$app->params['DATE_TIME_FORMAT_2']);
            $secs = strtotime($nowTime) - strtotime($time);
            if($secs >= 0 && $secs<6){
                $countOrder++;
            }
        }

//        die();

        return $countOrder;
    }


    public function searchAllOrderToday(){
        date_default_timezone_set('Asia/Bangkok');
        $dateTime = new \DateTime("00:00:00");
        //$dateTime->sub(new \DateInterval("P1D"));
        $DAY = $dateTime->format( \DateTime::ISO8601 );
        $today = new \MongoDate(strtotime($DAY));
        $oders = Orderonlinelog::find()
            ->select(['_id','user_id','status'])
            ->where(['$gte','created_at', $today])
            ->asArray()
            ->all();
        return $oders;
    }
    public function searchOrderByCityName($city_name){
        $oders = Orderonlinelog::find()
            ->select(['_id','district'])
            ->where(['province' => $city_name])
            ->asArray()
            ->all();
        return $oders;
    }

    public function searchAllOrderTodayById($ids){
        date_default_timezone_set('Asia/Bangkok');
        $dateTime = new \DateTime("00:00:00");
        //$dateTime->sub(new \DateInterval("P1D"));
        $DAY = $dateTime->format( \DateTime::ISO8601 );
        $today = new \MongoDate(strtotime($DAY));

        $oders = Orderonlinelog::find()
            ->select(['_id','user_id','status','pos_id'])
            ->where(['pos_id' => $ids])
            ->andWhere(['$gte','created_at', $today])
            ->asArray()
            ->all();
        return $oders;
    }

    public function searchAllOrderByUserId($userId){
        $type = \Yii::$app->session->get('type_acc');
        if($type ==1){
            $oders = Orderonlinelog::find()
                ->where(['user_id' => (int)$userId])
                ->orderBy(['created_at' => SORT_DESC])
                ->asArray()
                ->all();
            return $oders;
        }else{
            $searchIdsPos = new DmposSearch();
            $ids = $searchIdsPos->getIds();
//            var_dump($ids);
//            die();
            $oders = Orderonlinelog::find()
                //->select(['_id','user_id','status','pos_id','created_at'])
                ->where(['user_id' => (int)$userId])
                ->andWhere(['pos_id' => $ids])
                ->orderBy(['created_at' => SORT_DESC])
                ->asArray()
                ->all();
            return $oders;
        }

    }


}
