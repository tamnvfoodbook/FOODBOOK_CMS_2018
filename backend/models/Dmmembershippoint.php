<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "DM_MEMBERSHIP_POINT".
 *
 * @property string $MEMBERSHIP_ID
 * @property string $POS_PARENT
 * @property double $AMOUNT
 * @property double $POINT
 * @property string $EAT_FIRST_DATE
 * @property string $EAT_LAST_DATE
 * @property integer $EAT_COUNT
 * @property integer $EAT_COUNT_FAIL
 * @property integer $ZALO_FOLLOW
 * @property integer $IS_FOLLOW_ZALO
 */
class Dmmembershippoint extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DM_MEMBERSHIP_POINT';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MEMBERSHIP_ID', 'POS_PARENT'], 'required'],
            [['MEMBERSHIP_ID', 'EAT_COUNT', 'EAT_COUNT_FAIL'], 'integer'],
            [['AMOUNT', 'POINT'], 'number'],
            [['EAT_FIRST_DATE', 'EAT_LAST_DATE', 'ZALO_FOLLOW', 'IS_FOLLOW_ZALO'], 'safe'],
            [['POS_PARENT'], 'string', 'max' => 20],
            [['MEMBERSHIP_ID', 'POS_PARENT'], 'unique', 'targetAttribute' => ['MEMBERSHIP_ID', 'POS_PARENT'], 'message' => 'The combination of Membership  ID and Pos  Parent has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MEMBERSHIP_ID' => 'Membership  ID',
            'POS_PARENT' => 'Thương hiệu',
            'AMOUNT' => 'Amount',
            'POINT' => 'Điểm',
            'EAT_FIRST_DATE' => 'Eat  First  Date',
            'EAT_LAST_DATE' => 'Eat  Last  Date',
            'EAT_COUNT' => 'Eat  Count',
            'EAT_COUNT_FAIL' => 'Eat  Count  Fail',
            'ZALO_FOLLOW' => 'Zalo',
            'IS_FOLLOW_ZALO' => 'Quan tâm zalo',
        ];
    }
}
