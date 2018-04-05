<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "DM_CITY".
 *
 * @property integer $ID
 * @property string $CITY_NAME
 * @property integer $SORT
 * @property integer $ACTIVE
 * @property double $LONGITUDE
 * @property double $LATITUDE
 * @property string $GG_LOCALITY
 * @property string $AM_LOCALITY
 */
class DMCITY extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DM_CITY';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'CITY_NAME', 'GG_LOCALITY', 'AM_LOCALITY'], 'required'],
            [['ID', 'SORT', 'ACTIVE'], 'integer'],
            [['LONGITUDE', 'LATITUDE'], 'number'],
            [['CITY_NAME'], 'string', 'max' => 200],
            [['GG_LOCALITY', 'AM_LOCALITY'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'CITY_NAME' => 'City  Name',
            'SORT' => 'Sort',
            'ACTIVE' => 'Active',
            'LONGITUDE' => 'Longitude',
            'LATITUDE' => 'Latitude',
            'GG_LOCALITY' => 'Gg  Locality',
            'AM_LOCALITY' => 'Am  Locality',
        ];
    }


//    public function getPos()
//    {
//        return $this->hasMany(Dmpos::className(), ['ID' => 'POS_ID']);
//    }
}
