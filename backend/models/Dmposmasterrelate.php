<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "DM_POS_MASTER_RELATE".
 *
 * @property string $ID
 * @property string $POS_ID
 * @property integer $POS_MASTER_ID
 * @property integer $SORT
 */
class Dmposmasterrelate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DM_POS_MASTER_RELATE';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['POS_ID', 'POS_MASTER_ID'], 'required'],
            [['POS_ID', 'POS_MASTER_ID', 'SORT'], 'integer'],
            [['POS_ID', 'POS_MASTER_ID'], 'unique', 'targetAttribute' => ['POS_ID', 'POS_MASTER_ID'], 'message' => 'The combination of Pos  ID and Pos  Master  ID has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'POS_ID' => 'Pos  ID',
            'POS_MASTER_ID' => 'Pos Master ID',
            'SORT' => 'Sort',
        ];
    }

    public function getPos()
    {
        return $this->hasOne(Dmpos::className(), ['ID' => 'POS_ID']);
    }

    public function getPosmaster()
    {
        return $this->hasOne(Dmposmaster::className(), ['ID' => 'POS_MASTER_ID']);
    }
    public function getCity()
    {
        $cityModelSearch = new DmcitySearch();
        $city = $cityModelSearch->searchCityById($this->posmaster->CITY_ID);
//        echo '<pre>';
//        var_dump($city);
//        echo '</pre>';
//        die();

        return $city->CITY_NAME;
    }
//    public function getCityName()
//    {
//        return $this->city->CITY_NAME;
//    }

}
