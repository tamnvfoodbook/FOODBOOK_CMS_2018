<?php

namespace backend\controllers;
use backend\controllers\OrderonlinelogController;

use backend\models\DmposSearch;
use Yii;
use yii\web\ForbiddenHttpException;

class DiscountController extends \yii\web\Controller
{
    function actionIndex(){
//        $code               = $_REQUEST['code'];            // Ma chinh
//        $subCode            = $_REQUEST['subCode'];         // Ma phu
//        $mobile             = $_REQUEST['mobile'];          // So dien thoai +84
//        $serviceNumber      = $_REQUEST['serviceNumber'];   // Dau so 8x85
//        $info               = $_REQUEST['info'];            // Noi dung tin nhan
//        $ipremote           = $_SERVER['REMOTE_ADDR'];      // IP server goi qua truyen du lieu
//
//        // 2. Ghi log va kiem tra du lieu
//        // Tim file log.txt tai thu muc chua file php xu ly sms nay
//        // kiem tra de biet ban da nhan du thong tin ve tin nhan hay chua
//                $text = $code." - ".$subCode." - ".$mobile." - ".$serviceNumber." - ".$ipremote." - ".$info;
//                $fh = fopen('log.txt', "a+") or die("Could not open log.txt file.");
//                @fwrite($fh, date("d-m-Y, H:i")." - $text\n") or die("Could not write file!");
//                fclose($fh);
//
//
//        // 2. Kiem tra bao mat du lieu tu iNET gui qua
//        // Lien he voi iNET de lay IP nay
//                if($_SERVER['REMOTE_ADDR'] != '210.211.127.168') { // 210.211.127.168
//                    echo $_SERVER['REMOTE_ADDR'];
//                    echo "Authen Error";
//                    exit;
//                }

        // 3. Xu ly du lieu cua ban tai day
        // ket noi csdl
        // xu ly du lieu


        // 5. Tra ve tin nha gom kieu tin nhan (0) va noi dung tin nhan
        // Xuong dong trong tin nhan su dung \n
                $noidung = "Hi ! \nCam on ban da su dung dich vu";
                echo "0|".$noidung;
        //die();
    }

}
