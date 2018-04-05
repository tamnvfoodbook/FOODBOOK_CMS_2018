<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "DM_MEMBERSHIP_TYPE_RELATE".
 *
 * @property string $ID
 * @property string $MEMBERSHIP_ID
 * @property string $POS_PARENT
 * @property string $MEMBERSHIP_TYPE_ID
 * @property string $CREATED_AT
 * @property string $DOB
 */
class Dmmembershiptyperelate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DM_MEMBERSHIP_TYPE_RELATE';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MEMBERSHIP_ID', 'MEMBERSHIP_TYPE_ID'], 'required'],
            [['MEMBERSHIP_ID'], 'integer'],
            [['CREATED_AT', 'DOB'], 'safe'],
            [['POS_PARENT'], 'string', 'max' => 100],
            [['MEMBERSHIP_TYPE_ID'], 'string', 'max' => 20],
            [['POS_PARENT', 'MEMBERSHIP_ID'], 'unique', 'targetAttribute' => ['POS_PARENT', 'MEMBERSHIP_ID'], 'message' => 'The combination of Membership  ID and Pos  Parent has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'MEMBERSHIP_ID' => 'Membership  ID',
            'POS_PARENT' => 'Pos  Parent',
            'MEMBERSHIP_TYPE_ID' => 'Membership  Type  ID',
            'CREATED_AT' => 'Created  At',
            'DOB' => 'Dob',
        ];
    }
}
