<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "DM_POLICY_IMAGE".
 *
 * @property string $ID
 * @property string $IMAGE_LINK
 * @property string $DESCRIPTION
 * @property string $DESCRIPTION_URL
 * @property integer $SORT
 * @property string $DATE_CREATED
 * @property string $DATE_START
 * @property string $DATE_END
 * @property integer $ACTIVE
 */
class Dmpolicyimage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DM_POLICY_IMAGE';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DATE_CREATED', 'DATE_START', 'DATE_END'], 'required'],
            [['SORT', 'ACTIVE','CITY_ID'], 'integer'],
            [['DATE_CREATED', 'DATE_START', 'DATE_END', 'LIST_POS_PARENT', 'DESCRIPTION'], 'safe'],
            [['IMAGE_LINK', 'DESCRIPTION_URL'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'IMAGE_LINK' => 'Image  Link',
            'DESCRIPTION' => 'Description',
            'DESCRIPTION_URL' => 'Description  Url',
            'SORT' => 'Sort',
            'DATE_CREATED' => 'Date  Created',
            'DATE_START' => 'Date  Start',
            'DATE_END' => 'Date  End',
            'CITY_ID' => 'Thành phố',
            'ACTIVE' => 'Active',
            'LIST_POS_PARENT' => 'Danh sách thương hiệu',
        ];
    }
}
