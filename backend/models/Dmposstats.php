<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "dm_pos_stats".
 *
 * @property string $ID
 * @property string $POS_ID
 * @property string $POS_PARENT
 * @property string $CREATED_AT
 * @property string $SUM_USER_CHECKIN
 * @property string $SUM_USER_ORDER_ONLINE
 * @property double $SUM_PRICE_ONLINE
 * @property string $SUM_USER_ORDER_OFF
 * @property double $SUM_PRICE_OFF
 * @property string $SUM_COUPON_USED
 * @property double $SUM_COUPON_PRICE
 * @property string $SUM_COUPON_AVAILABLE
 * @property string $SUM_USER_SHARED_FB
 * @property string $SUM_USER_WISHLIST
 */
class Dmposstats extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $name;

    public static function tableName()
    {
        return 'dm_pos_stats';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['POS_ID', 'POS_PARENT', 'CREATED_AT'], 'required'],
            [['POS_ID', 'CREATED_AT', 'SUM_USER_CHECKIN', 'SUM_USER_ORDER_ONLINE', 'SUM_USER_ORDER_OFF', 'SUM_COUPON_USED', 'SUM_COUPON_AVAILABLE', 'SUM_USER_SHARED_FB', 'SUM_USER_WISHLIST'], 'integer'],
            [['SUM_PRICE_ONLINE', 'SUM_PRICE_OFF', 'SUM_COUPON_PRICE'], 'number'],
            [['POS_PARENT'], 'string', 'max' => 50],
            [['POS_ID', 'CREATED_AT'], 'unique', 'targetAttribute' => ['POS_ID', 'CREATED_AT'], 'message' => 'The combination of Pos  ID and Created  At has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'POS_ID' => 'Pos  ID',
            'POS_PARENT' => 'Pos  Parent',
            'CREATED_AT' => 'Created  At',
            'SUM_USER_CHECKIN' => 'Sum  User  Checkin',
            'SUM_USER_ORDER_ONLINE' => 'Sum  User  Order  Online',
            'SUM_PRICE_ONLINE' => 'Sum  Price  Online',
            'SUM_USER_ORDER_OFF' => 'Sum  User  Order  Off',
            'SUM_PRICE_OFF' => 'Sum  Price  Off',
            'SUM_COUPON_USED' => 'Sum  Coupon  Used',
            'SUM_COUPON_PRICE' => 'Sum  Coupon  Price',
            'SUM_COUPON_AVAILABLE' => 'Sum  Coupon  Available',
            'SUM_USER_SHARED_FB' => 'Sum  User  Shared  Fb',
            'SUM_USER_WISHLIST' => 'Sum  User  Wishlist',
        ];
    }
}
