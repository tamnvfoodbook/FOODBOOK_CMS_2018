<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dmuserpartner;

/**
 * DmuserpartnerSearch represents the model behind the search form about `backend\models\Dmuserpartner`.
 */
class DmuserpartnerSearch extends Dmuserpartner
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'ACTIVE', 'IS_SEND_SMS'], 'integer'],
            [['PARTNER_NAME', 'AUTH_KEY', 'ACCESS_TOKEN', 'LIST_POS_PARENT', 'BRAND_NAME', 'SMS_PARTNER', 'API_KEY', 'SECRET_KEY', 'RESPONSE_URL'], 'safe'],
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
        $query = Dmuserpartner::find();

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
            'ACTIVE' => $this->ACTIVE,
            'IS_SEND_SMS' => $this->IS_SEND_SMS,
        ]);

        $query->andFilterWhere(['like', 'PARTNER_NAME', $this->PARTNER_NAME])
            ->andFilterWhere(['like', 'AUTH_KEY', $this->AUTH_KEY])
            ->andFilterWhere(['like', 'ACCESS_TOKEN', $this->ACCESS_TOKEN])
            ->andFilterWhere(['like', 'LIST_POS_PARENT', $this->LIST_POS_PARENT])
            ->andFilterWhere(['like', 'BRAND_NAME', $this->BRAND_NAME])
            ->andFilterWhere(['like', 'SMS_PARTNER', $this->SMS_PARTNER])
            ->andFilterWhere(['like', 'API_KEY', $this->API_KEY])
            ->andFilterWhere(['like', 'SECRET_KEY', $this->SECRET_KEY])
            ->andFilterWhere(['like', 'RESPONSE_URL', $this->RESPONSE_URL]);

        return $dataProvider;
    }

    public function searchAllpartner(){
        $userPhone = Dmuserpartner::find()
            ->asArray()
            ->all();
        return $userPhone;
    }

}
