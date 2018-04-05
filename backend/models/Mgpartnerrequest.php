<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for collection "MG_PARTNER_REQUEST".
 *
 * @property \MongoId|string $_id
 * @property mixed $partner_name
 * @property mixed $request_at
 * @property mixed $response_at
 * @property mixed $request_data
 * @property mixed $response_data
 * @property mixed $has_exception
 * @property mixed $tag
 */
class MGPARTNERREQUEST extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return ['IPOS', 'MG_PARTNER_REQUEST'];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'partner_name',
            'request_at',
            'response_at',
            'request_data',
            'response_data',
            'has_exception',
            'tag',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['partner_name', 'request_at', 'response_at', 'request_data', 'response_data', 'has_exception', 'tag'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'partner_name' => 'Partner Name',
            'request_at' => 'Request At',
            'response_at' => 'Response At',
            'request_data' => 'Request Data',
            'response_data' => 'Response Data',
            'has_exception' => 'Has Exception',
            'tag' => 'Tag',
        ];
    }
}
