<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "DM_ITEM_TYPE".
 *
 * @property integer $ID
 * @property string $POS_ID
 * @property string $ITEM_TYPE_ID
 * @property string $ITEM_TYPE_NAME
 * @property integer $ACTIVE
 * @property string $LAST_UPDATED
 * @property string $MAX_ITEM_CHOICE
 */
class Dmitemtype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DM_ITEM_TYPE';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['POS_ID', 'ACTIVE','MAX_ITEM_CHOICE'], 'integer'],
            [['ITEM_TYPE_NAME'], 'required'],
            [['LAST_UPDATED'], 'safe'],
            [['ITEM_TYPE_ID'], 'string', 'max' => 15],
            [['ITEM_TYPE_NAME'], 'string', 'max' => 200],
            [['POS_ID', 'ITEM_TYPE_ID'], 'unique', 'targetAttribute' => ['POS_ID', 'ITEM_TYPE_ID'], 'message' => 'The combination of Pos  ID and Item  Type  ID has already been taken.']
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
            'ITEM_TYPE_ID' => 'Item  Type  ID',
            'ITEM_TYPE_NAME' => 'Nhóm món',
            'ACTIVE' => 'Active',
            'LAST_UPDATED' => 'Last  Updated',
            'MAX_ITEM_CHOICE' => 'Giới hạn số món',
        ];
    }
}
