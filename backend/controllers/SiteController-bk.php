<?php
namespace backend\controllers;

use backend\models\DmmembershipSearch;
use backend\models\DmposSearch;

use backend\models\OrderrateSearch;
use backend\models\SaledetailSearch;
use backend\models\User;
use backend\models\UserSearch;
use Yii;

use yii\filters\AccessControl;

use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;

use yii\helpers\ArrayHelper;

use backend\models\Bookmarkpos;
use backend\models\Orderrate;
use backend\models\Dmpos;


class SiteController extends Controller
{
    /**
     * @inheritdoc
     * Merget code 02_07_2016
     *
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error','pushnote','resetpassword','renewpassword','congratulation','getcommentinrateloadmore'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @param $modelSum
     * @return array|null
     */

    //static
    static function actionCountDay($start,$end,$format = 'Y-m-d',$step = '+1 day'){
        $days = (strtotime(date('Y-m-d',$end->sec)) - strtotime(date('Y-m-d',$start->sec))) / (60 * 60 * 24);
        $first = date('Y-m-d',$start->sec);
        $last = date('Y-m-d',$end->sec);

        $dates = array();
        $current = strtotime($first);
        $last = strtotime($last);

        while( $current <= $last ) {
            $dates[] = date($format, $current);
            $current = strtotime($step, $current);
        }

        return $dates;
    }


    public function actionSumOrther($modelSum){
        $total = 0;
        if ($modelSum){
            foreach ($modelSum as $key => $value){
                foreach ($value as $key1 => $value1) {
                    if ($key1 == 1) {
                        $total = $value1 + $total;
                    }
                }
            }
        }
        return $total;
    }


    public function countPrice($arraySales){
       // echo '<pre>';
       // var_dump($arraySales);
       // echo '</pre>';
       // die();
        $arrayData = NULL;
        foreach ($arraySales as $key => $valueAllPosByDay) {
            if($valueAllPosByDay){
                $arrayData[]['value'] = (string)array_sum($valueAllPosByDay);
            }else{
                $arrayData[]['value'] = 0;
            }

        }
        return $arrayData;
    }

    public function countElement($priceTotal){

        $arrayElement = NULL;
        foreach ($priceTotal as $key1 => $value1) {
            $arrayElement[$key1] = [date('D',strtotime($key1)),array_sum($value1),number_format(array_sum($value1))];
        }
        return array_values($arrayElement);
    }

    public function countElementRate($arrayRateCountByDay){
        $arrayRateData = NULL;
        foreach ($arrayRateCountByDay as $key => $valueRateByDay) {
            if(count(array_filter($valueRateByDay))){
                $arrayRateData[]['value'] = number_format(array_sum(array_filter($valueRateByDay))/count(array_filter($valueRateByDay)),1);
            }else{
                $arrayRateData[]['value'] = 0;
            }
        }

        return $arrayRateData;
    }


    public function ratingDetail($rateTotal,$rateId,$checkAjax = null){
        // Sap xep thu tu mang thieu diem rate
        function subval_sort($a,$subkey) {
            foreach($a as $k=>$v) {
                $b[$k] = strtolower($v[$subkey]);
            }
            asort($b);
            foreach($b as $key=>$val) {
                $c[] = $a[$key];
            }
            return $c;
        }


        $arrayRateToday = NULL;
        if($rateTotal != NULL && $rateId != NULL){
            $oderRateSorted = subval_sort($rateTotal,'score');
            // End Sap xep thu tu mang thieu diem rate

            // Get name member
            $memberRateObj = new DmmembershipSearch();
            $memberObj = $memberRateObj->searchMemberById($rateId);
            //$memberNameMap = ArrayHelper::map($memberObj,'ID','MEMBER_NAME');

            $posModel = new DmposSearch();

            $Today = date('Y-m-d');
            // Show Rating detail
            foreach ($memberObj as $key => $value) {
                foreach ($oderRateSorted as $key1 => $value1) {
                    $pos = $posModel->searchAllPosById($value1['pos_id']);
                    $posNameMap = ArrayHelper::map($pos,'ID','POS_NAME');

                    if($checkAjax){
                        if ($value['ID'] == $value1['member_id']){
                            $oderRateSorted[$key1]['memberName'] = $value['MEMBER_NAME'];
                            $oderRateSorted[$key1]['pos_name'] = $posNameMap[$value1['pos_id']];
                            $arrayRateToday[] = $oderRateSorted[$key1];
                        }
                    }else{
                        if($value1['created_at'] === $Today){
                            if ($value['ID'] == $value1['member_id']){
                                $oderRateSorted[$key1]['memberName'] = $value['MEMBER_NAME'];
                                $oderRateSorted[$key1]['pos_name'] = $posNameMap[$value1['pos_id']];
                                $arrayRateToday[] = $oderRateSorted[$key1];
                            }
                        }
                    }
                }
            }

        }else{
            $oderRateSorted = NULL;
        }

//        echo '<pre>';
//        var_dump($arrayRateToday);
//        echo '</pre>';
//        die();

        return $arrayRateToday;

    }

    public static function sumDetail($arrayDetail,$ids,$start,$end){

        $dayArray = SiteController::actionCountDay($start,$end);
        if ($ids){
            // Tạo ra một mảng đầy đủ nếu không có Price thì vẫn có dữ liệu các máng
            foreach($ids as $id){
                foreach($dayArray as $day){
                    if(!isset($objDataByDayAll[$id][$day])){
                        $objDataByDayAll[$id][$day] = 0;
                    }
                }
            }

            if($arrayDetail){
                // lấy ra các phần tử, kiểm tra xem phần tử nào trùng khớp với ngày của mảng tổng ở trên thì cộng thêm giá trị vào vào index đó.
                foreach($arrayDetail as $key => $value){
                    foreach($objDataByDayAll as $id => $arrayPos){
                        foreach($arrayPos as $day => $value1){
                            if($value['created_at'] === $day && $value['pos_id'] == $id){
                                $objDataByDayAll[$id][$day] = $objDataByDayAll[$id][$day]+1;
                            }
                        }
                    }

                }
            }

        }else{ // Neu như không tồn tại dữ liệu thì mặc định đều bằng không hết
            foreach($dayArray as $day){
                $objDataByDayAll[$day] = 0;
            }
        }

        // Dùng để foreach Title chi tiết
        $dayDetail = SiteController::actionCountDay($start,$end,'D');

        return  $sumDetail = [
            'sum' => $objDataByDayAll,
            'allDay' => $dayDetail,
        ];
    }

    public static function priceDetail($ids,$start,$end){
        $dayArray = SiteController::actionCountDay($start,$end);
        if ($ids != NULL ) {
//            $PriceObj = Saledetail::find()
//                ->where(['Pos_Id' => array_values($ids)])
//                ->andwhere(['between','Created_At',$start,$end])
//                ->asArray()
//                ->all();

            $PriceObjSearch = new SaledetailSearch();
            $PriceObj = $PriceObjSearch->searchByTime($ids,$start,$end);

            // Tạo ra một mảng đầy đủ nếu không có Price thì vẫn có dữ liệu các máng
            foreach($ids as $id){
                foreach($dayArray as $day){
                    if(!isset($objDataByDayAll['price'][$id][$day])){
                        $objDataByDayAll['price'][$id][$day] = 0;
                    }
                    if(!isset($objDataByDayAll['order'][$id][$day])){
                        $objDataByDayAll['order'][$id][$day] = null;
                    }
                }
            }

            if($PriceObj){
                // Tạo array cho phần chú giải
                $arrayPosNotePrice = NULL;
                // Convert giá trị thời gian - id
                foreach ($PriceObj as $key1 => $value1) {
                    $PriceObj[$key1]['Created_At'] = date('Y-m-d',$value1['Created_At']->sec);
                    $PriceObj[$key1]['_id'] = $value1['_id']->__toString();
                }

                // lấy ra các phần tử, kiểm tra xem phần tử nào trùng khớp với ngày của mảng tổng ở trên thì cộng thêm giá trị vào vào index đó.
                foreach($PriceObj as $key => $value){
                    foreach($objDataByDayAll['price'] as $id => $arrayPos){
                        foreach($arrayPos as $day => $value1){
                            if($value['Created_At'] === $day && $value['Pos_Id'] == $id){
                                $objDataByDayAll['price'][$id][$day] = $value['Amount'] + $objDataByDayAll['price'][$id][$day];
                                $objDataByDayAll['order'][$id][$day][$value['Fr_Key']] = [$value['Fr_Key']];
                            }
                        }
                    }

                }


                // Đếm các phần tử của mảng sau khi đã loại đi các Fr_Key giống nhau.
                foreach($objDataByDayAll['order'] as $key =>$value){
                    foreach($value as $key1 =>$value1){
                        $objDataByDayAll['order'][$key][$key1] = count($value1);
                    }
                }

            }

            // Dùng để lấy tên các nhà hàng
            $posObj = Dmpos::find()
                ->select(['ID','POS_NAME'])
                ->where(['ID' => array_values($ids)])
                ->asArray()
                ->all();


        }else{ // Neu như không tồn tại dữ liệu thì mặc định đều bằng không hết


            foreach($dayArray as $day){
                foreach($ids as $id){
                    $objDataByDay['price'][$id][$day] = 0;
                    $objDataByDay['order'][$id][$day] = 0;
                }
            }
        }

        // Dùng để foreach Title chi tiết
        $dayDetail = SiteController::actionCountDay($start,$end,'D');



        return $data = [
            'priceDetail'=>$objDataByDayAll['price'],
            'orderDetail'=>$objDataByDayAll['order'],
            'allDay'=>$dayDetail,
            'posObj'=>$posObj,
        ];

    }

    /*Sum For Pie Chart*/
    public  function sumForPie($arrayOrderOnline,$arrayOrderOffline){
        $sumOrderOnLine = 0;
        foreach($arrayOrderOnline as $dataOneday){
            $sumOrderOnLine = array_sum($dataOneday) + $sumOrderOnLine;
        }

        $sumOrderOffLine = 0;
        foreach($arrayOrderOffline as $dataOneday){
            $sumOrderOffLine = array_sum($dataOneday) + $sumOrderOffLine;
        }

        $arrayPie = [['label' =>'Mang về','value' => $sumOrderOnLine],['label' => 'Tại chỗ','value' => $sumOrderOffLine]];
        return $arrayPie;
    }

    public static  function getMember($posIdList,$memberId){
//        echo '<pre>';
//        var_dump($memberId);
//        echo '</pre>';
        // Data khách hàng
        $posModel = new DmposSearch();
        $pos = $posModel->searchAllPosByListId($posIdList);
        $posNameMap = ArrayHelper::map($pos,'ID','POS_NAME');
        $posParent = \Yii::$app->session->get('pos_parent');

        $memberArr = array();
        $tmp = 1;
        foreach((array)$memberId as $member){
            $memberArr[$tmp]['memberName'] = @$member->Member_Name;
            $memberArr[$tmp]['member_id'] = @$member->Member_Id;
            $memberArr[$tmp]['count'] = @$member->Total_Eat_Count;
            $memberArr[$tmp]['pos_name'] = @$posNameMap[$member->Pos_Id];
            $memberArr[$tmp]['pos_id'] = @$member->Pos_Id;
            $memberArr[$tmp]['pos_parent'] = $posParent;

            if($member->Type == 1){
                $memberArr[$tmp]['type'] = "Khách cũ";
            }else{
                $memberArr[$tmp]['type'] = "Khách mới";
            }
            $tmp++;
        }

//        echo '<pre>';
//        var_dump($memberArr);
//        echo '</pre>';
//        die();
        return $memberArr;

    }
    public static  function getMemberRateDetail($posNameMap,$memberId){
        $posParent = \Yii::$app->session->get('pos_parent');
        $memberArr = array();
        $tmp = 1;
        foreach((array)$memberId as $member){
            $memberArr[$tmp]['_id'] = $tmp;
            $memberArr[$tmp]['memberName'] = @$member->Member_Name;
            $memberArr[$tmp]['member_id'] = @$member->Member_Id;
            $memberArr[$tmp]['pos_name'] = @$posNameMap[$member->Pos_Id];
            $memberArr[$tmp]['pos_id'] = @$member->Pos_Id;
            $memberArr[$tmp]['reson_note'] = @$member->Note;
            $memberArr[$tmp]['created_at'] = @$member->Created_At;
            $memberArr[$tmp]['pos_parent'] = $posParent;
            $tmp++;
        }
        return $memberArr;

    }

public function dataToday($start,$end){

    $posModelSearch = new DmposSearch();
    $posIdList = \Yii::$app->session->get('pos_id_list');
    $posObj = $posModelSearch->searchAllPosByListId($posIdList);
    $posNameMap = ArrayHelper::map($posObj,'ID','POS_NAME');


    $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];

    $name = 'ipcc/total_info_v2';
    $param = array(
        'date_start' => $start,
        'date_end' => $end,
    );

    $total_data = ApiController::getApiByMethod($name,$apiPath,$param,'POST');

//    $str = '{"data":{"Total_Amount":678504.6,"Order_Count":10,"TA_Count":5,"OTS_Count":5,"List_Revenue_Pos":[{"Pos_Id":296,"Amount":678504.6,"Order_Count":9,"TA_Count":5,"OTS_Count":4},{"Pos_Id":297,"Amount":0.0,"Order_Count":1,"TA_Count":0,"OTS_Count":1}],"Customer_Count":4,"Customer_Old":3,"Customer_New":1,"List_Member_Statics":[{"Member_Id":"84982680993","Member_Name":"dat","Total_Eat_Count":1,"Type":0,"Pos_Parent":"FOODBOOK"},{"Member_Id":"84979358808","Member_Name":"","Total_Eat_Count":1,"Type":1,"Pos_Parent":"FOODBOOK"},{"Member_Id":"84979358807","Member_Name":"Nguyễn Văn Tâm","Total_Eat_Count":1,"Type":1,"Pos_Parent":"FOODBOOK"},{"Member_Id":"84967142868","Member_Name":"Đạt","Total_Eat_Count":6,"Type":1,"Pos_Parent":"FOODBOOK"}],"Order_Rate_Info":{"total_rate":0,"avg_rate":0.0,"count_5_star":0,"count_4_star":0,"count_3_star":0,"count_2_star":0,"count_1_star":0,"count_reason_bad_food":0,"count_reason_expensive_price":0,"count_reason_bad_service":0,"count_reason_bad_shipper":0,"count_reason_other":0},"Comment_In_Fb_Count":0,"Comment_In_Rate_Count":0,"Checkin_Infos":[{"Workstation_Id":2,"Workstation_Name":"foodbook test","Total_Bill":12,"Total_Bill_CheckIn":9,"dm_pos":{"Id":296,"Phone_Number":"0967142868","Pos_Name":"Nhà Hàng Đất Xanh - Hoàng Quốc Việt","Pos_Parent":"FOODBOOK","Pos_Address":"106 Hoàng Quốc Việt, Nghĩa Đô, Cầu Giấy, Hà Nội"}},{"Workstation_Id":3,"Workstation_Name":"Thịt chó chấm mắm tôm","Total_Bill":1,"Total_Bill_CheckIn":0}],"List_Payment_Reports":[{"Payment_Name":"MOMO","Total_Amount":0.0,"Success_Count":0,"Average_Amount":0.0},{"Payment_Name":"MOCA","Total_Amount":1234500.0,"Success_Count":125,"Average_Amount":1502.23},{"Payment_Name":"ONEPAY","Total_Amount":5412100.0,"Success_Count":218,"Average_Amount":5390.32}]},"is_next":0}';
//    $total_data = json_decode($str);
//    echo '<pre>';
//    var_dump($total_data);
//    echo '</pre>';
//    die();

    $commmentName = 'ipcc/get_comments_in_fb';
    $paramCommnet = array(
        'page' => 1
    );

    $comment = ApiController::getApiByMethod($commmentName,$apiPath,$paramCommnet,'GET');
    $dataComment = array();
    if(isset($comment->data)){
        foreach((array)$comment->data as $cm){
            $dataComment[$cm->id]['member_id'] = $cm->User_Id;
            $dataComment[$cm->id]['memberName'] = @$cm->User->Member_Name;
            $dataComment[$cm->id]['pos_id'] = $cm->Pos_Id;
            $dataComment[$cm->id]['pos_name'] = $posNameMap[$cm->Pos_Id];
            $dataComment[$cm->id]['reson_note'] = $cm->Content;
            $dataComment[$cm->id]['created_at'] = $cm->Created_At;
            $dataComment[$cm->id]['pos_parent'] = \Yii::$app->session->get('pos_parent');;
        }
    }


    $memberStatics = @$total_data->data->List_Member_Statics;
//    echo '<pre>';
//    var_dump($memberStatics);
//    echo '</pre>';

    $allMember = SiteController::getMember($posIdList,$memberStatics);


    //Tính toán tổng số bill
    $checkinData = self::checkinData(@$total_data->data->Checkin_Infos);

    return $data = [
        /* Dữ liệu cho ngày hôm nay*/
        'priceToday' => @$total_data->data->Total_Amount,
        'orderToday' => @$total_data->data->Order_Count,
        'todayData' => @$total_data->data,

        'TA_Count' => @$total_data->data->TA_Count,
        'OTS_Count' => @$total_data->data->OTS_Count,
        'Comment_In_Fb_Count' => @$total_data->data->Comment_In_Fb_Count,
        'Comment_In_Rate_Count' => @$total_data->data->Comment_In_Rate_Count,

        /*Khách hàng*/
        'oldMember' => @$total_data->data->Customer_Old,
        'newMember' => @$total_data->data->Customer_New,
        'checkin_Infos' => @$total_data->data->Checkin_Infos,
        'checkinData' => $checkinData,

        'allMember' => $allMember,
        'comment' => $dataComment,


        //'Share_Facebook_Count'=> @$total_data->data->Share_Facebook_Count,
        //'List_Shared_Facebook'=> $memberShareFacebook,

        'totalRate'=> @$total_data->data->Order_Rate_Info->total_rate,
//        'rateArrayByStat'=> $rateArrayByStat,
//        'rateArrayByReson'=> $rateArrayByReson,
        'avg_rate'=> @$total_data->data->Order_Rate_Info->avg_rate,
        'oderRateSorted'=> @$total_data->data->Order_Rate_Info,

        'orderpriceDetail'=>@$total_data->data->List_Revenue_Pos,
        'posNameMap'=>$posNameMap,
    ];
}

/////////////////////////////
    public function sumPosSstatis($posId,$start,$end){
        $dataToday = self::dataToday($start,$end);

        $posModelSearch = new DmposSearch();
        $posIdList = \Yii::$app->session->get('pos_id_list');
        $posObj = $posModelSearch->searchAllPosByListId($posIdList);
        $ids = ArrayHelper::map($posObj,'POS_NAME','ID');
        $ids = array_map('intval', $ids);

        // Tính số pos
        if(count($ids) > 6){
            $countId = 6;
        }else{
            $countId = count($ids);
        }

        // Tính toán số liệu cho biểu đồ
        $dateTime = new \DateTime;
        $dateTime->sub(new \DateInterval("P7D"));
        $DAY2 = $dateTime->format( \DateTime::ISO8601 );

        $firstDAY2 = date('Y-m-d 0:0:0',(strtotime($DAY2)));
        $startDate = new \MongoDate(strtotime($firstDAY2));
        $endDate = new \MongoDate(strtotime(date('c')));

        $priceOnlineTotal = SiteController::sumSales($ids,'TA',$startDate,$endDate);

        $arrayPriceOnline = SiteController::countPrice($priceOnlineTotal['price']); //Tính  array Price Online
        $arrayOrderOnline = SiteController::countPrice($priceOnlineTotal['order']); //Tính array Order Online

        $allOerder = SiteController::sumSales($ids,NULL,$startDate,$endDate);
        $priceDetail = end($allOerder['price']); //Tính array Tinh Price
        $orderDetail = end($allOerder['order']); //Tính array Tinh Order

        $priceOfflineTotal = SiteController::sumSales($ids,'OTS',$startDate,$endDate);
        $arrayPriceOffline = SiteController::countPrice($priceOfflineTotal['price']); //Tính  array Price Offline
        $arrayOrderOffline = SiteController::countPrice($priceOfflineTotal['order']);//Tính  array  Order Offline
        // price Detail

        $arrayWishlist = SiteController::sumBookMark($ids,1,$startDate,$endDate);
        //$arrayBeenHere = SiteController::sumBookMark($ids,2,$start,$end);
        $arrayCheckin = SiteController::sumBookMark($ids,3,$startDate,$endDate);
        $arrayShareFB = SiteController::sumBookMark($ids,4,$startDate,$endDate);
//        $shareFbDetail = SiteController::sumDetail($arrayShareFB['detail'],$ids,$start,$end);

        $rateTotal = SiteController::sumRate($ids,$startDate,$endDate);

        $arrayRate = SiteController::countElementRate($rateTotal['count']);//Tính  Rate
//        echo '<pre>';
//        var_dump($arrayRate);
//        echo '</pre>';
//        die();
        $rate = 0;
        foreach ($rateTotal['count'] as $key => $value) {
            foreach ($value as $key1 => $value1) {
                $rate = count($value1) + $rate;
            }
        }

        // Tinh Order Online
        $orderPie = SiteController::sumForPie($arrayOrderOnline,$arrayOrderOffline);
        $pricePie = SiteController::sumForPie($arrayPriceOnline,$arrayPriceOffline);

        $endDayShareFB = (end($arrayShareFB['count']));

        $arrayShareFBDetail = NULL;
        $arrayMemberShareFB = NULL;

        $allMemberNameSearch = new DmmembershipSearch();
        $memberFbName = $allMemberNameSearch->searchMemberById($arrayMemberShareFB);
        $memberNameMap = ArrayHelper::map($memberFbName,'ID','MEMBER_NAME');

        $dayArray = SiteController::actionCountDay($startDate,$endDate,'D');
        foreach($dayArray as $key => $day){
            $allDay_test[]['label'] = $day;
        }


//        echo '<pre>';
//        var_dump($dataToday);
//        echo '</pre>';
//        die();

        return $data = [
            'arrayPriceOnline'=>$arrayPriceOnline,
            'arrayOrderOnline'=>$arrayOrderOnline,
            'arrayPriceOffline'=>$arrayPriceOffline,
            'arrayOrderOffline'=>$arrayOrderOffline,

            'orderPie'=>$orderPie,
            'pricePie'=>$pricePie,

            'dataToday' =>$dataToday,
            'todayData' => $dataToday['todayData'],

            /* Dữ liệu cho ngày hôm nay*/
            'priceToday' => @$dataToday['priceToday'],
            'orderToday' => @$dataToday['orderToday'],

            'TA_Count' => @$dataToday['TA_Count'],
            'OTS_Count' => @$dataToday['OTS_Count'],


            'Comment_In_Fb_Count' => @$dataToday['Comment_In_Fb_Count'],
            'Comment_In_Rate_Count' => @$dataToday['Comment_In_Rate_Count'],
            'comment' => @$dataToday['comment'],

            /*Khách hàng*/
            'oldMember' => @$dataToday['oldMember'],
            'newMember' => @$dataToday['newMember'],
            'allMember' => @$dataToday['allMember'],


            //'rate'=> $rate,
            //'scoreRateOnDay'=> $scoreRateOnDay,
            //'arrayRateToday'=> $arrayRateToday,
//            'Share_Facebook_Count'=> @$dataToday['Share_Facebook_Count'],
//            'shareFacebook'=>$shareFacebook,
            'memberNameMap'=>$memberNameMap,


            'arrayCheckin'=>$arrayCheckin['count'],
            'arrayShareFB'=>$arrayShareFB['count'],
//            'facebookDetail'=>$dataToday['List_Shared_Facebook'],
            'arrayWishlist'=>$arrayWishlist['count'],

            'arrayRate'=>$arrayRate,
            //'rateOnday'=>$rateOnday,

            'totalRate'=> @$dataToday['totalRate'],
            'avg_rate'=> @$dataToday['avg_rate'],
            'oderRateSorted'=> @$dataToday['oderRateSorted'],
//            'rateArrayByStat'=>$dataToday['rateArrayByStat'],
//            'rateArrayByReson'=>$dataToday['rateArrayByReson'],


            'priceDetail'=> $priceDetail,
            //'allDay'=>$priceDetail['allDay'],
            'orderDetail'=>$orderDetail,
            //'shareFbDetail'=>$shareFbDetail,
            'orderpriceDetail'=>@$dataToday['orderpriceDetail'],

            'posObj'=>$posObj,
            'posNameMap'=>$dataToday['posNameMap'],
            'countIds' => $countId,
            'allDay_test' => $allDay_test,
            'date_start' => $start,
            'date_end' => $end,
        ];
    }

    static function checkinData($data){
        $totalBill = 0;
        $totalBillCheckin = 0;
        foreach((array)$data as $value){
            $totalBill = $totalBill + $value->Total_Bill;
            $totalBillCheckin = $totalBillCheckin + $value->Total_Bill_CheckIn;
        }
        $checkinData = [
            'totalBill' => $totalBill,
            'totalBillCheckin' => $totalBillCheckin,
        ];
        return $checkinData;
    }

    public function sumPosSstatisAjax($posId,$start,$end){
        $dataToday = self::dataToday($start,$end);

        return $data = [
            'todayData' => @$dataToday['todayData'],
            'dataToday' => @$dataToday,
            'orderToday' => @$dataToday['orderToday'],

            'priceToday' => @$dataToday['priceToday'],

            /*Khách hàng*/
            'oldMember' => @$dataToday['oldMember'],
            'newMember' => @$dataToday['newMember'],
            'allMember' => @$dataToday['allMember'],

            'TA_Count' => @$dataToday['TA_Count'],
            'OTS_Count' => @$dataToday['OTS_Count'],
            'Comment_In_Fb_Count' => @$dataToday['Comment_In_Fb_Count'],
            'Comment_In_Rate_Count' => @$dataToday['Comment_In_Rate_Count'],
            'comment' => @$dataToday['comment'],

            'Share_Facebook_Count'=> @$dataToday['Share_Facebook_Count'],
            'facebookDetail'=> @$dataToday['List_Shared_Facebook'],

            'totalRate'=> @$dataToday['totalRate'],
            'avg_rate'=> @$dataToday['avg_rate'],
//            'rateArrayByStat'=>$dataToday['rateArrayByStat'],
//            'rateArrayByReson'=>$dataToday['rateArrayByReson'],

            'oderRateSorted'=> @$dataToday['oderRateSorted'],
            'orderpriceDetail'=>@$dataToday['orderpriceDetail'],
            'posNameMap'=>$dataToday['posNameMap'],
            'date_start'=>$start,
            'date_end'=>$end,

        ];
    }

    public function getMemberShareFacebook($posNameMap,$members){
        $posParent = \Yii::$app->session->get('pos_parent');
        $memberArr = array();
        $tmp = 1;
        foreach((array)$members as $member){
            $memberArr[$tmp]['memberName'] = $member->Member_Name;
            $memberArr[$tmp]['member_id'] = $member->Member_Id;
            $memberArr[$tmp]['count'] = $member->count;
            $memberArr[$tmp]['pos_name'] = $posNameMap[$member->Pos_Id];
            $memberArr[$tmp]['pos_id'] = $member->Pos_Id;
            $memberArr[$tmp]['pos_parent'] = $posParent;
            $tmp++;
        }
        return $memberArr;
    }

    public static function sumSales($ids,$type = null,$start,$end){
        // Lay tất cả các ngày
        $dayArray = SiteController::actionCountDay($start,$end);

        /* Get Data of SaleDetail_$month
         *
         */

        if ($ids != NULL ){
            if($type){
                $PriceObjSearch = new SaledetailSearch();
                $PriceObj = $PriceObjSearch->searchByTime($ids,$start,$end,$type);
//                Yii::error($PriceObj);
            }else{
                $PriceObjSearch = new SaledetailSearch();
                $PriceObj = $PriceObjSearch->searchByTime($ids,$start,$end);

            }

            // Tạo ra một mảng đầy đủ nếu không có Price thì vẫn có dữ liệu các máng

            foreach($ids as $id){
                foreach($dayArray as $day){
                    if(!isset($objDataByDayAll['price'][$day][$id])){
                        $objDataByDayAll['price'][$day][$id] = 0;
                    }
                    if(!isset($objDataByDayAll['order'][$day][$id])){
                        $objDataByDayAll['order'][$day][$id] = null;
                    }
                }
            }

            if($PriceObj){

                // Convert giá trị thời gian - id
                foreach ($PriceObj as $key1 => $value1) {
                    $PriceObj[$key1]['Sale_Date'] = date('Y-m-d',$value1['Sale_Date']->sec);
                    $PriceObj[$key1]['_id'] = $value1['_id']->__toString();
                }

                // lấy ra các phần tử, kiểm tra xem phần tử nào trùng khớp với ngày của mảng tổng ở trên thì cộng thêm giá trị vào vào index đó.
                foreach($PriceObj as $key => $value){
//                    echo '<pre>';
//                    var_dump($value['Amount']);
//                    echo '</pre>';
//                    die();
                    foreach($objDataByDayAll['price'] as $day => $arrayPos){
                        foreach($arrayPos as $id => $value1){
                            if($value['Sale_Date'] === $day && $value['Pos_Id'] == $id){
//                                echo '<pre>';
//                                var_dump($value['Amount'].'-'.$value['Created_At'] );
//                                echo '</pre>';
                                $objDataByDayAll['price'][$day][$id] = $value['Amount'] + $objDataByDayAll['price'][$day][$id];
                                $objDataByDayAll['order'][$day][$id][$value['Fr_Key']] = [$value['Fr_Key']];
                            }
                        }
                    }
                }

                // Đếm các phần tử của mảng sau khi đã loại đi các Fr_Key giống nhau.
                foreach($objDataByDayAll['order'] as $key =>$value){
                    foreach($value as $key1 =>$value1){
                        $objDataByDayAll['order'][$key][$key1] = count($value1);
                    }
                }
            }



        }else{ //Nếu chưa có ID nào thì sẽ trả về kết quả NULL
            foreach($dayArray as $day){
                $objDataByDayAll['price'][$day] = 0;
                $objDataByDayAll['order'][$day] = null;
            }
        }




        return $objDataByDayAll;
    }

    public function sumSalesAjax($ids,$type,$start,$end){
//        $PriceObj = Saledetail::find()
//            ->where(['Pos_Id' => array_values($ids)])
//            ->andwhere(['between','Created_At',$start,$end])
//            ->andwhere(['Tran_Id' => $type])
//            ->asArray()
//            ->all();

        $PriceObjSearch = new SaledetailSearch();
        $PriceObj = $PriceObjSearch->searchByTime($ids,$start,$end,$type);

        foreach($PriceObj as $key =>  $value){
                $PriceObj[$key]['_id'] = $value['_id']->__toString();
        }

        return $PriceObj;
    }

    public static function sumSalesAllAjax($ids,$start,$end){
//        $PriceObj = Saledetail::find()
//            ->where(['Pos_Id' => array_values($ids)])
//            ->andwhere(['between','Created_At',$start,$end])
//            ->asArray()
//            ->all();

        $PriceObjSearch = new SaledetailSearch();
        $PriceObj = $PriceObjSearch->searchByTime($ids,$start,$end);

        foreach($PriceObj as $key =>  $value){
                $PriceObj[$key]['_id'] = $value['_id']->__toString();
        }

        return $PriceObj;
    }

    public function sumBookMark($ids,$type,$start,$end){
        $dayArray = SiteController::actionCountDay($start,$end);
        $BookmarkPosObj = NULL;
        $bookMarkToday = array();
        if($ids){
            $BookmarkPosObj = Bookmarkpos::find()
                ->where(['pos_id' => array_values($ids)])
                ->andwhere(['between','created_at',$start,$end])
                ->andwhere(['type' => $type])
                ->asArray()
                ->all();


            // Tạo ra một mảng đầy đủ
            foreach($ids as $id){
                foreach($dayArray as $day){
                    if(!isset($objDataByDayAll[$day][$id])){
                        $objDataByDayAll[$day][$id] = 0;
                    }
                }
            }

            if ($BookmarkPosObj){
                $posModelBookMark = new DmposSearch();
                $posBookMark = $posModelBookMark->searchAllPosById($ids);
                $posNameBookMap = ArrayHelper::map($posBookMark,'ID','POS_NAME');
                $posParent = \Yii::$app->session->get('pos_parent');
                $allMemberFaceSearch = new DmmembershipSearch();

                // Convert giá trị thời gian - id
                foreach ($BookmarkPosObj as $key1 => $value1) {
                    $BookmarkPosObj[$key1]['created_at'] = date('Y-m-d',$value1['created_at']->sec);

                    $BookmarkPosObj[$key1]['_id'] = $value1['_id']->__toString();
                    $BookmarkPosObj[$key1]['member_id'] = $value1['user_id'];
                    $BookmarkPosObj[$key1]['pos_name'] = $posNameBookMap[$value1['pos_id']];
                    $BookmarkPosObj[$key1]['pos_parent'] = $posParent;


                    $name = $allMemberFaceSearch->searchMemberById($value1['user_id']);
                    if(isset($name[0]['MEMBER_NAME'])){
                        $BookmarkPosObj[$key1]['memberName'] = $name[0]['MEMBER_NAME'];
                    }else{
                        $BookmarkPosObj[$key1]['memberName'] = "'";
                    }
                    if($BookmarkPosObj[$key1]['created_at'] == date('Y-m-d')){
                        array_push($bookMarkToday,$BookmarkPosObj[$key1]);
                    }
                }

                // lấy ra các phần tử, kiểm tra xem phần tử nào trùng khớp với ngày của mảng tổng ở trên thì cộng thêm giá trị vào vào index đó.

                foreach($BookmarkPosObj as $key => $value1){
                    foreach($objDataByDayAll as $day => $arrayPos){
                        foreach($arrayPos as $id => $value){
//                            echo '<pre>';
//                            var_dump($value1);
//                            echo '</pre>';
//                            die();
                            if($value1['created_at'] === $day && $value1['pos_id'] == $id){
                                $objDataByDayAll[$day][$id] = $value+1;
                            }
                        }
                    }
                }

            }

            $objData = NULL;
            foreach($objDataByDayAll as $day => $values){
                foreach($values as $key => $value1)
                    if(!isset($objData[$day])){
                        $objData[$day] = [date('D', strtotime($day)),$value1,(string)$value1];
                    }else{
                        array_push($objData[$day],$value1,(string)$value1);
                    }
            }
        }else{
            foreach($dayArray as $day){
                if(!isset($objDataByDayAll[$day])){
                    $objDataByDayAll[$day] = 0;
                }
            }
        }


        // Sum các giá trị của các ngày lại
        foreach((array)$objDataByDayAll as $day =>$arrayPos){
            if($arrayPos){
                $objDataByDay[]['value'] = array_sum($arrayPos);
            }else{
                $objDataByDay[]['value'] = 0;
            }

        }

//        echo '<pre>';
//        var_dump($bookMarkToday);
//        echo '</pre>';

        return $arrayElementBookMark = [
            'count' => array_values($objDataByDay),
            'detail' => $bookMarkToday,
        ];
    }
    public function sumBookMarkAjax($ids,$type,$start,$end){
        $dayArray = SiteController::actionCountDay($start,$end);
        $BookmarkPosObj = NULL;
        if($ids){
            $BookmarkPosObj = Bookmarkpos::find()
                ->where(['pos_id' => array_values($ids)])
                ->andwhere(['between','created_at',$start,$end])
                ->andwhere(['type' => $type])
                ->asArray()
                ->all();


            // Tạo ra một mảng đầy đủ
            foreach($ids as $id){
                foreach($dayArray as $day){
                    if(!isset($objDataByDayAll[$day][$id])){
                        $objDataByDayAll[$day][$id] = 0;
                    }
                }
            }

            if ($BookmarkPosObj){
                $posModelBookMark = new DmposSearch();
                $posBookMark = $posModelBookMark->searchAllPosById($ids);
                $posNameBookMap = ArrayHelper::map($posBookMark,'ID','POS_NAME');
                $posParent = \Yii::$app->session->get('pos_parent');
                $allMemberFaceSearch = new DmmembershipSearch();

                // Convert giá trị thời gian - id
                foreach ($BookmarkPosObj as $key1 => $value1) {
                    $BookmarkPosObj[$key1]['created_at'] = date('Y-m-d',$value1['created_at']->sec);

                    $BookmarkPosObj[$key1]['_id'] = $value1['_id']->__toString();
                    $BookmarkPosObj[$key1]['member_id'] = $value1['user_id'];
                    $BookmarkPosObj[$key1]['pos_name'] = $posNameBookMap[$value1['pos_id']];
                    $BookmarkPosObj[$key1]['pos_parent'] = $posParent;


                    $name = $allMemberFaceSearch->searchMemberById($value1['user_id']);
                    if(isset($name[0]['MEMBER_NAME'])){
                        $BookmarkPosObj[$key1]['memberName'] = $name[0]['MEMBER_NAME'];
                    }else{
                        $BookmarkPosObj[$key1]['memberName'] = "'";
                    }
                }

                // lấy ra các phần tử, kiểm tra xem phần tử nào trùng khớp với ngày của mảng tổng ở trên thì cộng thêm giá trị vào vào index đó.

                foreach($BookmarkPosObj as $key => $value1){
                    foreach($objDataByDayAll as $day => $arrayPos){
                        foreach($arrayPos as $id => $value){
//                            echo '<pre>';
//                            var_dump($value1);
//                            echo '</pre>';
//                            die();
                            if($value1['created_at'] === $day && $value1['pos_id'] == $id){
                                $objDataByDayAll[$day][$id] = $value+1;
                            }
                        }
                    }
                }

            }

            $objData = NULL;
            foreach($objDataByDayAll as $day => $values){
                foreach($values as $key => $value1)
                    if(!isset($objData[$day])){
                        $objData[$day] = [date('D', strtotime($day)),$value1,(string)$value1];
                    }else{
                        array_push($objData[$day],$value1,(string)$value1);
                    }
            }
        }else{
            foreach($dayArray as $day){
                if(!isset($objDataByDayAll[$day])){
                    $objDataByDayAll[$day] = 0;
                }
            }
        }


        // Sum các giá trị của các ngày lại
        foreach((array)$objDataByDayAll as $day =>$arrayPos){
            if($arrayPos){
                $objDataByDay[]['value'] = array_sum($arrayPos);
            }else{
                $objDataByDay[]['value'] = 0;
            }

        }


        return $arrayElementBookMark = [
            'count' => array_values($objDataByDay),
            'detail' => $BookmarkPosObj,
        ];
    }



    public function sumRate($ids,$start,$end){
        $rateSearchModel = new OrderrateSearch();
        $RateObj = $rateSearchModel->searchAllRateByTime($ids,$start,$end);

        $dayArray = SiteController::actionCountDay($start,$end);
        $objDataByDay = NULL;

        $objDataByDayAll = array();
        foreach($ids as $id){
            foreach($dayArray as $day){
                if(!isset($objDataByDayAll[$day][$id])){
                    $objDataByDayAll[$day][$id] = 0;
                }
            }
        }

        if ($RateObj) {
            foreach ($RateObj as $key1 => $value1) {
                $RateObj[$key1]['created_at'] = date('Y-m-d',$value1['created_at']->sec);
                $RateObj[$key1]['_id'] = $value1['_id']->__toString();
            }


        }

        foreach((array)$objDataByDayAll as $day => $arrayPos){
            foreach($arrayPos as $id => $value1){
                $tmp = 0;
                foreach($RateObj as $key => $value){
                    if($value['created_at'] === $day && $value['pos_id'] == $id){
                        $objDataByDayAll[$day][$id] = $value['score'] + $objDataByDayAll[$day][$id];
                        $tmp++;
                    }
                }
                if($tmp){
                    $objDataByDayAll[$day][$id] = $objDataByDayAll[$day][$id]/$tmp;
                }
            }
        }
//        echo '<pre>';
//        var_dump($objDataByDayAll);
//        echo '</pre>';
//        die();


        $objDataByDay['detail'] = ArrayHelper::map($RateObj,'_id','member_id');


        $objDataByDay['full'] = $RateObj;
        $objDataByDay['count'] = $objDataByDayAll;

        return $objDataByDay;
    }


    public function sumRateAjax($ids,$start,$end){
        $RateObj = Orderrate::find()
            ->select(['_id','className','pos_id','pos_parent','member_id','created_at','score','reson_bad_food','reson_expensive_price','reson_bad_service','reson_bad_shipper','reson_other','reson_note','published'])
            ->where(['pos_id' => array_values($ids)])
            ->andwhere(['between','created_at',$start,$end])
            ->andwhere(['>','score',0])
            ->asArray()
            ->all();


        return $RateObj;
    }


    public function actionStatistics($dateRanger = null){

        //$DAY1 =  $dateTime->format( \DateTime::ISO8601 );

        $posId = \Yii::$app->session->get('pos_id_list');
        if($dateRanger){
            $arrTime = explode("-",$dateRanger);
            $date_start_tmp = str_replace('/', '-', $arrTime[0]);
            $date_start = date("Y-m-d", strtotime($date_start_tmp));

            $date_end_tmp = str_replace('/', '-', $arrTime[1]);
            $date_end = date("Y-m-d", strtotime($date_end_tmp));
//            $start = new \MongoDate(strtotime($date_start));
//            $end = new \MongoDate(strtotime($date_end));

            $data = SiteController::sumPosSstatisAjax($posId,$date_start,$date_end);
        }else{
            $date_end = date("Y-m-d");
            $date_start = date('Y-m-d');
            $data = SiteController::sumPosSstatis($posId,$date_start,$date_end);


//        echo '<pre>';
//        var_dump($data);
//        echo '</pre>';
//        die();
        }

        return $data;
    }


    public function actionIndex()
    {

        $post = Yii::$app->request->post();
        $type = \Yii::$app->session->get('type_acc');
        Yii::info($type);
        if($type != 1){
            $posIdModel = new DmposSearch();
            $posId = $posIdModel->getIds();
            if($posId){
                if($post){
                    $data = SiteController::actionStatistics($post['dateRanger']);
                    $data['dateTextLabel'] = $post['dateTextLabel'];
                    if($post['dateTextLabel'] === 'Tùy chọn'){
                        $post['dateTextLabel'] = $post['dateRanger'];
                    }
                    $data['dateTextLabel'] = $post['dateTextLabel'];
                    $data['checkAjax'] = 1;
                    return $this->renderPartial('_form_today',$data);
                }else{
                    $data = SiteController::actionStatistics();

                    $data['dateTextLabel'] = 'Hôm nay';

                    return $this->render('index',$data);
                }
            }else{
                return $this->render('null_pos');
            }

        }else{
            return UsermanagerController::redirect('index.php?r=dmitem/itemsupdate','302');
            //return UsermanagerController::redirect('/dmitem/itemsupdate','302');
        }

    }

    public function actionPushnote()
    {
        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $param = [
                'content' => $post['noidung'],
                'url' => $post['url']
            ];
            $apiPath = Yii::$app->params['CMS_API_PATH'];
            $type = 'push_notify';
            $access_token = Yii::$app->params['ACCESS_TOKEN'];

            $result = ApiController::actionCallApiByPost($param,$apiPath,$type,$access_token);

            if(isset($result->data)){
                Yii::$app->getSession()->setFlash('success', 'Chúc mừng bạn đã gửi tin nhắn thành công!!');
            }else if($result->error) {
                Yii::$app->getSession()->setFlash('error', $result->error->message);

            }
            return $this->redirect(['pushnote'],302);

        } else {
            return $this->render('pushnote');
        }
    }


    public function actionResetpassword()
    {
        $model = new User();
        if ($model->load(Yii::$app->request->post())) {
            $modelSearch = new UserSearch();
            $modelSeach = $modelSearch->searchUserbyPPandUserEmail(strtoupper($model->POS_PARENT),$model->USERNAME,$model->EMAIL);

            if($modelSeach){
                $AUTH_KEY = strtoupper(substr(md5(rand()), 0, 6));
                $sendEmail = \Yii::$app->mailer->compose('hellomail', ['private_key' => $AUTH_KEY])
                    ->setFrom(['mobile@ipos.vn' => 'iPOS.vn'])
                    ->setTo($model->EMAIL)
                    ->setSubject('Email gửi mã code lấy lại mật khẩu ' )
                    ->send();
                Yii::error($model);

                if($sendEmail) {
                    $key = 'resetPass_' . $model->POS_PARENT . '_' . $model->USERNAME;
                    //$keyResetPassword = \Yii::$app->cache->get($key);
                    //if ($keyResetPassword === false) {
                    \Yii::$app->cache->set(sha1($key), $AUTH_KEY, 7200); // time in seconds to store cache
                    //}
                    return $this->redirect(['renewpassword',
                        'email' => $model->EMAIL,
                        'public_code' => sha1($key),
                        'pos_parent' => $model->POS_PARENT,
                        'username' => $model->USERNAME,
                    ]);

                }

            }else{
                    return 300;
//                return $this->render('resetpassword', [
//                    'model' => $model,
//                ]);
            }


//
//            if($sendEmail){
//                $model->save();
//            }else{
//
//            }
//
//            die();


            //Get Accetoken user
//            $param = [
//                'pos_parent' => $model->POS_PARENT,
//                'username' => $model->USERNAME,
//                'email' => $model->EMAIL
//            ];  //'msisdn' => (int)$model->user_id,
//            $apiPath = Yii::$app->params['CMS_API_PATH_IPOS_MOBILE'];
//            $type = 'auth/manager_forget_pwd_pre';
//            $access_token = Yii::$app->params['ACCESS_TOKEN'];
//            $dataCode = ApiController::actionCallApiByPost($param,$apiPath,$type,$access_token);

//            echo '<pre>';
//            var_dump($dataCode);
//            echo '</pre>';
//            die();

//            if(isset($dataCode->data)){
//                return $this->redirect(['renewpassword',
//                    'email' => $dataCode->data->email,
//                    'public_code' => $dataCode->data->public_code,
//                    'pos_parent' => $model->POS_PARENT,
//                    'username' => $model->USERNAME,
//                ]);
//            }else{
//                //return $this->redirect(\Yii::$app->urlManager->createUrl("site/resetpassword"));
//                return $this->render('resetpassword', [
//                    'model' => $model,
//                ]);
//            }

        } else {

            return $this->render('resetpassword', [
                'model' => $model,
            ]);
        }
    }


    public function actionRenewpassword($email,$public_code,$pos_parent,$username)
    {
        $modelSearch = new UserSearch();
        $model = $modelSearch->searchUserbyPPandUser($pos_parent,$username);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            //$key = 'resetPass_' . $model->POS_PARENT . '_' . $model->USERNAME;
            $keyResetPassword = \Yii::$app->cache->get($public_code);
            if(strcasecmp($keyResetPassword,$model->AUTH_KEY) == 0){
                //Yii::error($model->newpass);
                $password_generate = $model->USERNAME.strtoupper($model->POS_PARENT).'YG4BQ0FYMD'.$model->newpass;
                $model->PASSWORD_HASH = Yii::$app->getSecurity()->generatePasswordHash($password_generate);
                if($model->save()){
//                    $modelLogin = new \common\models\User();
//                    $modelLogin->pos_parent = $model->POS_PARENT;
//                    $modelLogin->username = $model->USERNAME;

                    //Yii::$app->session->setFlash('success', 'Đổi mật khẩu thành công');
//                    return $this->render('login', [
//                        'model' => $model,
//                    ]);

                    return $this->redirect(['congratulation','meseage' => 'Đặt lại mật khẩu']);

                }else{
                    Yii::$app->session->setFlash('error', 'Đổi mật khẩu lỗi');
                    return $this->render('renewpassword', [
                        'model' => $model,
                        'public_code' => $public_code,
                    ]);
                }
            }else{

                $model->addError('AUTH_KEY', "Mã xác nhận không đúng");

                return $this->render('renewpassword', [
                    'model' => $model,
                    'public_code' => $public_code,
                ]);
            }
        } else {
            $model->POS_PARENT = $pos_parent;
            $model->USERNAME = $username;
            $model->EMAIL = $email;
            $model->AUTH_KEY = '';
            return $this->render('renewpassword', [
                'model' => $model,
                'public_code' => $public_code,
            ]);
        }
    }

    public function actionCongratulation($meseage){
        return $this->render('congratulation',['meseage' => $meseage]);
    }


    public function actionGetcommentinrateloadmore($page = 1,$commentType = 'get_comments_in_rate'){
        $posModelSearch = new DmposSearch();
        $posIdList = \Yii::$app->session->get('pos_id_list');
        $posObj = $posModelSearch->searchAllPosByListId($posIdList);
        $posNameMap = ArrayHelper::map($posObj,'ID','POS_NAME');
        $apiPath = Yii::$app->params['CMS_API_PATH_IPOS'];
        $comments_in_rate = 'ipcc/'.$commentType;
        $param_comments_in_rate = array(
            'page' => $page
        );

        $comment = ApiController::getApiByMethod($comments_in_rate,$apiPath,$param_comments_in_rate,'GET');

        $dataComment = array();
        if(isset($comment->data)){
            foreach((array)$comment->data as $cm){
                $dataComment[$cm->id]['member_id'] = $cm->member_id;
                $dataComment[$cm->id]['memberName'] = $cm->dmMember->Member_Name;
                $dataComment[$cm->id]['pos_id'] = $cm->pos_id;
                $dataComment[$cm->id]['pos_name'] = $posNameMap[$cm->pos_id];
                $dataComment[$cm->id]['reson_note'] = $cm->reason_note;
                $dataComment[$cm->id]['created_at'] = $cm->created_at;
                $dataComment[$cm->id]['pos_parent'] = $cm->pos_parent;
            }
        }
//        echo '<pre>';
//        var_dump($page);
//        echo '</pre>';
        $page++;
        /*echo '<pre>';
        var_dump($page);
//        var_dump($comment->is_next);
        echo '</pre>';*/
        return $this->renderPartial('commentdetail_form',[
            'comment' => $dataComment,
            'is_next' => @$comment->is_next,
            'curentpage' => $page
        ]);
//        return json_encode(array_values((array)$dataComment));
    }



    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
//            echo '<pre>';
//            var_dump($model);
//            echo '</pre>';
//            die();
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
