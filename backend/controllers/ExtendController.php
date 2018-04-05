<?php

namespace backend\controllers;
use backend\controllers\OrderonlinelogController;

use backend\models\DmposSearch;
use backend\models\User;
use backend\models\UserSearch;
use Yii;
use yii\web\ForbiddenHttpException;

class ExtendController extends \yii\web\Controller
{
    public static function checkUserPermiswithPos($user_id){
        $userId = \Yii::$app->session->get('user_id');
        $posParent = \Yii::$app->session->get('pos_parent');
        $type = \Yii::$app->session->get('type_acc');
        $posId = \Yii::$app->session->get('pos_id_list');
        if($type == 3){
            if($userId == $user_id){
                return true;
            }else{
                return false;
            }
        }elseif($type == 2){
            $user = new UserSearch();
            $model = $user->searcUserById($user_id);
            if(@$model->POS_PARENT === $posParent){
                return true;
            }else{
                return false;
            }
        }elseif($type == 1){
            return true;
        }else{
            return false;
        }
    }

    function ensure2Digit($number) {
        if($number < 10) {
            $number = '0' . $number;
        }
        return $number;
    }

    static function ExportFile($records) {
        $heading = false;
        if(!empty($records))
            foreach($records as $row) {
                if(!$heading) {
                    // display field/column names as a first row
                    echo implode("\t", array_keys($row)) . "\n";
                    $heading = true;
                }
                echo implode("\t", array_values($row)) . "\n";
            }
        exit;
    }

    function ExportCSVFile($records) {
        // create a file pointer connected to the output stream
        $fh = fopen( 'php://output', 'w' );
        $heading = false;
        if(!empty($records))
            foreach($records as $row) {
                if(!$heading) {
                    // output the column headings
                    fputcsv($fh, array_keys($row));
                    $heading = true;
                }
                // loop over the rows, outputting them

                fputcsv($fh, array_values($row));

            }
        fclose($fh);
    }

// Convert seconds into months, days, hours, minutes, and seconds.
    function secondsToTime($ss) {
        $s = self::ensure2Digit($ss%60);
        $m = self::ensure2Digit(floor(($ss%3600)/60));
        $h = self::ensure2Digit(floor(($ss%86400)/3600));
        $d = self::ensure2Digit(floor(($ss%2592000)/86400));
        $M = self::ensure2Digit(floor($ss/2592000));

        return "$M:$d:$h:$m:$s";
    }

    //Convert phone number
    static function format_number_callcenter_vht($number)
    {
        //make sure the number is actually a number
        if(is_numeric($number)){

            //if number doesn't start with a 0 or a 4 add a 0 to the start.
            //if($number[0] != 0 && $number[0] != 4){

            //if number doesn't start with a 0 add a 0 to the start.
            if($number[0] != 0){
                $number = "0".$number;
            }

            //if number starts with a 0 replace with 8
//            if($number[0] == 0){
//                $number[0] = str_replace("0","4",$number[0]);
//                $number = "8".$number;
//            }

            //remove any spaces in the number
            $number = str_replace(" ","",$number);

            //return the number
            return $number;

            //number is not a number
        } else {

            //return nothing
            return false;
        }
    }
    static function format_number_callcenter_vht_with_prenumber($number)
    {
        //make sure the number is actually a number
        if(is_numeric($number)){

            //if number doesn't start with a 0 or a 4 add a 0 to the start.
            //if($number[0] != 0 && $number[0] != 4){

            //if number doesn't start with a 0 add a 0 to the start.
            if($number[0] != 0){
                $number = "0".$number;
            }

            //if number starts with a 0 replace with 8
            if($number[0] == 0){
                $number[0] = str_replace("0","4",$number[0]);
                $number = "8".$number;
            }

            //remove any spaces in the number
            $number = str_replace(" ","",$number);

            //return the number
            return $number;

            //number is not a number
        } else {

            //return nothing
            return false;
        }
    }
}
