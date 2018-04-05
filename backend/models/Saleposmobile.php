<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for collection "SALE_POS_MOBILE".
 *
 * @property \MongoId|string $_id
 * @property mixed $pos_id
 * @property mixed $pr_key
 * @property mixed $status
 * @property mixed $ticket_name
 * @property mixed $user_id
 * @property mixed $time_update
 * @property mixed $date_time
 * @property mixed $trans_type
 * @property mixed $data_sale_detail
 */
class Saleposmobile extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return [Yii::$app->params['COLLECTION'], 'SALE_POS_MOBILE'];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'pos_id',
            'pr_key',
            'status',
            'ticket_name',
            'user_id',
            'time_update',
            'date_time',
            'trans_type',
            'data_sale_detail',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pos_id', 'pr_key', 'status', 'ticket_name', 'user_id', 'time_update', 'date_time', 'trans_type', 'data_sale_detail'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'pos_id' => 'Pos ID',
            'pr_key' => 'Pr Key',
            'status' => 'Status',
            'ticket_name' => 'Ticket Name',
            'user_id' => 'User ID',
            'time_update' => 'Time Update',
            'date_time' => 'Date Time',
            'trans_type' => 'Trans Type',
            'data_sale_detail' => 'Data Sale Detail',
        ];
    }
}
