<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for collection "MG_SALE_MANAGER".
 *
 * @property \MongoId|string $_id
 * @property mixed $pos_name
 * @property mixed $pos_type
 * @property mixed $channels
 * @property mixed $pos_parent
 * @property mixed $pos_id
 * @property mixed $tran_id
 * @property mixed $tran_date
 * @property mixed $created_at
 * @property mixed $discount_extra
 * @property mixed $discount_extra_amount
 * @property mixed $service_charge
 * @property mixed $service_charge_amount
 * @property mixed $coupon_amount
 * @property mixed $coupon_code
 * @property mixed $ship_fee_amount
 * @property mixed $discount_amount_on_item
 * @property mixed $original_amount
 * @property mixed $vat_amount
 * @property mixed $bill_amount
 * @property mixed $total_amount
 * @property mixed $membership_name
 * @property mixed $membership_id
 * @property mixed $sale_note
 * @property mixed $tran_no
 * @property mixed $sale_type
 * @property mixed $hour
 * @property mixed $pos_city
 * @property mixed $pos_district
 */
class Mgsalemanager extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return ['IPOS', 'MG_SALE_MANAGER'];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'pos_name',
            'pos_type',
            'channels',
            'pos_parent',
            'pos_id',
            'tran_id',
            'tran_date',
            'created_at',
            'discount_extra',
            'discount_extra_amount',
            'service_charge',
            'service_charge_amount',
            'coupon_amount',
            'coupon_code',
            'ship_fee_amount',
            'discount_amount_on_item',
            'original_amount',
            'vat_amount',
            'bill_amount',
            'total_amount',
            'membership_name',
            'membership_id',
            'sale_note',
            'tran_no',
            'sale_type',
            'hour',
            'pos_city',
            'pos_district',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pos_name', 'pos_type', 'channels', 'pos_parent', 'pos_id', 'tran_id', 'tran_date', 'created_at', 'discount_extra', 'discount_extra_amount', 'service_charge', 'service_charge_amount', 'coupon_amount', 'coupon_code', 'ship_fee_amount', 'discount_amount_on_item', 'original_amount', 'vat_amount', 'bill_amount', 'total_amount', 'membership_name', 'membership_id', 'sale_note', 'tran_no', 'sale_type', 'hour', 'pos_city', 'pos_district'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'pos_name' => 'Pos Name',
            'pos_type' => 'Pos Type',
            'channels' => 'Channels',
            'pos_parent' => 'Pos Parent',
            'pos_id' => 'Pos ID',
            'tran_id' => 'Tran ID',
            'tran_date' => 'Tran Date',
            'created_at' => 'Created At',
            'discount_extra' => 'Discount Extra',
            'discount_extra_amount' => 'Discount Extra Amount',
            'service_charge' => 'Service Charge',
            'service_charge_amount' => 'Service Charge Amount',
            'coupon_amount' => 'Coupon Amount',
            'coupon_code' => 'Coupon Code',
            'ship_fee_amount' => 'Ship Fee Amount',
            'discount_amount_on_item' => 'Discount Amount On Item',
            'original_amount' => 'Original Amount',
            'vat_amount' => 'Vat Amount',
            'bill_amount' => 'Bill Amount',
            'total_amount' => 'Total Amount',
            'membership_name' => 'Membership Name',
            'membership_id' => 'Membership ID',
            'sale_note' => 'Sale Note',
            'tran_no' => 'Tran No',
            'sale_type' => 'Sale Type',
            'hour' => 'Hour',
            'pos_city' => 'Pos City',
            'pos_district' => 'Pos District',
        ];
    }
}
