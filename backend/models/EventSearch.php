<?php

namespace backend\models;

use backend\controllers\ApiController;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Commisssion;
use yii\data\ArrayDataProvider;

/**
 * CommissionSearch represents the model behind the search form about `backend\models\Bookingonlinelog`.
 */
class EventSearch extends Event
{
    /**
     * @inheritdoc
     */

    public function rules()
    {
        return [
            [[
                '_id',
                'trigger_name',
                'trigger_type',
                'pos_parent',
                'created_at',
                'updated_at',
                'active',
                'trigger_message',
                'send_via_sms',
                'send_via_zalo',
                'send_via_facebook',
                'trigger_remind_voucher',
                'trigger_voucher_campaign',
            ], 'safe'],
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
    public function search($params,$triggerName)
    {
        $this->load($params);
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];
        $pos_parent = \Yii::$app->session->get('pos_parent');
        $nameApi = 'ipcc/get_list_trigger_event';
        $param = array(
            'trigger_name' => $triggerName,
            'pos_parent' => $pos_parent,
        );

        $event = ApiController::getObjDataFromApi($apiPath,$nameApi,$param);


        $dataProvider = new ArrayDataProvider([
            'allModels' => @$event->data,
        ]);


        return $dataProvider;
    }


    public function searchBirthday($params)
    {
        $this->load($params);
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];
        $comments_in_rate = 'ipcc/getListTriggerEvent';
        $param = array(
            'trigger_name' => 'birthday',
//            'pos_parent' => $this->pos_name,
        );

        $event = ApiController::getObjDataFromApi($apiPath,$comments_in_rate,$param);
        echo '<pre>';
        var_dump($event);
        echo '</pre>';
        die();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $commmision,
        ]);


        return $dataProvider;
    }

    public function searchReport($params,$dateTime)
    {
        $this->load($params);
        if(!$this->created_at){
            $date_start = date("Y-m-d 00:00:00",strtotime('-7 days'));
            $date_end = date("Y-m-d 23:59:59");
        }else{
            $arrTime = explode(" - ",$this->created_at);
            $date_start_tmp = \DateTime::createFromFormat('d/m/Y', $arrTime[0]);
            $date_start = $date_start_tmp->format('Y-m-d 00:00:00');

            $date_end_tmp = \DateTime::createFromFormat('d/m/Y', $arrTime[1]);
            $date_end = $date_end_tmp->format('Y-m-d H:i:s');

        }

        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];
        $comments_in_rate = 'ipcc/report_commission';

        $param = array(
            'date_start' => $date_start,
            'date_end' => $date_end,
//            'pos_parent' => $this->pos_parent,
            'pos_id' => $this->pos_id,
            'partner_id' => $this->partner_id
        );


        $commmision = ApiController::getDataFromApi($apiPath,$comments_in_rate,$param);
        /*echo '<pre>';
        var_dump($commmision);
        echo '</pre>';
        die();*/

        if(is_array($commmision)){
            \Yii::$app->session->set('commission_report',$commmision);
        }


        $dataProvider = new ArrayDataProvider([
            'allModels' => $commmision,
            'pagination' => false,
        ]);



        return $dataProvider;
    }

}


