<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Campaign;

/**
 * CampaignSearch represents the model behind the search form about `backend\models\Campaign`.
 */
class CampaignSearch extends Campaign
{
    /**
     * @inheritdoc
     */

    public $pos;
    public $city;
    public $coupon;

    public function rules()
    {
        return [
            [['_id', 'coupon', 'className', 'Pos_Id', 'City_Id', 'Campaign_Name', 'Campaign_Desc', 'Campaign_Type', 'Campaign_Type_Row', 'Hex_Color', 'Image', 'Image_Line', 'Image_Logo', 'Campaign_Created_At', 'Campaign_Start', 'Campaign_End', 'Coupon_Id', 'Item_Id_List', 'Active', 'Sort', 'Show_Price_Bottom'], 'safe'],
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
    public function search($params,$POS_ID_LIST = NULL)
    {
        $query = Campaign::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->with('pos');

        $dataProvider->sort->attributes['pos'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['DM_POS.POS_NAME' => SORT_ASC],
            'desc' => ['DM_POS.POS_NAME' => SORT_DESC],
        ];

        $query->with('city');

        $dataProvider->sort->attributes['pos'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['DM_CITY.CITY_NAME' => SORT_ASC],
            'desc' => ['DM_CITY.CITY_NAME' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['coupon'] = [
            // in my case they are prefixed with "tbl_"
            'asc' => ['COUPON_LOG.Denominations' => SORT_ASC],
            'desc' => ['COUPON_LOG.Denominations' => SORT_DESC],
        ];

        $this->load($params);


        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if($POS_ID_LIST){
            if($this->Pos_Id){
                $query->andFilterWhere(['Pos_Id' => (int)$this->Pos_Id]);
            }else{
                $query->andFilterWhere(['Pos_Id' => $POS_ID_LIST]);
            }
        }else{
            if($this->Pos_Id){
                $query
                    ->andFilterWhere(['Pos_Id' => (int)$this->Pos_Id])
                ;
            }
        }


        $query
            //->andFilterWhere(['like', '_id', $this->_id])
            //->andFilterWhere(['like', 'className', $this->className])
            //->andFilterWhere(['like', 'Pos_Id', $this->Pos_Id])
            ->andFilterWhere(['=', 'City_Id', $this->City_Id])
            ->andFilterWhere(['=', 'Campaign_Name', $this->Campaign_Name])
            ->andFilterWhere(['like', 'Campaign_Desc', $this->Campaign_Desc])
            ->andFilterWhere(['=', 'Campaign_Type', $this->Campaign_Type])
            ->andFilterWhere(['=', 'Campaign_Type_Row', $this->Campaign_Type_Row])
            //->andFilterWhere(['like', 'Hex_Color', $this->Hex_Color])
            //->andFilterWhere(['like', 'Image', $this->Image])
            //->andFilterWhere(['like', 'Image_Line', $this->Image_Line])
            //->andFilterWhere(['like', 'Image_Logo', $this->Image_Logo])
            ->andFilterWhere(['=', 'Campaign_Created_At', $this->Campaign_Created_At])
            ->andFilterWhere(['=', 'Campaign_Start', $this->Campaign_Start])
            ->andFilterWhere(['=', 'Campaign_End', $this->Campaign_End])
            ->andFilterWhere(['=', 'Coupon_Id', $this->Coupon_Id])
            ->andFilterWhere(['=', 'Item_Id_List', $this->Item_Id_List])
            ->andFilterWhere(['=', 'Active', $this->Active])
            ->andFilterWhere(['=', 'Sort', $this->Sort])
            ->andFilterWhere(['=', 'Show_Price_Bottom', $this->Show_Price_Bottom]);

        return $dataProvider;
    }
}
