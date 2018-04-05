<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dmtimeorder;

/**
 * DmtimeorderSearch represents the model behind the search form about `backend\models\Dmtimeorder`.
 */
class DmtimeorderSearch extends Dmtimeorder
{
    /**
     * @inheritdoc
     */

    public $pos;

    public function rules()
    {
        return [
            [['ID', 'POS_ID', 'TYPE', 'ACTIVE'], 'integer'],
            [['DAY_OF_WEEK'], 'safe'],
            [['TIME_START', 'TIME_END', 'DAY_OFF'], 'safe'],
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
    public function search($params)
    {
        $query = Dmtimeorder::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith('pos');

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

        $type = \Yii::$app->session->get('type_acc');
        /*echo '<pre>';
        var_dump($this->POS_ID);
        echo '</pre>';
        die();*/
        if($type != 1 && $this->POS_ID == NULL){
            $posId = \Yii::$app->session->get('pos_id_list');
            $posArr = explode(",",$posId);
            $query->where([
                'POS_ID' => $posArr,
            ]);
        }else{
            $query->andFilterWhere([
                'POS_ID' => $this->POS_ID,
            ]);
        }

        $query->andFilterWhere([
            'ID' => $this->ID,
            'TYPE' => $this->TYPE,
            'DAY_OF_WEEK' => $this->DAY_OF_WEEK,
            'DM_TIME_ORDER.ACTIVE' => $this->ACTIVE,
        ]);

        $query->andFilterWhere(['like', 'TIME_START', $this->TIME_START])
            ->andFilterWhere(['like', 'TIME_END', $this->TIME_END])
            ->andFilterWhere(['like', 'DAY_OFF', $this->DAY_OFF])
            ->andFilterWhere(['like', 'DM_POS.POS_NAME', $this->pos]);

        return $dataProvider;
    }
}
