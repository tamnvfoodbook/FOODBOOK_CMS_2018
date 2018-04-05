<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for collection "SALE_DETAIL".
 *
 * @property \MongoId|string $_id
 * @property mixed $Pos_Id
 * @property mixed $Pos_Parent
 * @property mixed $Fr_Key
 * @property mixed $Amount
 * @property mixed $Price_Sale
 * @property mixed $Tran_Id
 * @property mixed $Created_At
 */
class Saledetail extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        $date = date("Ymd");
        $moth = substr((string)$date,0,6);
        return [Yii::$app->params['COLLECTION'], 'SALE_DETAIL_'.$moth];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'Pos_Id',
            'Pos_Parent',
            'Fr_Key',
            'Amount',
            'Price_Sale',
            'Tran_Id',
            'Created_At',
            'Created_At_DateTime',

        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Pos_Id', 'Pos_Parent', 'Fr_Key', 'Amount', 'Price_Sale', 'Tran_Id', 'Created_At'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'Pos_Id' => 'Pos  ID',
            'Pos_Parent' => 'Pos  Parent',
            'Fr_Key' => 'Fr  Key',
            'Amount' => 'Amount',
            'Price_Sale' => 'Price  Sale',
            'Tran_Id' => 'Tran  ID',
            'Created_At' => 'Created  At',            
            'Created_At_DateTime' => 'Created_At_DateTime',            
        ];
    }
}
