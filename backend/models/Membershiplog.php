<?php

namespace backend\models;

use Yii;
use backend\models\Dmmerbership;

/**
 * This is the model class for collection "MEMBERSHIP_LOG".
 *
 * @property \MongoId|string $_id
 * @property mixed $className
 * @property mixed $Pos_Id
 * @property mixed $User_Id
 * @property mixed $Pr_Key
 * @property mixed $Membership_Log_Type
 * @property mixed $Amount
 * @property mixed $Point
 * @property mixed $Membership_Log_Date
 */
class Membershiplog extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return [Yii::$app->params['COLLECTION'], 'MEMBERSHIP_LOG'];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'className',
            'Pos_Id',
            'User_Id',
            'Pr_Key',
            'Membership_Log_Type',
            'Amount',
            'Point',
            'Membership_Log_Date',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['className', 'Pos_Id', 'User_Id', 'Pr_Key', 'Membership_Log_Type', 'Amount', 'Point', 'Membership_Log_Date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'className' => 'Class Name',
            'Pos_Id' => 'Pos  ID',
            'User_Id' => 'User  ID',
            'Pr_Key' => 'Pr  Key',
            'Membership_Log_Type' => 'Membership  Log  Type',
            'Amount' => 'Amount',
            'Point' => 'Point',
            'Membership_Log_Date' => 'Membership  Log  Date',
        ];
    }

    public function getMembership()
    {
        return $this->hasOne(Dmmembership::className(), ['ID' => 'User_Id'])->select(['ID','MEMBER_NAME']);
    }
}
