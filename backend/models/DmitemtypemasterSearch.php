<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dmitemtypemaster;

/**
 * DmitemtypemasterSearch represents the model behind the search form about `backend\models\Dmitemtypemaster`.
 */
class DmitemtypemasterSearch extends Dmitemtypemaster
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'SORT'], 'integer'],
            [['ITEM_TYPE_MASTER_NAME', 'DESCRIPTION', 'IMAGE_PATH'], 'safe'],
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
        $query = Dmitemtypemaster::find();

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
            'SORT' => $this->SORT,
        ]);

        $query
            ->andFilterWhere(['like', 'ITEM_TYPE_MASTER_NAME', $this->ITEM_TYPE_MASTER_NAME])
            ->andFilterWhere(['like', 'DESCRIPTION', $this->DESCRIPTION])
//            ->andFilterWhere(['=', 'IMAGE_PATH', $this->IMAGE_PATH])
        ;

        return $dataProvider;
    }
    public function searchAllItemTypeMaster(){
            $itemTypeMaster = Dmitemtypemaster::find()
            ->asArray()
            ->all();
        return $itemTypeMaster;
    }
}
