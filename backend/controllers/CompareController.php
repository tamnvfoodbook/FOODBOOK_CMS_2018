<?php
//use yii\filters\AccessControl;
//use yii\web\Controller;
//use yii\filters\VerbFilter;
//
//use yii\helpers\ArrayHelper;
//use yii\mongodb\ActiveQueryInterface;



namespace backend\controllers;

class CompareController extends \yii\web\Controller
{
    public function actionIndex()
    {
        date_default_timezone_set('Asia/Bangkok');
        $dateTime = new \DateTime;

        $post = \Yii::$app->request->post();
        if($post['optionTime'] === 'manual'){
            $cutTime1 = substr($post['dateFrom'],0,10); // Cắt đầu chuỗi lấy time start
            $cutTime2 = substr($post['dateFrom'],-10);   // Cắt đầu chuỗi lấy time End
            $time1 = date('c', strtotime($cutTime1));
            $start = new \MongoDate(strtotime($time1));

            $time2 = date('c', strtotime($cutTime2));
            $end = new \MongoDate(strtotime($time2));
        }else{

            $optionTime = $post['optionTime'];
            $dateTime->sub(new \DateInterval(".$optionTime."));
            $DAY2 = $dateTime->format( \DateTime::ISO8601 );
            $end = new \MongoDate(strtotime(date('c')));
            $start = new \MongoDate(strtotime($DAY2));
            if($optionTime === 'P1D'){
                $end = $start;
            }
        }

        $posId = $post['posOption'];
        $data = SiteController::sumPosSstatis($posId,$end,$start);
//        echo '<pre>';
//        var_dump($data);
//        echo '</pre>';
//        die();

        return $this->render('index',$data);
    }


    function date_range($first, $last, $step = '+1 day', $output_format = 'd/m/Y' ) {
        $dates = array();
        $current = strtotime($first);
        $last = strtotime($last);

        while( $current <= $last ) {

            $dates[] = date($output_format, $current);
            $current = strtotime($step, $current);
        }

        return $dates;
    }

}
