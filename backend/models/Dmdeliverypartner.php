<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "DM_DELIVERY_PARTNER".
 *
 * @property string $ID
 * @property string $NAME
 * @property string $URL
 * @property string $CONFIG_JSON
 * @property integer $ACTIVE
 */
class Dmdeliverypartner extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DM_DELIVERY_PARTNER';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID'], 'required'],
            [['CONFIG_JSON'], 'string'],
            [['ACTIVE'], 'integer'],
            [['ID'], 'string', 'max' => 20],
            [['NAME'], 'string', 'max' => 50],
            [['URL'], 'string', 'max' => 200]
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
            'URL' => 'Url',
            'CONFIG_JSON' => 'Config  Json',
            'ACTIVE' => 'Active',
        ];
    }

    public function searchAll(){
        $data = Dmdeliverypartner::find()
            ->asArray()
            ->all();

        return $data;
    }

}
