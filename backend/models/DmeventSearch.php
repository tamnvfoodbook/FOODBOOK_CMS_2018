<?php

namespace backend\models;

use backend\controllers\AjaxapiController;
use backend\controllers\ApiController;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dmevent;
use yii\data\ArrayDataProvider;
use yii\data\SqlDataProvider;
use yii\helpers\ArrayHelper;

/**
 * DmeventSearch represents the model behind the search form about `backend\models\Dmevent`.
 */
class DmeventSearch extends Dmevent
{
    /**
     * @inheritdoc
     */
//    public $dmmembershippoint;

    public $TOP;
    public $TOP_TYPE;
    public $MEMBER_TYPE;
    public $LAST_VISIT_FREQUENCY_START;
    public $LAST_VISIT_FREQUENCY_END;
    public $CITY_ID;

    public function rules()
    {
        return [
            [['ID', 'ACTIVE', 'MANAGER_ID', 'MIN_EAT_COUNT', 'MAX_EAT_COUNT', 'LAST_VISIT_FREQUENCY', 'CAMPAIGN_ID', 'STATUS', 'EXPECTED_APPROACH', 'PRACTICAL_APPROACH'], 'integer'],
            [['EVENT_NAME', 'POS_PARENT', 'DATE_CREATED', 'DATE_UPDATED', 'DATE_START', 'SEND_TYPE', 'STATUS','TOP','TOP_TYPE','MEMBER_TYPE','LAST_VISIT_FREQUENCY_END','LAST_VISIT_FREQUENCY_START','FACEBOOK_MES_ID','CITY_ID'], 'safe'],
            [['MIN_PAY_AMOUNT', 'MAX_PAY_AMOUNT','MIN_POINT', 'MAX_POINT', 'BIRTH_MONTH', 'USER_GROUP', 'GENDER', 'EVENT_TYPE'], 'number'],
//            ['LAST_VISIT_FREQUENCY_START', 'compare', 'compareAttribute' => 'LAST_VISIT_FREQUENCY_END', 'operator' => '<'],
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
        $query = Dmevent::find();

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
            'DATE_CREATED' => $this->DATE_CREATED,
            'DATE_UPDATED' => $this->DATE_UPDATED,
            'DATE_START' => $this->DATE_START,
            'ACTIVE' => $this->ACTIVE,
            'MANAGER_ID' => $this->MANAGER_ID,
            'MIN_EAT_COUNT' => $this->MIN_EAT_COUNT,
            'MAX_EAT_COUNT' => $this->MAX_EAT_COUNT,
            'MIN_PAY_AMOUNT' => $this->MIN_PAY_AMOUNT,
            'MAX_PAY_AMOUNT' => $this->MAX_PAY_AMOUNT,
            'LAST_VISIT_FREQUENCY' => $this->LAST_VISIT_FREQUENCY,
            'CAMPAIGN_ID' => $this->CAMPAIGN_ID,
            'STATUS' => $this->STATUS,
            'EXPECTED_APPROACH' => $this->EXPECTED_APPROACH,
            'PRACTICAL_APPROACH' => $this->PRACTICAL_APPROACH,
        ]);

        $query->andFilterWhere(['like', 'EVENT_NAME', $this->EVENT_NAME])
            ->andFilterWhere(['like', 'POS_PARENT', $this->POS_PARENT]);

        return $dataProvider;
    }

    public function searchByApi($params)
    {
        $this->load($params);

        $max_eat_count = Yii::$app->params['maxEat'];
        if($this->MAX_EAT_COUNT){
            $max_eat_count = $this->MAX_EAT_COUNT;
        }

        $max_eat_amount = Yii::$app->params['maxAmount'];
        if($this->MAX_PAY_AMOUNT){
            $max_eat_amount = $this->MAX_PAY_AMOUNT;
        }
        $max_point = Yii::$app->params['maxPoint'];
        if($this->MAX_POINT){
            $max_point = $this->MAX_POINT;
        }
        if(isset($params['page'])){
            $page = $params['page'];
        }else{
            $page = 1;
        }
        $this->load($params);



    /*    if($this->LAST_VISIT_FREQUENCY_START){
//                $lastdate = 'AND DATE_SUB(NOW(), INTERVAL '.(int)$this->LAST_VISIT_FREQUENCY.' DAY) < b.EAT_LAST_DATE';
            $lastdate_start = 'AND DATE_SUB(NOW(), INTERVAL '.(int)$this->LAST_VISIT_FREQUENCY_START.' DAY) > b.EAT_LAST_DATE';
        }

        if($this->LAST_VISIT_FREQUENCY_END){
//                $lastdate = 'AND DATE_SUB(NOW(), INTERVAL '.(int)$this->LAST_VISIT_FREQUENCY.' DAY) < b.EAT_LAST_DATE';
            $lastdate_end = ' AND DATE_SUB(NOW(), INTERVAL '.(int)$this->LAST_VISIT_FREQUENCY_END.' DAY) < b.EAT_LAST_DATE';
        }*/


        $paramArr = [
            'min_eat_count' => $this->MIN_EAT_COUNT, // Mượn trường của model
            'max_eat_count' => $max_eat_count,
            'min_eat_amount' => $this->MIN_PAY_AMOUNT,
            'max_eat_amount' => $max_eat_amount,
            'min_point' => $this->MIN_POINT,
            'max_point' => $max_point,
//            'last_visit_frequency' => $this->LAST_VISIT_FREQUENCY,
            'min_last_visit_frequency' => $this->LAST_VISIT_FREQUENCY_START,
            'max_last_visit_frequency' => $this->LAST_VISIT_FREQUENCY_END,
            'gender' => $this->GENDER,
            'birth_month' => $this->BIRTH_MONTH,
            'user_group' => $this->USER_GROUP,
            'phone' => $this->ID,
            'source' => $this->POS_PARENT,
            'membership_type' => $this->MEMBER_TYPE,
            'page' => (int)$page
        ];

        if($this->CITY_ID){
            $paramArr['city_id'] = $this->CITY_ID;
        }



//        die();

        $nameAPI = 'ipcc/filter_member';

        $apiPath = Yii::$app->params['CMS_API_PATH_SHORT'];

        $result = ApiController::getApiByMethod($nameAPI,$apiPath,$paramArr,'GET');

        $data = array();
        if($page != 1){
            $number = ($page - 1)*20;
            for ($i = 1; $i <= $number; $i++) {
                $data[] = $i;
            }
        }
        $data =  array_merge($data,@$result->data->filter_result);

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'totalCount' => @$result->data->count,
        ]);



        return $dataProvider;
    }


    public function searchByModel($params)
    {

        $this->load($params);

        /*echo '<pre>';
        var_dump($this);
        echo '</pre>';
        die();*/

        $posParent = \Yii::$app->session->get('pos_parent');

        $max_eat_count = Yii::$app->params['maxEat'];
        if($this->MAX_EAT_COUNT){
            $max_eat_count = $this->MAX_EAT_COUNT;
        }

        $max_eat_amount = Yii::$app->params['maxAmount'];
        if($this->MAX_PAY_AMOUNT){
            $max_eat_amount = $this->MAX_PAY_AMOUNT;
        }
        $max_point = Yii::$app->params['maxPoint'];
        if($this->MAX_POINT){
            $max_point = $this->MAX_POINT;
        }

//        echo '<pre>';
//        var_dump($this);
//        echo '</pre>';
//        die();

        if($this->GENDER != null){
            $sex_query =  ' AND SEX = '.$this->GENDER.'';
        }

        if($this->USER_GROUP){
            $user_group_query =  ' AND USER_GROUPS = '.$this->USER_GROUP.'';
        }

        if($this->BIRTH_MONTH){
           $birthday_query =  ' AND MONTH(a.BIRTHDAY) = '.$this->BIRTH_MONTH ;
        }

        if($this->POS_PARENT){
            if($this->POS_PARENT  == 'ZALO'){
                $source_query = ' AND LENGTH(ZALO_FOLLOW) > 10';
            }else{
                $source_query = ' AND LENGTH(FACEBOOK_MES_ID) > 5';
            }

        }


        if($this->MEMBER_TYPE){
            $user_member_type_query =  " AND MEMBERSHIP_ID IN ( SELECT MEMBERSHIP_ID FROM `DM_MEMBERSHIP_TYPE_RELATE` WHERE POS_PARENT = '".$posParent."' AND MEMBERSHIP_TYPE_ID = '".$this->MEMBER_TYPE."' ) " ;
        }


        $pagination = [
            'pageSize' => 20
        ];
        if($this->TOP){
            $pagination = false;
            $type = 'EAT_COUNT';
            if($this->TOP_TYPE){
                $type = 'AMOUNT';
            }
            $top_query = ' ORDER BY '. $type .' DESC LIMIT '.$this->TOP ;

        }

        if($this->ID){
            $phone = AjaxapiController::fixPhoneNumbTo84($this->ID);
            $quey_count = 'FROM `DM_MEMBERSHIP` a, `DM_MEMBERSHIP_POINT` b
                            WHERE b.MEMBERSHIP_ID = :phone
                            AND b.POS_PARENT= :pos_parent
                            AND a.ID = b.MEMBERSHIP_ID';
            $paramTmp = [
                ':phone' => $phone,
                ':pos_parent' => $posParent
            ];
        }else{
            if($this->LAST_VISIT_FREQUENCY_START){
//                $lastdate = 'AND DATE_SUB(NOW(), INTERVAL '.(int)$this->LAST_VISIT_FREQUENCY.' DAY) < b.EAT_LAST_DATE';
                $lastdate_start = 'AND DATE_SUB(NOW(), INTERVAL '.(int)$this->LAST_VISIT_FREQUENCY_START.' DAY) > b.EAT_LAST_DATE';
            }

            if($this->LAST_VISIT_FREQUENCY_END){
//                $lastdate = 'AND DATE_SUB(NOW(), INTERVAL '.(int)$this->LAST_VISIT_FREQUENCY.' DAY) < b.EAT_LAST_DATE';
                $lastdate_end = ' AND DATE_SUB(NOW(), INTERVAL '.(int)$this->LAST_VISIT_FREQUENCY_END.' DAY) < b.EAT_LAST_DATE';
            }

            $quey_count = 'FROM `DM_MEMBERSHIP` a, `DM_MEMBERSHIP_POINT` b
                      WHERE  b.POS_PARENT= :pos_parent

                        '.@$lastdate_start.@$lastdate_end.'
                        AND EAT_COUNT >= :min_eat_count  AND EAT_COUNT <= :max_eat_count
                        AND AMOUNT >= :min_eat_amout AND AMOUNT <= :max_eat_amout
                        AND POINT >= :min_point AND POINT <= :max_point
                        AND a.ID = b.MEMBERSHIP_ID'
                        .@$birthday_query.@$user_group_query.@$sex_query.@$source_query.@$user_member_type_query.@$top_query;

            $paramTmp = [
//                ':sex' => $this->GENDER,
//                ':birthday' => $this->BIRTH_MONTH,
//                ':user_group' => (int)$this->USER_GROUP,
                ':pos_parent' => $posParent,
//                ':last_date' => (int)$this->LAST_VISIT_FREQUENCY,
                ':min_eat_count' => (int)$this->MIN_EAT_COUNT,
                ':max_eat_count' => $max_eat_count,
                ':min_eat_amout' => (int)$this->MIN_PAY_AMOUNT,
                ':max_eat_amout' => $max_eat_amount,
                ':min_point' => (int)$this->MIN_POINT,
                ':max_point' => $max_point,
            ];
        }


        $count = Yii::$app->db->createCommand('SELECT COUNT(*)'.$quey_count, $paramTmp)->queryScalar();

/*        echo '<pre>';
        var_dump(Yii::$app->db->createCommand('SELECT COUNT(*)'.$quey_count, $paramTmp)->sql);
        echo '</pre>';
        die();*/


        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT * '.$quey_count,
            'params' => $paramTmp,
            'totalCount' => (int)$count ,
            'sort' =>false,
            'pagination' => $pagination
        ]);

        return $dataProvider;


    }
    public function searchModelByArrayParam($params)
    {

        $posParent = \Yii::$app->session->get('pos_parent');

        /*echo '<pre>';
        var_dump($params);
        echo '</pre>';
        die();*/

        $max_eat_count = Yii::$app->params['maxEat'];
        if(@$params->max_eat_count){
            $max_eat_count = $params->max_eat_count;
        }

        $max_eat_amount = Yii::$app->params['maxAmount'];
        if(@$params->max_eat_amount){
            $max_eat_amount = $params->max_eat_amount;
        }

        $max_point = Yii::$app->params['maxPoint'];
        if(@$params->max_point){
            $max_point = $params->max_point;
        }

        /*echo '<pre>';
        var_dump($params);
        echo '</pre>';
        die();*/

        if(@$params->gender != null){
            $sex_query =  ' AND SEX = '.$params->gender.'';
        }

        if(@$params->user_group){
            $user_group_query =  ' AND USER_GROUPS = '.$params->user_group.'';
        }

        if(@$params->birth_month){
           $birthday_query =  ' AND MONTH(a.BIRTHDAY) = '.$params->birth_month ;
        }

        if(@$params->pos_parent){
            $zalo_query = ' AND LENGTH(ZALO_FOLLOW) > 10';
        }



        if($this->MEMBER_TYPE){
            $user_member_type_query =  " AND MEMBERSHIP_ID IN ( SELECT MEMBERSHIP_ID FROM `DM_MEMBERSHIP_TYPE_RELATE` WHERE POS_PARENT = '".$posParent."' AND MEMBERSHIP_TYPE_ID = '".$this->MEMBER_TYPE."' ) " ;
        }

        if($this->TOP){
            $type = 'EAT_COUNT';
            if($this->TOP_TYPE){
                $type = 'AMOUNT';
            }
            $top_query = ' ORDER BY '. $type .' DESC LIMIT '.$this->TOP ;

        }



        if(@$params->ID){
            return [
                ['ID' => $params->phone]
            ];
        }else{
            if(@$params->last_visit_frequency){
                $lastdate = 'AND DATE_SUB(NOW(), INTERVAL '.(int)$params->last_visit_frequency.' DAY) < b.EAT_LAST_DATE';
            }

            $quey_count = 'FROM `DM_MEMBERSHIP` a, `DM_MEMBERSHIP_POINT` b
                      WHERE  b.POS_PARENT= :pos_parent

                        '.@$lastdate.'
                        AND EAT_COUNT >= :min_eat_count  AND EAT_COUNT <= :max_eat_count
                        AND AMOUNT >= :min_eat_amout AND AMOUNT <= :max_eat_amout
                        AND POINT >= :min_point AND POINT <= :max_point
                        AND a.ID = b.MEMBERSHIP_ID'
                        .@$birthday_query.@$user_group_query.@$sex_query.@$zalo_query.@$user_member_type_query.@$top_query;

            $paramTmp = [
//                ':sex' => $this->GENDER,
//                ':birthday' => $this->BIRTH_MONTH,
//                ':user_group' => (int)$this->USER_GROUP,
                ':pos_parent' => $posParent,
//                ':last_date' => (int)$this->LAST_VISIT_FREQUENCY,
                ':min_eat_count' => (int)$params->min_eat_count,
                ':max_eat_count' => $max_eat_count,
                ':min_eat_amout' => (int)$params->min_eat_amount,
                ':max_eat_amout' => $max_eat_amount,
                ':min_point' => (int)$params->min_point,
                ':max_point' => $max_point,
            ];
        }


//        $count = Yii::$app->db->createCommand('SELECT COUNT(*)'.$quey_count, $paramTmp)->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT ID '.$quey_count,
            'params' => $paramTmp,
//            'totalCount' => (int)$count ,
            'sort' =>false,
            'pagination' =>false,
        ]);

        return $dataProvider->getModels();


    }

    public function searchByModel_BK($params)
    {
        $query = Dmmembership::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->joinWith('dmmembershippoint');

        $posParent = \Yii::$app->session->get('pos_parent');
        $query->where(['DM_MEMBERSHIP_POINT.POS_PARENT' => $posParent]);

        $max_eat_count = Yii::$app->params['maxEat'];
        if($this->MAX_EAT_COUNT){
            $max_eat_count = $this->MAX_EAT_COUNT;
        }

        $max_eat_amount = Yii::$app->params['maxAmount'];
        if($this->MAX_PAY_AMOUNT){
            $max_eat_amount = $this->MAX_PAY_AMOUNT;
        }
        $max_point = Yii::$app->params['maxPoint'];
        if($this->MAX_POINT){
            $max_point = $this->MAX_POINT;
        }


        $query->andFilterWhere([
            'ID' => $this->ID,
//            'ACTIVE' => 1,
//            'CREATED_AT' => $this->CREATED_AT,
//            'LAST_UPDATED' => $this->LAST_UPDATED,
        ]);
        if($this->ID){
            $phone = AjaxapiController::fixPhoneNumbTo84($this->ID);
            $query->andFilterWhere([
                'ID' => $phone,
            ]);
        }
        if($this->GENDER != NULL){
            $query->andFilterWhere([
                'SEX' => (int)$this->GENDER,
            ]);
        }
        if($this->USER_GROUP){
            $query->andFilterWhere([
                'USER_GROUPS' => (int)$this->USER_GROUP,
            ]);
        }

        if($this->BIRTH_MONTH){
            $query->andFilterWhere([
                '=', 'MONTH(BIRTHDAY)', $this->BIRTH_MONTH]);
        }


        if($this->POS_PARENT){
            $query
                ->andFilterWhere(['>', 'ZALO_FOLLOW', 0]);
        }

        if($this->LAST_VISIT_FREQUENCY){
            $subday = 'P'.$this->LAST_VISIT_FREQUENCY.'D';
            $date = new \DateTime('');
            $date->sub(new \DateInterval($subday));
//            echo $this->LAST_VISIT_FREQUENCY;
            $query
                ->andFilterWhere(['<=', 'DM_MEMBERSHIP_POINT.EAT_LAST_DATE', $date->format('Y-m-d H:i:s')]);
        }


        $query
            ->andFilterWhere(['between', 'DM_MEMBERSHIP_POINT.POINT', $this->MIN_POINT,$max_point])
            ->andFilterWhere(['between', 'DM_MEMBERSHIP_POINT.AMOUNT', $this->MIN_PAY_AMOUNT,$max_eat_amount])
            ->andFilterWhere(['between', 'DM_MEMBERSHIP_POINT.EAT_COUNT', $this->MIN_EAT_COUNT,$max_eat_count]);
//        echo '<pre>';
//        var_dump($query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);
//        echo '</pre>';
//        die();


        return $dataProvider;
    }
    public function searchParam($params)
    {
        $this->load($params);

        $max_eat_count = Yii::$app->params['maxEat'];
        if($this->MAX_EAT_COUNT){
            $max_eat_count = $this->MAX_EAT_COUNT;
        }

        $max_eat_amount = Yii::$app->params['maxAmount'];
        if($this->MAX_PAY_AMOUNT){
            $max_eat_amount = $this->MAX_PAY_AMOUNT;
        }
        $max_point = Yii::$app->params['maxPoint'];
        if($this->MAX_POINT){
            $max_point = $this->MAX_POINT;
        }


        $paramArr = array();



        $paramArr = [
            'min_eat_count' => $this->MIN_EAT_COUNT, // Mượn trường của model
            'max_eat_count' => $max_eat_count,
            'min_eat_amount' => $this->MIN_PAY_AMOUNT,
            'max_eat_amount' => $max_eat_amount,
            'min_point' => $this->MIN_POINT,
            'max_point' => $max_point,
//            'last_visit_frequency' => $this->LAST_VISIT_FREQUENCY,
            'gender' => $this->GENDER,
            'birth_month' => $this->BIRTH_MONTH,
            'user_group' => $this->USER_GROUP,
            'phone' => $this->ID,
            'source' => $this->POS_PARENT,
            'membership_type' => $this->MEMBER_TYPE,
        ];

        if($this->CITY_ID){
            $paramArr['city_id'] = $this->CITY_ID;
        }

        if($this->LAST_VISIT_FREQUENCY_START){
            $paramArr['min_last_visit_frequency']= $this->LAST_VISIT_FREQUENCY_START;
        }
        if($this->LAST_VISIT_FREQUENCY_END){
            $paramArr['max_last_visit_frequency']= $this->LAST_VISIT_FREQUENCY_END;
        }

        return $paramArr;
    }

    public function getEvent($params)
    {
        $this->load($params);
        $apiName = 'ipcc/get_events';
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];


        if(!$this->EVENT_TYPE){
            $this->EVENT_TYPE = 1;
        }
        $paramCommnet = [
            'status' => $this->STATUS,
            'event_type' =>  $this->EVENT_TYPE
        ];

        $result = ApiController::getApiByMethod($apiName,$apiPath,$paramCommnet,'GET');
//        echo '<pre>';
//        var_dump($this->EVENT_TYPE);
////        var_dump($result);
//        echo '</pre>';
////        die();

        return @$result->data;
    }
}
