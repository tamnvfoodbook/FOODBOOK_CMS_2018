<?php

namespace backend\models;

use backend\controllers\ExtendController;
use Yii;

/**
 * This is the model class for collection "BOOKING_ONLINE_LOG".
 *
 * @property \MongoId|string $_id
 * @property mixed $Foodbook_Code
 * @property mixed $Pos_Id
 * @property mixed $Pos_Workstation
 * @property mixed $User_Id
 * @property mixed $Book_Date
 * @property mixed $Hour
 * @property mixed $Minute
 * @property mixed $Number_People
 * @property mixed $Note
 * @property mixed $Status
 * @property mixed $Created_At
 * @property mixed $Updated_At
 * @property mixed $Created_By
 */
class Bookingonlinelog extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $bookinginfo;
    public $user_id;
    public $username;

    public static function collectionName()
    {
        return [Yii::$app->params['COLLECTION'], 'BOOKING_ONLINE_LOG'];
    }


    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'Foodbook_Code',
            'Pos_Id',
            'Pos_Workstation',
            'User_Id',
            'Book_Date',
            'Hour',
            'Minute',
            'Number_People',
            'Note',
            'Status',
            'Created_At',
            'Updated_At',
            'Created_By',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Foodbook_Code', 'Pos_Id', 'Pos_Workstation', 'User_Id', 'Book_Date', 'Hour', 'Minute', 'Number_People', 'Note', 'Status', 'Created_At', 'Updated_At','bookinginfo','user_id','Created_By'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'Foodbook_Code' => 'Mã FB',
            'Pos_Id' => 'Nhà hàng',
            'Pos_Workstation' => 'PosWS',
            'User_Id' => 'SĐT Khách hàng',
            'Book_Date' => 'Ngày đặt',
            'Hour' => 'Giờ',
            'Minute' => 'Phút',
            'Number_People' => 'Số người',
            'Note' => 'Ghi chú',
            'Status' => 'Trạng thái',
            'Created_At' => 'Ngày tạo',
            'Updated_At' => 'Ngày cập nhật',
            'Created_By' => 'Nguồn tạo',
        ];
    }
    public function getChagebookdate(){
        if($this->Hour < 10){
           $this->Hour = '0'.$this->Hour;
        }
        if($this->Minute < 10){
           $this->Minute = '0'.$this->Minute;
        }
        return date(Yii::$app->params['DATE_FORMAT'], @$this->Book_Date->sec).'<br>'.@$this->Hour.':'.@$this->Minute.':00';
    }
//    public function getUpdatelable(){
//        return Yii::t('yii',$this->Status);
//    }
//    public function getChangeUpdate(){
//        return date('d-m-Y H:i:s', $this->Updated_At->sec);
//    }

    public function getCountUpdateTime(){
//        echo '<pre>';
//        var_dump($this->Updated_At);
//        echo '</pre>';
//        $timecounted =  Orderonlinelog::countTime($this->Updated_At,$this->Created_At,$this->Status);
//        return $timecounted;
        $creatTime = date(Yii::$app->params['DATE_TIME_FORMAT_2'],$this->Created_At->sec);
        $time = $this->Updated_At;
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


        switch ($this->Status) {
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
            case 'WAIT_CONFIRMED':
                # code...
                $class = 'time-info-wanning';
                break;

            default:
                //var_dump($this->status);
                # code...
                $class = 'time-info-info';
                break;
        }


//        print ExtendController::secondsToTime($secs);
//        echo '<br>';

        /*return '
            <div>
            <div class="'.$class.'">
                <b>'.Yii::t('yii',$this->Status).'</b><br>
                <b>
                    <span>'.gmdate("d H:i:s", $secs).'</span>
                </b>
            </div>
        </div>';*/
        return '
            <div>
            <div class="'.$class.'">
                <b>'.Yii::t('yii',$this->Status).'</b><br>
                <b>
                    <span>'.number_format($min).' phút</span>
                </b>
            </div>
        </div>';
    }

    public  function getMemberinfo(){

        return $this->user_id.'<br>'.$this->username;
    }

    public function getDmmembership()
    {
        return $this->hasOne(Dmmembership::className(), ['ID' => 'User_Id'])->select(['ID','MEMBER_NAME']);
    }

    public function getPos()
    {
        return $this->hasOne(Dmpos::className(), ['ID' => 'Pos_Id']);
    }
}
