<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for collection "COUPON".
 *
 * @property \MongoId|string $_id
 * @property mixed $className
 * @property mixed $Pos_Id
 * @property mixed $Coupon_Name
 * @property mixed $Coupon_Log_Date
 * @property mixed $Denominations
 * @property mixed $Active
 */
class Coupon extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return [Yii::$app->params['COLLECTION'], 'COUPON'];
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
            'Coupon_Name',
            'Coupon_Log_Date',
            'Denominations',
            'Active',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['className', 'Pos_Id', 'Coupon_Log_Date', 'Denominations', 'Active'], 'safe'],
            [['Coupon_Name'], 'string'],
            //[['Denominations'], 'number'],
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
            'Pos_Id' => 'Tên nhà hàng',
            'Coupon_Name' => 'Couppon',
            'Coupon_Log_Date' => 'Ngày tạo Coupon',
            'Denominations' => 'Mệnh giá Coupon',
            'Active' => 'Trạng thái',
        ];
    }
}
