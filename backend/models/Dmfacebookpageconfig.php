<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "DM_FACEBOOK_PAGE_CONFIG".
 *
 * @property string $PAGE_ID
 * @property string $POS_PARENT
 * @property string $PAGE_ACCESS_TOKEN
 * @property string $URL_POINT_POLICY
 * @property string $URL_PROMOTION
 * @property string $CREATED_AT
 * @property string $UPDATED_AT
 * @property string $PERSISTENT_MENU
 * @property string $MESSAGE_GREETING
 * @property string $MESSAGE_ERROR
 * @property string $MESSAGE_CHECKIN
 * @property string $MESSAGE_MEMBER_POINT
 * @property string $MESSAGE_MEMBER_NO_POINT
 * @property string $MESSAGE_NO_GIFT_POINT
 * @property string $MESSAGE_GET_MENU
 * @property string $MESSAGE_TOKEN_ORDER
 * @property string $MESSAGE_ORDER_ONLINE
 * @property string $MESSAGE_BOOKING_ONLINE
 * @property string $MESSAGE_REQUIED_RATE
 * @property string $MESSAGE_REQUIED_REGISTER
 * @property string $MESSAGE_REGISTER_SUCCESS
 * @property string $MESSAGE_NO_DAILY_VOUCHER
 * @property string $MESSAGE_MISS_DAILY_VOUCHER
 * @property string $MESSAGE_SENT_DAILY_VOUCHER
 * @property string $MESSAGE_LIMIT_DAILY_VOUCHER
 * @property string $SUB_TITLE_HOTLINE
 * @property string $SUB_TITLE_PROMOTION
 * @property string $SUB_TITLE_POLICY_POINT
 * @property string $MESSAGE_GET_POS
 * @property string $AUTO_REPLY_MENU
 * @property integer $STATUS_BOTCHAT
 * @property string $JSON_FUNCTION
 * @property string $$TYPE_FUNCTION
 * @property string $TYPE_MENU
 * @property string $IMAGE_PATH
 * @property string $IMAGE_URL
 * @property string $TITLE
 * @property string $DESCRIPTION
 * @property string $FUNCTION_NAME
 */
class Dmfacebookpageconfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $TYPE_FUNCTION;
    public $TYPE_MENU;
    public $IMAGE_PATH;
    public $IMAGE_URL;
    public $TITLE;
    public $DESCRIPTION;
    public $FUNCTION_NAME;
    public $ACTIVE;

    public $FACEBOOK_POSTBACK = [
        'login' =>"Đăng nhập",
        'change_phone_number' =>"Đổi số điện thoại",
        'list_pos' =>"Danh sách nhà hàng",
        'get_menu' =>"Lấy Menu",
        'booking_online' =>"Đặt bàn online",
        'order_online' =>"Đặt hàng online",
        'get_voucher' =>"Lấy thẻ giảm giá",
        'get_pos_near_by' =>"Danh sách nhà hàng gần bạn",
        'get_point' =>"Xem điểm thành viên",
        'check_in' =>"Checkin",
        'hotline_cskh' =>"Hotline CSKH",
        'promotion_info' =>"Chính sách khuyến mại",
        'member_policy' =>"Chính sách thành viên",
        'order_online_no_gps' =>"Đặt hàng online không sử dụng GPS",
        'off_bot_chat' =>"Tắt chat tự động",
    ];


    public static function tableName()
    {
        return 'DM_FACEBOOK_PAGE_CONFIG';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PAGE_ID', 'POS_PARENT', 'PAGE_ACCESS_TOKEN'], 'required'],
            [['PAGE_ID', 'STATUS_BOTCHAT'], 'integer'],
            [['CREATED_AT', 'UPDATED_AT','TYPE_FUNCTION','TYPE_MENU','IMAGE_PATH','IMAGE_URL','TITLE','DESCRIPTION','FUNCTION_NAME'], 'safe'],
            [['PERSISTENT_MENU', 'AUTO_REPLY_MENU', 'JSON_FUNCTION'], 'safe'],
            [['POS_PARENT'], 'string', 'max' => 20],
            [['PAGE_ACCESS_TOKEN'], 'string', 'max' => 200],
            [['URL_POINT_POLICY', 'URL_PROMOTION', 'MESSAGE_GREETING', 'MESSAGE_ERROR', 'MESSAGE_CHECKIN', 'MESSAGE_TOKEN_ORDER', 'MESSAGE_REQUIED_RATE', 'MESSAGE_REQUIED_REGISTER', 'MESSAGE_REGISTER_SUCCESS', 'MESSAGE_NO_DAILY_VOUCHER', 'MESSAGE_MISS_DAILY_VOUCHER', 'MESSAGE_SENT_DAILY_VOUCHER', 'MESSAGE_LIMIT_DAILY_VOUCHER'], 'string', 'max' => 500],
            [['MESSAGE_MEMBER_POINT', 'MESSAGE_MEMBER_NO_POINT', 'MESSAGE_NO_GIFT_POINT', 'MESSAGE_GET_MENU', 'MESSAGE_ORDER_ONLINE', 'MESSAGE_BOOKING_ONLINE', 'SUB_TITLE_HOTLINE', 'SUB_TITLE_PROMOTION', 'SUB_TITLE_POLICY_POINT', 'MESSAGE_GET_POS'], 'string', 'max' => 80],
            [['PAGE_ID'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PAGE_ID' => 'Page  ID',
            'POS_PARENT' => 'Pos  Parent',
            'PAGE_ACCESS_TOKEN' => 'Page  Access  Token',
            'URL_POINT_POLICY' => 'Url  Point  Policy',
            'URL_PROMOTION' => 'Url  Promotion',
            'CREATED_AT' => 'Created  At',
            'UPDATED_AT' => 'Updated  At',
            'PERSISTENT_MENU' => 'Persistent  Menu',
            'MESSAGE_GREETING' => 'Message  Greeting',
            'MESSAGE_ERROR' => 'Message  Error',
            'MESSAGE_CHECKIN' => 'Message  Checkin',
            'MESSAGE_MEMBER_POINT' => 'Message  Member  Point',
            'MESSAGE_MEMBER_NO_POINT' => 'Message  Member  No  Point',
            'MESSAGE_NO_GIFT_POINT' => 'Message  No  Gift  Point',
            'MESSAGE_GET_MENU' => 'Message  Get  Menu',
            'MESSAGE_TOKEN_ORDER' => 'Message  Token  Order',
            'MESSAGE_ORDER_ONLINE' => 'Message  Order  Online',
            'MESSAGE_BOOKING_ONLINE' => 'Message  Booking  Online',
            'MESSAGE_REQUIED_RATE' => 'Message  Requied  Rate',
            'MESSAGE_REQUIED_REGISTER' => 'Message  Requied  Register',
            'MESSAGE_REGISTER_SUCCESS' => 'Message  Register  Success',
            'MESSAGE_NO_DAILY_VOUCHER' => 'Message  No  Daily  Voucher',
            'MESSAGE_MISS_DAILY_VOUCHER' => 'Message  Miss  Daily  Voucher',
            'MESSAGE_SENT_DAILY_VOUCHER' => 'Message  Sent  Daily  Voucher',
            'MESSAGE_LIMIT_DAILY_VOUCHER' => 'Message  Limit  Daily  Voucher',
            'SUB_TITLE_HOTLINE' => 'Sub  Title  Hotline',
            'SUB_TITLE_PROMOTION' => 'Sub  Title  Promotion',
            'SUB_TITLE_POLICY_POINT' => 'Sub  Title  Policy  Point',
            'MESSAGE_GET_POS' => 'Message  Get  Pos',
            'AUTO_REPLY_MENU' => 'Auto  Reply  Menu',
            'STATUS_BOTCHAT' => 'Status  Botchat',
            'JSON_FUNCTION' => 'Json  Function',
        ];
    }
}
