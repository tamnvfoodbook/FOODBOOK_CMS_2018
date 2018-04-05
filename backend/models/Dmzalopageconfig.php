<?php

namespace backend\models;

use Yii;



/**
 * This is the model class for table "DM_ZALO_PAGE_CONFIG".
 *
 * @property string $PAGE_ID
 * @property string $POS_PARENT
 * @property string $ZALO_OA_KEY
 * @property string $URL_POINT_POLICY
 * @property string $URL_PROMOTION
 * @property string $MESSAGE_ERROR
 * @property string $MESSAGE_TITLE_CHECKIN
 * @property string $MESSAGE_CHECKIN
 * @property string $MESSAGE_MEMBER_POINT
 * @property string $MESSAGE_MEMBER_NO_POINT
 * @property string $MESSAGE_NO_GIFT_POINT
 * @property string $MESSAGE_GET_MENU
 * @property string $MESSAGE_TOKEN_ORDER
 * @property string $MESSAGE_TITLE_ORDER_ONLINE
 * @property string $MESSAGE_ORDER_ONLINE
 * @property string $MESSAGE_TITLE_BOOKING
 * @property string $MESSAGE_BOOKING_ONLINE
 * @property string $MESSAGE_TITLE_RATE
 * @property string $MESSAGE_REQUIED_RATE
 * @property string $MESSAGE_TITLE_REQUIED_REGISTER
 * @property string $MESSAGE_REQUIED_REGISTER
 * @property string $MESSAGE_REGISTER_SUCCESS
 * @property string $MESSAGE_NO_DAILY_VOUCHER
 * @property string $MESSAGE_MISS_DAILY_VOUCHER
 * @property string $MESSAGE_SENT_DAILY_VOUCHER
 * @property string $MESSAGE_LIMIT_DAILY_VOUCHER
 * @property string $MESSAGE_TITLE_LIST_POS
 * @property string $MESSAGE_LIST_POS
 * @property string $MESSAGE_TITLE_MEMBERSHIP_INFO
 * @property string $MESSAGE_TITLE_PROMOTION
 * @property string $MESSAGE_VIEW_ALL_ARTICLES
 * @property string $MESSAGE_SHOW_PROMOTION
 * @property string $MESSAGE_TITLE_GET_MENU
 * @property string $CREATED_AT
 * @property string $UPDATED_AT
 * @property string $JSON_FUNCTION
 */
class Dmzalopageconfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $TYPE_FUNCTION;
    public $IMAGE_PATH;
    public $IMAGE_URL;
    public $TITLE;
    public $DESCRIPTION;
    public $FUNCTION_NAME;

    public static function tableName()
    {
        return 'DM_ZALO_PAGE_CONFIG';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PAGE_ID', 'POS_PARENT', 'ZALO_OA_KEY'], 'required'],
            [['PAGE_ID'], 'integer'],
            [['CREATED_AT', 'UPDATED_AT','TYPE_FUNCTION','IMAGE_PATH','IMAGE_URL','DESCRIPTION','TITLE','FUNCTION_NAME'], 'safe'],
            [['JSON_FUNCTION'], 'string'],
            [['POS_PARENT'], 'string', 'max' => 20],
            [['ZALO_OA_KEY'], 'string', 'max' => 30],
            [['URL_POINT_POLICY', 'URL_PROMOTION', 'MESSAGE_ERROR', 'MESSAGE_CHECKIN', 'MESSAGE_TOKEN_ORDER', 'MESSAGE_REQUIED_RATE', 'MESSAGE_REQUIED_REGISTER', 'MESSAGE_NO_DAILY_VOUCHER', 'MESSAGE_MISS_DAILY_VOUCHER', 'MESSAGE_SENT_DAILY_VOUCHER', 'MESSAGE_LIMIT_DAILY_VOUCHER'], 'string', 'max' => 500],
            [['MESSAGE_TITLE_CHECKIN', 'MESSAGE_MEMBER_POINT', 'MESSAGE_MEMBER_NO_POINT', 'MESSAGE_NO_GIFT_POINT', 'MESSAGE_GET_MENU', 'MESSAGE_TITLE_ORDER_ONLINE', 'MESSAGE_ORDER_ONLINE', 'MESSAGE_TITLE_BOOKING', 'MESSAGE_BOOKING_ONLINE', 'MESSAGE_TITLE_RATE', 'MESSAGE_TITLE_REQUIED_REGISTER', 'MESSAGE_REGISTER_SUCCESS', 'MESSAGE_TITLE_LIST_POS', 'MESSAGE_TITLE_MEMBERSHIP_INFO', 'MESSAGE_TITLE_PROMOTION', 'MESSAGE_VIEW_ALL_ARTICLES', 'MESSAGE_SHOW_PROMOTION', 'MESSAGE_TITLE_GET_MENU'], 'string', 'max' => 80],
            [['MESSAGE_LIST_POS'], 'string', 'max' => 200],
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
            'ZALO_OA_KEY' => 'Zalo  Oa  Key',
            'URL_POINT_POLICY' => 'Url  Point  Policy',
            'URL_PROMOTION' => 'Url  Promotion',
            'MESSAGE_ERROR' => 'Message  Error',
            'MESSAGE_TITLE_CHECKIN' => 'Message  Title  Checkin',
            'MESSAGE_CHECKIN' => 'Message  Checkin',
            'MESSAGE_MEMBER_POINT' => 'Message  Member  Point',
            'MESSAGE_MEMBER_NO_POINT' => 'Message  Member  No  Point',
            'MESSAGE_NO_GIFT_POINT' => 'Message  No  Gift  Point',
            'MESSAGE_GET_MENU' => 'Message  Get  Menu',
            'MESSAGE_TOKEN_ORDER' => 'Message  Token  Order',
            'MESSAGE_TITLE_ORDER_ONLINE' => 'Message  Title  Order  Online',
            'MESSAGE_ORDER_ONLINE' => 'Message  Order  Online',
            'MESSAGE_TITLE_BOOKING' => 'Message  Title  Booking',
            'MESSAGE_BOOKING_ONLINE' => 'Message  Booking  Online',
            'MESSAGE_TITLE_RATE' => 'Message  Title  Rate',
            'MESSAGE_REQUIED_RATE' => 'Message  Requied  Rate',
            'MESSAGE_TITLE_REQUIED_REGISTER' => 'Message  Title  Requied  Register',
            'MESSAGE_REQUIED_REGISTER' => 'Message  Requied  Register',
            'MESSAGE_REGISTER_SUCCESS' => 'Message  Register  Success',
            'MESSAGE_NO_DAILY_VOUCHER' => 'Message  No  Daily  Voucher',
            'MESSAGE_MISS_DAILY_VOUCHER' => 'Message  Miss  Daily  Voucher',
            'MESSAGE_SENT_DAILY_VOUCHER' => 'Message  Sent  Daily  Voucher',
            'MESSAGE_LIMIT_DAILY_VOUCHER' => 'Message  Limit  Daily  Voucher',
            'MESSAGE_TITLE_LIST_POS' => 'Message  Title  List  Pos',
            'MESSAGE_LIST_POS' => 'Message  List  Pos',
            'MESSAGE_TITLE_MEMBERSHIP_INFO' => 'Message  Title  Membership  Info',
            'MESSAGE_TITLE_PROMOTION' => 'Message  Title  Promotion',
            'MESSAGE_VIEW_ALL_ARTICLES' => 'Message  View  All  Articles',
            'MESSAGE_SHOW_PROMOTION' => 'Message  Show  Promotion',
            'MESSAGE_TITLE_GET_MENU' => 'Message  Title  Get  Menu',
            'CREATED_AT' => 'Created  At',
            'UPDATED_AT' => 'Updated  At',
            'JSON_FUNCTION' => 'Json  Function',
            'TITLE' => 'Tiêu đề',
            'DESCRIPTION' => 'Mô tả',
            'TYPE_FUNCTION' => 'Loại tin nhắn',
            'IMAGE_PATH' => 'Ảnh',
        ];
    }
}
