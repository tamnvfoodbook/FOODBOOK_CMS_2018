<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dmfacebookpageconfig;

/**
 * DmfacebookpageconfigSearch represents the model behind the search form about `backend\models\Dmfacebookpageconfig`.
 */
class DmfacebookpageconfigSearch extends Dmfacebookpageconfig
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PAGE_ID', 'STATUS_BOTCHAT'], 'integer'],
            [['POS_PARENT', 'PAGE_ACCESS_TOKEN', 'URL_POINT_POLICY', 'URL_PROMOTION', 'CREATED_AT', 'UPDATED_AT', 'PERSISTENT_MENU', 'MESSAGE_GREETING', 'MESSAGE_ERROR', 'MESSAGE_CHECKIN', 'MESSAGE_MEMBER_POINT', 'MESSAGE_MEMBER_NO_POINT', 'MESSAGE_NO_GIFT_POINT', 'MESSAGE_GET_MENU', 'MESSAGE_TOKEN_ORDER', 'MESSAGE_ORDER_ONLINE', 'MESSAGE_BOOKING_ONLINE', 'MESSAGE_REQUIED_RATE', 'MESSAGE_REQUIED_REGISTER', 'MESSAGE_REGISTER_SUCCESS', 'MESSAGE_NO_DAILY_VOUCHER', 'MESSAGE_MISS_DAILY_VOUCHER', 'MESSAGE_SENT_DAILY_VOUCHER', 'MESSAGE_LIMIT_DAILY_VOUCHER', 'SUB_TITLE_HOTLINE', 'SUB_TITLE_PROMOTION', 'SUB_TITLE_POLICY_POINT', 'MESSAGE_GET_POS', 'AUTO_REPLY_MENU', 'JSON_FUNCTION'], 'safe'],
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
        $query = Dmfacebookpageconfig::find();

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
            'PAGE_ID' => $this->PAGE_ID,
            'CREATED_AT' => $this->CREATED_AT,
            'UPDATED_AT' => $this->UPDATED_AT,
            'STATUS_BOTCHAT' => $this->STATUS_BOTCHAT,
        ]);

        $query->andFilterWhere(['like', 'POS_PARENT', $this->POS_PARENT])
            ->andFilterWhere(['like', 'PAGE_ACCESS_TOKEN', $this->PAGE_ACCESS_TOKEN])
            ->andFilterWhere(['like', 'URL_POINT_POLICY', $this->URL_POINT_POLICY])
            ->andFilterWhere(['like', 'URL_PROMOTION', $this->URL_PROMOTION])
            ->andFilterWhere(['like', 'PERSISTENT_MENU', $this->PERSISTENT_MENU])
            ->andFilterWhere(['like', 'MESSAGE_GREETING', $this->MESSAGE_GREETING])
            ->andFilterWhere(['like', 'MESSAGE_ERROR', $this->MESSAGE_ERROR])
            ->andFilterWhere(['like', 'MESSAGE_CHECKIN', $this->MESSAGE_CHECKIN])
            ->andFilterWhere(['like', 'MESSAGE_MEMBER_POINT', $this->MESSAGE_MEMBER_POINT])
            ->andFilterWhere(['like', 'MESSAGE_MEMBER_NO_POINT', $this->MESSAGE_MEMBER_NO_POINT])
            ->andFilterWhere(['like', 'MESSAGE_NO_GIFT_POINT', $this->MESSAGE_NO_GIFT_POINT])
            ->andFilterWhere(['like', 'MESSAGE_GET_MENU', $this->MESSAGE_GET_MENU])
            ->andFilterWhere(['like', 'MESSAGE_TOKEN_ORDER', $this->MESSAGE_TOKEN_ORDER])
            ->andFilterWhere(['like', 'MESSAGE_ORDER_ONLINE', $this->MESSAGE_ORDER_ONLINE])
            ->andFilterWhere(['like', 'MESSAGE_BOOKING_ONLINE', $this->MESSAGE_BOOKING_ONLINE])
            ->andFilterWhere(['like', 'MESSAGE_REQUIED_RATE', $this->MESSAGE_REQUIED_RATE])
            ->andFilterWhere(['like', 'MESSAGE_REQUIED_REGISTER', $this->MESSAGE_REQUIED_REGISTER])
            ->andFilterWhere(['like', 'MESSAGE_REGISTER_SUCCESS', $this->MESSAGE_REGISTER_SUCCESS])
            ->andFilterWhere(['like', 'MESSAGE_NO_DAILY_VOUCHER', $this->MESSAGE_NO_DAILY_VOUCHER])
            ->andFilterWhere(['like', 'MESSAGE_MISS_DAILY_VOUCHER', $this->MESSAGE_MISS_DAILY_VOUCHER])
            ->andFilterWhere(['like', 'MESSAGE_SENT_DAILY_VOUCHER', $this->MESSAGE_SENT_DAILY_VOUCHER])
            ->andFilterWhere(['like', 'MESSAGE_LIMIT_DAILY_VOUCHER', $this->MESSAGE_LIMIT_DAILY_VOUCHER])
            ->andFilterWhere(['like', 'SUB_TITLE_HOTLINE', $this->SUB_TITLE_HOTLINE])
            ->andFilterWhere(['like', 'SUB_TITLE_PROMOTION', $this->SUB_TITLE_PROMOTION])
            ->andFilterWhere(['like', 'SUB_TITLE_POLICY_POINT', $this->SUB_TITLE_POLICY_POINT])
            ->andFilterWhere(['like', 'MESSAGE_GET_POS', $this->MESSAGE_GET_POS])
            ->andFilterWhere(['like', 'AUTO_REPLY_MENU', $this->AUTO_REPLY_MENU])
            ->andFilterWhere(['like', 'JSON_FUNCTION', $this->JSON_FUNCTION]);

        return $dataProvider;
    }
}
