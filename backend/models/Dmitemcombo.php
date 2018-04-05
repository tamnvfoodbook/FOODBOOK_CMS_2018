<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "DM_ITEM_COMBO".
 *
 * @property string $ID
 * @property string $POS_ID
 * @property string $ITEM_ID
 * @property string $COMBO_ITEM_ID_LIST
 * @property integer $QUANTITY
 * @property double $TA_PRICE
 * @property double $OTS_PRICE
 * @property double $TA_DISCOUNT
 * @property double $OTS_DISCOUNT
 * @property integer $SORT
 * @property string $CREATED_AT
 */
class Dmitemcombo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DM_ITEM_COMBO';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['POS_ID', 'ITEM_ID', 'COMBO_ITEM_ID_LIST', 'CREATED_AT'], 'required'],
            [['POS_ID', 'QUANTITY', 'SORT'], 'integer'],
            [['TA_PRICE', 'OTS_PRICE', 'TA_DISCOUNT', 'OTS_DISCOUNT'], 'number'],
            [['CREATED_AT'], 'safe'],
            [['ITEM_ID'], 'string', 'max' => 50],
            [['COMBO_ITEM_ID_LIST'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'POS_ID' => 'Pos  ID',
            'ITEM_ID' => 'Item  ID',
            'COMBO_ITEM_ID_LIST' => 'Combo  Item  Id  List',
            'QUANTITY' => 'Quantity',
            'TA_PRICE' => 'Ta  Price',
            'OTS_PRICE' => 'Ots  Price',
            'TA_DISCOUNT' => 'Ta  Discount',
            'OTS_DISCOUNT' => 'Ots  Discount',
            'SORT' => 'Sort',
            'CREATED_AT' => 'Created  At',
        ];
    }
}
