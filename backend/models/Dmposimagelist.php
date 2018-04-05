<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "DM_POS_IMAGE_LIST".
 *
 * @property string $ID
 * @property string $POS_ID
 * @property string $DESCRIPTION
 * @property string $IMAGE_PATH
 * @property integer $ACTIVE
 * @property integer $SORT
 */
class Dmposimagelist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DM_POS_IMAGE_LIST';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['POS_ID', 'ACTIVE', /*'IMAGE_PATH'*/], 'required'],
            [['POS_ID', 'ACTIVE', 'SORT'], 'integer'],
            [['DESCRIPTION', 'IMAGE_PATH'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'POS_ID' => 'Pos  ID',
            'DESCRIPTION' => 'Description',
            'IMAGE_PATH' => 'Image  Path',
            'ACTIVE' => 'Active',
            'SORT' => 'Sort',
        ];
    }

    public function getPos()
    {
        return $this->hasOne(Dmpos::className(), ['ID' => 'POS_ID']);
    }
}
