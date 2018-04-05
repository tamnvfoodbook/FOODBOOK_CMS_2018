<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * DmitemSearch represents the model behind the search form about `backend\models\Dmitem`.
 */
class DmitemSearch extends Dmitem
{
    /**
     * @inheritdoc
     */
    public $pos;
    public $itemtypemaster;
    public $itemtype;

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

        // join with relation `author` that is a relation to the table `users`
        // and set the table alias to be `author`
        /*$query->joinWith('pos');

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

        $query->joinWith('itemtype');

        $dataProvider->sort->attributes['itemtype'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['DM_ITEM_TYPE.ITEM_TYPE_NAME' => SORT_ASC],
            'desc' => ['DM_ITEM_TYPE.ITEM_TYPE_NAME' => SORT_DESC],
        ];*/




        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ID' => $this->ID,
            'POS_ID' => $this->POS_ID,
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

            //->andFilterWhere(['like', 'ACTIVE', $type])
            ->andFilterWhere(['=', 'ITEM_ID', $this->ITEM_ID])
            ->andFilterWhere(['=', 'ITEM_TYPE_ID', $this->ITEM_TYPE_ID])
            ->andFilterWhere(['like', 'ITEM_NAME', $this->ITEM_NAME])
            //->andFilterWhere(['like', 'ITEM_IMAGE_PATH_THUMB', $this->ITEM_IMAGE_PATH_THUMB])
//            ->andFilterWhere(['like', 'ITEM_IMAGE_PATH', $this->ITEM_IMAGE_PATH])
            ->andFilterWhere(['like', 'DESCRIPTION', $this->DESCRIPTION])
            //->andFilterWhere(['like', 'FB_IMAGE_PATH', $this->FB_IMAGE_PATH])
            //->andFilterWhere(['like', 'FB_IMAGE_PATH_THUMB', $this->FB_IMAGE_PATH_THUMB])
            //->andFilterWhere(['like', 'ITEM_ID_EAT_WITH', $this->ITEM_ID_EAT_WITH])
            ->orderBy(['POS_ID' => SORT_ASC])
            //->orderBy(['pos.IS_POSMOBILE' => SORT_ASC])
        ;


        return $dataProvider;
    }
    public function searchByPos($params,$POS_ID)
    {
        $query = Dmitem::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // join with relation `author` that is a relation to the table `users`
        // and set the table alias to be `author`
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

//        $query->joinWith('itemtype');
//
//        $dataProvider->sort->attributes['itemtype'] = [
//            // The tables are the ones our relation are configured to
//            // in my case they are prefixed with "tbl_"
//            'asc' => ['DM_ITEM_TYPE.ITEM_TYPE_NAME' => SORT_ASC],
//            'desc' => ['DM_ITEM_TYPE.ITEM_TYPE_NAME' => SORT_DESC],
//        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        $query
            ->where(['DM_POS.ID' => $POS_ID])
            //->orderBy(['POS_ID' => SORT_ASC])
            ->andFilterWhere(['=', 'DM_ITEM.ACTIVE', $this->ACTIVE])
            ->andFilterWhere(['=', 'ITEM_ID', $this->ITEM_ID])
            ->andFilterWhere(['=', 'ITEM_TYPE_ID', $this->ITEM_TYPE_ID])
            ->andFilterWhere(['like', 'ITEM_NAME', $this->ITEM_NAME])
//            ->andFilterWhere(['like', 'ITEM_IMAGE_PATH_THUMB', $this->ITEM_IMAGE_PATH_THUMB])
//            ->andFilterWhere(['like', 'ITEM_IMAGE_PATH', $this->ITEM_IMAGE_PATH])
            //->andFilterWhere(['like', 'DESCRIPTION', $this->DESCRIPTION])
//            ->andFilterWhere(['like', 'FB_IMAGE_PATH', $this->FB_IMAGE_PATH])
//            ->andFilterWhere(['like', 'FB_IMAGE_PATH_THUMB', $this->FB_IMAGE_PATH_THUMB])
            ->andFilterWhere(['like', 'ITEM_ID_EAT_WITH', $this->ITEM_ID_EAT_WITH])
            //->andFilterWhere(['=', 'DM_ITEM_TYPE_MASTER.ID', $this->itemtypemaster])
            //->andFilterWhere(['like', 'DM_POS.ID', $POS_ID])
        ;

        $query->andFilterWhere([
            'ID' => $this->ID,
            //'POS_ID' => $this->POS_ID,
            'ITEM_MASTER_ID' => $this->ITEM_MASTER_ID,
            'ITEM_TYPE_MASTER_ID' => $this->ITEM_TYPE_MASTER_ID,
            'OTS_PRICE' => $this->OTS_PRICE,
            'TA_PRICE' => $this->TA_PRICE,
            //'POINT' => $this->POINT,
            //'IS_GIFT' => $this->IS_GIFT,
            'SHOW_ON_WEB' => $this->SHOW_ON_WEB,
            'SHOW_PRICE_ON_WEB' => $this->SHOW_PRICE_ON_WEB,
            'DM_ITEM.ACTIVE' => $this->ACTIVE,
            'SPECIAL_TYPE' => $this->SPECIAL_TYPE,
            //'LAST_UPDATED' => $this->LAST_UPDATED,
            //'ALLOW_TAKE_AWAY' => $this->ALLOW_TAKE_AWAY,
            'IS_EAT_WITH' => $this->IS_EAT_WITH,
            'REQUIRE_EAT_WITH' => $this->REQUIRE_EAT_WITH,
            'IS_FEATURED' => $this->IS_FEATURED,
        ]);

        return $dataProvider;
    }



    public function searchItemdetail($id,$posId)
    {
        $dataProvider = Dmitem::find()
            ->where(['ID' => $id])
            ->andWhere(['POS_ID' => $posId])
            ->with('pos')
            ->asArray()
            ->one();
        return $dataProvider;
    }


    public function searchAllItemReport($posMapId)
    {
        $items = Dmitem::find()
            ->select(['POS_ID','ACTIVE','COUNT(*) AS allItem'])
            ->where(['POS_ID' => $posMapId])
            ->groupBy(['POS_ID','ACTIVE'])
            ->asArray()
            ->all();
        return $items;
    }


    public function searchAllItemReportJustUpdate($posMapId)
    {

        $today = date('Y-m-d 23:59:59');
        $yesterday = date("Y-m-d", strtotime("-1 day"));

        $items = Dmitem::find()
            ->select(['POS_ID','COUNT(*) AS justupdate'])
            ->where(['POS_ID' => $posMapId])
            ->andWhere(['ACTIVE' => 2])
            ->andWhere(['between', 'LAST_UPDATED', $yesterday, $today])
            ->groupBy(['POS_ID'])
            ->asArray()
            ->all();
        return $items;
    }

    public function searchAllItem()
    {
        $type = \Yii::$app->session->get('type_acc');
        if($type != 1){
            $ids = DmposSearch::getIds();
            $item = Dmitem::find()
                ->select(['ID','ITEM_NAME','POS_ID'])
                ->where(['POS_ID' => $ids])
                ->asArray()
                ->all();
        }else{
            $item = Dmitem::find()
                ->select(['ID','ITEM_NAME','POS_ID'])
                ->asArray()
                ->all();
        }
        return $item;

    }

    public function searchItemCampain($posId){
        $items = Dmitem::find()
            ->where(['ACTIVE'=> 1])
            ->andWhere(['POS_ID' => $posId])
            ->asArray()
            ->all();
        $allItemTypeMap = array();
        $itemsMap = ArrayHelper::map($items,'ITEM_ID','ITEM_NAME');
        foreach((array)$itemsMap as $key => $value){
            array_push($allItemTypeMap,['id'=>$key ,'name'=> $value]);
        }
        return $allItemTypeMap;
    }

    public function searchItemEatWith($POS_ID)
    {
        $dataProvider = Dmitem::find()
            ->select(['ITEM_ID','ITEM_NAME'])
            ->where(['IS_EAT_WITH' => 1])
            ->andWhere(['POS_ID' => $POS_ID])
            ->andWhere(['ACTIVE' => 1])
            ->asArray()
            ->orderBy(['ITEM_NAME' => SORT_ASC])
            ->all();
        return $dataProvider;
    }

    public function searchItemByPos($posId){
        $item = Dmitem::find()
            ->select(['ID','ITEM_ID','ITEM_IMAGE_PATH','ITEM_IMAGE_PATH_THUMB','ITEM_NAME','TA_PRICE','OTS_PRICE','ITEM_TYPE_ID','DESCRIPTION'])
            ->where(['ACTIVE'=> 1])
            ->andWhere(['POS_ID' => $posId])
            ->asArray()
            ->all();
        return $item;
    }
    public function searchItemByParentItem($itemId){
        $item = Dmitem::find()
            ->where(['ACTIVE'=> 1])
            ->andWhere(['IS_SUB'=> 1])
            ->andWhere(['ITEM_ID_BARCODE' => $itemId])
            ->asArray()
            ->all();
        return $item;
    }
    public function searchMainItemByPos($posId){
        $itemType = Dmitem::find()
            ->select(['ID','ITEM_IMAGE_PATH','ITEM_IMAGE_PATH_THUMB','ITEM_NAME','TA_PRICE','OTS_PRICE','ITEM_TYPE_ID','DESCRIPTION'])
            ->where(['IS_EAT_WITH'=> 0])
            ->andWhere(['ACTIVE'=> 1])
            ->andWhere(['POS_ID' => $posId])
            ->asArray()
            ->all();
        return $itemType;
    }


}
