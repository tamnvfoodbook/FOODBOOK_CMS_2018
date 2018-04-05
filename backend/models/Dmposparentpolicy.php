<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "DM_POS_PARENT_POLICY".
 *
 * @property string $ID
 * @property string $POS_PARENT
 * @property integer $EXCHANGE_POINT
 * @property string $DESCRIPTION
 */
class Dmposparentpolicy extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DM_POS_PARENT_POLICY';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['POS_PARENT'], 'required'],
            [['EXCHANGE_POINT'], 'integer'],
            [['POS_PARENT'], 'string', 'max' => 20],
            [['DESCRIPTION'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'POS_PARENT' => 'Thương hiệu',
            'EXCHANGE_POINT' => 'Điểm quy đổi',
            'DESCRIPTION' => 'Mô tả',
        ];
    }
}
