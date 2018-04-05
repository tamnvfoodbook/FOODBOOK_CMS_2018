<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "DM_PARTNER".
 *
 * @property string $ID
 * @property string $PARTNER_NAME
 * @property string $DESCRIPTION
 * @property string $AVATAR_IMAGE
 * @property integer $ACTIVE
 */
class Dmpartner extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DM_PARTNER';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PARTNER_NAME'], 'required'],
            [['DESCRIPTION'], 'string'],
            [['ACTIVE'], 'integer'],
            [['PARTNER_NAME'], 'string', 'max' => 50],
            [['AVATAR_IMAGE'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'PARTNER_NAME' => 'Tên đối tác',
            'DESCRIPTION' => 'Mô tả',
            'AVATAR_IMAGE' => 'Ảnh đại diện',
            'ACTIVE' => 'Active',
        ];
    }
}
