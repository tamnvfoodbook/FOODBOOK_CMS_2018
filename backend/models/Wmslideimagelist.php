<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "WM_SLIDE_IMAGE_LIST".
 *
 * @property string $ID
 * @property string $POS_ID
 * @property string $DESCRIPTION
 * @property string $IMAGE_PATH
 * @property integer $ACTIVE
 * @property integer $SORT
 */
class Wmslideimagelist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'WM_SLIDE_IMAGE_LIST';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['POS_ID', 'DESCRIPTION', 'IMAGE_PATH'], 'required'],
            [['POS_ID', 'ACTIVE', 'SORT'], 'integer'],
            [['DESCRIPTION', 'IMAGE_PATH'], 'string', 'max' => 500]
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
            'DESCRIPTION' => 'Mô tả',
            'IMAGE_PATH' => 'Ảnh',
            'ACTIVE' => 'Trạng thái',
            'SORT' => 'Thứ tự',
        ];
    }
}
