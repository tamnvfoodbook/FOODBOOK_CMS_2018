<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "DM_MEMBERSHIP_TYPE".
 *
 * @property string $ID
 * @property string $POS_PARENT
 * @property string $MEMBERSHIP_TYPE_ID
 * @property string $MEMBERSHIP_TYPE_NAME
 * @property integer $ACTIVE
 * @property string $MEMBERSHIP_TYPE_IMAGE
 */
class Dmmembershiptype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DM_MEMBERSHIP_TYPE';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MEMBERSHIP_TYPE_NAME'], 'required'],
            [['ACTIVE'], 'integer'],
            [['POS_PARENT'], 'string', 'max' => 20],
            [['MEMBERSHIP_TYPE_ID'], 'string', 'max' => 15],
            [['MEMBERSHIP_TYPE_NAME'], 'string', 'max' => 200],
            [['MEMBERSHIP_TYPE_IMAGE'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'POS_PARENT' => 'Pos  Parent',
            'MEMBERSHIP_TYPE_ID' => 'Membership  Type  ID',
            'MEMBERSHIP_TYPE_NAME' => 'Membership  Type  Name',
            'ACTIVE' => 'Active',
            'MEMBERSHIP_TYPE_IMAGE' => 'Membership  Type  Image',
        ];
    }
}
