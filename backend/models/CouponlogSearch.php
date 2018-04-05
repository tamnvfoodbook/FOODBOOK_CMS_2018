<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CouponlogSearch represents the model behind the search form about `backend\models\Couponlog`.
 */
class CouponlogSearch extends Couponlog
{
    /**
     * @inheritdoc
     */
    public $dmmembership;
    public $pos;

    public function rules()
    {
        return [
            [['_id', 'Pos_Id', 'User_Id', 'Coupon_Id', 'User_Id_Parent', 'User_Id_Parent', 'Coupon_Log_Date', 'Coupon_Log_Start', 'Coupon_Log_End'/*, 'Share_Quantity'*/,'Pr_Key'], 'safe'],
            [['dmmembership','pos'],'safe'],
            [['Coupon_Name'],'string'],
            [['User_Id','Active'],'integer'],
            [['Denominations'],'integer'],

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
    public function search($params,$type,$POS_ID_LIST = NULL)
    {
        $query = Couponlog::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $query->with('dmmembership');

        $dataProvider->sort->attributes['dmmembership'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['DM_MEMBERSHIP.MEMBER_NAME' => SORT_ASC],
            'desc' => ['DM_MEMBERSHIP.MEMBER_NAME' => SORT_DESC],
        ];


        $query->with('pos');
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

        if($POS_ID_LIST){
            if($this->Pos_Id){
                $query->andFilterWhere(['Pos_Id' => (int)$this->Pos_Id]);
            }else{
                if($type === 'COUPON_TYPE_POS'){
                    $query->andFilterWhere([
                        'Pos_Id' => $POS_ID_LIST,
                    ]);
                }
                if($type == 'COUPON_TYPE_POS_PARENT'){
                    $POS_PARENT = \Yii::$app->session->get('pos_parent');
                    $query->andFilterWhere([
                        'Pos_Parent' => $POS_PARENT,
                    ]);
                }
            }
        }else{
            if($this->Pos_Id){
                $query
                    ->andFilterWhere(['Pos_Id' => (int)$this->Pos_Id])
                ;
            }
        }


        $query
            ->orderBy(['Coupon_Log_Date' => SORT_DESC])
            ->andFilterWhere(['like', '_id', $this->_id])
            ->andFilterWhere(['=','Type', $type])
            ->andFilterWhere(['=', 'User_Id', $this->User_Id])
            ->andFilterWhere(['=', 'Coupon_Id', $this->Coupon_Id])
            ->andFilterWhere(['=', 'User_Id_Parent', $this->User_Id_Parent])
            ->andFilterWhere(['=', 'Coupon_Log_Date', $this->Coupon_Log_Date])
            ->andFilterWhere(['=', 'Coupon_Log_Start', $this->Coupon_Log_Start])
            ->andFilterWhere(['=', 'Coupon_Log_End', $this->Coupon_Log_End])
            ->andFilterWhere(['=', 'Denominations', $this->Denominations])
            ->andFilterWhere(['=', 'Coupon_Name', $this->Coupon_Name])
            ->andFilterWhere(['=', 'Active', $this->Active])
            ->andFilterWhere(['=', 'Pr_Key', $this->Pr_Key])
            ->andFilterWhere(['=', 'DM_MEMBERSHIP.MEMBER_NAME', $this->dmmembership])
        ;



        return $dataProvider;
    }

    public function findOneCouponLog($id){
        $couponLog = Couponlog::find()
            ->where(['_id' => $id])
            ->with(['pos','coupon'])
            ->one();
        return $couponLog;
    }

}
