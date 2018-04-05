<?php

namespace backend\models;

use Yii;
use backend\models\Dmpos;
use yii\debug\models\search\Db;

/**
 * This is the model class for table "DM_ITEM".
 *
 * @property string $ID
 * @property string $POS_ID
 * @property string $ITEM_ID
 * @property string $ITEM_TYPE_ID
 * @property string $ITEM_NAME
 * @property integer $ITEM_MASTER_ID
 * @property integer $ITEM_TYPE_MASTER_ID
 * @property string $ITEM_IMAGE_PATH_THUMB
 * @property string $ITEM_IMAGE_PATH
 * @property string $DESCRIPTION
 * @property double $OTS_PRICE
 * @property double $TA_PRICE
 * @property double $POINT
 * @property integer $IS_GIFT
 * @property integer $SHOW_ON_WEB
 * @property integer $SHOW_PRICE_ON_WEB
 * @property integer $ACTIVE
 * @property integer $SPECIAL_TYPE
 * @property string $LAST_UPDATED
 * @property string $FB_IMAGE_PATH
 * @property string $FB_IMAGE_PATH_THUMB
 * @property integer $ALLOW_TAKE_AWAY
 * @property integer $IS_EAT_WITH
 * @property integer $REQUIRE_EAT_WITH
 * @property string $ITEM_ID_EAT_WITH
 * @property integer $IS_FEATURED
 * @property integer $LIST_SUB_ITEM
 * @property integer $IS_PARENT
 */
class Dmitem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DM_ITEM';
    }
    public $LIST_SUB_ITEM;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['POS_ID', 'ITEM_MASTER_ID', 'ITEM_TYPE_MASTER_ID', 'IS_GIFT', 'SHOW_ON_WEB', 'SHOW_PRICE_ON_WEB', 'ACTIVE', 'SPECIAL_TYPE', 'ALLOW_TAKE_AWAY', 'IS_EAT_WITH', 'REQUIRE_EAT_WITH', 'IS_FEATURED','SORT'], 'integer'],
            [['ITEM_NAME','SORT','ITEM_ID'], 'required'],
            [['DESCRIPTION'], 'string'],
            [['OTS_PRICE', 'TA_PRICE', 'POINT', 'IS_PARENT'], 'number'],
            [['LAST_UPDATED','LIST_SUB_ITEM','ITEM_TYPE_ID'], 'safe'],
            [['IS_FEATURED','TIME_SALE_DATE_WEEK','TIME_SALE_HOUR_DAY','DESCRIPTION_FB'], 'safe'],
            [['ITEM_ID'], 'string', 'max' => 50],
            [['ITEM_NAME'], 'string', 'max' => 200],
            //[['ITEM_IMAGE_PATH_THUMB', 'ITEM_IMAGE_PATH', 'FB_IMAGE_PATH', 'FB_IMAGE_PATH_THUMB'], 'safe'],
            [['ITEM_IMAGE_PATH_THUMB', 'ITEM_IMAGE_PATH', 'FB_IMAGE_PATH', 'FB_IMAGE_PATH_THUMB'], 'string', 'max' => 500],
            //[['ITEM_ID_EAT_WITH'], 'string', 'max' => 100],
            [['ITEM_ID_EAT_WITH'], 'safe'],
            [['POS_ID', 'ITEM_ID'], 'unique', 'targetAttribute' => ['POS_ID', 'ITEM_ID'], 'message' => 'The combination of Pos  ID and Item  ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'Mã món',
            'POS_ID' => 'Nhà hàng',
            'ITEM_ID' => 'Mã món',
            'ITEM_TYPE_ID' => 'Loại món',
            'ITEM_NAME' => 'Tên món',
            'ITEM_MASTER_ID' => 'Item  Master  ID',
            'ITEM_TYPE_MASTER_ID' => 'Item  Type  Master  ID',
            'ITEM_IMAGE_PATH_THUMB' => 'Ảnh thu nhỏ',
            'ITEM_IMAGE_PATH' => 'Item  Image  Path',
            'OTS_PRICE' => 'Giá tại chỗ',
            'TA_PRICE' => 'Giá mang về',
            'POINT' => 'Point',
            'IS_GIFT' => 'Tích điểm đổi quà',
            'SHOW_ON_WEB' => 'Show  On  Web',
            'SHOW_PRICE_ON_WEB' => 'Show  Price  On  Web',
            'ACTIVE' => 'Trạng thái',
            'SPECIAL_TYPE' => 'Special  Type',
            'LAST_UPDATED' => 'Last  Updated',
            'FB_IMAGE_PATH' => 'Fb  Image  Path',
            'FB_IMAGE_PATH_THUMB' => 'Fb  Image  Path  Thumb',
            'ALLOW_TAKE_AWAY' => 'Allow  Take  Away',
            'IS_EAT_WITH' => 'Món ăn kèm',
            'REQUIRE_EAT_WITH' => 'Require  Eat  With',
            'ITEM_ID_EAT_WITH' => 'Các món ăn kèm',
            'IS_FEATURED' => 'Bán qua kênh phân phối',
            'TIME_SALE_DATE_WEEK' => 'Ngày mở cửa',
            'TIME_SALE_HOUR_DAY' => 'Giờ mở cửa',
            'DESCRIPTION_FB' => 'FB Mô tả',
            'DESCRIPTION' => 'Mô tả',
            'SORT' => 'Thứ tự',
            'LIST_SUB_ITEM' => 'Danh sách món con',
            'IS_PARENT' => 'Món cha',
        ];
    }

    public function getPos()
    {
        return $this->hasOne(Dmpos::className(), ['ID' => 'POS_ID']);
    }
    public function getItemtypemaster()
    {
        return $this->hasOne(Dmitemtypemaster::className(), ['ID' => 'ITEM_TYPE_MASTER_ID']);
    }
    public function getItemtype()
    {
        return $this->hasOne(Dmitemtype::className(), ['ITEM_TYPE_ID' => 'ITEM_TYPE_ID','POS_ID' => 'POS_ID']);
    }

    public function getItemeatwith()
    {
        //return strtok(wordwrap($this->ITEM_ID_EAT_WITH, 3, "...\n"), "\n");
        return mb_strimwidth($this->ITEM_ID_EAT_WITH, 0, 20, "...");
        //return $this->hasOne(Dmitemtype::className(), ['ITEM_TYPE_ID' => 'ITEM_TYPE_ID']);
    }
}
