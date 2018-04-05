<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "DM_USER_PARTNER".
 *
 * @property string $ID
 * @property string $PARTNER_NAME
 * @property string $AUTH_KEY
 * @property string $ACCESS_TOKEN
 * @property integer $ACTIVE
 * @property integer $IS_SEND_SMS
 * @property string $LIST_POS_PARENT
 * @property string $BRAND_NAME
 * @property string $SMS_PARTNER
 * @property string $API_KEY
 * @property string $SECRET_KEY
 * @property string $RESPONSE_URL
 */
class Dmuserpartner extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DM_USER_PARTNER';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PARTNER_NAME'], 'required'],
            [['LIST_POS_PARENT'], 'safe'],
            [['ACTIVE', 'IS_SEND_SMS'], 'integer'],
            [['PARTNER_NAME', 'BRAND_NAME', 'SMS_PARTNER', 'API_KEY', 'SECRET_KEY'], 'string', 'max' => 50],
            [['AUTH_KEY'], 'string', 'max' => 32],
            [['ACCESS_TOKEN'], 'string', 'max' => 255],
            [['RESPONSE_URL'], 'string', 'max' => 200],
            [['ACCESS_TOKEN'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'PARTNER_NAME' => 'Tên đối tác',
            'AUTH_KEY' => 'Key chứng thực',
            'ACCESS_TOKEN' => 'Access  Token',
            'ACTIVE' => 'Active',
            'IS_SEND_SMS' => 'Cho phép gửi tin nhắn',
            'LIST_POS_PARENT' => 'Danh sách thương hiệu',
            'BRAND_NAME' => 'Brand  Name',
            'SMS_PARTNER' => 'Sms  Partner',
            'API_KEY' => 'Api  Key',
            'SECRET_KEY' => 'Secret  Key',
            'RESPONSE_URL' => 'Response  Url',
        ];
    }
}
