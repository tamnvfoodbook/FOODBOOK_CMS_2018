<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "DM_QUERY_LOG".
 *
 * @property string $ID
 * @property string $CREATED_AT
 * @property string $ACTION_QUERY
 * @property string $TABLE_NAME
 * @property string $DATA_OLD
 * @property string $DATA_NEW
 * @property string $USER_MANAGER_ID
 * @property string $USER_MANAGER_NAME
 */
class Dmquerylog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DM_QUERY_LOG';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CREATED_AT', 'ACTION_QUERY', 'TABLE_NAME', 'DATA_OLD', 'USER_MANAGER_ID'], 'required'],
            [['CREATED_AT'], 'safe'],
            [['DATA_OLD', 'DATA_NEW'], 'string'],
            [['USER_MANAGER_ID'], 'integer'],
            [['ACTION_QUERY'], 'string', 'max' => 20],
            [['TABLE_NAME', 'USER_MANAGER_NAME'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'CREATED_AT' => 'Created  At',
            'ACTION_QUERY' => 'Action  Query',
            'TABLE_NAME' => 'Table  Name',
            'DATA_OLD' => 'Data  Old',
            'DATA_NEW' => 'Data  New',
            'USER_MANAGER_ID' => 'User  Manager  ID',
            'USER_MANAGER_NAME' => 'User  Manager  Name',
        ];
    }
}
