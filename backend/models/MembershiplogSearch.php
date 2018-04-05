<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dmmerbership;
use yii\helpers\ArrayHelper;

/**
 * MembershiplogSearch represents the model behind the search form about `backend\models\Membershiplog`.
 */
class MembershiplogSearch extends Membershiplog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['_id', 'className', 'Pos_Id', 'User_Id', 'Pr_Key', 'Membership_Log_Type', 'Amount', 'Point', 'Membership_Log_Date'], 'safe'],
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
        $query = Membershiplog::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['=', '_id', $this->_id])
            //->andFilterWhere(['like', 'className', $this->className])
            ->andFilterWhere(['=', 'Pos_Id', $this->Pos_Id])
            ->andFilterWhere(['=', 'User_Id', $this->User_Id])
            ->andFilterWhere(['=', 'Pr_Key', $this->Pr_Key])
            ->andFilterWhere(['=', 'Membership_Log_Type', $this->Membership_Log_Type])
            ->andFilterWhere(['=', 'Amount', $this->Amount])
            ->andFilterWhere(['=', 'Point', $this->Point])
            ->andFilterWhere(['=', 'Membership_Log_Date', $this->Membership_Log_Date]);

        return $dataProvider;
    }

    public function searchAllMemberLog($ids,$start= NULL,$end){
        $allMember = Membershiplog::find()
            ->select(['User_Id','_id'])
            ->where(['Pos_Id' => array_values($ids)])
            ->orderBy(['Pos_Id' => SORT_ASC])
            ->asArray()
            ->all();
        if(!$start){
            $dateTime = new \DateTime;
            $dateTime->sub(new \DateInterval("P1D"));
            $DAY2 = $dateTime->format( \DateTime::ISO8601 );
            $yesterday = new \MongoDate(strtotime($DAY2));
        }else{
            $yesterday = $start;
        }


        $memberToday = Membershiplog::find()
            ->select(['User_Id','Membership_Log_Date','Pos_Id'])
            ->where(['Pos_Id' => array_values($ids)])
            ->andWhere(['Membership_Log_Date' => ['$lte' => $end]])
            ->andWhere(['Membership_Log_Date' => ['$gt' => $yesterday]])
            ->with('membership')
            ->orderBy(['Pos_Id' => SORT_ASC])
            ->asArray()
            ->all();
//        echo '<pre>';
//        var_dump($memberToday);
//        echo '</pre>';
//        die();

        return $membershiplog = [
            'allMember'=> $allMember,
            'memberToday' => $memberToday
        ];

    }
    public function checkStatusMember($memberId,$posId){

        $memberInfo = array();
        foreach((array)$memberId as $id){
            $allMember = Membershiplog::find()
                //->select(['User_Id'])
                ->where(['User_Id' => $id])
                ->andWhere(['Pos_Id' => array_values($posId)])
                ->count();
            $memberInfo[$id] = $allMember;
        }
//        echo '<pre>';
//        var_dump($posId);
//        var_dump($memberInfo);
//        echo '</pre>';
//        die();
        return $memberInfo;
    }

    public function getAllMemberByPosId($posId){
            $allMember = Membershiplog::find()
                ->where(['Pos_Id' => array_values($posId)])
                ->asArray()
                ->all();
        return $allMember;
    }

}
