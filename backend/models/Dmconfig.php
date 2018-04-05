<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "DM_CONFIG".
 *
 * @property integer $ID
 * @property string $KEYGROUP
 * @property integer $SORT
 * @property string $KEYWORD
 * @property string $VALUES
 * @property string $DESC
 * @property integer $ACTIVE
 */
class Dmconfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DM_CONFIG';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SORT', 'ACTIVE'], 'integer'],
            [['KEYWORD'], 'required'],
            [['KEYGROUP'], 'string', 'max' => 50],
            [['KEYWORD', 'VALUES', 'DESC'], 'string', 'max' => 200],
            [['KEYWORD'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'KEYGROUP' => 'Keygroup',
            'SORT' => 'Sort',
            'KEYWORD' => 'Keyword',
            'VALUES' => 'Values',
            'DESC' => 'Desc',
            'ACTIVE' => 'Active',
        ];
    }
}
