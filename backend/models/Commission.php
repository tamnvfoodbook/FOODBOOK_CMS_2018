<?php

namespace backend\models;

use backend\controllers\ExtendController;
use Yii;

/**
 * This is the model class for collection "BOOKING_ONLINE_LOG".
 *
 * @property \MongoId|string $_id
 * @property mixed $partner_id
 * @property mixed $partner_name
 * @property mixed $pos_parent
 * @property mixed $pos_id
 * @property mixed $pos_name
 * @property mixed $commission_rate
 * @property mixed $created_at
 */
class Commission extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public static function collectionName()
    {
        return [Yii::$app->params['COLLECTION'], 'MG_COMMISSION'];
    }


    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'partner_id',
            'partner_name',
            'pos_parent',
            'pos_id',
            'pos_name',
            'commission_rate',
            'created_at',
            'updated_at',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[
                'partner_id',
                'partner_name',
                'pos_parent',
                'pos_id',
                'pos_name',
                'commission_rate',
                'created_at',
                'updated_at',
            ], 'safe'],
            [['pos_id','partner_id','pos_parent','commission_rate'], 'required'],
            ['commission_rate', 'compare', 'compareValue' => 100, 'operator' => '<=', 'type' => 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'partner_id' => 'Mã đối tác',
            'partner_name' => 'Tên đối tác',
            'pos_parent' => 'Thương hiệu',
            'pos_id' => 'Mã nhà hàng',
            'pos_name' => 'Nhà hàng',
            'commission_rate' => 'Tỉ lệ hoa hồng (%)',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Ngày cập nhật',
        ];
    }
}
