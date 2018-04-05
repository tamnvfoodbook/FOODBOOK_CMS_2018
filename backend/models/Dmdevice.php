<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "DM_DEVICE".
 *
 * @property integer $ID
 * @property string $DEVICE_ID
 * @property integer $DEVICE_TYPE
 * @property string $PUSH_ID
 * @property string $MSISDN
 * @property string $LAST_UPDATED
 * @property integer $ACTIVE
 * @property string $VERSION
 * @property string $CREATED_AT
 * @property string $MODEL
 * @property string $LANGUAGE
 */
class Dmdevice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DM_DEVICE';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DEVICE_ID', 'PUSH_ID'], 'required'],
            [['DEVICE_TYPE', 'MSISDN', 'ACTIVE'], 'integer'],
            [['LAST_UPDATED', 'CREATED_AT'], 'safe'],
            [['DEVICE_ID', 'PUSH_ID', 'MODEL'], 'string', 'max' => 200],
            [['VERSION'], 'string', 'max' => 20],
            [['LANGUAGE'], 'string', 'max' => 50],
            [['DEVICE_ID', 'DEVICE_TYPE'], 'unique', 'targetAttribute' => ['DEVICE_ID', 'DEVICE_TYPE'], 'message' => 'The combination of Device  ID and Device  Type has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'DEVICE_ID' => 'Device  ID',
            'DEVICE_TYPE' => 'Device  Type',
            'PUSH_ID' => 'Push  ID',
            'MSISDN' => 'Msisdn',
            'LAST_UPDATED' => 'Last  Updated',
            'ACTIVE' => 'Active',
            'VERSION' => 'Version',
            'CREATED_AT' => 'Created  At',
            'MODEL' => 'Model',
            'LANGUAGE' => 'Language',
        ];
    }

    public function getDischargedLabel()
    {
        //return $this->DEVICE_TYPE ? 'Yes' : 'No';
        if($this->DEVICE_TYPE == 1){
            return 'ANDROID';
        }else{
            return 'IOS';
        }
    }


}
