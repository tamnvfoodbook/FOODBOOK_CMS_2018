<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dmzalopageconfig;

/**
 * DmzalopageconfigSearch represents the model behind the search form about `backend\models\Dmzalopageconfig`.
 */
class DmzalopageconfigSearch extends Dmzalopageconfig
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PAGE_ID'], 'integer'],
            [['POS_PARENT', 'ZALO_OA_KEY', 'URL_POINT_POLICY', 'URL_PROMOTION', 'MESSAGE_ERROR', 'MESSAGE_TITLE_CHECKIN', 'MESSAGE_CHECKIN', 'MESSAGE_MEMBER_POINT', 'MESSAGE_MEMBER_NO_POINT', 'MESSAGE_NO_GIFT_POINT', 'MESSAGE_GET_MENU', 'MESSAGE_TOKEN_ORDER', 'MESSAGE_TITLE_ORDER_ONLINE', 'MESSAGE_ORDER_ONLINE', 'MESSAGE_TITLE_BOOKING', 'MESSAGE_BOOKING_ONLINE', 'MESSAGE_TITLE_RATE', 'MESSAGE_REQUIED_RATE', 'MESSAGE_TITLE_REQUIED_REGISTER', 'MESSAGE_REQUIED_REGISTER', 'MESSAGE_REGISTER_SUCCESS', 'MESSAGE_NO_DAILY_VOUCHER', 'MESSAGE_MISS_DAILY_VOUCHER', 'MESSAGE_SENT_DAILY_VOUCHER', 'MESSAGE_LIMIT_DAILY_VOUCHER', 'MESSAGE_TITLE_LIST_POS', 'MESSAGE_LIST_POS', 'MESSAGE_TITLE_MEMBERSHIP_INFO', 'MESSAGE_TITLE_PROMOTION', 'MESSAGE_VIEW_ALL_ARTICLES', 'MESSAGE_SHOW_PROMOTION', 'MESSAGE_TITLE_GET_MENU', 'CREATED_AT', 'UPDATED_AT', 'JSON_FUNCTION', 'IMAGE_PATH'], 'safe'],
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
        $query = Dmzalopageconfig::find();

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
        ]);

        $query->andFilterWhere(['like', 'POS_PARENT', $this->POS_PARENT])
            ->andFilterWhere(['like', 'ZALO_OA_KEY', $this->ZALO_OA_KEY])
            ->andFilterWhere(['like', 'URL_POINT_POLICY', $this->URL_POINT_POLICY])
            ->andFilterWhere(['like', 'URL_PROMOTION', $this->URL_PROMOTION])
            ->andFilterWhere(['like', 'MESSAGE_ERROR', $this->MESSAGE_ERROR])
            ->andFilterWhere(['like', 'MESSAGE_TITLE_CHECKIN', $this->MESSAGE_TITLE_CHECKIN])
            ->andFilterWhere(['like', 'MESSAGE_CHECKIN', $this->MESSAGE_CHECKIN])
            ->andFilterWhere(['like', 'MESSAGE_MEMBER_POINT', $this->MESSAGE_MEMBER_POINT])
            ->andFilterWhere(['like', 'MESSAGE_MEMBER_NO_POINT', $this->MESSAGE_MEMBER_NO_POINT])
            ->andFilterWhere(['like', 'MESSAGE_NO_GIFT_POINT', $this->MESSAGE_NO_GIFT_POINT])
            ->andFilterWhere(['like', 'MESSAGE_GET_MENU', $this->MESSAGE_GET_MENU])
            ->andFilterWhere(['like', 'MESSAGE_TOKEN_ORDER', $this->MESSAGE_TOKEN_ORDER])
            ->andFilterWhere(['like', 'MESSAGE_TITLE_ORDER_ONLINE', $this->MESSAGE_TITLE_ORDER_ONLINE])
            ->andFilterWhere(['like', 'MESSAGE_ORDER_ONLINE', $this->MESSAGE_ORDER_ONLINE])
            ->andFilterWhere(['like', 'MESSAGE_TITLE_BOOKING', $this->MESSAGE_TITLE_BOOKING])
            ->andFilterWhere(['like', 'MESSAGE_BOOKING_ONLINE', $this->MESSAGE_BOOKING_ONLINE])
            ->andFilterWhere(['like', 'MESSAGE_TITLE_RATE', $this->MESSAGE_TITLE_RATE])
            ->andFilterWhere(['like', 'MESSAGE_REQUIED_RATE', $this->MESSAGE_REQUIED_RATE])
            ->andFilterWhere(['like', 'MESSAGE_TITLE_REQUIED_REGISTER', $this->MESSAGE_TITLE_REQUIED_REGISTER])
            ->andFilterWhere(['like', 'MESSAGE_REQUIED_REGISTER', $this->MESSAGE_REQUIED_REGISTER])
            ->andFilterWhere(['like', 'MESSAGE_REGISTER_SUCCESS', $this->MESSAGE_REGISTER_SUCCESS])
            ->andFilterWhere(['like', 'MESSAGE_NO_DAILY_VOUCHER', $this->MESSAGE_NO_DAILY_VOUCHER])
            ->andFilterWhere(['like', 'MESSAGE_MISS_DAILY_VOUCHER', $this->MESSAGE_MISS_DAILY_VOUCHER])
            ->andFilterWhere(['like', 'MESSAGE_SENT_DAILY_VOUCHER', $this->MESSAGE_SENT_DAILY_VOUCHER])
            ->andFilterWhere(['like', 'MESSAGE_LIMIT_DAILY_VOUCHER', $this->MESSAGE_LIMIT_DAILY_VOUCHER])
            ->andFilterWhere(['like', 'MESSAGE_TITLE_LIST_POS', $this->MESSAGE_TITLE_LIST_POS])
            ->andFilterWhere(['like', 'MESSAGE_LIST_POS', $this->MESSAGE_LIST_POS])
            ->andFilterWhere(['like', 'MESSAGE_TITLE_MEMBERSHIP_INFO', $this->MESSAGE_TITLE_MEMBERSHIP_INFO])
            ->andFilterWhere(['like', 'MESSAGE_TITLE_PROMOTION', $this->MESSAGE_TITLE_PROMOTION])
            ->andFilterWhere(['like', 'MESSAGE_VIEW_ALL_ARTICLES', $this->MESSAGE_VIEW_ALL_ARTICLES])
            ->andFilterWhere(['like', 'MESSAGE_SHOW_PROMOTION', $this->MESSAGE_SHOW_PROMOTION])
            ->andFilterWhere(['like', 'MESSAGE_TITLE_GET_MENU', $this->MESSAGE_TITLE_GET_MENU])
            ->andFilterWhere(['like', 'JSON_FUNCTION', $this->JSON_FUNCTION]);

        return $dataProvider;
    }


    public function checkZaloConfig($posParent){
        $config = Dmzalopageconfig::find()
            ->where(['POS_PARENT' => $posParent])
            ->one();
        return $config;
    }

}
