<?php

namespace backend\models;

use Yii;
use backend\models\Dmitem;
use backend\models\Dmcity;
use yii\helpers\Html;
use yii\helpers\Url;


/**
 * This is the model class for table "DM_POS".
 *
 * @property string $ID
 * @property integer $ACTIVE
 * @property string $DEVICE_ID
 * @property string $POS_NAME
 * @property double $POS_LONGITUDE
 * @property double $POS_LATITUDE
 * @property string $POS_PARENT
 * @property integer $DISTRICT_ID
 * @property integer $CITY_ID
 * @property string $POS_ADDRESS
 * @property string $DESCRIPTION
 * @property string $OPEN_TIME
 * @property string $PHONE_NUMBER
 * @property string $ESTIMATE_PRICE_MAX
 * @property string $ESTIMATE_PRICE
 * @property string $WIFI_PASSWORD
 * @property integer $IS_CAR_PARKING
 * @property integer $IS_VISA
 * @property integer $IS_STICKY
 * @property string $IMAGE_PATH
 * @property string $IMAGE_PATH_THUMB
 * @property integer $SORT
 * @property string $WIFI_SERVICE_PATH
 * @property string $LAST_READY
 * @property integer $IS_ORDER
 * @property string $MORE_INFO
 * @property string $WEBSITE_URL
 * @property double $POS_RADIUS_DETAL
 * @property integer $IS_ORDER_ONLINE
 * @property double $SHIP_PRICE
 * @property integer $WORKSTATION_ID
 * @property string $WS_ORDER_ONLINE
 * @property string $MIN_ORDER_PRICE
 * @property integer $IS_HOT
 * @property integer $POS_MASTER_ID
 * @property integer $IS_ACTIVE_SHAREFB_EVENT
 * @property integer $SHAREFB_EVENT_RATE
 * @property integer $IS_SHOW_ITEM_TYPE
 * @property integer $IS_AHAMOVE_ACTIVE
 * @property integer $IS_POS_MOBILE
 * @property integer $TIME_START
 * @property integer $TIME_END
 * @property integer $TIME_START_FB
 * @property integer $TIME_END_FB
 * @property integer $LOCALE_ID
 * @property integer $DELIVERY_SERVICES
 * @property integer $DECIMAL_NUMBER
 * @property integer $VAT_TAX_RATE
 */
class Dmpos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DM_POS';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ACTIVE', 'DISTRICT_ID', 'CITY_ID', 'ESTIMATE_PRICE_MAX', 'ESTIMATE_PRICE', 'IS_CAR_PARKING', 'IS_VISA', 'IS_STICKY', 'SORT', 'IS_ORDER', 'IS_ORDER_ONLINE', 'WORKSTATION_ID', 'MIN_ORDER_PRICE', 'IS_HOT', 'POS_MASTER_ID', 'IS_ACTIVE_SHAREFB_EVENT', 'SHAREFB_EVENT_RATE', 'IS_SHOW_ITEM_TYPE', 'IS_AHAMOVE_ACTIVE'], 'integer'],
            [['POS_LONGITUDE', 'POS_LATITUDE', 'POS_RADIUS_DETAL', 'SHIP_PRICE'], 'number'],
            [['DESCRIPTION', 'MORE_INFO'], 'string'],
            [['IS_ORDER_LATER','CREATED_AT','LOCALE_ID','DELIVERY_SERVICES','DECIMAL_NUMBER','CURRENCY','DECIMAL_MONEY'], 'safe'],
            [['LAST_READY','VAT_TAX_RATE'], 'safe'],
            [['IS_BOOKING','IS_CALL_CENTER','IS_POS_MOBILE','TIME_END','TIME_START','TIME_START_FB','TIME_END_FB'], 'safe'],
            [['SHAREFB_EVENT_RATE'], 'required'],
            [['DEVICE_ID', 'POS_NAME', 'POS_ADDRESS', 'WIFI_SERVICE_PATH', 'WEBSITE_URL'], 'string', 'max' => 200],
            [['POS_PARENT', 'OPEN_TIME', 'WS_ORDER_ONLINE'], 'string', 'max' => 100],
            [['PHONE_NUMBER','PHONE_MANAGER'], 'string', 'max' => 15],
            [['WIFI_PASSWORD'], 'string', 'max' => 50],
            [['IMAGE_PATH', 'IMAGE_PATH_THUMB'], 'string', 'max' => 500],
            [['MOMO_PUBLIC_KEY', 'MOMO_PUBLIC_KEY_PM'], 'string'],
            [['MOMO_MERCHANT_ID', 'MOCA_MERCHANT_ID'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'ACTIVE' => 'Trạng thái',
            'DEVICE_ID' => 'Device  ID',
            'POS_NAME' => 'Tên Nhà hàng',
            'POS_LONGITUDE' => 'Kinh độ',
            'POS_LATITUDE' => 'Vĩ độ',
            'POS_PARENT' => 'Thương hiệu',
            'DISTRICT_ID' => 'Quận / Huyện',
            'CITY_ID' => 'Thành phố / Tỉnh',
            'POS_ADDRESS' => 'Địa chỉ',
            'DESCRIPTION' => 'Mô tả',
            'OPEN_TIME' => 'Giờ mở cửa',
            'PHONE_NUMBER' => 'Số điện thoại',
            'ESTIMATE_PRICE_MAX' => 'Estimate  Price  Max',
            'ESTIMATE_PRICE' => 'Estimate  Price',
            'WIFI_PASSWORD' => 'Wifi  Password',
            'IS_CAR_PARKING' => 'Có chỗ để ô tô',
            'IS_VISA' => 'Visa',
            'IS_STICKY' => 'Sticky',
            'IMAGE_PATH' => 'Image',
            'IMAGE_PATH_THUMB' => 'Thumb',
            'SORT' => 'Sort',
            'WIFI_SERVICE_PATH' => 'Wifi  Service  Path',
            'LAST_READY' => 'Lần cuối đồng bộ',
            'IS_ORDER' => 'Is  Order',
            'MORE_INFO' => 'More  Info',
            'WEBSITE_URL' => 'Website  Url',
            'POS_RADIUS_DETAL' => 'Pos  Radius  Detal',
            'IS_ORDER_ONLINE' => 'Gọi đồ Online',
            'SHIP_PRICE' => 'Ship Price',
            'WORKSTATION_ID' => 'Workstation  ID',
            'WS_ORDER_ONLINE' => 'Ws  Order  Online',
            'MIN_ORDER_PRICE' => 'Min  Order  Price',
            'IS_HOT' => 'Hot',
            'POS_MASTER_ID' => 'Pos  Master',
            'IS_ACTIVE_SHAREFB_EVENT' => 'Is  Active  Sharefb  Event',
            'SHAREFB_EVENT_RATE' => 'Sharefb  Event  Rate',
            'IS_SHOW_ITEM_TYPE' => 'Is  Show  Item  Type',
            'IS_AHAMOVE_ACTIVE' => 'Is  Ahamove  Active',
            'IS_BOOKING' => 'Đặt bàn',
            'PHONE_MANAGER' => 'PhoneMN',
            'IS_ORDER_LATER' => 'Is Order Later',
            'IS_CALL_CENTER' => 'Qua tổng đài',
            'IS_POS_MOBILE' => 'Loại POS',

            'MOMO_MERCHANT_ID' => 'Momo  Merchant  ID',
            'MOMO_PUBLIC_KEY' => 'Momo  Public  Key',
            'MOMO_PUBLIC_KEY_PM' => 'Momo  Public  Key  Pm',
            'MOCA_MERCHANT_ID' => 'Moca  Merchant  ID',
            'TIME_START' => 'Ngày POS bắt đầu',
            'TIME_START_FB' => 'Ngày bắt đầu FB',
            'TIME_END' => 'Ngày POS hết hạn',
            'TIME_END_FB' => 'Ngày hết hạn FB',
            'CREATED_AT' => 'Ngày tạo',
            'LOCALE_ID' => 'Mã vùng',
            'DELIVERY_SERVICES' => 'Giao hàng',
            'VAT_TAX_RATE' => 'Vat Tax Rate',
        ];
    }

public function getActivedLabel($value)
{
    return $this->$value ? 'Active' : 'Deactive';
}

public function getWifi()
{
    $button =  Html::a('Ảnh wifi','index.php?r=wmitemimagelist&id='.$this->ID,[
        'class' => 'btn btn-primary'
    ]);
    return $button;
}

public function getSlidewifi()
{
    $button =  Html::a('Ảnh slide', 'index.php?r=wmslideimagelist&id='.$this->ID,
        [
            'class' => 'btn btn-primary'
        ]
    );
    return $button;
}
    public function getListitem()
    {
        $button =  Html::a('Danh sách món ăn', 'index.php?r=dmpositem/view&id='.$this->ID,
            [
                'class' => 'btn btn-success'
            ]
        );
        return $button;
    }


    public function getActivedLabelGirdView()
    {
        if($this->ACTIVE == 0){
            return 'Deactive';
        }else if($this->ACTIVE == 1){
            return 'Active';
        }else{
            return 'Active Pos Mobile';
        }
    }
    public function getStatusMonitor()
    {
        if($this->ACTIVE == 0){
            return 'Deactive';
        }else if($this->ACTIVE == 2){
            return 'Active';
        }else{
            return 'Active Pos Mobile';
        }
    }
    public function getStatusMonitorFb()
    {
        if($this->ACTIVE == 0){
            return 'Deactive';
        }else if($this->ACTIVE == 1){
            return 'Active';
        }else{
            return 'Active Pos Mobile';
        }
    }

    public function getActivevalueFilter($searchModel,$attribute_name){
            return Html::activeDropDownList($searchModel,$attribute_name, [0=> 'Deactive', 1=> 'Active'],['class'=>'form-control','prompt' => 'Select Status']);
    }

    public function getImageUrl(){
        //return Url::to($this->IMAGE_PATH_THUMB, true);
        //return Html::img($this->IMAGE_PATH_THUMB);
        //return $this->IMAGE_PATH_THUMB;
        //return $this->IMAGE_PATH_THUMB;
    }


    public function getItem()
    {
        return $this->hasMany(Dmitem::className(), ['ITEM_ID' => 'ID']);
    }

    public function getCity()
    {
        return $this->hasOne(Dmcity::className(), ['ID' => 'CITY_ID']);
    }


    public function getPartner()
    {
        return $this->hasOne(Dmposparent::className(), ['ID' => 'POS_PARENT']);
    }
    public function getDistrict()
    {
        return $this->hasOne(Dmdistrict::className(), ['ID' => 'DISTRICT_ID']);
    }

    public function getLastReady()
    {
        if($this->LAST_READY){
            $tmpTime = $this->LAST_READY;
            //return $time;
            $nowTime = date("Y-m-d H:i:s");
            $secs = strtotime($nowTime) - strtotime($tmpTime);
            $days = number_format($secs / 86400);
            $now = new \DateTime(date("Y-m-d H:i:s"));
            $ref = new \DateTime($tmpTime);
            $diff = $now->diff($ref);
            //printf('%d days, %d hours, %d minutes', $diff->d, $diff->h, $diff->i);
            //echo $secs;
            //$day = number_format($secs / (60*60*60));
            //$day = ($secs / (60*60*60));
//            echo '<pre>';
//            var_dump($secs);
//            var_dump($day);
//            echo '</pre>';
//            die();

            if($days >= 7){
                return '
                    <div class="time-info-danger">
                        <b>
                            <span>'.$this->LAST_READY.'('.$days.' ngày)</span>
                        </b>
                    </div>
                ';
            }else {
                return '
                    <div class="time-info-first">
                        <b>
                            <span>'.$this->LAST_READY.'('.$days.' ngày)</span>
                        </b>
                    </div>
                ';
            }
        }else{
            return NULL;
        }


    }

    public function getEndTimeFb()
    {

        if($this->TIME_END_FB){
            $tmpTime = $this->TIME_END_FB;
            $nowTime = date("Y-m-d H:i:s");
            $secs = strtotime($tmpTime) - strtotime($nowTime);
            $day = number_format(($secs / 86400) +1) ;
            $date = date( Yii::$app->params['DATE_FORMAT'],strtotime($this->TIME_END_FB));

            if($day > 60){
                return '
                    <div class="time-info-first">
                        <b>
                            <span>'.$date.'<br>('.$day.' ngày)</span>
                        </b>
                    </div>
                ';
            }elseif( $day > 7 && $day <= 60) {
                return '
                    <div class="time-info-info">
                        <b>
                            <span>'.$date.'<br>('.$day.' ngày)</span>
                        </b>
                    </div>
                ';
            }elseif( $day >= 0 && $day <= 7) {
                return '
                    <div class="time-info-wanning">
                        <b>
                            <span>'.$date.'<br>('.$day.' ngày)</span>
                        </b>
                    </div>
                ';
            }else {
                return '
                    <div class="time-info-danger">
                        <b>
                            <span>'.$date.'<br>('.$day.' ngày)</span>
                        </b>
                    </div>
                ';
            }
        }else{
            return NULL;
        }


    }

    public function getEndTime()
    {
        if($this->TIME_END){
            $tmpTime = $this->TIME_END;
            //return $time;
            $nowTime = date("Y-m-d H:i:s");
            $secs = strtotime($tmpTime) - strtotime($nowTime);
            $day = number_format(($secs / 86400)  + 1);

//            $now = new \DateTime(date("Y-m-d H:i:s"));
//            $ref = new \DateTime($tmpTime);
//            $diff = $now->diff($ref);

            $date = date( Yii::$app->params['DATE_FORMAT'],strtotime($this->TIME_END));

            if($day > 60){
                return '
                    <div class="time-info-first">
                        <b>
                            <span>'.$date.'<br>('.$day.' ngày)</span>
                        </b>
                    </div>
                ';
            }elseif( $day >= 7 && $day <= 60) {
                return '
                    <div class="time-info-info">
                        <b>
                            <span>'.$date.'<br>('.$day.' ngày)</span>
                        </b>
                    </div>
                ';
            }elseif( $day >= 0 && $day <= 7) {
                return '
                    <div class="time-info-wanning">
                        <b>
                            <span>'.$date.'<br>('.$day.' ngày)</span>
                        </b>
                    </div>
                ';
            }else {
                return '
                    <div class="time-info-danger">
                        <b>
                            <span>'.$date.'<br>('.$day.' ngày)</span>
                        </b>
                    </div>
                ';
            }
        }else{
            return NULL;
        }


    }

}
