<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dmposparent;


/**
 * DmposparentSearch represents the model behind the search form about `backend\models\Dmposparent`.
 */
class DmposparentSearch extends Dmposparent
{
    /**
     * @inheritdoc
     */

    public function rules()
    {
        return [
            [['AHAMOVE_ID','ID','NAME','CREATED_AT', 'DESCRIPTION', 'IMAGE','SOURCE'], 'safe'],
            [['POS_TYPE','IS_GIFT_POINT'], 'integer'],
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
        $query = Dmposparent::find();

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
            'AHAMOVE_ID' => $this->AHAMOVE_ID,
            'SOURCE' => $this->SOURCE,
            'POS_TYPE' => $this->POS_TYPE,
            'IS_GIFT_POINT' => $this->IS_GIFT_POINT,
        ]);

        $query->andFilterWhere(['like', 'ID', $this->ID])
                ->andFilterWhere(['like', 'DESCRIPTION', $this->DESCRIPTION])
                ->andFilterWhere(['like', 'NAME', $this->NAME]);
            //->andFilterWhere(['like', 'IMAGE', $this->IMAGE]);

        if ( ! is_null($this->CREATED_AT) && strpos($this->CREATED_AT, ' - ') !== false ) {
            list($start_date, $end_date) = explode(' - ', $this->CREATED_AT);
            $query->andFilterWhere(['between', 'CREATED_AT', $start_date, $end_date]);
            //$this->created_at = null;
        }

        return $dataProvider;
    }
    public function searchAllParent(){
        $type = \Yii::$app->session->get('type_acc');
        if($type != 1){
            $posparentSesion = \Yii::$app->session->get('pos_parent');
            $posparent = Dmposparent::find()
                ->where(['ID' => $posparentSesion])
                ->asArray()
                ->all();
        }else{
            $posparent = Dmposparent::find()
                ->asArray()
            ->all();
        }

        return $posparent;
    }

    public function searchPosparentById($idPosparent){
        $posparent = Dmposparent::find()
            ->where(['ID' => $idPosparent])
            ->one();
        return $posparent;
    }
}
