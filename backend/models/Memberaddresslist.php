<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for collection "MEMBER_ADDRESS_LIST".
 *
 * @property \MongoId|string $_id
 * @property mixed $user_id
 * @property mixed $alias_name
 * @property mixed $extend_address
 * @property mixed $full_address
 * @property mixed $city_id
 * @property mixed $district_id
 * @property mixed $created_at
 * @property mixed $longitude
 * @property mixed $latitude
 */
class Memberaddresslist extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return [Yii::$app->params['COLLECTION'], 'MEMBER_ADDRESS_LIST'];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'user_id',
            'alias_name',
            'extend_address',
            'full_address',
            'city_id',
            'district_id',
            'created_at',
            'longitude',
            'latitude',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'alias_name', 'extend_address', 'full_address', 'city_id', 'district_id', 'created_at', 'longitude', 'latitude'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'user_id' => 'User ID',
            'alias_name' => 'Alias Name',
            'extend_address' => 'Extend Address',
            'full_address' => 'Full Address',
            'city_id' => 'City ID',
            'district_id' => 'District ID',
            'created_at' => 'Created At',
            'longitude' => 'Longitude',
            'latitude' => 'Latitude',
        ];
    }
}
