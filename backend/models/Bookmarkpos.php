<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for collection "BOOKMARK_POS".
 *
 * @property \MongoId|string $_id
 * @property mixed $user_id
 * @property mixed $pos_id
 * @property mixed $type
 * @property mixed $created_at
 */
class BOOKMARKPOS extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return [Yii::$app->params['COLLECTION'], 'BOOKMARK_POS'];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            '_id',
            'user_id',
            'pos_id',
            'type',
            'created_at',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'pos_id', 'type', 'created_at'], 'safe']
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
            'pos_id' => 'Pos ID',
            'type' => 'Type',
            'created_at' => 'Created At',
        ];
    }
}
