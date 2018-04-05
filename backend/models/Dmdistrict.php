<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "DM_DISTRICT".
 *
 * @property integer $ID
 * @property string $DISTRICT_NAME
 * @property integer $CITY_ID
 * @property integer $SORT
 */
class Dmdistrict extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DM_DISTRICT';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DISTRICT_NAME'], 'required'],
            [['CITY_ID', 'SORT'], 'integer'],
            [['DISTRICT_NAME'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'DISTRICT_NAME' => 'District  Name',
            'CITY_ID' => 'City  ID',
            'SORT' => 'Sort',
        ];
    }

    public function getCity()
    {
        return $this->hasOne(Dmcity::className(), ['ID' => 'CITY_ID']);
    }
}
