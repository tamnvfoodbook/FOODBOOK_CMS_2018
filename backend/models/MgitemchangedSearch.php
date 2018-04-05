<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Mgitemchanged;

/**
 * MgitemchangedSearch represents the model behind the search form about `backend\models\Mgitemchanged`.
 */
class MgitemchangedSearch extends Mgitemchanged
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['_id', 'pos_parent', 'pos_id', 'last_changed', 'reversion', 'changed', 'last_broadcast'], 'safe'],
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
        $query = Mgitemchanged::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', '_id', $this->_id])
            ->andFilterWhere(['like', 'pos_parent', $this->pos_parent])
            ->andFilterWhere(['like', 'pos_id', $this->pos_id])
            ->andFilterWhere(['like', 'last_changed', $this->last_changed])
            ->andFilterWhere(['like', 'reversion', $this->reversion])
            ->andFilterWhere(['like', 'changed', $this->changed])
            ->andFilterWhere(['like', 'last_broadcast', $this->last_broadcast]);

        return $dataProvider;
    }

    public function updatechange($pos_id,$pos_parent = null){

        $model = Mgitemchanged::find()
            ->where(['pos_id' => (int)$pos_id])
            ->one();

        if(!$model){
            $dmpos = Dmpos::find()
                ->where(['ID' => (int)$pos_id])
                ->one();

            $model = new Mgitemchanged();
            $model->pos_parent = $dmpos->POS_PARENT;
        }


        $model->changed = 1;
        $model->reversion  = $model->reversion + 1;
        $nowTime =  date(Yii::$app->params['DATE_TIME_FORMAT_3']);
        $model->pos_id = (int)$pos_id;
        $model->last_changed  =  new \MongoDate(strtotime($nowTime));

        $model->save();
        return $model;
    }
}
