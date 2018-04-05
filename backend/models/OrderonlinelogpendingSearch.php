<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Orderonlinelogpending;

/**
 * OrderonlinelogpendingSearch represents the model behind the search form about `backend\models\Orderonlinelogpending`.
 */
class OrderonlinelogpendingSearch extends Orderonlinelogpending
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['_id'], 'safe'],
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
        $query = Orderonlinelogpending::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $pos_parent = \Yii::$app->session->get('pos_parent');
        $query->where(['pos_parent' => $pos_parent]);
        $query->andFilterWhere(['like', '_id', $this->_id])
            ->andFilterWhere(['is_pending' => 1])
        ->orderBy(['_id' => SORT_ASC])
        ;

        return $dataProvider;
    }


    public function checkNewPending(){
        $type = \Yii::$app->session->get('type_acc');
        $dateTime = new \DateTime("00:00:00");
        //$dateTime->sub(new \DateInterval("P1D"));
        $DAY = $dateTime->format( \DateTime::ISO8601 );
        $today = new \MongoDate(strtotime($DAY));

        if($type != 1){
            $posModel = new DmposSearch();
            $posIds = $posModel->getIds();
            $booked = Orderonlinelogpending::find()
                ->where(['$gte','created_at', $today])
                ->andWhere(['pos_id' => $posIds])
                ->asArray()
                ->all();
        }else{
            $booked = Orderonlinelogpending::find()
                ->asArray()
                ->all();
        }

//        echo '<pre>';
//        var_dump($DAY);
//        var_dump($today);
//        var_dump($booked);
//        echo '</pre>';
//        die();

        $countPending = 0;
        foreach($booked as $booking){
            $time = date(Yii::$app->params['DATE_TIME_FORMAT_2'],$booking['created_at']->sec);
            $nowTime = date(Yii::$app->params['DATE_TIME_FORMAT_2']);
            $secs = strtotime($nowTime) - strtotime($time);
            if($secs >= 0 && $secs<6){
                $countPending++;
            }
        }

//        die();

        return $countPending;
    }


}
