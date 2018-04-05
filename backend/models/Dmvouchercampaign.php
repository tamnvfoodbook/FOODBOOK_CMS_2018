<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "DM_VOUCHER_CAMPAIGN".
 *
 * @property string $ID
 * @property string $VOUCHER_NAME
 * @property string $VOUCHER_DESCRIPTION
 * @property string $CITY_ID
 * @property string $POS_PARENT
 * @property string $POS_ID
 * @property integer $QUANTITY_PER_DAY
 * @property string $DATE_CREATED
 * @property string $DATE_UPDATED
 * @property string $DATE_START
 * @property string $DATE_END
 * @property string $TIME_HOUR_DAY
 * @property integer $TIME_DATE_WEEK
 * @property double $AMOUNT_ORDER_OVER
 * @property integer $DISCOUNT_TYPE
 * @property double $DISCOUNT_AMOUNT
 * @property double $DISCOUNT_EXTRA
 * @property integer $IS_ALL_ITEM
 * @property string $ITEM_TYPE_ID_LIST
 * @property integer $ACTIVE
 * @property string $MANAGER_ID
 * @property string $MANAGER_NAME
 * @property string $AFFILIATE_ID
 * @property integer $AFFILIATE_DISCOUNT_TYPE
 * @property double $AFFILIATE_DISCOUNT_AMOUNT
 * @property double $AFFILIATE_DISCOUNT_EXTRA
 * @property double $CAMPAIGN_TYPE
 * @property double $IS_DELIVERY
 * @property double $IS_OTS
 * @property double $REQUIED_MEMBER
 * @property double $LIST_POS_ID
 * @property double $DISCOUNT_MAX
 * @property double $MANY_TIMES_CODE
 * @property double $SMS_CONTENT
 * @property double $ITEM_ID_LIST
 * @property double $DATE_LOG_START
 * @property double $DISCOUNT_ONE_ITEM
 * @property double $LUCKY_NUMBER
 * @property double $VOUCHER_TYPE
 * @property double $APPLY_ITEM_ID
 * @property double $APPLY_ITEM_TYPE
 * @property double $NUMBER_ITEM_BUY
 * @property double $LIMIT_DISCOUNT_ITEM
 * @property double $MIN_QUANTITY_DISCOUNT
 * @property double $APPLY_ONCE_PER_USER
 * @property double $SEND_ITEM_GIFT_TYPE
 * @property double $ONLY_COUPON

 */
class Dmvouchercampaign extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $SEND_GIFT_TYPE;

    public static function tableName()
    {
        return 'DM_VOUCHER_CAMPAIGN';
    }

    public  $VOUCHER_TYPE;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['VOUCHER_NAME', 'CITY_ID', 'POS_PARENT', 'POS_ID', 'DATE_CREATED', 'DATE_UPDATED', 'DATE_START', 'DATE_END', 'DISCOUNT_TYPE', 'MANAGER_ID'/*,'DISCOUNT_AMOUNT'*/,'DISCOUNT_EXTRA','TIME_HOUR_DAY','TIME_DATE_WEEK','CAMPAIGN_TYPE','IS_DELIVERY','IS_OTS'], 'required'],
            [['VOUCHER_DESCRIPTION','SMS_CONTENT','VOUCHER_TYPE'], 'string'],
            [['CITY_ID', 'POS_ID', 'QUANTITY_PER_DAY', 'TIME_HOUR_DAY', 'TIME_DATE_WEEK', 'DISCOUNT_TYPE', 'IS_ALL_ITEM', 'ACTIVE', 'MANAGER_ID', 'AFFILIATE_ID', 'AFFILIATE_DISCOUNT_TYPE','CAMPAIGN_TYPE','IS_DELIVERY','IS_OTS','REQUIED_MEMBER','LUCKY_NUMBER','IS_COUPON','NUMBER_ITEM_BUY','ONLY_COUPON'], 'integer'],
            [['DATE_CREATED', 'DATE_UPDATED', 'DATE_START', 'DATE_END' ,'DATE_LOG_START'/*,'POS_PARENT'*/,'LIST_POS_ID','DISCOUNT_ONE_ITEM','DISCOUNT_MAX','QUANTITY_PER_DAY','APPLY_ITEM_TYPE','APPLY_ITEM_ID','SAME_PRICE','LIMIT_DISCOUNT_ITEM','MIN_QUANTITY_DISCOUNT','APPLY_ONCE_PER_USER','SEND_GIFT_TYPE','ITEM_ID_LIST'], 'safe'],
            [['AMOUNT_ORDER_OVER', 'DISCOUNT_AMOUNT', 'DISCOUNT_EXTRA', 'AFFILIATE_DISCOUNT_AMOUNT', 'AFFILIATE_DISCOUNT_EXTRA','DURATION','ID','NUMBER_ITEM_FREE'], 'number'],
            [['VOUCHER_NAME'/*, 'POS_PARENT'*/, 'MANAGER_NAME'], 'string', 'max' => 50],
            [['ITEM_TYPE_ID_LIST'], 'string', 'max' => 5000],
            [['MANY_TIMES_CODE'], 'string', 'max' => 20],
            [['MANY_TIMES_CODE'],'match', 'pattern' => '/^[a-z]\w*$/i','message' => 'Không bao gồm kí tự đặc biệt'],


            /*['MANY_TIMES_CODE', 'compare', 'compareValue' => 'FB', 'operator' => '!=','message' => 'Không được sử dụng mã FB' ],*/

            ['DURATION', 'required', 'when' => function ($model) {
                return $model->CAMPAIGN_TYPE == '7';
                }, 'whenClient' => "function (attribute, value) {
                return $('#dmvouchercampaign-campaign_type').val() == '7';
            }"],

            ['SMS_CONTENT', 'required', 'when' => function ($model) {
                return $model->CAMPAIGN_TYPE == '7';
                }, 'whenClient' => "function (attribute, value) {
                return $('#dmvouchercampaign-campaign_type').val() == '7';
            }"],

            ['SMS_CONTENT', 'required', 'when' => function ($model) {
                return $model->CAMPAIGN_TYPE == '2';
                }, 'whenClient' => "function (attribute, value) {
                return $('#dmvouchercampaign-campaign_type').val() == '2';
            }"],
            ['SMS_CONTENT', 'required', 'when' => function ($model) {
                return $model->CAMPAIGN_TYPE == '10';
                }, 'whenClient' => "function (attribute, value) {
                return $('#dmvouchercampaign-campaign_type').val() == '10';
            }"],

            ['MANY_TIMES_CODE', 'required', 'when' => function ($model) {
                return $model->CAMPAIGN_TYPE == '9';
            }, 'whenClient' => "function (attribute, value) {
                return $('#dmvouchercampaign-campaign_type').val() == '9';
            }"],


            ['SAME_PRICE', 'required', 'when' => function ($model) {
                return $model->VOUCHER_TYPE == '3';
                }, 'whenClient' => "function (attribute, value) {
                return $('#dmvouchercampaign-voucher_type').val() == '3';
            }"],
/*
            ['QUANTITY_PER_DAY', 'required', 'when' => function ($model) {
                return $model->CAMPAIGN_TYPE == '7';
                }, 'whenClient' => "function (attribute, value) {
                return $('#dmvouchercampaign-campaign_type').val() == '7';
            }"],

            ['QUANTITY_PER_DAY', 'required', 'when' => function ($model) {
                return $model->CAMPAIGN_TYPE == '9';
                }, 'whenClient' => "function (attribute, value) {
                return $('#dmvouchercampaign-campaign_type').val() == '9';
            }"],*/



            ['DURATION', 'required', 'when' => function ($model) {
                return $model->CAMPAIGN_TYPE == '8';
            }, 'whenClient' => "function (attribute, value) {
                return $('#dmvouchercampaign-campaign_type').val() == '8';
            }"],

            ['DISCOUNT_AMOUNT', 'required', 'when' => function ($model) {
                return $model->VOUCHER_TYPE == '1';
            }, 'whenClient' => "function (attribute, value) {
                return $('#dmvouchercampaign-voucher_type').val() == '1';
            }"],



        ];
    }
    /**
     * @inheritdoc
     */

    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'VOUCHER_NAME' => 'Tên chương trình',
            'VOUCHER_DESCRIPTION' => 'Mô tả',
            'CITY_ID' => 'Thành phố',
            'POS_PARENT' => 'Thương hiệu',
            'POS_ID' => 'Nhà hàng',
            'QUANTITY_PER_DAY' => 'Số lượng/ngày',
            'DATE_CREATED' => 'Ngày tạo',
            'DATE_UPDATED' => 'Ngày sửa',
//            'DATE_START' => 'Ngày bắt đầu',
            'DATE_START' => 'Thời gian xuất voucher từ /Voucher có hiệu lực từ',
//            'DATE_END' => 'Ngày kết thúc',
            'DATE_END' => 'Thời gian xuất voucher đến /Voucher có hiệu lực đến',
            'TIME_HOUR_DAY' => 'Khung giờ áp dụng',
            'TIME_DATE_WEEK' => 'Ngày trong tuần',
            'AMOUNT_ORDER_OVER' => 'Áp dụng hóa đơn từ (vnđ)',
            'DISCOUNT_TYPE' => 'Loại giảm giá',
            'DISCOUNT_AMOUNT' => 'Số tiền giảm giá',
            'DISCOUNT_EXTRA' => 'Giảm giá (%)',
            'IS_ALL_ITEM' => 'Áp dụng cho tất cả các món',
            'ITEM_TYPE_ID_LIST' => 'Nhóm món áp dụng / Nhóm món được tặng',
            'ACTIVE' => 'Trạng thái',
            'MANAGER_ID' => 'Quản lý',
            'MANAGER_NAME' => 'Tên quản lý',
            'AFFILIATE_ID' => 'Nhà phân phối',
            'AFFILIATE_DISCOUNT_TYPE' => 'Affiliate  Discount  Type',
            'AFFILIATE_DISCOUNT_AMOUNT' => 'Affiliate  Discount  Amount',
            'AFFILIATE_DISCOUNT_EXTRA' => 'Affiliate  Discount  Extra',
            'CAMPAIGN_TYPE' => 'Mục đích sử dụng',
            'IS_DELIVERY' => 'Dùng cho Order Online',
            'IS_OTS' => 'Dùng cho bán mang về',
            'DURATION' => 'Thời hạn (ngày)',
            'LIST_POS_ID' => 'Danh sách nhà hàng áp dụng',
            'DISCOUNT_MAX' => 'Giới hạn giảm giá',
            'SMS_CONTENT' => 'Nội dung tin nhắn',
            'MANY_TIMES_CODE' => 'Mã dùng nhiều lần',
            'ITEM_ID_LIST' => 'Danh sách món',
            'DATE_LOG_START' => 'Mã Voucher phát hành có hiệu lực từ ngày',
            'DISCOUNT_ONE_ITEM' => 'Giảm giá món cao nhất / thấp nhất',
            'REQUIED_MEMBER' => 'Yêu cầu mã hội viên khi sử dụng Voucher',
            'LUCKY_NUMBER' => 'Số may mắn',
            'IS_COUPON' => 'Loại giảm giá',
            'VOUCHER_TYPE' => 'Loại chương trình',
            'APPLY_ITEM_TYPE' => 'Nhóm món cần mua',
            'APPLY_ITEM_ID' => 'Món cần mua',
            'NUMBER_ITEM_BUY' => 'Số lượng món cần mua',
            'NUMBER_ITEM_FREE' => 'Số lượng món được tặng',
            'SAME_PRICE' => 'Đồng giá',
            'LIMIT_DISCOUNT_ITEM' => 'Số món giảm giá',
            'MIN_QUANTITY_DISCOUNT' => 'Giảm giá từ món thứ',
            'APPLY_ONCE_PER_USER' => 'Mỗi thành viên nhận một lần',
            'SEND_GIFT_TYPE' => 'Chọn loại áp dụng',
            'ONLY_COUPON' => 'Áp dụng cùng với chương trình khác',
        ];
    }


    public function getCity()
    {
        return $this->hasOne(Dmcity::className(), ['ID' => 'CITY_ID'])->select(['ID','CITY_NAME']);
    }

    public function getPos()
    {
        return $this->hasOne(Dmpos::className(), ['ID' => 'POS_ID']);
    }
//    public function getTimehourday()
//    {
//        echo '<pre>';
//        var_dump($this->TIME_DATE_WEEK);
//        echo '</pre>';
//        die();
//        return $this->TIME_DATE_WEEK;
//    }

    public function getStartHourOfTime($time)
    {
        switch ($time) {
            case 'TIME_MORNING':
                return 6;
            case 'TIME_LUNCH':
                return 11;
            case 'TIME_AFTERNOON':
                return 14;
            case 'TIME_NIGHT':
                return 17;
            case 'TIME_MID_NIGHT':
                return 21;
            default:
                # code...
                return 0;
        }
    }



    public function getEndHourOfTime($time){
        switch ($time) {
            case 'TIME_MORNING':
                return 10;
            case 'TIME_LUNCH':
                return 13;
            case 'TIME_AFTERNOON':
                return 16;
            case 'TIME_NIGHT':
                return 20;
            case 'TIME_MID_NIGHT':
                return 23;
            default:
                return 0;
        }

    }



    public function getDateofweek(){
        //$dateBin = pow($this->TIME_DATE_WEEK, 7);

        switch ($this->TIME_DATE_WEEK){
            case 124:
                return "Từ thứ 2 - thứ 6";
            case 254:
                return "Từ thứ 2 - chủ nhật";
            case 4:
                return "Thứ 2";
            case 8:
                return "Thứ 3";
            case 16:
                return "Thứ 4";
            case 32:
                return "Thứ 5";
            case 64:
                return "Thứ 6";
            case 128:
                return "Thứ 7";
            case 2:
                return "Chủ nhật";
            default: return '';
        }
    }
    public function labelType($type){
        switch ($type){
            case 1:
                return "Sms";
            case 2:
                return "Vc Giấy";
            case 3:
                return "Vc checkin";
            case 4:
                return "Vc Booking";
            case 5:
                return "VC sử dụng nhiều lần";

            default: return '';
        }
    }



    public function getTypeOfTime(){
        $maskMorning = pow(2, 6);
        $maskLunch = pow(2, 11);
        $maskAfternoon = pow(2, 14);
        $maskNight = pow(2, 17);
        $maskMidNight = pow(2, 21);
        $maskAllDay = pow(2, 0);


        if(($this->TIME_HOUR_DAY & $maskAllDay) > 0){
            return 'ALL_OF_DAY';
        }else if(($this->TIME_HOUR_DAY & $maskLunch) > 0){
            return 'TIME_LUNCH';
        }else if(($this->TIME_HOUR_DAY & $maskAfternoon) > 0){
            return 'TIME_AFTERNOON';
        }else if(($this->TIME_HOUR_DAY & $maskNight) > 0){
            return 'TIME_NIGHT';
        }else if(($this->TIME_HOUR_DAY & $maskMidNight) > 0){
            return 'TIME_MID_NIGHT';
        }else if(($this->TIME_HOUR_DAY & $maskMorning) > 0){
            return 'TIME_MORNING';
        }
        return 0;
    }

    public function  getTimeHourDayBeautiful() {
        $type = self::getTypeOfTime();
        switch ($type) {
            case 'TIME_MORNING':
                return "Ăn sáng (06h00 - 10h59)";
            case 'TIME_LUNCH':
                return "Ăn trưa (11h00 - 13h59)";
            case 'TIME_AFTERNOON':
                return "Ăn chiều (14h00 - 16h59)";
            case 'TIME_NIGHT':
                return "Ăn tối (17h00 - 20h59)";
            case 'TIME_MID_NIGHT':
                return "Ăn đêm(21h00 - 23h59)";
            case 'ALL_OF_DAY':
                return "Cả ngày";
        }
        return "";
    }


}
