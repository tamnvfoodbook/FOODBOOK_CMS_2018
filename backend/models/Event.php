<?php

namespace backend\models;

use backend\controllers\ExtendController;
use Yii;

/**
 * This is the model class for collection "BOOKING_ONLINE_LOG".
 *
 * @property \MongoId|string $_id
 * @property mixed $trigger_name
 * @property mixed $trigger_type
 * @property mixed $pos_parent
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $active
 * @property mixed $trigger_message
 * @property mixed $send_via_sms
 * @property mixed $send_via_zalo
 * @property mixed $send_via_facebook
 * @property mixed $trigger_remind_voucher
 * @property mixed $trigger_voucher_campaign
 * @property mixed $trigger_birthday
 * @property mixed $card_before
 * @property mixed $card_after
 * @property mixed $min_amount
 * @property mixed $max_amount
 */
class Event extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public static function collectionName()
    {
        return [Yii::$app->params['COLLECTION'], 'MG_TRIGGER_EVENT'];
    }


    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'trigger_name',
            'trigger_type',
            'pos_parent',
            'trigger_birthday',
            'created_at',
            'updated_at',
            'active',
            'trigger_message',
            'send_via_sms',
            'send_via_zalo',
            'send_via_facebook',
            'trigger_remind_voucher',
            'trigger_voucher_campaign',
            'trigger_pre',
            'trigger_time',
            'card_before',
            'card_after',
            'min_amount',
            'max_amount',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[
                'trigger_name',
                'trigger_type',
                'pos_parent',
                'created_at',
                'updated_at',
                'active',
                'trigger_message',
                'send_via_sms',
                'send_via_zalo',
                'send_via_facebook',
                'trigger_remind_voucher',
                'trigger_voucher_campaign',
                'trigger_birthday',
                'trigger_pre',
                'trigger_time',
                'card_before',
                'card_after',
                'min_amount',
                'max_amount',
            ], 'safe'],
            [['trigger_message'], 'required'],
            /*['trigger_message', 'required', 'when' => function($model) {
                return $model->trigger_type == 0;
            }, 'whenClient' => "function (attribute, value) {
                return $('#trigger_type_0').val() == 0;
            }"],*/

            /*
            ['commission_rate', 'compare', 'compareValue' => 100, 'operator' => '<=', 'type' => 'number'],*/
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'id',
            'trigger_name' => 'Trigger Name',
            'pos_parent' => 'Thương hiệu',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Ngày cập nhật',
            'active' => 'Active',
            'trigger_message' => 'Nội dung tin nhắn',
            'send_via_sms' => 'Gửi qua SMS',
            'send_via_zalo' => 'Gửi qua Zalo',
            'send_via_facebook' => 'Gửi qua Facebook',
            'trigger_remind_voucher' => 'Trigger remind voucher',
            'trigger_voucher_campaign' => 'Gửi kèm voucher',
            'trigger_birthday' => 'Điều kiện trigger sinh nhật',
            'trigger_pre' => 'Điều kiện',
            'trigger_time' => 'Thời gian sự kiện',
            'trigger_type' => 'Hình thức gửi',
            'card_before' => 'Từ thẻ',
            'card_after' => 'Đến thẻ',
            'min_amount' => 'Từ',
            'max_amount'=> 'Đến',
        ];
    }
}
