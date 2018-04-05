<?php

namespace backend\models;
use backend\models\DMMEMBERSHIP;

use Yii;

/**
 * This is the model class for collection "ORDER_RATE".
 *
 * @property \MongoId|string $_id
 * @property mixed $pos_id
 * @property mixed $pos_parent
 * @property mixed $dmShift
 * @property mixed $member_id
 * @property mixed $created_at
 * @property mixed $score
 * @property mixed $reson_bad_food
 * @property mixed $reson_expensive_price
 * @property mixed $reson_bad_service
 * @property mixed $reson_bad_shipper
 * @property mixed $reson_other
 * @property mixed $reson_note
 * @property mixed $published
 */
class Orderrate extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return [Yii::$app->params['COLLECTION'], 'ORDER_RATE'];
    }    

    public function getDmmembership()
    {
        return $this->hasOne(DMMEMBERSHIP::className(), ['ID' => 'member_id']);
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'pos_id',
            'pos_parent',
            'dmShift',
            'member_id',
            'created_at',
            'score',
            'reson_bad_food',
            'reson_expensive_price',
            'reson_bad_service',
            'reson_bad_shipper',
            'reson_other',
            'reson_note',
            'published',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pos_id', 'pos_parent', 'dmShift', 'member_id', 'created_at', 'score', 'reson_bad_food', 'reson_expensive_price', 'reson_bad_service', 'reson_bad_shipper', 'reson_other', 'reson_note', 'published'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'pos_id' => 'Nhà hàng',
            'pos_parent' => 'Thương hiệu',
            'dmShift' => 'Dm Shift',
            'member_id' => 'Khách hàng',
            'created_at' => 'Ngày tạo',
            'score' => 'Điểm',
            'reson_bad_food' => 'Reson Bad Food',
            'reson_expensive_price' => 'Reson Expensive Price',
            'reson_bad_service' => 'Reson Bad Service',
            'reson_bad_shipper' => 'Reson Bad Shipper',
            'reson_other' => 'Reson Other',
            'reson_note' => 'Ghi chú',
            'published' => 'Published',
        ];
    }

    public function getPos()
    {
        return $this->hasOne(Dmpos::className(), ['ID' => 'pos_id']);
    }
    public function getmemberInfo()
    {
        $member = new DmmembershipSearch();
        $memberInfo = $member->searchMemberModelById($this->member_id);
        return $this->member_id.'<br>'.@$memberInfo->MEMBER_NAME;
    }

    public function getReson()
    {
        $reson = null;
        if($this->reson_bad_food){
            $reson = 'Đồ ăn kém';
        }
        if($this->reson_bad_service){
            $reson = 'Dịch vụ kém';
        }
        if($this->reson_bad_shipper){
            $reson = 'Giao hàng kém';
        }
        if($this->reson_expensive_price){
            $reson = 'Giá đắt';
        }
        if($this->reson_other){
            $reson = "Đánh giá khác";
        }
        return $reson;
    }
}
