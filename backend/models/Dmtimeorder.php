<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "DM_TIME_ORDER".
 *
 * @property string $ID
 * @property string $POS_ID
 * @property integer $TYPE
 * @property integer $DAY_OF_WEEK
 * @property string $TIME_START
 * @property string $TIME_END
 * @property string $DAY_OFF
 * @property integer $ACTIVE
 */
class Dmtimeorder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DM_TIME_ORDER';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['POS_ID','DAY_OF_WEEK','TYPE','ACTIVE'], 'required'],
            [['POS_ID', 'TYPE', 'ACTIVE'], 'integer'],
            [['TIME_START', 'TIME_END', 'DAY_OFF'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'POS_ID' => 'Nhà hàng',
            'TYPE' => 'Loại',
            'DAY_OF_WEEK' => 'Ngày trong tuần',
            'TIME_START' => 'Thòi gian bắt đầu',
            'TIME_END' => 'Thời gian kết thúc',
            'DAY_OFF' => 'Ngày nghỉ',
            'ACTIVE' => 'Active',
        ];
    }

    public function getPos()
    {
        return $this->hasOne(Dmpos::className(), ['ID' => 'POS_ID']);
    }
    public function getType()
    {
        return $this->TYPE == 10 ? 'Kiểu ngày' : 'Kiểu Tuần';
    }

    public function getChangeDate()
    {
        if($this->DAY_OF_WEEK == 8){
            return 'Chủ nhật';
        }else{
            return 'Thứ '.$this->DAY_OF_WEEK;
        }
    }

}
