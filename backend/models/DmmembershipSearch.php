<?php

namespace backend\models;

use backend\controllers\ApiController;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dmmembership;
use yii\data\SqlDataProvider;
use yii\helpers\ArrayHelper;

/**
 * DmmembershipSearch represents the model behind the search form about `backend\models\Dmmembership`.
 */
class DmmembershipSearch extends Dmmembership
{
    /**
     * @inheritdoc
     */

    public $dmmembershippoint;

    public function rules()
    {
        return [
            [['ID', 'ACTIVE','SEX','USER_GROUPS'], 'integer'],
            [['MEMBER_NAME', 'MEMBER_IMAGE_PATH', 'HASH_PASSWORD', 'FACEBOOK_ID', 'PHONE_NUMBER', 'EMAIL', 'CREATED_AT', 'LAST_UPDATED', 'MY_STATUS', 'BIRTHDAY', 'CREATED_BY','CITY_ID'], 'safe'],
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


    public function searchByApi_bk($params)
    {
        $query = Dmmembership::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if(!$this->load($params)){
            $membershipPoinModelSeach = new DmmembershippointSearch();
            $posParent = \Yii::$app->session->get('pos_parent');
            $memberPosparent = $membershipPoinModelSeach->searchMemberByPosparent($posParent);
            $memberPosparentMap = ArrayHelper::map($memberPosparent,'MEMBERSHIP_ID','MEMBERSHIP_ID');

            $query->where([
                'ID' => $memberPosparentMap,
            ]);

        }else{

            if(@$params['BIRTHDAY']){
                $month = date('m',strtotime($params['BIRTHDAY']));
            }

            $paramArr = [
                'min_eat_count' => @$params['CREATED_AT'], // Mượn trường của model
                'max_eat_count' => @$params['LAST_UPDATED'],
                'min_eat_amount' => @$params['FB_AMOUNT'],
                'max_eat_amount' => @$params['PRESENTER'],
                'min_point' => @$params['IS_COMPLETED_PROFILE'],
                'max_point' => @$params['ZALO_UID'],
                'last_visit_frequency' => @$params['ACTIVE'],
                'gender' => @$params['SEX'],
                'birth_month' => @$month,
                'user_group' => @$params['USER_GROUPS'],
            ];


            $nameAPI = 'ipcc/filter_member';

            $apiPath = Yii::$app->params['CMS_API_PATH_SHORT'];

            $result = ApiController::getApiByMethod($nameAPI,$apiPath,$paramArr,'POST');

            return @$result->data;
        }

        return $dataProvider;
    }

    public function search($params)
    {
        $query = Dmmembership::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

//        echo '<pre>';
//        var_dump($params);
//        echo '</pre>';
//        die();

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $membershipPoinModelSeach = new DmmembershippointSearch();
        $posParent = \Yii::$app->session->get('pos_parent');
        $memberPosparent = $membershipPoinModelSeach->searchMemberByPosparent($posParent);
        $memberPosparentMap = ArrayHelper::map($memberPosparent,'MEMBERSHIP_ID','MEMBERSHIP_ID');
//        echo '<pre>';
//        var_dump($memberPosparentMap);
//        echo '</pre>';
//        die();
        $query->where([
            'ID' => $memberPosparentMap,
        ]);

        $query->andFilterWhere([
            'ID' => $this->ID,
            'ACTIVE' => 1,
            'CREATED_AT' => $this->CREATED_AT,
            'LAST_UPDATED' => $this->LAST_UPDATED,
        ]);
        if($this->SEX != NULL){
            $query->andFilterWhere([
                'SEX' => (int)$this->SEX,
            ]);
        }
        if($this->USER_GROUPS){
            $query->andFilterWhere([
                'USER_GROUPS' => (int)$this->USER_GROUPS,
            ]);
        }

        if($this->BIRTHDAY){
                $query->andFilterWhere([
                    '=', 'MONTH(BIRTHDAY)', $this->BIRTHDAY]);
        }

        $query->andFilterWhere(['like', 'MEMBER_NAME', $this->MEMBER_NAME])
            ->andFilterWhere(['like', 'MEMBER_IMAGE_PATH', $this->MEMBER_IMAGE_PATH])
            ->andFilterWhere(['like', 'HASH_PASSWORD', $this->HASH_PASSWORD])
            ->andFilterWhere(['like', 'FACEBOOK_ID', $this->FACEBOOK_ID])
            ->andFilterWhere(['like', 'PHONE_NUMBER', $this->PHONE_NUMBER])
            ->andFilterWhere(['like', 'EMAIL', $this->EMAIL])
            ->andFilterWhere(['like', 'MY_STATUS', $this->MY_STATUS])
            ->andFilterWhere(['like', 'CREATED_BY', $this->CREATED_BY]);

        return $dataProvider;
    }
    public function searchReport($params)
    {
        $query = Dmmembership::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->joinWith('dmmembershippoint');

//        echo '<pre>';
//        var_dump($params);
//        echo '</pre>';
//        die();

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $membershipPoinModelSeach = new DmmembershippointSearch();
        $posParent = \Yii::$app->session->get('pos_parent');
        $memberPosparent = $membershipPoinModelSeach->searchMemberByPosparent($posParent);
        $memberPosparentMap = ArrayHelper::map($memberPosparent,'MEMBERSHIP_ID','MEMBERSHIP_ID');
//        echo '<pre>';
//        var_dump($memberPosparentMap);
//        echo '</pre>';
//        die();
        $query->where([
            'ID' => $memberPosparentMap,
        ]);

        $query->andFilterWhere([
            'ID' => $this->ID,
            'ACTIVE' => 1,
            'CREATED_AT' => $this->CREATED_AT,
            'LAST_UPDATED' => $this->LAST_UPDATED,
        ]);
        if($this->SEX != NULL){
            $query->andFilterWhere([
                'SEX' => (int)$this->SEX,
            ]);
        }
        if($this->USER_GROUPS){
            $query->andFilterWhere([
                'USER_GROUPS' => (int)$this->USER_GROUPS,
            ]);
        }

        if($this->BIRTHDAY){
                $query->andFilterWhere([
                    '=', 'MONTH(BIRTHDAY)', $this->BIRTHDAY]);
        }

        $query->andFilterWhere(['like', 'MEMBER_NAME', $this->MEMBER_NAME])
            ->andFilterWhere(['like', 'MEMBER_IMAGE_PATH', $this->MEMBER_IMAGE_PATH])
            ->andFilterWhere(['like', 'HASH_PASSWORD', $this->HASH_PASSWORD])
            ->andFilterWhere(['like', 'FACEBOOK_ID', $this->FACEBOOK_ID])
            ->andFilterWhere(['like', 'PHONE_NUMBER', $this->PHONE_NUMBER])
            ->andFilterWhere(['like', 'EMAIL', $this->EMAIL])
            ->andFilterWhere(['like', 'MY_STATUS', $this->MY_STATUS])
            ->andFilterWhere(['like', 'CREATED_BY', $this->CREATED_BY]);

        return $dataProvider;
    }

    /*public function searchSql($params)
    {

        $count = Yii::$app->db->createCommand(1000)->queryScalar();
        $this->load($params);

        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT * FROM `DM_MEMBERSHIP` a, `DM_MEMBERSHIP_POINT` b WHERE USER_GROUPS = 1 AND  a.SEX = 1 AND MONTH(a.BIRTHDAY) = 3 AND a.ID = b.MEMBERSHIP_ID
                      AND b.POS_PARENT= '..'
                        AND b.EAT_LAST_DATE <= '2017-05-20 23:59:59'
                        AND b.EAT_COUNT >= 0 AND b.EAT_COUNT <= 99999
                        AND b.AMOUNT >= 0.0 AND b.AMOUNT <= 999999999999
                        AND b.POINT >= 0.0 AND b.POINT <= 999999999
                        AND b.ZALO_FOLLOW > 0
            ',
            'params' => [],
            'totalCount' => 1000,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $dataProvider;
    }*/

    public function seachAllPhone(){
        $userPhone = Dmmembership::find()
            ->select(['ID','MEMBER_NAME'])
            ->orderBy(['CREATED_AT' => SORT_DESC])
            ->asArray()
            ->all();
        return $userPhone;
    }
    public function seachAllPhoneByPospent(){
        $membershipPoinModelSeach = new DmmembershippointSearch();
        $posParent = \Yii::$app->session->get('pos_parent');
        $memberPosparent = $membershipPoinModelSeach->searchMemberByPosparent($posParent);
        $memberPosparentMap = ArrayHelper::map($memberPosparent,'MEMBERSHIP_ID','MEMBERSHIP_ID');

        $userPhone = Dmmembership::find()
            ->select(['ID','MEMBER_NAME'])
            ->where(['ID' => $memberPosparentMap ])
            ->asArray()
            ->all();
        return $userPhone;
    }

    public function searchMemberById($memberIds){
        $userPhone = Dmmembership::find()
            ->select(['ID','MEMBER_NAME','MY_STATUS'])
            ->where(['ID' => $memberIds])
            ->asArray()
            ->all();
        return $userPhone;
    }
    public function searchMemberModelById($memberIds){
        $userPhone = Dmmembership::find()
//            ->select(['ID','MEMBER_NAME'])
            ->where(['ID' => $memberIds])
            ->one();
        return $userPhone;
    }
}
