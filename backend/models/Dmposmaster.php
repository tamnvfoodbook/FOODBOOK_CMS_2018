<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "DM_POS_MASTER".
 *
 * @property integer $ID
 * @property string $POS_MASTER_NAME
 * @property string $DESCRIPTION
 * @property string $IMAGE_PATH
 * @property integer $IS_COLLECTION
 * @property integer $ACTIVE
 * @property integer $FOR_BREAKFAST
 * @property integer $FOR_LUNCH
 * @property integer $FOR_DINNER
 * @property integer $FOR_MIDNIGHT
 * @property integer $SORT
 * @property integer $CITY_ID
 * @property string $TIME_START
 * @property string $DAY_ON
 * @property string $LOAD_BY_LOCATION
 */
class Dmposmaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DM_POS_MASTER';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['POS_MASTER_NAME'/*,   'TIME_START', 'DAY_ON'*/], 'required'],
            [['IS_COLLECTION', 'ACTIVE', 'FOR_BREAKFAST', 'FOR_LUNCH', 'FOR_DINNER', 'FOR_MIDNIGHT', 'SORT', 'CITY_ID','LOAD_BY_LOCATION'], 'integer'],
            [['POS_MASTER_NAME'], 'string', 'max' => 200],
            [['DESCRIPTION', 'IMAGE_PATH'], 'string', 'max' => 500],
            [['TIME_START', 'DAY_ON'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'POS_MASTER_NAME' => 'Tên nhóm điểm (Tiếng việt)',
            'POS_MASTER_NAME_EN' => 'Tên nhóm điểm (Tiếng Anh)',
            'DESCRIPTION' => 'Mô tả',
            'IMAGE_PATH' => 'Ảnh',
            'IS_COLLECTION' => 'Is  Collection',
            'ACTIVE' => 'Active',
            'FOR_BREAKFAST' => 'Bữa sáng',
            'FOR_LUNCH' => 'Bữa trưa',
            'FOR_DINNER' => 'Bữa tối',
            'FOR_MIDNIGHT' => 'Bữa đêm',
            'SORT' => 'Thứ tự',
            'CITY_ID' => 'Thành phố',
            'TIME_START' => 'Thời điểm bắt đầu',
            'DAY_ON' => 'Trong ngày',
            'LOAD_BY_LOCATION' => 'Tải theo vị trí',
        ];
    }

    public function getCity()
    {
        return $this->hasOne(Dmcity::className(), ['ID' => 'CITY_ID']);
    }
}
