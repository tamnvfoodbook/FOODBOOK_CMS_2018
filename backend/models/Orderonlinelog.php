<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


/**
 * This is the model class for collection "ORDER_ONLINE_LOG".
 *
 * @property \MongoId|string $_id
 * @property mixed $foodbook_code
 * @property mixed $coupon_log_id
 * @property mixed $pos_id
 * @property mixed $order_data_item
 * @property mixed $pos_workstation
 * @property mixed $user_id
 * @property mixed $duration
 * @property mixed $user_phone
 * @property mixed $isFromFoodbook
 * @property mixed $to_address
 * @property mixed $address_id
 * @property mixed $username
 * @property mixed $status
 * @property mixed $ahamove_code
 * @property mixed $supplier_id
 * @property mixed $supplier_name
 * @property mixed $shared_link
 * @property mixed $distance
 * @property mixed $total_fee
 * @property mixed $note
 * @property mixed $payment_method
 * @property mixed $payment_info
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $time_assigning
 * @property mixed $time_confirmed
 * @property mixed $time_accepted
 * @property mixed $time_inprocess
 * @property mixed $time_completed
 * @property mixed $time_cancelled
 * @property mixed $time_failed
 * @property mixed $booking_info
 * @property mixed $longitude
 * @property mixed $latitude
 * @property mixed $ship_price_real
 * @property mixed $voucher
 * @property mixed $created_by
 * @property mixed $orders_purpose
 * @property mixed $pos_parent
 * @property mixed $DISCOUNT_BILL
 * @property mixed $DISCOUNT_BILL_TYPE
 * @property mixed $discount_items
 * @property mixed $amount_total_item
 * @property mixed $amount_driver_pay_mechant
 * @property mixed $amount_partner_commission
 * @property mixed $amount_partner_pay_merchant

 */
class Orderonlinelog extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public  $DISCOUNT_BILL;
    public  $DISCOUNT_BILL_TYPE;
    public  $discount_items;

    public static function collectionName()
    {
        return [Yii::$app->params['COLLECTION'], 'ORDER_ONLINE_LOG'];
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
            'updated_at',
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
            'delivery_partner_info',
            'discount_extra',
            'discount_extra_amount',
            'service_charge',
            'vat_tax_rate',
            'total_amount',
            'discount_items',
            'amount_total_item',
            'amount_driver_pay_mechant',
            'amount_partner_commission',
            'amount_partner_pay_merchant'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['foodbook_code', 'coupon_log_id', 'order_data_item', 'pos_workstation', 'user_id', 'duration',
                'user_phone', 'isFromFoodbook', 'to_address', 'address_id', 'username', 'status', 'ahamove_code',
                'supplier_id', 'supplier_name', 'shared_link', 'distance', 'total_fee', 'note', 'payment_method',
                'payment_info', 'created_at', 'updated_at','isCallCenterConfirmed','isCallCheckAhamove','isCallCenterConfirmWithPos',
                'booking_info','ship_price_real','created_by','pos_parent','discount_extra','discount_extra_amount','service_charge'
                ,'vat_tax_rate','total_amount','discount_items','amount_total_item','amount_driver_pay_mechant','amount_partner_commission','amount_partner_pay_merchant'
            ], 'safe'],

            [['time_confirmed','time_assigning','time_accepted','time_inprocess','time_completed','time_cancelled','time_failed','paymentInfo','longitude','latitude','voucher','amount','orders_purpose','province','district','manager_id','delivery_partner_info'], 'safe'],
            [['pos_id'], 'required'],

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
            'pos_id' => 'Nhà hàng',
            'order_data_item' => 'Danh sách món gọi',
            'pos_workstation' => 'Pos Workstation',
            'user_id' => 'Khách hàng',
            'duration' => 'Duration',
            'user_phone' => 'SĐT khách',
            'isFromFoodbook' => 'Đơn hàng từ Foodbook',
            'to_address' => 'Địa chỉ',
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
            'updated_at' => 'Thời điểm cập nhật',
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
            'voucher' => 'Giảm giá Voucher',
            'amount' => 'Tổng tiền',
            'orders_purpose' => 'Mục đích',
            'province' => 'Tỉnh / thành phố',
            'district' => 'Quận / huyện',
            'manager_id' => 'Người tạo đơn',
            'created_by' => 'Nguồn tạo',
            'pos_parent'=> 'Thương hiệu',
            'delivery_partner_info'=> 'Giao vận',
            'total_amount'=> 'Tổng sau chiết khấu',
            'discount_items'=> 'Giảm giá món',
            'amount_total_item'=> 'Tổng tiền trên món',
            'amount_driver_pay_mechant'=> 'Tài xế đã trả NH',
            'amount_partner_commission'=> 'NH discount LALA',
            'amount_partner_pay_merchant'=> 'LALA còn trả NH',
        ];
    }

    public function getPos()
    {
        return $this->hasOne(Dmpos::className(), ['ID' => 'pos_id']);
    }

    public function getMemberaddresslist()
    {
        return $this->hasOne(Memberaddresslist::className(), ['_id' => 'address_id']);
    }

    public function getImgestatus(){
        switch ($this->status) {
            case 'COMPLETED':
                return '<image src="images/CANCEL_IC.png"></image>';
                break;
            case 'CANCELLED':
                return $this->status;
                break;
            case 'FAILED':
                return $this->status;
                break;
            case 'WAIT_CONFIRM':
                return '<image src="images/WAIT_CONFIRM_IC.png"></image>';
                break;
            case 'ASSIGNING':
                return '<image src="images/ASSIGNING_IC.png"></image>';
                break;
            case 'ACCEPTED':
                return '<image src="images/ACCEPTED_IC.png"></image>';
                break;
            case 'CONFIRMED':
                return '<image src="images/CONFIRMED_IC.png"></image>';
                break;
            case 'IN PROCESS':
                return '<image src="images/IN_PROCESS_IC.png"></image>';
                break;

            default:
                return $this->status;
                break;
        }
    }


    public  function getCreatTime(){
        $tmpTime = $this->created_at;
        return $time = date(Yii::$app->params['DATE_TIME_FORMAT_2'],$tmpTime->sec);
    }

    public function getMemberinfo(){
        return $this->user_id.'<br><b>'.$this->username.'</b><br/>'.$this->to_address.'<br/>'.$this->note;
    }

    /**
     * @param $time
     * @param $firstTime
     * @param $status
     * @return string
     */
    public static function countTime($time,$firstTime,$status){
        /**
         * @param $time
         * @param $firstTime
         * @param $status
         * @return string
         *
         * HÀM NÀY DÙNG CHUNG CHO VIỆC SHOW TRẠNG THÁI của 2 Model là ORderonlinelog và Bookingonlinelog đối với bên Order onlinelog trạng thái update cùng với created, vậy nên kiểm tra neus bằng nhau thì dùng time hiện tại,
         */

        $creatTime = date(Yii::$app->params['DATE_TIME_FORMAT_2'],$firstTime->sec);
        if($time){
            $secondTime = date(Yii::$app->params['DATE_TIME_FORMAT_2'],$time->sec);
        }else{
            $secondTime = date(Yii::$app->params['DATE_TIME_FORMAT_2']);
        }
        $secs = strtotime($secondTime) - strtotime($creatTime);
        if(!$secs){
            $secondTime = date(Yii::$app->params['DATE_TIME_FORMAT_2']);
            $secs = strtotime($secondTime) - strtotime($creatTime);
        }
        //if($secs){
        $min = $secs/60;
//        $hours = floor($secs / 3600);
//        $minutes = floor(($secs / 60) % 60);
//        $seconds = $secs % 60;
        //var_dump($firstTime .'-'.$secs.'-'.$min);
//        <span>'.gmdate("H:i:s", $secs).'</span>  // Phần
        if($min >=3){
            return '
                    <div>
                    <div class="time-info-danger">
                        <b>'.Yii::t('yii',$status).'</b><br>
                        <b>

                            <span>'.gmdate("H:i:s", $secs).'</span>
                        </b>
                    </div>
                </div>';
        }else if($min >=1 && $min <3) {
            return '
                    <div >
                    <div class="time-info-wanning">
                    <b>'.Yii::t('yii',$status).'</b><br>
                    <b>
                        <span>'.gmdate("H:i:s", $secs).'</span>
                    </b>
                </div>';
        }else{
            return '
                    <div>
                    <div class="time-info-first">
                    <b>'.Yii::t('yii',$status).'</b><br>
                    <b>
                        <span>'.gmdate("H:i:s", $secs).'</span>
                    </b>
                </div>';
        }
    }

    public function getChangeUpdateTimeWaitOrder($time,$firstTime,$status,$foodbookCode)
    {
        $tmpTime = $time;
        //$time = date(Yii::$app->params['DATE_TIME_FORMAT_2'],@$tmpTime->sec);
        $timeToday = date(Yii::$app->params['DATE_TIME_FORMAT_2'],@$tmpTime->sec);
        $startTime = date("M,d,Y,H:i:s",$firstTime->sec);

//        echo '<pre>';
//        var_dump($timeToday);
//        echo '</pre>';
//        die();

        $hours = 0;
        $minutes = 0;
        $seconds = 0;
        $content = '
            <div class="time-info-danger">
                <b>'.Yii::t('yii',$status).'</b><br>
                    <b>
                        <span id="hoursUpdate'.$foodbookCode.'">'.$hours.'</span><span>:</span>
                        <span id="minutesUpdate'.$foodbookCode.'">'.$minutes.'</span><span>:</span>
                        <span id="secondsUpdate'.$foodbookCode.'">'.$seconds.'</span>
                    </b>
            </div>
            <script>
                upDateTime("'.$foodbookCode.'","'.$startTime.'");
            </script>';
        ?>

        <script type="text/javascript">
            function upDateTime(foodbookCode,countTo) {
                now = new Date();
                countTo = new Date(countTo);
                difference = (now-countTo);
                hours=Math.floor((difference%(60*60*1000*24))/(60*60*1000)*1);
                mins=Math.floor(((difference%(60*60*1000*24))%(60*60*1000))/(60*1000)*1);
                secs=Math.floor((((difference%(60*60*1000*24))%(60*60*1000))%(60*1000))/1000*1);
                if(hours<10){
                    hours = '0' + hours;
                }
                if(mins<10){
                    mins = '0' + mins;
                }
                if(secs<10){
                    secs = '0' + secs;
                }

                var elemHour = document.getElementById('hoursUpdate'+foodbookCode).firstChild.nodeValue;
                if(typeof elemHour !== 'undefined' && elemHour !== null) {
                    document.getElementById('hoursUpdate'+foodbookCode).firstChild.nodeValue = hours;
                }

                document.getElementById('minutesUpdate'+foodbookCode).firstChild.nodeValue = mins;
                document.getElementById('secondsUpdate'+foodbookCode).firstChild.nodeValue = secs;

                clearTimeout(upDateTime+foodbookCode.to);
                upDateTime.to=setTimeout(function(){ upDateTime(foodbookCode,countTo); },1000);
            }
        </script>
        <?php
        //Check bookingonline
        /*  $searchBookingModel = new BookingonlinelogSearch();
          $checkNewBooking = $searchBookingModel->checkNewbooking();

          if($checkNewBooking){
              echo '<script type="text/javascript">play_sound(2);</script>';
          }*/
//        echo '<pre>';
//        var_dump()
//        echo '</pre>';

        //Check bookingonline


        //return $time;
        $nowTime = date(Yii::$app->params['DATE_TIME_FORMAT_2']);
        $secs = strtotime($nowTime) - strtotime($time);


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

//            echo '<pre>';
//            var_dump($hours);
//            echo '</pre>';
//            die();
        return $content;
    }

    public function getCountUpdateTime(){

//        echo '<pre>';
//        var_dump(date(Yii::$app->params['DATE_TIME_FORMAT_2'],$this->updated_at->sec));
//        echo '</pre>';
//        $timecounted =  Orderonlinelog::countTime($this->updated_at,$this->created_at,$this->status);
//        return $timecounted;
        $creatTime = date(Yii::$app->params['DATE_TIME_FORMAT_2'],$this->created_at->sec);
        $time = $this->updated_at;
        if($time){
            $secondTime = date(Yii::$app->params['DATE_TIME_FORMAT_2'],$time->sec);
        }else{
            $secondTime = date(Yii::$app->params['DATE_TIME_FORMAT_2']);
        }
        $secs = strtotime($secondTime) - strtotime($creatTime);

        if(!$secs){
            $secondTime = date(Yii::$app->params['DATE_TIME_FORMAT_2']);
            $secs = strtotime($secondTime) - strtotime($creatTime);
        }

        $min = $secs/60;


        switch ($this->status) {
            case 'CANCELLED':
                # code...
                $class = 'time-info-danger';
                break;
            case 'ACCEPTED':
                # code...
                $class = 'time-info-first';
                break;
            case 'CONFIRMED':
                # code...
                $class = 'time-info-first';
                break;
            case 'COMPLETED':
                # code...
                $class = 'time-info-first';
                break;
            case 'WAIT_CONFIRM':
                # code...
                $class = 'time-info-wanning';
                break;

            default:
                //var_dump($this->status);
                # code...
                $class = 'time-info-info';
                break;
        }

        return '
            <div>
            <div class="'.$class.'">
                <b>'.Yii::t('yii',$this->status).'</b><br>
                <b>
                    <span>'.number_format($min).' phút</span>
                </b>
            </div>
        </div>';


    }


    public function getChangeUpdateTime()
    {

        //\Yii::$app->cache->delete('ALL_POS_MAP');
        $usename = \Yii::$app->session->get('username');
        $key = 'ALL_POS_MAP'.$usename;
//        $allPosMap = \Yii::$app->cache->get($key);

        $searchPosModel = new DmposSearch();
        $allPos = $searchPosModel->searchAllPos();
        $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');

        /*if ($allPosMap === false) {
            $searchPosModel = new DmposSearch();
            $allPos = $searchPosModel->searchAllPos();
            $allPosMap = ArrayHelper::map($allPos,'ID','POS_NAME');
            \Yii::$app->cache->set($key, $allPosMap, 42000); // time in seconds to store cache
        }*/
        $posName = @$allPosMap[$this->pos_id];
        $tmpTime = $this->updated_at;
        $time = date(Yii::$app->params['DATE_TIME_FORMAT_2'],$tmpTime->sec);
        $timeToday = date(Yii::$app->params['DATE_TIME_FORMAT_2'],$tmpTime->sec);
        $startTime = date("M,d,Y,H:i:s",$tmpTime->sec);
        ?>
        <script type="text/javascript">
            //$(window).load(function(){ // Bỏ phần này đi thì số ko bị nhảy cóc nhưng lúc vào số nhảy hơi chậm
                //upDateTime<?php $this->_id?>('<?php $startTime ?>'); // ****** Change this line!
            //});

            function upDateTime(oderId,countTo) {
                now = new Date();
                countTo = new Date(countTo);
                difference = (now-countTo);

                hours=Math.floor((difference%(60*60*1000*24))/(60*60*1000)*1);
                mins=Math.floor(((difference%(60*60*1000*24))%(60*60*1000))/(60*1000)*1);
                secs=Math.floor((((difference%(60*60*1000*24))%(60*60*1000))%(60*1000))/1000*1);
                if(hours<10){
                    hours = '0' + hours;
                }
                if(mins<10){
                    mins = '0' + mins;
                }
                if(secs<10){
                    secs = '0' + secs;
                }

//                var elemHour = document.getElementById('hoursUpdate'+oderId).firstChild.nodeValue;
//                if(typeof elemHour !== 'undefined' && elemHour !== null) {
//                    document.getElementById('hoursUpdate'+oderId).firstChild.nodeValue = hours;
//                }
//                document.getElementById('minutesUpdate'+oderId).firstChild.nodeValue = mins;
//                document.getElementById('secondsUpdate'+oderId).firstChild.nodeValue = secs;
//
//                clearTimeout(upDateTime.to);
//                upDateTime.to=setTimeout(function(){ upDateTime(oderId,countTo); },1000);
            }

            function getCookie(cname) {
                var name = cname + "=";
                var ca = document.cookie.split(';');
                for(var i = 0; i < ca.length; i++) {
                    var c = ca[i];
                    while (c.charAt(0) == ' ') {
                        c = c.substring(1);
                    }
                    if (c.indexOf(name) == 0) {
                        return c.substring(name.length, c.length);
                    }
                }
                return "";
            }

            function play_sound(type,posName) {
                var str = getCookie("username");
                var checksoundOff = 1;
                if(str != ""){
                    var arrChecksound = str.split("_");
                    if(arrChecksound[1] == 0){
                        checksoundOff = 0;
                    }
                }

                if(checksoundOff == 1){
                    var audioElement = document.createElement('audio');
                    audioElement.setAttribute('src', '/music/sound_file'+ type +'.mp3');
                    audioElement.setAttribute('autoplay', 'autoplay');
                    audioElement.load();
                    audioElement.play();

                    // Show popup notify
                    document.addEventListener('DOMContentLoaded', function () {
                        if (Notification.permission !== "granted")
                            Notification.requestPermission();
                    });


                    if (!Notification) {
                        alert('Trình duyệt của bạn không cho phép đẩy thông báo, xin vui lòng thử lại.');
                        return;
                    }

                    if (Notification.permission !== "granted")
                        Notification.requestPermission();
                    else {
                        if(type == 1){
                            notification = new Notification('Đơn hàng mới từ Foodbook - Nhà hàng '+ posName , {
                                icon: 'http://image.foodbook.vn/images/fb/ic_lancher_158x158.png',
                                body: "Vừa có đơn hàng mới, Click tại đây để kiểm tra đơn hàng! "
                            });

                            notification.onclick = function () {
                                window.open("index.php?r=orderonlinelog");
                            };
                        }else if(type ==2){
                            notification = new Notification('Đặt bàn mới từ Foodbook - Nhà hàng '+ posName , {
                                icon: 'http://image.foodbook.vn/images/fb/ic_lancher_158x158.png',
                                body: "Vừa đặt bàn mới , Click tại đây để kiểm tra đặt bàn! "
                            });

                            notification.onclick = function () {
                                window.open("index.php?r=bookingonline");
                            };
                        }else{
                            notification = new Notification('Đơn hàng chờ từ Foodbook - Nhà hàng '+ posName , {
                                icon: 'http://image.foodbook.vn/images/fb/ic_lancher_158x158.png',
                                body: "Vừa có đơn hàng chờ, cick vào đây để kiểm tra đơn hàng! "
                            });

                            notification.onclick = function () {
                                window.open("index.php?r=orderonlinelogpending");
                            };
                        }

                    }
                    // End Show popup notify
                }
            }

        </script>

        <?php
        //Check bookingonline
        /*  $searchBookingModel = new BookingonlinelogSearch();
          $checkNewBooking = $searchBookingModel->checkNewbooking();

          if($checkNewBooking){
              echo '<script type="text/javascript">play_sound(2);</script>';
          }*/
//        echo '<pre>';
//        var_dump()
//        echo '</pre>';

        $searchPending = new OrderonlinelogpendingSearch();
        $checkNewPending = $searchPending->checkNewPending();


        if($checkNewPending){
            echo '<script type="text/javascript">play_sound(3,"'.$posName.'");</script>';
        }

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
                if($this->pos->IS_AHAMOVE_ACTIVE == 1 && $this->status == 'WAIT_CONFIRM'){
                    return '
                    <div class="time-info-danger">
                        <b>'.Yii::t('yii',$this->status).'</b><br>
                        <b>
                            <span>'.number_format($min).' phút</span>
                        </b>
                    </div>
                </div><script> upDateTime("'.$this->_id.'","'.$startTime.'");</script>';
                }else{
                    return '
                    <div class="time-info-danger">
                        <b>'.Yii::t('yii',$this->status).'</b><br>
                        <b>
                            <span>'.number_format($min).' phút</span>
                        </b>
                    </div>
                </div>';
                }

            }else if($min >=1 && $min <3) {
                if($this->pos->IS_AHAMOVE_ACTIVE == 1 && $this->status == 'WAIT_CONFIRM'){
                    return '
                    <div class="time-info-wanning">
                    <b>'.Yii::t('yii',$this->status).'</b><br>
                    <b>
                        <span>'.number_format($min).' phút</span>
                    </b>
                </div><script> upDateTime("'.$this->_id.'","'.$startTime.'");</script>';
                }else{
                    return '
                    <div class="time-info-wanning">
                    <b>'.Yii::t('yii',$this->status).'</b><br>
                    <b>
                            <span>'.number_format($min).' phút</span>
                    </b>
                </div>';
                }


            }else{
                if(($seconds >=0  && $seconds <6)&& ($this->status === 'WAIT_CONFIRM') ){
                    echo '<script type="text/javascript">play_sound(1,"'.$posName.'");</script>';
                }
                if($this->pos->IS_AHAMOVE_ACTIVE == 1 && $this->status == 'WAIT_CONFIRM'){
                    return '
                        <div class="time-info-first">
                        <b>'.Yii::t('yii',$this->status).'</b><br>
                        <b>
                            <span>'.number_format($min).' phút</span>
                        </b>
                    </div><script> upDateTime("'.$this->_id.'","'.$startTime.'");</script>';
                }else{
                    return '
                        <div class="time-info-first">
                        <b>'.Yii::t('yii',$this->status).'</b><br>
                        <b>
                            <span>'.number_format($min).' phút</span>
                        </b>
                    </div>';
                }


            }
        }

    }

    /*public function getCheckAddress(){
        $addressModel = new MemberaddresslistSearch();
        $adrees = $addressModel->searchModel($this->address_id);
        if(isset($adrees) && $adrees->latitude != 0 && $adrees->longitude != 0){
            return '<image src="images/icon-location-green.png"></image>';
        }else{
            return '<image src="images/icon-location-red.png"></image>';
        }

    }*/

    public function getIscallcenter()
    {
        $posModel = new DmposSearch();
        $adrees = $posModel->searchById($this->pos_id);
        return $adrees["IS_CALL_CENTER"] ? '<image src="images/icon_phone_green.png"></image>' : '<image src="images/icon_phone_red.png"></image>';
    }

    public function getPosphonenumber()
    {
        return Html::a($this->pos->PHONE_NUMBER,null,['id'=> 'target'] );
    }

    public function getBookinginfo()
    {
        /*echo '<pre>';
        var_dump($this->created_by);
        echo '</pre>';
        die();*/
        if(@$this->booking_info['hour']){
            $hour = @$this->booking_info['hour'];
            $minute = @$this->booking_info['minute'];

            if($hour < 10){
                $hour = '0'.@$this->booking_info['hour'];
            }
            if($minute < 10){
                $minute = '0'.@$this->booking_info['minute'];
            }

            return 'Giao sau' .'<br>'. date(Yii::$app->params['DATE_FORMAT'], @$this->booking_info['book_date']->sec).'<br> '. $hour.':'.$minute.':00'.
            '<br/> Nguồn: '.$this->created_by;
        }else{
            return 'Giao ngay'. '<br/> Nguồn: '.$this->created_by;
        }
    }

    public function getFbcodeLabel()
    {
        if(!$this->isFromFoodbook){
            return 'POS';
        }else{
            return 'FB';
        }
    }

    /*public function getCutstring()
    {
        return $this->foodbook_code;

    }*/
    public function getCutstring()
    {
        if(strlen($this->foodbook_code) > 10){
            return 'POS-'.(substr ($this->foodbook_code, -4));
        }else{
            return $this->foodbook_code;
        }

    }
    public function getPosname()
    {
        $posModel = new  DmposSearch();
        $pos = $posModel->searchById($this->pos_id);

        return $pos['POS_NAME'];
    }

    public function getSalebefore(){

        $saleNoDiscount = 0;
        if(($this->status !==  Yii::$app->params['CANCELLED']) || ($this->status !==  Yii::$app->params['FAILED'])){
            foreach((array)$this->order_data_item as $item){
                $saleNoDiscount = (@$item['Price']*@$item['Quantity']) + $saleNoDiscount;
            }
        }
        return $saleNoDiscount;
    }
    public function getSale(){
        $sale = 0;

        if(($this->status !==  Yii::$app->params['CANCELLED']) || ($this->status !==  Yii::$app->params['FAILED'])){

            $discounItem = 0;

            foreach((array)$this->order_data_item as $item){
                if(@$item['mDiscount']){
                    $discounItem = $item['Price']*$item['Quantity']*$item['mDiscount'] + $discounItem;
                }

                $sale = ($item['Price']*$item['Quantity']) + $sale;
            }

            $this->amount = $sale;

            $discountVoucher = 0;
            $discount = 0;

            if(@$this->voucher['discount_type']){

                if(@$this->voucher['same_price']){
                    $same_price = $this->voucher['same_price'];
                    foreach($this->order_data_item as $item){
                        $discountVoucher = $item['Price']*$item['Quantity'] - $same_price + $discountVoucher;
                    }
                }else{
                    $discountVoucher = $this->voucher['used_discount_amount'];
                }

            }else{
                if(@$this->discount_extra){
                    $discount = $this->discount_extra*$sale;
                }

                if(@$this->discount_extra_amount){
                    $discount = $this->discount_extra_amount;
                }
            }

            if($this->voucher['only_coupon'] == 1){
                $discounItem = 0;
                $discount = 0;
            }

            $this->discount_items = $discounItem;

            $discount = $discount + $discountVoucher + $discounItem;
            $total = $sale - $discount;
            $total = $total + @$this->service_charge*$total;
            $sale = $total + $total*$this->vat_tax_rate;
        }

        return $sale;
    }

    public function getDiscomplete(){
        $disComplete = 0;
        if($this->status ===  'COMPLETED'){
            $disComplete = $this->distance + $disComplete;
        }
        return $disComplete;
    }
    public function getShip(){
        $ship = 0;
        if(@$this->ship_price_real > 0 ){
            $ship = $this->ship_price_real;
        }else{
           $ship = 0;
        }
        return $ship;
    }

    public function getBill(){
        $sale = '';
        if($this->order_data_item){
            foreach((array)$this->order_data_item as $item){
                $itemName =  mb_strimwidth(@$item['Item_Name'], 0, 28, "...");
                if($sale !== ''){
                    $sale = $sale.'('.@$item['Quantity'].') '.$itemName.' <br>';
                }else{
                    $sale = '('.@$item['Quantity'].') '.$itemName.' <br>';
                }
            }
        }
        return $sale;
    }

    public function getCheckCase(){
        $IS_CALL_CENTER = $this->pos->IS_CALL_CENTER;
        $IS_AHAMOVE_ACTIVE = $this->pos->IS_AHAMOVE_ACTIVE;
        $IS_POS_MOBILE = $this->pos->IS_POS_MOBILE;

        if(isset($this->longitude) && isset($this->latitude)){
            $longitude = $this->longitude;
            $latitude = $this->latitude;
        }else{
            $longitude = 0;
            $latitude = 0;
        }
        $checkCase = 0;
        if($IS_CALL_CENTER ==1){
            if($this->status === 'WAIT_CONFIRM'){
                if($IS_POS_MOBILE == 0){
                    if($longitude != 0 && $latitude != 0 ){
                        $id = $this->_id->__toString();
                        $key = 'checkSendToPos_'.$id;
                        $checkSendToPos = \Yii::$app->cache->get($key);
                        if ($checkSendToPos === false) {
                            $checkCase = 15;
                        }else{
                            $checkCase = 16;
                        }

//                    die();

                    }else{
                        $checkCase = 17;
                    }
                }else{
                    if($IS_AHAMOVE_ACTIVE){
                        $checkCase = 1;
                    }else{
                        $checkCase = 3;
                    }

                }
            }else if($IS_CALL_CENTER == 1 && ($longitude != 0 || $latitude != 0) && $this->status === 'WAIT_CONFIRM' && $IS_AHAMOVE_ACTIVE == 1 && $this->isCallCheckAhamove == 0 && $this->isCallCenterConfirmWithPos == 0 && $this->isCallCenterConfirmed == 0){
                $checkCase = 2;
            }else if($IS_CALL_CENTER == 1 && ($longitude != 0 || $latitude != 0) && $this->status === 'ASSIGNING' && $IS_AHAMOVE_ACTIVE == 1 && $this->isCallCheckAhamove == 1 && $this->isCallCenterConfirmWithPos == 0 && $this->isCallCenterConfirmed == 0){
                $checkCase = 7;
            }else if($IS_CALL_CENTER == 1 && ($longitude != 0 || $latitude != 0) && $this->status === 'ACCEPTED' && $IS_AHAMOVE_ACTIVE == 1 && $this->isCallCheckAhamove == 1 && $this->isCallCenterConfirmWithPos == 0 /*&& $this->isCallCenterConfirmed == 0*/){
                $checkCase = 8;
            }else if($IS_CALL_CENTER == 1 && ($longitude != 0 || $latitude != 0) && $this->status === 'ACCEPTED' && $IS_AHAMOVE_ACTIVE == 1 && $this->isCallCheckAhamove == 1 && $this->isCallCenterConfirmWithPos == 0 /*&& $this->isCallCenterConfirmed == 0*/){
                $checkCase = 14;
            }else if($IS_CALL_CENTER == 1 && ($longitude != 0 || $latitude != 0) && $this->status === 'IN PROCESS' && $IS_AHAMOVE_ACTIVE == 1 && $this->isCallCheckAhamove == 1 && $this->isCallCenterConfirmWithPos == 0 /*&& $this->isCallCenterConfirmed == 0*/){
                $checkCase = 13;
            }else if($IS_CALL_CENTER == 1 && ($longitude != 0 || $latitude != 0) && $this->status === 'ACCEPTED' && $IS_AHAMOVE_ACTIVE == 1 && $this->isCallCheckAhamove == 1 && $this->isCallCenterConfirmWithPos == 1 /*&& $this->isCallCenterConfirmed == 1*/){
                $checkCase = 10;
            }else if($IS_CALL_CENTER == 1 && ($longitude != 0 || $latitude != 0) && ($this->status === 'IN PROCESS'  || $this->status === 'ACCEPTED') && $IS_AHAMOVE_ACTIVE == 1 && $this->isCallCheckAhamove == 1 && $this->isCallCenterConfirmWithPos == 0 && $this->isCallCenterConfirmed == 0){
                $checkCase = 11;
            }else if($IS_CALL_CENTER == 1 && ($longitude != 0 || $latitude != 0) && $this->status === 'CONFIRMED' /*&& $IS_AHAMOVE_ACTIVE == 1 && $this->isCallCheckAhamove == 1 */ && $this->isCallCenterConfirmWithPos == 1 /*&& $this->isCallCenterConfirmed == 0*/){
                $checkCase = 9;
            }else if($IS_CALL_CENTER == 1 && ($longitude != 0 || $latitude != 0) && $this->status === 'WAIT_CONFIRM' && $IS_AHAMOVE_ACTIVE == 0 && $this->isCallCenterConfirmWithPos == 0){
                $checkCase = 3;
            }else if($IS_CALL_CENTER == 1 && ($longitude != 0 || $latitude != 0) && $this->status === 'WAIT_CONFIRM' && $IS_AHAMOVE_ACTIVE == 0 && $this->isCallCenterConfirmWithPos == 1){
                $checkCase = 12;
            }else if($IS_CALL_CENTER == 1 && ($longitude != 0 || $latitude != 0) && $this->status === 'CANCELLED' && $IS_AHAMOVE_ACTIVE == 1 ){
                $checkCase = 4;
            }else if($IS_CALL_CENTER == 1 && ($longitude != 0 || $latitude != 0) && $this->status === 'CONFIRMED' && $IS_AHAMOVE_ACTIVE == 1 && $this->isCallCenterConfirmWithPos == 1 && $this->isCallCheckAhamove == 1 && $this->isCallCenterConfirmed  == 1){
                $checkCase = 5;
            }else if($IS_CALL_CENTER == 1 && ($longitude != 0 || $latitude != 0) && $this->status === 'IN PROCESS' && $IS_AHAMOVE_ACTIVE == 1 && $this->isCallCenterConfirmWithPos == 1 && $this->isCallCheckAhamove == 1 && $this->isCallCenterConfirmed  == 1){
                $checkCase = 6;
            }
        }else{
            if($IS_POS_MOBILE){
                if($IS_AHAMOVE_ACTIVE){ //Kiểm tra nếu dùng AHAMOVE
                    if($this->status == 'CONFIRMED'){
                        $checkCase = 18;
                    }elseif($this->status == 'AHA_CANCELLED'){
                        $checkCase = 19;
                    }elseif($this->status == 'CANCELLED'){
                        $checkCase = 19;
                    }else{
                        $checkCase = 0;
                    }
                }else{
                    $checkCase = 0;
                }
            }else{
                $checkCase = 100;
            }

        }



        return $checkCase;
    }





    public function getCheckCase______backup(){
        $IS_CALL_CENTER = $this->pos->IS_CALL_CENTER;
        $IS_AHAMOVE_ACTIVE = $this->pos->IS_AHAMOVE_ACTIVE;
        $IS_POS_MOBILE = $this->pos->IS_POS_MOBILE;

        if(isset($this->longitude) && isset($this->latitude)){
            $longitude = $this->longitude;
            $latitude = $this->latitude;
        }else{
            $longitude = 0;
            $latitude = 0;
        }
        $checkCase = 0;
        if($IS_CALL_CENTER == 1 && $this->status === 'WAIT_CONFIRM'){
            if($IS_POS_MOBILE == 0){
                if($longitude != 0 && $latitude != 0 ){
                    $id = $this->_id->__toString();
                    $key = 'checkSendToPos_'.$id;
                    $checkSendToPos = \Yii::$app->cache->get($key);
                    if ($checkSendToPos === false) {
                        $checkCase = 15;
                    }else{
                        $checkCase = 16;
                    }

//                    die();

                }else{
                    $checkCase = 17;
                }
            }else{
                if($IS_AHAMOVE_ACTIVE){
                    $checkCase = 1;
                }else{
                    $checkCase = 3;
                }

            }
        }else if($IS_CALL_CENTER == 1 && ($longitude != 0 || $latitude != 0) && $this->status === 'WAIT_CONFIRM' && $IS_AHAMOVE_ACTIVE == 1 && $this->isCallCheckAhamove == 0 && $this->isCallCenterConfirmWithPos == 0 && $this->isCallCenterConfirmed == 0){
            $checkCase = 2;
        }else if($IS_CALL_CENTER == 1 && ($longitude != 0 || $latitude != 0) && $this->status === 'ASSIGNING' && $IS_AHAMOVE_ACTIVE == 1 && $this->isCallCheckAhamove == 1 && $this->isCallCenterConfirmWithPos == 0 && $this->isCallCenterConfirmed == 0){
            $checkCase = 7;
        }else if($IS_CALL_CENTER == 1 && ($longitude != 0 || $latitude != 0) && $this->status === 'ACCEPTED' && $IS_AHAMOVE_ACTIVE == 1 && $this->isCallCheckAhamove == 1 && $this->isCallCenterConfirmWithPos == 0 /*&& $this->isCallCenterConfirmed == 0*/){
            $checkCase = 8;
        }else if($IS_CALL_CENTER == 1 && ($longitude != 0 || $latitude != 0) && $this->status === 'ACCEPTED' && $IS_AHAMOVE_ACTIVE == 1 && $this->isCallCheckAhamove == 1 && $this->isCallCenterConfirmWithPos == 0 /*&& $this->isCallCenterConfirmed == 0*/){
            $checkCase = 14;
        }else if($IS_CALL_CENTER == 1 && ($longitude != 0 || $latitude != 0) && $this->status === 'IN PROCESS' && $IS_AHAMOVE_ACTIVE == 1 && $this->isCallCheckAhamove == 1 && $this->isCallCenterConfirmWithPos == 0 /*&& $this->isCallCenterConfirmed == 0*/){
            $checkCase = 13;
        }else if($IS_CALL_CENTER == 1 && ($longitude != 0 || $latitude != 0) && $this->status === 'ACCEPTED' && $IS_AHAMOVE_ACTIVE == 1 && $this->isCallCheckAhamove == 1 && $this->isCallCenterConfirmWithPos == 1 /*&& $this->isCallCenterConfirmed == 1*/){
            $checkCase = 10;
        }else if($IS_CALL_CENTER == 1 && ($longitude != 0 || $latitude != 0) && ($this->status === 'IN PROCESS'  || $this->status === 'ACCEPTED') && $IS_AHAMOVE_ACTIVE == 1 && $this->isCallCheckAhamove == 1 && $this->isCallCenterConfirmWithPos == 0 && $this->isCallCenterConfirmed == 0){
            $checkCase = 11;
        }else if($IS_CALL_CENTER == 1 && ($longitude != 0 || $latitude != 0) && $this->status === 'CONFIRMED' /*&& $IS_AHAMOVE_ACTIVE == 1 && $this->isCallCheckAhamove == 1 */ && $this->isCallCenterConfirmWithPos == 1 /*&& $this->isCallCenterConfirmed == 0*/){
            $checkCase = 9;
        }else if($IS_CALL_CENTER == 1 && ($longitude != 0 || $latitude != 0) && $this->status === 'WAIT_CONFIRM' && $IS_AHAMOVE_ACTIVE == 0 && $this->isCallCenterConfirmWithPos == 0){
            $checkCase = 3;
        }else if($IS_CALL_CENTER == 1 && ($longitude != 0 || $latitude != 0) && $this->status === 'WAIT_CONFIRM' && $IS_AHAMOVE_ACTIVE == 0 && $this->isCallCenterConfirmWithPos == 1){
            $checkCase = 12;
        }else if($IS_CALL_CENTER == 1 && ($longitude != 0 || $latitude != 0) && $this->status === 'CANCELLED' && $IS_AHAMOVE_ACTIVE == 1 ){
            $checkCase = 4;
        }else if($IS_CALL_CENTER == 1 && ($longitude != 0 || $latitude != 0) && $this->status === 'CONFIRMED' && $IS_AHAMOVE_ACTIVE == 1 && $this->isCallCenterConfirmWithPos == 1 && $this->isCallCheckAhamove == 1 && $this->isCallCenterConfirmed  == 1){
            $checkCase = 5;
        }else if($IS_CALL_CENTER == 1 && ($longitude != 0 || $latitude != 0) && $this->status === 'IN PROCESS' && $IS_AHAMOVE_ACTIVE == 1 && $this->isCallCenterConfirmWithPos == 1 && $this->isCallCheckAhamove == 1 && $this->isCallCenterConfirmed  == 1){
            $checkCase = 6;
        }
        return $checkCase;
    }


    public function getSuggest(){

        $case0 = 'Theo dõi trạng thái đơn hàng';
        $case1 = 'Đơn hàng sử dụng AHAMOVE để giao đồ chọn TO AHAMOVE';
        $case2 = 'Nhà hàng NH sử dụng Ahamove, cần kiểm tra tài xế, chọn Tìm xế';
        $case3 = 'Đã xác nhận địa chỉ, NH tự giao hàng, cần chuyển xuống POS, chọn ToPos -> Xuống Pos';
        $case4 = 'Đã xác nhận địa chỉ, không có tài xế. Cần alo hủy đơn hàng, sau đó nhấn nút hủy';
        $case5 = 'Nhà hàng lâu không xác nhận lại đơn hàng, gọi điện giục nhà hàng';
        $case6 = 'Nhà hàng đã giao hàng cho tài xế, gọi điện cho tài xế '.$this->supplier_id;
        $case7 = 'Đơn hàng đã được gửi tới các tài xế, hãy chờ xác nhận của các tài xế, nếu lâu quá có thể gọi điện cho khách hủy đơn hàng';
        $case8 = 'Tài xế đã chấp nhận đơn hàng, chuyển đơn hàng xuống Pos';
        $case9 = 'Nhà hàng đã chấp nhận đơn hàng, theo dõi thời gian, nếu lâu quá thì gọi điện giục nhà hàng';
        $case10 = 'Đã gửi đơn hàng xuống Pos nhưng chưa có phản hồi từ đơn hàng, nếu lâu quá check lại nhà hàng';
        $case11 = 'Nhà hàng chưa có phản hồi về đơn hàng nhưng tài xế đã thực hiện, cần check lại tài xế';
        $case12 = 'Đã xác nhận địa chỉ, NH tự giao hàng, đơn hàng đã chuyển xuống Pos nhưng nhà hàng chưa xác nhận';
        $case13 = 'Đơn hàng đang được tài xế vận chuyển tới khách hàng';
        $case15 = 'Đơn hàng mới, hãy chuyển xuống nhà hàng';
        $case16 = 'Đơn hàng đã được đẩy xuống nhà hàng, chờ nhà hàng xác nhận đơn hàng';
        $case17 = 'Đơn hàng mới, chưa có địa chỉ hãy click vào biểu tượng địa chỉ để lấy địa chỉ khách hàng';

        //
        $case18 = 'Nhà hàng NH sử dụng Ahamove, cần tìm tài xế, chọn Tìm xế hoặc Để nhà hàng tự giao hàng';
        $case19 = 'Nhà hàng NH sử dụng Ahamove,chưa tìm được xế, thử lại tìm xế, chọn Tìm xế hoặc Để nhà hàng tự giao hàng';

        $case100 = 'Pos thường không sử dụng callcenter ';


        $checkCase = Orderonlinelog::getcheckCase();
        switch ($checkCase) {
            case 0:
                return $case0;
                break;
            case 1:
                return $case1;
                break;
            case 2:
                return $case2;
                break;
            case 3:
                return $case3;
                break;
            case 4:
                return $case4;
                break;
            case 5:
                return $case5;
                break;
            case 6:
                return $case6;
                break;
            case 7:
                return $case7;
                break;
            case 8:
                return $case8;
                break;
            case 9:
                return $case9;
                break;
            case 10:
                return $case10;
                break;
            case 11:
                return $case11;
                break;
            case 12:
                return $case12;
                break;
            case 13:
                return $case13;
                break;
            case 15:
                return $case15;
                break;
            case 16:
                return $case16;
                break;
            case 17:
                return $case17;
                break;
            case 18:
                return $case18;
                break;
            case 19:
                return $case19;
                break;

            case 100:
                return $case100;
                break;


            default:
                return 'Nhà hàng không thông qua CallCenter....';
                break;
        }
        //return $this->isFromFoodbook;
    }

    public  function getVieworder(){
        $buttonView =  Html::a('Xem', 'index.php?r=orderonlinelog/view&id='.$this->_id,
            [
                'class' => 'btn btn-primary btn-status-action btn_orderonlinelog_action',
            ]
        );

        $buttonUpdate =  Html::a('Sửa', 'index.php?r=orderonlinelog/update&id='.$this->_id,
            [
                'class' => 'btn btn-success btn-status-action btn_orderonlinelog_action',
            ]
        );
        $buttonRecreate =  Html::a('Sửa', 'index.php?r=orderonlinelogpending/update&id='.$this->_id,
            [
                'class' => 'btn btn-success btn-status-action btn_orderonlinelog_action',
            ]
        );
        $buttonConfirmed =  '<br>'.Html::a('Xác nhận', 'index.php?r=orderonlinelog/changestatus&id='.$this->_id.'&statusUpdate=CONFIRMED',
            [
                'class' => 'btn btn-success  btn_orderonlinelog_action',
            ]
        );

        $buttonCancel =  Html::a('Hủy', 'index.php?r=orderonlinelog/cancel&id='.$this->_id,
            [
                'class' => 'btn btn-danger btn-status-action btn_orderonlinelog_action',
                'data-confirm' => 'Bạn có chắc chắn muốn hủy đơn hàng này không ?'
            ]
        );
        if($this->pos->IS_POS_MOBILE == 1){
            if($this->status === 'WAIT_CONFIRM'){
                return $buttonView.$buttonUpdate.$buttonCancel;
            }else{
                return $buttonView.$buttonRecreate;
            }
        }else{
            if($this->status === 'WAIT_CONFIRM'){
                return $buttonView.$buttonCancel;
            }else{
                return $buttonView.$buttonRecreate;
            }
        }
    }

    public function getActions(){
        $button1 =  Html::a('', 'index.php?r=orderonlinelog/updatelocation&id='.$this->_id,
            [
                'class' => 'glyphicon glyphicon-check',
            ]
        );

        $button5 =  Html::a('', 'index.php?r=orderonlinelog/update&id='.$this->_id,
            [
                'class' => 'glyphicon glyphicon-pencil',
            ]
        );


        $button2 =  Html::a('Hủy', 'index.php?r=orderonlinelog/delete&id='.$this->_id,
            [
                'class' => 'btn btn-danger',
            ]
        );


        $button3 =  Html::a('Tìm xế', 'index.php?r=orderonlinelog/toahamove&id='.$this->_id,
            [
                'class' => 'btn btn-primary btn-status-oder',
            ]
        );
        $button4 =  Html::a('Nhà hàng giao', 'index.php?r=orderonlinelog/confirmtopos&id='.$this->_id,
            [
                'class' => 'btn btn-success btn-status-oder',
            ]
        );

        $staticBtn = Orderonlinelog::getVieworder();


        $checkCase = Orderonlinelog::getcheckCase();
        switch ($checkCase) {
            case 0:
                return '';
                break;
            case 1:
                return $button3.$staticBtn;
                break;
            case 2:
                return $button1.' '.$button3.$staticBtn;
                break;
            case 3:
                return /*$button1.' '.*/$button4.$staticBtn;
                break;
            case 4:
                return $button1.$staticBtn;
                break;
            case 5:
                return $button1.$staticBtn;
                break;
            case 6:
                return $button1.$staticBtn;
                break;
            case 7:
                return $button1.$staticBtn;
                break;
            case 8:
                return $button1.' '.$button4.$staticBtn;
                break;
            case 9:
                return $button1.$staticBtn;
                break;
            case 10:
                return $button1.$staticBtn;
                break;
            case 11:
                return $button1.' '.$button4.$staticBtn;
                break;
            case 12:
                return $staticBtn;
                break;
            case 13:
                return $staticBtn;
                break;
            case 15:
                return $button4.$staticBtn;
                break;
            case 16:
                return $staticBtn;
                break;
            case 17:
                return $button1.$staticBtn;
                break;
            case 18:
                return $button3.$button4.$staticBtn;
                break;
            case 19:
                return $button3.$button4.$staticBtn;
                break;

            case 100:
                return $staticBtn;
                break;

            default:
                return $staticBtn;
                break;
        }

    }

}
