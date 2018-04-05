<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "DM_TAG".
 *
 * @property string $ID
 * @property string $NAME
 * @property string $SCORE
 */
class Dmtag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DM_TAG';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NAME'], 'required'],
            [['SCORE'], 'integer'],
            [['NAME'], 'string', 'max' => 50],
            [['NAME'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'NAME' => 'Name',
            'SCORE' => 'Score',
        ];
    }
}
