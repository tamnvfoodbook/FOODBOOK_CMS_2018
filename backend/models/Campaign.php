<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for collection "CAMPAIGN".
 *
 * @property \MongoId|string $_id
 * @property mixed $className
 * @property mixed $Pos_Id
 * @property mixed $City_Id
 * @property mixed $Campaign_Name
 * @property mixed $Campaign_Desc
 * @property mixed $Campaign_Type
 * @property mixed $Campaign_Type_Row
 * @property mixed $Hex_Color
 * @property mixed $Image
 * @property mixed $Image_Line
 * @property mixed $Image_Logo
 * @property mixed $Campaign_Created_At
 * @property mixed $Campaign_Start
 * @property mixed $Campaign_End
 * @property mixed $Coupon_Id
 * @property mixed $Item_Id_List
 * @property mixed $Active
 * @property mixed $Sort
 * @property mixed $Show_Price_Bottom
 */
class Campaign extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public static function collectionName()
    {
        return ['IPOS', 'CAMPAIGN'];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'className',
            'Pos_Id',
            'City_Id',
            'Campaign_Name',
            'Campaign_Desc',
            'Campaign_Type',
            'Campaign_Type_Row',
            'Hex_Color',
            'Image',
            'Image_Line',
            'Image_Logo',
            'Campaign_Created_At',
            'Campaign_Start',
            'Campaign_End',
            'Coupon_Id',
            'Item_Id_List',
            'Active',
            'Sort',
            'Show_Price_Bottom',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['className', 'Image', 'Image_Line', 'Image_Logo', 'Campaign_Created_At', 'Campaign_Start', 'Campaign_End','Item_Id_List','Pos_Id', 'City_Id','Coupon_Id'], 'safe'],
            [['Active','Sort','Show_Price_Bottom'], 'number'],
            //[['Campaign_Name','Campaign_Type', 'Campaign_Type_Row', 'Campaign_Desc','Hex_Color','Campaign_Start'], 'string'],
            [['Campaign_Name','Campaign_Type', 'Campaign_Type_Row', 'Campaign_Desc','Hex_Color','Campaign_Start',], 'required']

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'className' => 'Class Name',
            'Pos_Id' => 'Nhà hàng',
            'City_Id' => 'Thành phố',
            'Campaign_Name' => 'Tên Campaign',
            'Campaign_Desc' => 'Chi tiết Campaign (###val_price: số tiền được giảm giá, ###val_coupon: tổng số tiền món ăn, ###val_discount = val_price - val_coupon)',
            'Campaign_Type' => 'Loại Campaign',
            'Campaign_Type_Row' => 'Campaign  Type  Row',
            'Hex_Color' => 'Hex  Color',
            'Image' => 'Image',
            'Image_Line' => 'Image  Line',
            'Image_Logo' => 'Image  Logo',
            'Campaign_Created_At' => 'Ngày tạo',
            'Campaign_Start' => 'Bắt đầu',
            'Campaign_End' => 'Kết thúc',
            'Coupon_Id' => 'Mệnh giá Coupon',
            'Item_Id_List' => 'Item  Id  List',
            'Active' => 'Active',
            'Sort' => 'Thứ tự',
            'Show_Price_Bottom' => 'Hiển thị giá',
        ];
    }

    public function imageLine(){

        return [
            'icon_1' => 'icon_1',
            'icon_2' => 'icon_2',
            'icon_3' => 'icon_3',
            'icon_4' => 'icon_4',
            'icon_5' => 'icon_5',
            'icon_6' => 'icon_6',
            'icon_7' => 'icon_7',
            'icon_20_10' => 'icon_20_10',
            'icon_birthday' => 'icon_birthday',
            'icon_co3la' => 'icon_co3la',
            'icon_gift' => 'icon_gift',
            'icon_halloween' => 'icon_halloween',
            'icon_new' => 'icon_new',
            'icon_noel' => 'icon_noel',
            'icon_noel2' => 'icon_noel2',
            'icon_noel3' => 'icon_noel3',
            'icon_sport' => 'icon_sport',
            'icon_tet' => 'icon_tet',
            'icon_valentine' => 'icon_valentine',
        ];
    }

    public function getPos()
    {
        return $this->hasOne(Dmpos::className(), ['ID' => 'Pos_Id']);
    }

    public function getCity()
    {
        return $this->hasOne(Dmcity::className(), ['ID' => 'City_Id']);
    }

    public function getCampaigndate(){
        return date(Yii::$app->params['DATE_FORMAT'], $this->Campaign_Created_At->sec);
    }
    public function getCampaignStartdate(){
        return date(Yii::$app->params['DATE_FORMAT'], $this->Campaign_Start->sec);
    }
    public function getCampaignEnddate(){
        return date(Yii::$app->params['DATE_FORMAT'], $this->Campaign_End->sec);
    }

    public function getCoupon(){
        return $this->hasOne(Coupon::className(),['_id' => 'Coupon_Id']);
        //return 'Hello';
    }
    public function getColor(){
        return '<div style="background-color: '.$this->Hex_Color.';width:30px;height:30px;margin:0 auto; "></div>';
        //return 'Hello';
    }

}
