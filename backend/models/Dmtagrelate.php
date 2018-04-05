<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "DM_TAG_RELATE".
 *
 * @property string $TAG_ID
 * @property string $POS_ID
 * @property integer $PIORITY
 */
class Dmtagrelate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DM_TAG_RELATE';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TAG_ID', 'POS_ID'], 'required'],
            [['TAG_ID', 'POS_ID', 'PIORITY'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TAG_ID' => 'Tag  ID',
            'POS_ID' => 'Pos  ID',
            'PIORITY' => 'Piority',
        ];
    }
}
