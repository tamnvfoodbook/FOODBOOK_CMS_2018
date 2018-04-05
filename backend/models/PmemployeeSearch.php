<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Pmemployee;

/**
 * PmemployeeSearch represents the model behind the search form about `backend\models\Pmemployee`.
 */
class PmemployeeSearch extends Pmemployee
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'POS_ID', 'PERMISTION'], 'integer'],
            [['POS_PARENT', 'NAME', 'PASSWORD', 'CREATED_AT'], 'safe'],
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
        $query = Pmemployee::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $posSearchModel = new DmposSearch();
        $posIds = $posSearchModel->getIds();

        $query->andFilterWhere([
            'ID' => $this->ID,
            'POS_ID' => $this->POS_ID,
            'CREATED_AT' => $this->CREATED_AT,
            'PERMISTION' => $this->PERMISTION,
        ]);


        $posParentSession = \Yii::$app->session->get('pos_parent');
        $typeAcc = \Yii::$app->session->get('type_acc');
        if ($typeAcc != 1) {
            if($typeAcc == 3){
                if(!$this->POS_ID){
                    $query->where(['POS_ID'=> $posIds]);
                }
                $query->andFilterWhere(['like', 'NAME', $this->NAME])
                    ->andFilterWhere(['=', 'PASSWORD', $this->PASSWORD])
                    ->orderBy(['POS_ID' => SORT_ASC]);
            }else{
                $query->andFilterWhere(['=', 'POS_PARENT', $posParentSession])
                    ->andFilterWhere(['=', 'NAME', $this->NAME])
                    ->andFilterWhere(['=', 'PASSWORD', $this->PASSWORD])
                    ->orderBy(['POS_ID' => SORT_ASC]);
            }

        }else {
            $query->andFilterWhere(['=', 'POS_PARENT', $this->POS_PARENT])
                ->andFilterWhere(['=', 'NAME', $this->NAME])
                ->andFilterWhere(['=', 'PASSWORD', $this->PASSWORD])
                ->orderBy(['POS_ID' => SORT_ASC]);
        }




        return $dataProvider;
    }
}
