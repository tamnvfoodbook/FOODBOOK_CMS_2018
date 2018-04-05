<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for collection "CALL_CENTER_LOG".
 *
 * @property \MongoId|string $_id
 * @property mixed $cid_name
 * @property mixed $source
 * @property mixed $destination
 * @property mixed $recording
 * @property mixed $start
 * @property mixed $tta
 * @property mixed $duration
 * @property mixed $pdd
 * @property mixed $mos
 * @property mixed $status
 */
class Callcenterlog extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return ['IPOS', 'CALL_CENTER_LOG'];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'cid_name',
            'source',
            'destination',
            'recording',
            'start',
            'tta',
            'duration',
            'pdd',
            'mos',
            'status',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cid_name', 'source', 'destination', 'recording', 'start', 'tta', 'duration', 'pdd', 'mos', 'status'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'cid_name' => 'Cid Name',
            'source' => 'Source',
            'destination' => 'Destination',
            'recording' => 'Recording',
            'start' => 'Start',
            'tta' => 'Tta',
            'duration' => 'Duration',
            'pdd' => 'Pdd',
            'mos' => 'Mos',
            'status' => 'Status',
        ];
    }
}
