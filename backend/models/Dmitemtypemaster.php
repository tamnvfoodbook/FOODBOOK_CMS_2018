<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "DM_ITEM_TYPE_MASTER".
 *
 * @property integer $ID
 * @property string $ITEM_TYPE_MASTER_NAME
 * @property string $DESCRIPTION
 * @property integer $SORT
 * @property string $IMAGE_PATH
 */
class Dmitemtypemaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DM_ITEM_TYPE_MASTER';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ITEM_TYPE_MASTER_NAME', 'DESCRIPTION'], 'required'],
            [['SORT'], 'integer'],
            [['ITEM_TYPE_MASTER_NAME', 'DESCRIPTION', 'IMAGE_PATH'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'ITEM_TYPE_MASTER_NAME' => 'Item  Type  Master  Name',
            'DESCRIPTION' => 'Description',
            'SORT' => 'Sort',
            'IMAGE_PATH' => 'Image  Path',
        ];
    }
}
