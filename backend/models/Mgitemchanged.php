<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for collection "MG_ITEM_CHANGED".
 *
 * @property \MongoId|string $_id
 * @property mixed $pos_parent
 * @property mixed $pos_id
 * @property mixed $last_changed
 * @property mixed $reversion
 * @property mixed $changed
 * @property mixed $last_broadcast
 */
class Mgitemchanged extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return 'MG_ITEM_CHANGED';
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'pos_parent',
            'pos_id',
            'last_changed',
            'reversion',
            'changed',
            'last_broadcast',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pos_parent', 'pos_id', 'last_changed', 'reversion', 'changed', 'last_broadcast'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('app', 'ID'),
            'pos_parent' => Yii::t('app', 'Pos Parent'),
            'pos_id' => Yii::t('app', 'Pos ID'),
            'last_changed' => Yii::t('app', 'Last Changed'),
            'reversion' => Yii::t('app', 'Reversion'),
            'changed' => Yii::t('app', 'Changed'),
            'last_broadcast' => Yii::t('app', 'Last Broadcast'),
        ];
    }
}
