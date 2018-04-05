<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Bookingonlinelog;

/**
 * BookingonlinelogSearch represents the model behind the search form about `backend\models\Bookingonlinelog`.
 */
class BookingonlinelogSearch extends Bookingonlinelog
{
    /**
     * @inheritdoc
     */

    public $pos;
    public $dmmembership;
    public $bookinginfo;


    public function rules()
    {
        return [
            [['_id', 'Foodbook_Code', 'Pos_Id', 'Pos_Workstation', 'User_Id', 'Book_Date', 'Hour', 'Minute', 'Number_People', 'Note', 'Status', 'Created_At', 'Updated_At','bookinginfo'], 'safe'],
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
    public function search($params,$dateRanger)
    {
        $query = Bookingonlinelog::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        if($this->Pos_Id){
            $this->Pos_Id = (int)$this->Pos_Id;
        }

        if($this->User_Id){
            $this->User_Id = (int)$this->User_Id;
        }
        $type = \Yii::$app->session->get('type_acc');

        if($type ==1){
            $query->andFilterWhere(['like', '_id', $this->_id])
                ->andFilterWhere(['like', 'Foodbook_Code', $this->Foodbook_Code])
                ->andFilterWhere(['Pos_Id' => $this->Pos_Id])
                ->andFilterWhere(['like', 'Pos_Workstation', $this->Pos_Workstation])
                ->andFilterWhere(['User_Id'=> $this->User_Id])
                ->andFilterWhere(['like', 'Book_Date', $this->Book_Date])
                ->andFilterWhere(['like', 'Hour', $this->Hour])
                ->andFilterWhere(['like', 'Minute', $this->Minute])
                ->andFilterWhere(['like', 'Number_People', $this->Number_People])
                ->andFilterWhere(['like', 'Note', $this->Note])
                ->andFilterWhere(['like', 'Status', $this->Status])
                ->andFilterWhere(['like', 'Created_At', $this->Created_At])
                ->andFilterWhere(['like', 'Updated_At', $this->Updated_At])
                ->orderBy(['Created_At' => SORT_DESC])
            ;
        }else{

            $searchIdsPos = new DmposSearch();
            $ids = $searchIdsPos->getIds();

            $query->andFilterWhere(['like', '_id', $this->_id])
                ->andFilterWhere(['like', 'Foodbook_Code', $this->Foodbook_Code])
                //->andFilterWhere(['Pos_Id' => $ids])
                ->andFilterWhere(['like', 'Pos_Workstation', $this->Pos_Workstation])
                ->andFilterWhere(['User_Id'=> $this->User_Id])
                ->andFilterWhere(['like', 'Book_Date', $this->Book_Date])
                ->andFilterWhere(['like', 'Hour', $this->Hour])
                ->andFilterWhere(['like', 'Minute', $this->Minute])
                ->andFilterWhere(['like', 'Number_People', $this->Number_People])
                ->andFilterWhere(['like', 'Note', $this->Note])
                ->andFilterWhere(['like', 'Status', $this->Status])
                ->andFilterWhere(['like', 'Updated_At', $this->Updated_At])
                ->orderBy(['Created_At' => SORT_DESC])
            ;
            if(!$this->Pos_Id){
                $query->andFilterWhere(['Pos_Id' => $ids]);
            }else{
                $query->andFilterWhere(['Pos_Id' => $this->Pos_Id]);
            }
        }



        if ( ! is_null($dateRanger) && strpos($dateRanger, ' - ') !== false ){
            list($start_date, $end_date) = explode(' - ', $dateRanger);
            $startTmp = \DateTime::createFromFormat('d/m/Y', $start_date);
            $starDateTmp = $startTmp->format('Y-m-d'); // => 2013-12-24
            $start = new \MongoDate(strtotime($starDateTmp));

            $date = \DateTime::createFromFormat('d/m/Y', $end_date);
            $end_date = $date->format('Y-m-d 23:59:59'); // => 2013-12-24
            $end = new \MongoDate(strtotime($end_date));
            $query->andFilterWhere(['between', 'Created_At', $start, $end]);
        }

        return $dataProvider;
    }


    public function searchWait($params)
    {
        $query = Bookingonlinelog::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

//        $query->with('pos');
//
//        $dataProvider->sort->attributes['pos'] = [
//            // The tables are the ones our relation are configured to
//            // in my case they are prefixed with "tbl_"
//            'asc' => ['DM_POS.POS_NAME' => SORT_ASC],
//            'desc' => ['DM_POS.POS_NAME' => SORT_DESC],
//        ];
//
//        $query->with('dmmembership');
//
//        $dataProvider->sort->attributes['dmmembership'] = [
//            // The tables are the ones our relation are configured to
//            // in my case they are prefixed with "tbl_"
//            'asc' => ['DM_MEMBERSHIP.MEMBER_NAME' => SORT_ASC],
//            'desc' => ['DM_MEMBERSHIP.MEMBER_NAME' => SORT_DESC],
//        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        if($this->Pos_Id){
            $this->Pos_Id = (int)$this->Pos_Id;
        }

        if($this->User_Id){
            $this->User_Id = (int)$this->User_Id;
        }

        $type = \Yii::$app->session->get('type_acc');

        if($type ==1){

            $start_date = date('m/d/Y',strtotime("-2 day"));
            $end_date = date('m/d/Y',strtotime("+1 day"));
            $start = new \MongoDate(strtotime($start_date));
            $end = new \MongoDate(strtotime($end_date));

//            echo '<pre>';
//            var_dump($start_date);
//            var_dump($end_date);
//            echo '</pre>';
//            die();

//            $start = new \MongoDate(strtotime($start_date));
//            $end_date = new \DateTime($end_date);
//            $end_date->add(new \DateInterval('P1D')); // Cộng thêm 1 ngày vào ngày cuối cùng để đảm bảo tới 24 giờ của ngày
//            $end_date = $end_date->format( \DateTime::ISO8601 );
//            $end = new \MongoDate(strtotime($end_date));
            $query->where(['between', 'Created_At', $start, $end]);

            $query->andFilterWhere(['like', '_id', $this->_id])
                ->andFilterWhere(['like', 'Foodbook_Code', $this->Foodbook_Code])
                ->andFilterWhere(['Pos_Id' => $this->Pos_Id])
                ->andFilterWhere(['like', 'Pos_Workstation', $this->Pos_Workstation])
                ->andFilterWhere(['User_Id'=> $this->User_Id])
                ->andFilterWhere(['like', 'Book_Date', $this->Book_Date])
                ->andFilterWhere(['like', 'Hour', $this->Hour])
                ->andFilterWhere(['like', 'Minute', $this->Minute])
                ->andFilterWhere(['like', 'Number_People', $this->Number_People])
                ->andFilterWhere(['like', 'Note', $this->Note])
                ->andFilterWhere(['like', 'Status', $this->Status])
//                ->andFilterWhere(['like', 'Created_At', $this->Created_At])
                //->andFilterWhere(['between', 'DM_POS.CREATED_AT', $before2day, $today])
                ->andFilterWhere(['like', 'Updated_At', $this->Updated_At])
                ->orderBy(['Created_At' => SORT_DESC])
            ;


        }else{

            $searchIdsPos = new DmposSearch();
            $ids = $searchIdsPos->getIds();

            $query->andFilterWhere(['like', '_id', $this->_id])
                ->andFilterWhere(['=', 'Foodbook_Code', $this->Foodbook_Code])
                //->andFilterWhere(['Pos_Id' => $ids])
                //->andFilterWhere(['like', 'Pos_Workstation', $this->Pos_Workstation])
                ->andFilterWhere(['User_Id'=> $this->User_Id])
                ->andFilterWhere(['=', 'Book_Date', $this->Book_Date])
                ->andFilterWhere(['=', 'Hour', $this->Hour])
                ->andFilterWhere(['=', 'Minute', $this->Minute])
                ->andFilterWhere(['=', 'Number_People', $this->Number_People])
                ->andFilterWhere(['like', 'Note', $this->Note])
                ->andFilterWhere(['=', 'Status', $this->Status])
                ->andFilterWhere(['=', 'Created_At', $this->Created_At])
                ->andFilterWhere(['=', 'Updated_At', $this->Updated_At])
                ->orderBy(['Created_At' => SORT_DESC])
            ;
            if(!$this->Pos_Id){
                $query->andFilterWhere(['Pos_Id' => $ids]);
            }else{
                $query->andFilterWhere(['Pos_Id' => $this->Pos_Id]);
            }
        }

        return $dataProvider;
    }

    public function checkNewbooking(){
        $type = \Yii::$app->session->get('type_acc');
        $dateTime = new \DateTime("00:00:00");
        //$dateTime->sub(new \DateInterval("P1D"));
        $DAY = $dateTime->format( \DateTime::ISO8601 );
        $today = new \MongoDate(strtotime($DAY));

        if($type != 1){
            $posModel = new DmposSearch();
            $posIds = $posModel->getIds();
            $booked = Bookingonlinelog::find()
                ->where(['Status' => 'WAIT_CONFIRMED'])
                ->andFilterWhere(['$gte','Created_At', $today])
                ->andWhere(['Pos_Id' => $posIds])
                ->asArray()
                ->all();
        }else{
            $booked = Bookingonlinelog::find()
                ->where(['Status' => 'WAIT_CONFIRMED'])
                ->asArray()
                ->all();
        }

        $countBooking = 0;
        foreach($booked as $booking){
            $time = date(Yii::$app->params['DATE_TIME_FORMAT_2'],$booking['Created_At']->sec);
            $nowTime = date(Yii::$app->params['DATE_TIME_FORMAT_2']);
            $secs = strtotime($nowTime) - strtotime($time);
            if($secs >= 0 && $secs<6){
                $countBooking++;
            }
        }
        return $countBooking;
    }
}


