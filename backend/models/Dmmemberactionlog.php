<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "DM_MEMBER_ACTION_LOG".
 *
 * @property string $ID
 * @property string $CREATED_AT
 * @property string $USER_ID
 * @property integer $SPIN_RESULT
 * @property string $DESCRIPTION
 * @property string $POS_PARENT
 * @property integer $LOG_TYPE
 * @property string $AMOUNT
 * @property string $VOUCHER_LOG
 * @property integer $PAYMENT_METHOD
 * @property string $RECEIVER_PHONE
 * @property string $BANK_ACCOUNT
 * @property string $UPDATED_AT
 * @property integer $WITHDRAW_STATE
 */
class Dmmemberactionlog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DM_MEMBER_ACTION_LOG';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CREATED_AT', 'USER_ID'], 'required'],
            [['CREATED_AT', 'UPDATED_AT'], 'safe'],
            [['USER_ID', 'SPIN_RESULT', 'LOG_TYPE', 'AMOUNT', 'PAYMENT_METHOD', 'WITHDRAW_STATE'], 'integer'],
            [['DESCRIPTION'], 'string', 'max' => 50],
            [['POS_PARENT', 'BANK_ACCOUNT'], 'string', 'max' => 20],
            [['VOUCHER_LOG'], 'string', 'max' => 10],
            [['RECEIVER_PHONE'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'CREATED_AT' => 'Created  At',
            'USER_ID' => 'User  ID',
            'SPIN_RESULT' => 'Spin  Result',
            'DESCRIPTION' => 'Description',
            'POS_PARENT' => 'Pos  Parent',
            'LOG_TYPE' => 'Log  Type',
            'AMOUNT' => 'Amount',
            'VOUCHER_LOG' => 'Voucher  Log',
            'PAYMENT_METHOD' => 'Payment  Method',
            'RECEIVER_PHONE' => 'Receiver  Phone',
            'BANK_ACCOUNT' => 'Bank  Account',
            'UPDATED_AT' => 'Updated  At',
            'WITHDRAW_STATE' => 'Withdraw  State',
        ];
    }
}
