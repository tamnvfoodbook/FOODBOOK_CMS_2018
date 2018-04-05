<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "DM_POS_PARENT".
 *
 * @property string $ID
 * @property string $NAME
 * @property string $DESCRIPTION
 * @property integer $AHAMOVE_ID
 * @property string $IMAGE
 * @property string $SOURCE
 * @property string $CREATED_AT
 * @property integer $ACTIVE
 * @property string $FACEBOOK_URL
 * @property string $MOMO_MERCHANT_ID
 * @property string $MOMO_PUBLIC_KEY
 * @property string $MOMO_PUBLIC_KEY_PM
 * @property string $MOCA_MERCHANT_ID
 * @property string $IS_GIFT_POINT
 * @property string $MAX_POS_NUMBER
 * @property string $MAX_EMPLOYEE_NUMBER
 * @property string $MAX_MANAGER_NUMBER
 * @property string $CC_API_SECRET
 * @property string $CC_API_KEY
 * @property string $IS_SEND_SMS
 * @property string $BRAND_NAME
 * @property string $SMS_PARTNER
 * @property string $MSG_UP_MEMBERSHIP
 * @property string $MSG_MEMBER_BAD_RATE
 * @property string $LOGO
 * @property string $ZALO_PAGE_ID
 * @property string $ZALO_OA_KEY
 * @property string $ZALO_SUBMIT_KEY
 * @property string $MANAGER_PHONE
 * @property string $DIRECT_LIST
 * @property string $CP_CODE
 * @property string $POS_FEATURE
 * @property string $MANAGER_EMAIL_LIST
 * @property string $$img_member
 */
class Dmposparent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public  $img_member;

    public static function tableName()
    {
        return 'DM_POS_PARENT';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID','MAX_POS_NUMBER'], 'required'],
            [['ID'], 'unique'],
            [['ID'], 'match', 'pattern' => '/^[A-Za-z0-9]{0,50}$/', 'message' => 'Bạn chỉ có thể sử dụng các kí tự tiếng anh liền nhau và số điếm'],
            [['CREATED_AT','DESCRIPTION','BRAND_NAME','SMS_PARTNER','DIRECT_LIST','CP_CODE','POS_FEATURE','MANAGER_EMAIL_LIST','MSG_UP_MEMBERSHIP','APP_ID','FACEBOOK_PAGE_ID'], 'safe'],
            [['ACTIVE','POS_TYPE','IS_GIFT_POINT','MAX_POS_NUMBER','MAX_EMPLOYEE_NUMBER','MAX_MANAGER_NUMBER','IS_SEND_SMS','MSG_MEMBER_BAD_RATE','MANAGER_PHONE'], 'integer'],
            [['MOMO_PUBLIC_KEY', 'MOMO_PUBLIC_KEY_PM', 'AHAMOVE_ID'], 'string'],
            [['ID','MOMO_MERCHANT_ID', 'MOCA_MERCHANT_ID','WS_SIP_SERVER','PASS_SIP_SERVER'], 'string', 'max' => 50],
            [['PASS_SIP_SERVER','CC_API_KEY','CC_API_SECRET','ZALO_PAGE_ID','ZALO_OA_KEY','ZALO_SUBMIT_KEY'], 'string', 'max' => 50],
            [['NAME','FACEBOOK_URL'], 'string', 'max' => 200],
            [['IMAGE','LOGO'], 'string', 'max' => 500],
            [['SOURCE'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'NAME' => 'Tên thương hiệu',
            'DESCRIPTION' => 'Mô tả',
            'AHAMOVE_ID' => 'Ahamove  ID',
            'IMAGE' => 'Image',
            'SOURCE' => 'Nguồn',
            'CREATED_AT' => 'Ngày tạo',
            'ACTIVE' => 'Active',
            'FACEBOOK_URL' => 'Facebook  Url',
            'MOMO_MERCHANT_ID' => 'Momo  Merchant  ID',
            'MOMO_PUBLIC_KEY' => 'Momo  Public  Key',
            'MOMO_PUBLIC_KEY_PM' => 'Momo  Public  Key  Pm',
            'MOCA_MERCHANT_ID' => 'Moca  Merchant  ID',
            'WS_SIP_SERVER' => 'Cấu hình Sip tổng đài',
            'PASS_SIP_SERVER' => 'Mật khẩu  Sip tổng đài',
            'POS_TYPE' => 'Loại Pos',
            'IS_GIFT_POINT' => 'Tích điểm',
            'MAX_POS_NUMBER' => 'Giới hạn số điểm',
            'MAX_EMPLOYEE_NUMBER' => 'Giới hạn số nhân viên',
            'MAX_MANAGER_NUMBER' => 'Giới hạn số quản lý',
            'CC_API_KEY' => 'CC API KEY',
            'CC_API_SECRET' => 'CC API SECRET',
            'IS_SEND_SMS' => 'Cho phép gửi tin nhắn',
            'MSG_UP_MEMBERSHIP' => 'Tin nhắn tăng hạng hội viên',
            'MSG_MEMBER_BAD_RATE' => 'Nhận tin cảnh báo khi có dánh giá số sao',
            'LOGO' => 'Logo',
            'ZALO_PAGE_ID' => 'ZALO_PAGE_ID',
            'ZALO_OA_KEY' => 'ZALO_OA_KEY',
            'ZALO_SUBMIT_KEY' => 'ZALO_SUBMIT_KEY',
            'MANAGER_PHONE' => 'Hotline',
            'CP_CODE' => 'CP CODE',
            'POS_FEATURE' => 'Nhà hàng tiêu biểu',
            'MANAGER_EMAIL_LIST' => 'Danh sách email quản lý',
            'APP_ID' => 'App ID',
            'FACEBOOK_PAGE_ID' => 'FACEBOOK PAGE ID',
        ];
    }

    public function getCountpos()
    {
        $posModel = new DmposSearch();
        $countPos = $posModel->countAllPosByPosParent($this->ID);

        return $countPos;
    }
    public function getPostypelabel()
    {
        $label = 'Mix Pos';
        if($this->POS_TYPE == 1){
            $label = 'POS PC';
        }elseif($this->POS_TYPE == 2){
            $label = 'POS MOBILE';
        }
        return $label;
    }

}
