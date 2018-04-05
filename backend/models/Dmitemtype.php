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
 * @property string $MIN_ITEM_CHOICE
 * @property string $SORT
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
    public $ITEM_LIST;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['POS_ID', 'ACTIVE','MAX_ITEM_CHOICE'], 'integer'],
            [['ITEM_TYPE_NAME','ITEM_TYPE_ID'], 'required'],
            [['LAST_UPDATED','SORT','ITEM_LIST','MIN_ITEM_CHOICE'], 'safe'],
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
            'POS_ID' => 'Nhà hàng',
            'ITEM_TYPE_ID' => 'Mã nhóm món',
            'ITEM_TYPE_NAME' => 'Nhóm món',
            'ACTIVE' => 'Active',
            'LAST_UPDATED' => 'Lần cuối cập nhật',
            'MIN_ITEM_CHOICE' => 'Số món ít nhất được chọn trong nhóm',
            'MAX_ITEM_CHOICE' => 'Giới hạn số món được chọn trong nhóm',
            'ITEM_LIST' => 'Danh sách món ăn',
        ];
    }
}
