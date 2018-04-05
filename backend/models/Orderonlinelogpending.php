<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for collection "ORDER_ONLINE_LOG_PENDING".
 *
 * @property \MongoId|string $_id
 */
class Orderonlinelogpending extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return ['IPOS', 'ORDER_ONLINE_LOG_PENDING'];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'foodbook_code',
            'coupon_log_id',
            'ship_price_real',
            'pos_id',
            'order_data_item',
            'pos_workstation',
            'user_id',
            'duration',
            'user_phone',
            'isFromFoodbook',
            'to_address',
            'address_id',
            'username',
            'status',
            'ahamove_code',
            'supplier_id',
            'supplier_name',
            'shared_link',
            'distance',
            'total_fee',
            'note',
            'payment_method',
            'payment_info',
            'created_at',
            'update_at',
            'isCallCenterConfirmed',
            'isCallCheckAhamove',
            'isCallCenterConfirmWithPos',
            'time_confirmed',
            'time_assigning',
            'time_accepted',
            'time_inprocess',
            'time_completed',
            'time_cancelled',
            'time_failed',
            'booking_info',
            'paymentInfo',
            'longitude',
            'latitude',
            'voucher',
            'amount',
            'created_by',
            'orders_purpose',
            'manager_id',
            'province',
            'district',
            'pos_parent',
            'is_pending',
            'user_status',
            'voucher_code'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['foodbook_code', 'coupon_log_id', 'order_data_item', 'pos_workstation', 'user_id', 'duration', 'user_phone', 'isFromFoodbook', 'to_address', 'address_id', 'username', 'status', 'ahamove_code', 'supplier_id', 'supplier_name', 'shared_link', 'distance', 'total_fee', 'note', 'payment_method', 'payment_info', 'created_at', 'update_at','isCallCenterConfirmed','isCallCheckAhamove','isCallCenterConfirmWithPos','booking_info','ship_price_real','created_by','pos_parent'], 'safe'],
            [['time_confirmed','time_assigning','time_accepted','time_inprocess','time_completed','time_cancelled','time_failed','paymentInfo','longitude','latitude','voucher','amount','orders_purpose','province','district','manager_id','is_pending','user_status','voucher_code'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'foodbook_code' => 'Mã FB',
            'coupon_log_id' => 'Mã coupon ',
            'voucher_code' => 'Mã coupon ',
            'pos_id' => 'Nhà hàng',
            'order_data_item' => 'Danh sách món gọi',
            'pos_workstation' => 'Pos Workstation',
            'user_id' => 'Khách hàng',
            'duration' => 'Duration',
            'user_phone' => 'SĐT khách',
            'isFromFoodbook' => 'Đơn hàng từ Foodbook',
            'to_address' => 'Địa chỉ giao hàng',
            'address_id' => 'Address ID',
            'username' => 'Tên khách hàng',
            'status' => 'Trạng thái đơn hàng',
            'ahamove_code' => 'Mã AHA',
            'supplier_id' => 'Số điện thoại tài xế',
            'supplier_name' => 'Tên tài xế',
            'shared_link' => 'Link theo dõi đơn hàng',
            'distance' => 'Khoảng cách',
            'total_fee' => 'Phí vận chuyển',
            'note' => 'Ghi chú',
            'payment_method' => 'Phương thức thanh toán',
            'payment_info' => 'Payment Info',
            'created_at' => 'Thời điểm gọi',
            'update_at' => 'Thời điểm cập nhật',
            'isCallCenterConfirmed' => 'Checked Order',
            'isCallCheckAhamove' => 'Tổng đài checked Ahamove',
            'isCallCenterConfirmWithPos' => 'TĐ - Pos',
            'time_assigning' => 'Thời điểm tìm xế',
            'time_accepted' => 'Thời điểm xế nhận',
            'time_confirmed' => 'Thời điểm xác nhận',
            'time_inprocess' => 'Thời điểm giao hàng',
            'time_completed' => 'Thời điểm hoàn thành',
            'time_cancelled' => 'Thời điểm hủy',
            'time_failed' => 'Thời điểm khách không nhận',
            'paymentInfo' => 'Thanh toán',
            'longitude' => 'Long',
            'latitude' => 'Lat',
            'ship_price_real' => 'Phí vận chuyển',
            'booking_info' => 'Thông tin đơn hàng',
            'voucher' => 'Chiết khấu',
            'amount' => 'Tổng tiền',
            'orders_purpose' => 'Mục đích',
            'province' => 'Tỉnh / thành phố',
            'district' => 'Quận / huyện',
            'manager_id' => 'Người tạo đơn',
            'created_by' => 'Nguồn tạo',
            'pos_parent' => 'Thương hiệu',
            'is_pending' => 'Pending',
            'user_status' => 'Tên tạm thời',
        ];
    }

    public function getChangeUpdateTime()
    {

        //\Yii::$app->cache->delete('ALL_POS_MAP');
        $usename = \Yii::$app->session->get('username');
        $key = 'ALL_POS_MAP'.$usename;
        $allPosMap = \Yii::$app->cache->get($key);
        if ($allPosMap === false) {
            $searchPosModel = new DmposSearch();
            $allPos = $searchPosModel->searchAllPos();
            $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');
            \Yii::$app->cache->set($key, $allPosMap, 42000); // time in seconds to store cache
        }

        $posName = @$allPosMap[$this->pos_id];
        $tmpTime = $this->update_at;
        $time = date(Yii::$app->params['DATE_TIME_FORMAT_2'],$tmpTime->sec);
        $timeToday = date(Yii::$app->params['DATE_TIME_FORMAT_2'],$tmpTime->sec);
        $startTime = date("M,d,Y,H:i:s",$tmpTime->sec);


        $createDate = date(Yii::$app->params['DATE_FORMAT'],$this->created_at->sec);
        $createTime = date('H:i:s',$this->created_at->sec);
        //return $time;
        $nowTime = date(Yii::$app->params['DATE_TIME_FORMAT_2']);
        $secs = strtotime($nowTime) - strtotime($time);
        if($secs){
            $min = $secs/60;
            $hours = floor($secs / 3600);
            $minutes = floor(($secs / 60) % 60);
            $seconds = $secs % 60;

            if($hours<10){
                $hours = '0' . $hours;
            }
            if($minutes<10){
                $minutes = '0' . $minutes;
            }
            if($seconds<10){
                $seconds = '0' . $seconds;
            }
            /* Phần hiển thị cũ có thời gian đầy đủ và đếm thời gian
             * <b>
                            <span id="hoursUpdate'.$this->_id.'">'.$hours.'</span><span>:</span>
                            <span id="minutesUpdate'.$this->_id.'">'.$minutes.'</span><span>:</span>
                            <span id="secondsUpdate'.$this->_id.'">'.$seconds.'</span>
                        </b>*/

            if($min >=3){
                return '
                    <div class="time-info-danger">
                        <b>'.$createTime.'</b>
                        <br>
                        <b>'.$createDate.'</b>
                        <br>
                        <b>
                            <span>'.number_format($min).' phút</span>
                        </b>
                    </div>
                </div>';

            }else if($min >=1 && $min <3) {
                return '
                    <div class="time-info-wanning">
                    <b>'.$createTime.'</b>
                    <br>
                    <b>'.$createDate.'</b>
                    <br>
                    <b>
                            <span>'.number_format($min).' phút</span>
                    </b>
                </div>';


            }else{
                return '
                        <div class="time-info-first">
                        <b>'.$createTime.'</b>
                        <br>
                        <b>'.$createDate.'</b>
                        <br>
                        <b>
                            <span>'.number_format($min).' phút</span>
                        </b>
                    </div>';
            }
        }

    }





    public function getBookinginfo()
    {
        if(@$this->booking_info['Hour']){
            $hour = @$this->booking_info['Hour'];
            $minute = @$this->booking_info['Minute'];

            if($hour < 10){
                $hour = '0'.@$this->booking_info['Hour'];
            }
            if($minute < 10){
                $minute = '0'.@$this->booking_info['Minute'];
            }

            return 'Giao sau' .'<br>'. date(Yii::$app->params['DATE_FORMAT'], @$this->booking_info['Book_Date']->sec).'<br> '. $hour.':'.$minute.':00';
        }else{
            return 'Giao ngay';
        }
    }

    public function getMemberinfo(){
        return $this->user_id.'<br>'.$this->username;
    }


    public function getActions(){

        $buttonPro =  Html::a('Xử lý', 'index.php?r=orderonlinelogpending/update&id='.$this->_id,
            [
                'class' => 'btn btn-primary btn-status-action btn_orderonlinelog_action',
                'target'=>'_blank','data-pjax'=>"0"
            ]
        );

        $buttonCancel =  Html::a('Hủy', 'index.php?r=orderonlinelogpending/deactive&id='.$this->_id,
            [
                'data' => [
                    'confirm' => 'Bạn có chắc chắn muốn hủy ?',
                ],
                'class' => 'btn btn-danger btn-status-action btn_orderonlinelog_action',
            ]
        );
        return $buttonPro.' '.$buttonCancel;

    }

}
