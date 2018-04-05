<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "DM_SHIP_FEE".
 *
 * @property string $ID
 * @property string $POS_ID
 * @property double $FROM_KM
 * @property double $TO_KM
 * @property double $FROM_AMOUNT
 * @property double $TO_AMOUNT
 * @property double $FEE
 */
class Dmshipfee extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DM_SHIP_FEE';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['POS_ID'], 'required'],
            [['POS_ID'], 'integer'],
            [['FROM_KM', 'TO_KM', 'FROM_AMOUNT', 'TO_AMOUNT', 'FEE'], 'number'],
            //['FROM_KM', 'TO_KM','<' ],
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
            'FROM_KM' => 'From  Km',
            'TO_KM' => 'To  Km',
            'FROM_AMOUNT' => 'From  Amount',
            'TO_AMOUNT' => 'To  Amount',
            'FEE' => 'Fee',
        ];
    }

    public function getPos()
    {
        return $this->hasOne(Dmpos::className(), ['ID' => 'POS_ID']);
    }
    public function getConvertfee()
    {
        if($this->FEE == -2){
            return 'AHAMOVE quyết định';
        }elseif($this->FEE == -1){
            return 'Nhà hàng liên hệ lại sau';
        }elseif($this->FEE == 0){
            return 'Miễn phí vận chuyển';
        }else{
            return $this->FEE;
        }

    }


}
