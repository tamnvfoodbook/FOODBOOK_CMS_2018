<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for collection "MG_PARTNER_CUSTOM_FIELD".
 *
 * @property \MongoId|string $_id
 * @property mixed $partner_id
 * @property mixed $partner_name
 * @property mixed $pos_id
 * @property mixed $pos_parent
 * @property mixed $pos_name
 * @property mixed $tags
 * @property mixed $time_delivery
 * @property mixed $image_url
 * @property mixed $image_thumb_url
 * @property mixed $active
 * @property mixed $created_at
 * @property mixed $updated_at
 */
class Mgpartnercustomfield extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return 'MG_PARTNER_CUSTOM_FIELD';
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
            'pos_id',
            'pos_parent',
            'pos_name',
            'tags',
            'time_delivery',
            'image_url',
            'image_thumb_url',
            'active',
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
            [['partner_name', 'pos_parent', 'pos_name', 'tags', 'time_delivery', 'image_url', 'image_thumb_url', 'active', 'created_at', 'updated_at'], 'safe'],
            [['pos_id','partner_id'], 'number'],
            [['tags'], 'required'],
            [['partner_id', 'pos_id'], 'unique', 'targetAttribute' => ['partner_id', 'pos_id'], 'message' => 'Cặp key khóa đã tồn tại.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('app', 'ID'),
            'partner_id' => Yii::t('app', 'Partner ID'),
            'partner_name' => Yii::t('app', 'Partner Name'),
            'pos_id' => Yii::t('app', 'Nhà hàng'),
            'pos_parent' => Yii::t('app', 'Pos Parent'),
            'pos_name' => Yii::t('app', 'Pos Name'),
            'tags' => Yii::t('app', 'Tags'),
            'time_delivery' => Yii::t('app', 'Time Delivery'),
            'image_url' => Yii::t('app', 'Image Url'),
            'image_thumb_url' => Yii::t('app', 'Image Thumb Url'),
            'active' => Yii::t('app', 'Active'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
