<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * DmitemSearch represents the model behind the search form about `backend\models\Dmitem`.
 */
class DmitemupdateSearch extends Dmitem
{
    /**
     * @inheritdoc
     */
    public $pos;
    public $itemtypemaster;

    public function rules()
    {
        return [
            [['ID', 'POS_ID', 'ITEM_MASTER_ID', 'ITEM_TYPE_MASTER_ID', 'IS_GIFT', 'SHOW_ON_WEB', 'SHOW_PRICE_ON_WEB', 'ACTIVE', 'SPECIAL_TYPE', 'ALLOW_TAKE_AWAY', 'IS_EAT_WITH', 'REQUIRE_EAT_WITH', 'IS_FEATURED'], 'integer'],
            [['ITEM_ID', 'ITEM_TYPE_ID', 'ITEM_NAME', 'ITEM_IMAGE_PATH_THUMB', 'ITEM_IMAGE_PATH', 'DESCRIPTION', 'LAST_UPDATED', 'FB_IMAGE_PATH', 'FB_IMAGE_PATH_THUMB', 'ITEM_ID_EAT_WITH'], 'safe'],
            [['OTS_PRICE', 'TA_PRICE', 'POINT'], 'number'],
            [['pos','itemtypemaster'], 'safe'],
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
    public function search($params,$type = 2)
    {

        $query = Dmitem::find();

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


        $query->joinWith('itemtypemaster');

        $dataProvider->sort->attributes['itemtypemaster'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['DM_ITEM_TYPE_MASTER.ITEM_TYPE_MASTER_NAME' => SORT_ASC],
            'desc' => ['DM_ITEM_TYPE_MASTER.ITEM_TYPE_MASTER_NAME' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ID' => $this->ID,
            'POS_ID' => $this->POS_ID,
            'DM_POS.IS_POS_MOBILE' => $this->pos,
            'DM_POS.ACTIVE' => 1,
            'ITEM_MASTER_ID' => $this->ITEM_MASTER_ID,
            'ITEM_TYPE_MASTER_ID' => $this->ITEM_TYPE_MASTER_ID,
            'OTS_PRICE' => $this->OTS_PRICE,
            'TA_PRICE' => $this->TA_PRICE,
            'POINT' => $this->POINT,
            'IS_GIFT' => $this->IS_GIFT,
            'SHOW_ON_WEB' => $this->SHOW_ON_WEB,
            'SHOW_PRICE_ON_WEB' => $this->SHOW_PRICE_ON_WEB,
            'DM_ITEM.ACTIVE' => $this->ACTIVE,
            'SPECIAL_TYPE' => $this->SPECIAL_TYPE,
            'LAST_UPDATED' => $this->LAST_UPDATED,
            'ALLOW_TAKE_AWAY' => $this->ALLOW_TAKE_AWAY,
            'IS_EAT_WITH' => $this->IS_EAT_WITH,
            'REQUIRE_EAT_WITH' => $this->REQUIRE_EAT_WITH,
            'IS_FEATURED' => $this->IS_FEATURED,
        ]);

        $query
            //->orderBy(['POS_ID' => SORT_ASC])
            ->andFilterWhere(['=', 'DM_ITEM.ACTIVE', $type])
            ->andFilterWhere(['=', 'ITEM_ID', $this->ITEM_ID])
            ->andFilterWhere(['=', 'ITEM_TYPE_ID', $this->ITEM_TYPE_ID])
            ->andFilterWhere(['like', 'ITEM_NAME', $this->ITEM_NAME])
            //->andFilterWhere(['like', 'ITEM_IMAGE_PATH_THUMB', $this->ITEM_IMAGE_PATH_THUMB])
//            ->andFilterWhere(['like', 'ITEM_IMAGE_PATH', $this->ITEM_IMAGE_PATH])
            //->andFilterWhere(['like', 'DESCRIPTION', $this->DESCRIPTION])
            //->andFilterWhere(['like', 'FB_IMAGE_PATH', $this->FB_IMAGE_PATH])
            //->andFilterWhere(['like', 'FB_IMAGE_PATH_THUMB', $this->FB_IMAGE_PATH_THUMB])
            //->andFilterWhere(['like', 'ITEM_ID_EAT_WITH', $this->ITEM_ID_EAT_WITH])
            ->orderBy(['DM_POS.IS_POS_MOBILE' => SORT_ASC])
        ;
        return $dataProvider;
    }
}
