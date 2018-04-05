<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dmitemtype;
use yii\helpers\ArrayHelper;

/**
 * DmitemtypeSearch represents the model behind the search form about `backend\models\Dmitemtype`.
 */
class DmitemtypeSearch extends Dmitemtype
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'POS_ID', 'ACTIVE'], 'integer'],
            [['ITEM_TYPE_ID', 'ITEM_TYPE_NAME', 'MAX_ITEM_CHOICE', 'SORT', 'LAST_UPDATED'], 'safe'],
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
    public function search($params,$pos_id)
    {
        $query = Dmitemtype::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if($pos_id){
            $query->andFilterWhere([
                'POS_ID' => $pos_id,
            ]);

            $this->POS_ID = $pos_id;
            $pos_id = null;
        }else{
            $query->andFilterWhere([
                'POS_ID' => $this->POS_ID,
            ]);
        }
        $query->andFilterWhere([
            'ID' => $this->ID,
            'POS_ID' => $this->POS_ID,
            'ACTIVE' => $this->ACTIVE,
            'LAST_UPDATED' => $this->LAST_UPDATED,
        ]);

        $query->andFilterWhere(['=', 'ITEM_TYPE_ID', $this->ITEM_TYPE_ID])
            ->andFilterWhere(['like', 'ITEM_TYPE_NAME', $this->ITEM_TYPE_NAME]);

        return $dataProvider;
    }

    public function searchByPos($id)
    {
        $query = Dmitemtype::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'POS_ID' => $id,
            'ACTIVE' => 1,
        ]);

        return $dataProvider;
    }


    public function searchCategoryByPos($posId){
        $itemType = DmitemtypeSearch::find()
            ->where(['ACTIVE'=> 1])
            ->andWhere(['POS_ID' => $posId])
            ->asArray()
            ->all();
        return $itemType;
    }


    public function searchCategoryForCampain($posId){
        $itemType = DmitemtypeSearch::find()
            ->where(['ACTIVE'=> 1])
            ->andWhere(['POS_ID' => $posId])
            ->asArray()
            ->all();
        $allItemTypeMap = array();
        foreach((array)$itemType as $value){
            array_push($allItemTypeMap,['id'=>$value['ITEM_TYPE_ID'],'name'=> $value['ITEM_TYPE_NAME']]);
        }
        return $allItemTypeMap;
    }

    public function searchCategoryForCampain_bk($posId){

        if(count($posId) > 1){
            $tmp = 0;
            $arrayData = array();
            $allItemTypeMap = array();
            $parten = array();

            foreach($posId as $id){
                $itemType = DmitemtypeSearch::find()
                    ->where(['ACTIVE'=> 1])
                    ->andWhere(['POS_ID' => $id])
                    ->asArray()
                    ->all();
                $itemTypeMap = ArrayHelper::map($itemType,'ITEM_TYPE_ID','ITEM_TYPE_NAME');
                if($tmp == 0){
                    $parten = $itemTypeMap;
                }

//                echo '<pre>';
//                var_dump($parten);
//                var_dump($itemType);
//                echo '</pre>';

                $tmp++;
                $arrayData = array_intersect($parten,$itemTypeMap);
            }

            foreach((array)$arrayData as $key => $value){
                array_push($allItemTypeMap,['id'=>$key,'name'=> $value]);
            }

            return $allItemTypeMap;
        }else{
            $itemType = DmitemtypeSearch::find()
                ->where(['ACTIVE'=> 1])
                ->andWhere(['POS_ID' => $posId])
                ->asArray()
                ->all();
            $allItemTypeMap = array();
            foreach((array)$itemType as $value){
                array_push($allItemTypeMap,['id'=>$value['ITEM_TYPE_ID'],'name'=> $value['ITEM_TYPE_NAME']]);

            }
            return $allItemTypeMap;
        }

    }

}
