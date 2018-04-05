<?php

namespace backend\models;

use Yii;
use backend\models\Dmmembership;
use yii\helpers\Html;

/**
 * This is the model class for collection "COUPON_LOG".
 *
 * @property \MongoId|string $_id
 * @property mixed $className
 * @property mixed $Pos_Id
 * @property mixed $Pos_Parent
 * @property mixed $User_Id
 * @property mixed $Coupon_Id
 * @property mixed $User_Id_Parent
 * @property mixed $Coupon_Name
 * @property mixed $Coupon_Log_Date
 * @property mixed $Coupon_Log_Start
 * @property mixed $Coupon_Log_End
 * @property mixed $Denominations
 * @property mixed $Share_Quantity
 * @property mixed $Type
 * @property mixed $Active
 * @property mixed $Pr_Key
 */
class Couponlog extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */


    public static function collectionName()
    {
        return [Yii::$app->params['COLLECTION'], 'COUPON_LOG'];
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
            'Pos_Parent',
            'User_Id',
            'Coupon_Id',
            'User_Id_Parent',
            'Coupon_Name',
            'Coupon_Log_Date',
            'Coupon_Log_Start',
            'Coupon_Log_End',
            'Denominations',
            /*'Share_Quantity',*/
            'Type',
            'Active',
            'Pr_Key',
            'Payment_At',
            'Deactive_On_Cancel',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['className', 'Coupon_Id', 'Coupon_Name', 'Coupon_Log_Date', 'Coupon_Log_Start', 'Coupon_Log_End', 'Denominations','Pr_Key','Payment_At','Payment_At'], 'safe'],
            [['User_Id', 'Coupon_Log_Start','Coupon_Id','Coupon_Name', 'Coupon_Log_Start', 'Denominations'/* ,'Share_Quantity', 'type'*/, 'Active'], 'required'],
            [['pos'], 'safe'],

            ['Pos_Id', 'required', 'when' => function($model) {
                return $model->Type == 'COUPON_TYPE_POS';
            }, 'whenClient' => "function (attribute, value) {
                return $('#couponType').val() == 'COUPON_TYPE_POS';
            }"],

            ['Pos_Parent', 'required', 'when' => function($model) {
                return $model->Type == 'COUPON_TYPE_POS_PARENT';
            }, 'whenClient' => "function (attribute, value) {
                return $('#couponType').val() == 'COUPON_TYPE_POS_PARENT';
            }"]
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
            'Pos_Id' => 'Nhà hàng',
            'Pos_Parent' => 'Hệ thống nhà hàng',
            'User_Id' => 'SĐT khách hàng',
            'Coupon_Id' => 'Coupon',
            'User_Id_Parent' => 'Quản lý',
            'Coupon_Name' => 'Tên Coupon',
            'Coupon_Log_Date' => 'Ngày tạo Coupon',
            'Coupon_Log_Start' => 'Ngày bắt đầu',
            'Coupon_Log_End' => 'Ngày kết thúc',
            'Denominations' => 'Giá trị',
            /*'Share_Quantity' => 'Số lượng chia sẻ',*/
            'Type' => 'Loại Coupon',
            'Active' => 'Trạng thái',
            'Pr_Key' => 'Pr Key',
        ];
    }

    public function getDmmembership()
    {
        return $this->hasOne(Dmmembership::className(), ['ID' => 'User_Id'])/*->select(['ID','MEMBER_NAME'])*/;
    }
    public function getPos()
    {
        return $this->hasOne(Dmpos::className(), ['ID' => 'Pos_Id'])->select(['ID','POS_NAME']);
    }
    public function getCoupon()
    {
        return $this->hasOne(Coupon::className(), ['_id' => 'Coupon_Id'])->select(['Coupon_Name']);
    }

    public function getCoupondate(){
        return date(Yii::$app->params['DATE_FORMAT'], $this->Coupon_Log_Date->sec);
    }
    public function getCouponStartdate(){
        return date(Yii::$app->params['DATE_FORMAT'], $this->Coupon_Log_Start->sec);
    }
    public function getCouponEnddate(){
        return date(Yii::$app->params['DATE_FORMAT'], $this->Coupon_Log_End->sec);
    }

}
