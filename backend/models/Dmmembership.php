<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "DM_MEMBERSHIP".
 *
 * @property string $ID
 * @property string $MEMBER_NAME
 * @property string $MEMBER_IMAGE_PATH
 * @property integer $ACTIVE
 * @property string $HASH_PASSWORD
 * @property string $FACEBOOK_ID
 * @property string $PHONE_NUMBER
 * @property string $EMAIL
 * @property string $CREATED_AT
 * @property string $LAST_UPDATED
 * @property string $MY_STATUS
 * @property string $BIRTHDAY
 * @property string $CREATED_BY
 * @property string $SEX
 * @property string $USER_GROUPS
 * @property string $CITY_ID
 */
class Dmmembership extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
//    public $dmmembershippoint;



    public static function tableName()
    {
        return 'DM_MEMBERSHIP';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'MEMBER_NAME', 'CREATED_BY'], 'required'],
            [['ID', 'ACTIVE','SEX','USER_GROUPS'], 'integer'],
            [['CREATED_AT', 'LAST_UPDATED', 'BIRTHDAY', 'CITY_ID'], 'safe'],
            [['MEMBER_NAME', 'MY_STATUS', 'CREATED_BY'], 'string', 'max' => 200],
            [['MEMBER_IMAGE_PATH'], 'string', 'max' => 500],
            [['HASH_PASSWORD'], 'string', 'max' => 100],
            [['FACEBOOK_ID', 'EMAIL'], 'string', 'max' => 50],
            [['PHONE_NUMBER'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'Số điện thoại',
            'MEMBER_NAME' => 'Họ tên',
            'MEMBER_IMAGE_PATH' => 'Ảnh đại diện',
            'ACTIVE' => 'Active',
            'HASH_PASSWORD' => 'Hash  Password',
            'FACEBOOK_ID' => 'Facebook  ID',
            'PHONE_NUMBER' => 'Phone  Number',
            'EMAIL' => 'Email',
            'CREATED_AT' => 'Created  At',
            'LAST_UPDATED' => 'Cập nhật lần cuối',
            'MY_STATUS' => 'My  Status',
            'BIRTHDAY' => 'Ngày sinh',
            'CREATED_BY' => 'Nguồn tạo',
            'SEX' => 'Giới tính',
            'USER_GROUPS' => 'Nhóm khách',
            'CITY_ID' => 'Thành phố',
        ];
    }


    public function getDmmembershippoint()
    {
        return $this->hasOne(Dmmembershippoint::className(), ['MEMBERSHIP_ID' => 'ID']);
    }
}
