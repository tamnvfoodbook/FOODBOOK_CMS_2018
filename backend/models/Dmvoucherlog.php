<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "DM_VOUCHER_LOG".
 *
 * @property string $VOUCHER_CODE
 * @property integer $VOUCHER_CAMPAIGN_ID
 * @property string $VOUCHER_CAMPAIGN_NAME
 * @property string $VOUCHER_DESCRIPTION
 * @property string $POS_PARENT
 * @property integer $POS_ID
 * @property string $DATE_CREATED
 * @property string $DATE_START
 * @property string $DATE_END
 * @property string $DATE_HASH
 * @property double $AMOUNT_ORDER_OVER
 * @property integer $DISCOUNT_TYPE
 * @property double $DISCOUNT_AMOUNT
 * @property double $DISCOUNT_EXTRA
 * @property integer $IS_ALL_ITEM
 * @property string $ITEM_TYPE_ID_LIST
 * @property integer $STATUS
 * @property string $BUYER_INFO
 * @property integer $AFFILIATE_ID
 * @property integer $AFFILIATE_DISCOUNT_TYPE
 * @property double $AFFILIATE_DISCOUNT_AMOUNT
 * @property double $AFFILIATE_DISCOUNT_EXTRA
 * @property double $AFFILIATE_USED_TOTAL_AMOUNT
 * @property string $USED_DATE
 * @property double $USED_DISCOUNT_AMOUNT
 * @property double $USED_BILL_AMOUNT
 * @property string $USED_MEMBER_INFO
 * @property integer $USED_POS_ID
 * @property string $USED_SALE_TRAN_ID
 * @property string $IS_DELIVERY
 * @property string $IS_OTS
 * @property string $EVENT_ID
 * @property string $REQUIED_MEMBER
 * @property string $DISCOUNT_MAX
 * @property string $LIST_POS_ID
 * @property string $ITEM_ID_LIST
 * @property string $DISCOUNT_ONE_ITEM
 * @property string $IS_COUPON
 * @property string $ONLY_COUPON
 */
class Dmvoucherlog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DM_VOUCHER_LOG';
    }

    public $COUNT_BILL;
    public $SUM_DISCOUNT_AMOUNT;
    public $AVG_USED_DISCOUNT_AMOUNT;
    public $SUM_USED_BILL_AMOUNT;
    public $AVG_USED_BILL_AMOUNT;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['VOUCHER_CODE', 'VOUCHER_CAMPAIGN_ID', 'VOUCHER_CAMPAIGN_NAME', 'POS_PARENT', 'DATE_CREATED', 'DATE_START', 'DATE_END', 'DATE_HASH', 'DISCOUNT_TYPE', 'AFFILIATE_ID'], 'required'],
            [['VOUCHER_CAMPAIGN_ID', 'POS_ID', 'DISCOUNT_TYPE', 'IS_ALL_ITEM', 'STATUS', 'AFFILIATE_ID', 'AFFILIATE_DISCOUNT_TYPE', 'USED_POS_ID'], 'integer'],
            [['VOUCHER_DESCRIPTION'], 'string'],
            [['DATE_CREATED', 'DATE_START', 'DATE_END', 'USED_DATE'], 'safe'],
            [['AMOUNT_ORDER_OVER', 'DISCOUNT_AMOUNT', 'DISCOUNT_EXTRA', 'AFFILIATE_DISCOUNT_AMOUNT', 'AFFILIATE_DISCOUNT_EXTRA', 'AFFILIATE_USED_TOTAL_AMOUNT', 'USED_DISCOUNT_AMOUNT', 'USED_BILL_AMOUNT'], 'number'],
            [['VOUCHER_CODE'], 'string', 'max' => 20],
            [['VOUCHER_CAMPAIGN_NAME', 'BUYER_INFO', 'USED_MEMBER_INFO'], 'string', 'max' => 100],
            [['POS_PARENT', 'USED_SALE_TRAN_ID'], 'string', 'max' => 50],
            [['DATE_HASH'], 'string', 'max' => 10],
            [['ITEM_TYPE_ID_LIST'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'VOUCHER_CODE' => 'Mã Voucher',
            'VOUCHER_CAMPAIGN_ID' => 'Chương trình',
            'VOUCHER_CAMPAIGN_NAME' => 'Tên chương trình',
            'VOUCHER_DESCRIPTION' => 'Mô tả',
            'POS_PARENT' => 'Thương hiệu',
            'POS_ID' => 'Nhà hàng',
            'DATE_CREATED' => 'Ngày tạo',
            'DATE_START' => 'Ngày phát hành',
            'DATE_END' => 'Ngày kết thúc',
            'DATE_HASH' => 'Date  Hash',
            'AMOUNT_ORDER_OVER' => 'Giới hạn đơn hàng',
//            'DISCOUNT_TYPE' => 'Discount  Type',
            'DISCOUNT_AMOUNT' => 'Giảm giá',
            'DISCOUNT_EXTRA' => '% giảm giá',
            'IS_ALL_ITEM' => 'Is  All  Item',
            'ITEM_TYPE_ID_LIST' => 'Item  Type  Id  List',
            'STATUS' => 'Trạng thái',
            'AFFILIATE_ID' => 'Affiliate  ID',
            'AFFILIATE_DISCOUNT_TYPE' => 'Affiliate  Discount  Type',
            'AFFILIATE_DISCOUNT_AMOUNT' => 'Affiliate  Discount  Amount',
            'AFFILIATE_DISCOUNT_EXTRA' => 'Affiliate  Discount  Extra',
            'AFFILIATE_USED_TOTAL_AMOUNT' => 'Affiliate  Used  Total  Amount',
            'USED_DATE' => 'Ngày sử dụng',
            'USED_DISCOUNT_AMOUNT' => 'Tiền giảm giá',
            'USED_BILL_AMOUNT' => 'Tổng hóa đơn',
            'USED_MEMBER_INFO' => 'Người sử dụng',
            'USED_POS_ID' => 'Nhà hàng sử dụng',
            'USED_SALE_TRAN_ID' => 'Mã giao dịch',
            'BUYER_INFO' => 'Người nhận',
        ];
    }

    public function getPos()
    {
        return $this->hasOne(Dmpos::className(), ['ID' => 'POS_ID']);
    }
    public function getStatusText()
    {
        switch ($this->STATUS) {
            case '1':
                # code...
                return 'OFF';
                break;
            case '2':
                # code...
                return '<p>ĐÃ SỬ DỤNG</p><p>'.date(Yii::$app->params['DATE_FORMAT'],strtotime($this->USED_DATE)).'</p>';
                break;
            case '3':
                # code...
                return 'HẾT HẠN';
                break;
            case '4':
                # code...
                return 'CHƯA SỬ DỤNG';
                break;

            default:
                # code...
                return $this->STATUS;
                break;
        }
    }
    public function getDiscountValue()
    {
        if($this->DISCOUNT_TYPE == 1){
            return $this->DISCOUNT_AMOUNT.'đ';
        }else{
            return $this->DISCOUNT_EXTRA*100 .'%';
        }
    }
}
