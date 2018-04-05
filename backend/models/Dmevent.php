<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "DM_EVENT".
 *
 * @property string $ID
 * @property string $EVENT_NAME
 * @property string $POS_PARENT
 * @property string $DATE_CREATED
 * @property string $DATE_UPDATED
 * @property string $DATE_START
 * @property integer $ACTIVE
 * @property string $MANAGER_ID
 * @property integer $MIN_EAT_COUNT
 * @property integer $MAX_EAT_COUNT
 * @property double $MIN_PAY_AMOUNT
 * @property double $MAX_PAY_AMOUNT
 * @property integer $LAST_VISIT_FREQUENCY
 * @property integer $CAMPAIGN_ID
 * @property integer $STATUS
 * @property string $EXPECTED_APPROACH
 * @property string $PRACTICAL_APPROACH
 * @property string $MIN_POINT
 * @property string $MAX_POINT
 * @property string $GENDER
 * @property string $SEND_TYPE
 * @property string $EVENT_TYPE
 * @property string $CONTENT_MESSAGE
 * @property string $USER_GROUP
 * @property string $MEMBER_TYPE
 * @property string $CITY_ID;
 */
class Dmevent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DM_EVENT';
    }

    public $MEMBER_TYPE;

    /**
     * @inheritdoc
     */



    public function rules()
    {
        return [
            [['EVENT_NAME', /*'POS_PARENT',*/ 'DATE_START', 'MIN_EAT_COUNT', 'MAX_EAT_COUNT', 'MIN_PAY_AMOUNT', 'MAX_PAY_AMOUNT', 'LAST_VISIT_FREQUENCY', /*'STATUS',*/ ], 'required'],
            [['DATE_CREATED', 'DATE_UPDATED', 'DATE_START', 'GENDER','MIN_POINT', 'MAX_POINT', 'CONTENT_MESSAGE','CAMPAIGN_ID','FILTER_NO_ACTIVE_MEMBER','MEMBER_TYPE','CITY_ID'], 'safe'],
            [['ACTIVE', 'MANAGER_ID', 'MIN_EAT_COUNT', 'MAX_EAT_COUNT', 'LAST_VISIT_FREQUENCY', 'CAMPAIGN_ID', 'STATUS', 'EXPECTED_APPROACH', 'PRACTICAL_APPROACH'], 'integer'],
            [['MIN_PAY_AMOUNT', 'MAX_PAY_AMOUNT', 'BIRTH_MONTH', 'USER_GROUP','SEND_TYPE','EVENT_TYPE'], 'number'],
            [['EVENT_NAME'], 'string', 'max' => 120],
            [['POS_PARENT'], 'string', 'max' => 50],
            //['MIN_PAY_AMOUNT','MAX_PAY_AMOUNT','compareAttribute'=>'MIN_PAY_AMOUNT','MAX_PAY_AMOUNT'=>'>','message'=>'Thanh toán tối đa phải lớn hơn tối thiểu'],
            //['MIN_PAY_AMOUNT', 'MAX_PAY_AMOUNT', 'compareValue' => 30, 'operator' => '>='],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'EVENT_NAME' => 'Tên chiến dịch',
            'POS_PARENT' => 'Thương hiệu',
            'DATE_CREATED' => 'Ngày tạo',
            'DATE_UPDATED' => 'Ngày cập nhật',
            'DATE_START' => 'Ngày bắt đầu',
            'ACTIVE' => 'Active',
            'MANAGER_ID' => 'Quản lý',
            'MIN_EAT_COUNT' => 'Số lần ăn tối thiểu',
            'MAX_EAT_COUNT' => 'Số lần ăn tối đa',
            'MIN_PAY_AMOUNT' => 'Khoản tiền khách hàng trả tối thiểu',
            'MAX_PAY_AMOUNT' => 'Khoản tiền khách hàng trả tối đa',
            'LAST_VISIT_FREQUENCY' => 'Số ngày khách hàng không trở lại',
            'CAMPAIGN_ID' => 'Campaign',
            'STATUS' => 'Trạng thái',
            'EXPECTED_APPROACH' => 'Expected  Approach',
            'PRACTICAL_APPROACH' => 'Practical  Approach',
            'GENDER' => 'Giới tính',
            'MIN_POINT' => 'Số điểm tối thiểu',
            'MAX_POINT' => 'Số điểm tối đa',
            'USER_GROUP' => 'Nhóm khách',
            'SEND_TYPE' => 'Kênh gửi',
            'CONTENT_MESSAGE' => 'Nội dung tin nhắn',
            'EVENT_TYPE' => 'Loại chiến dịch',
            'MEMBER_TYPE' => 'Loại thành viên',
            'LAST_VISIT_FREQUENCY_START' => 'Số ngày từ',
            'LAST_VISIT_FREQUENCY_END' => 'Số ngày đến',
            'CITY_ID' => 'Thành phố',
        ];
    }
}
