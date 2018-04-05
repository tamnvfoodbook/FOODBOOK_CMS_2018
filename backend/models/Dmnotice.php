<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "DM_NOTICE".
 *
 * @property integer $ID
 * @property string $TITLE
 * @property string $CONTENT
 * @property string $CREATED_BY
 * @property string $CREATED_AT
 * @property string $FULL_CONTENT_URL
 * @property integer $IS_ALL_POS
 * @property string $POS_PARENT
 * @property string $LIST_POS
 */
class Dmnotice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $TITLE;
    public $CREATED_AT;
    public $ID;
    public $CONTENT;
    public $CREATED_BY;
    public $FULL_CONTENT_URL;
    public $IS_ALL_POS;
    public $POS_PARENT;
    public $LIST_POS;

    /*public static function tableName()
    {
        return 'DM_NOTICE';
    }*/

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TITLE', 'CREATED_AT', 'POS_PARENT'], 'required'],
            [['CREATED_AT', 'LIST_POS'], 'safe'],
            [['IS_ALL_POS'], 'integer'],
            [['TITLE'], 'string', 'max' => 100],
            [['CONTENT', 'FULL_CONTENT_URL'], 'string', 'max' => 1000],
            [['CREATED_BY'], 'string', 'max' => 50],
            [['POS_PARENT'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'TITLE' => 'Title',
            'CONTENT' => 'Content',
            'CREATED_BY' => 'Created  By',
            'CREATED_AT' => 'Created  At',
            'FULL_CONTENT_URL' => 'Full  Content  Url',
            'IS_ALL_POS' => 'Is  All  Pos',
            'POS_PARENT' => 'Pos  Parent',
            'LIST_POS' => 'List  Pos',
        ];
    }
}
