<?php

namespace backend\controllers;
use backend\models\DmmembershipSearch;
use backend\models\Dmpos;
use backend\models\DmposSearch;
use backend\models\Dmposstats;
use backend\models\Bookmarkpos;
use Yii;
use yii\helpers\ArrayHelper;

class TopController extends \yii\web\Controller
{
    public function actionIndex($top = null,$bottom = null)
    {
        $data = TopController::actionStatisticsTop($top,$bottom);
        return $this->render('index',$data);
    }

    public function sumDetailTop($priceOnlineTotaL,$ids,$type){
        $arrayDataByPos = NULL;
        foreach($priceOnlineTotaL as $day => $value){
            foreach($ids as $id){
                    $arrayDataByPos[$id][]['value'] = (int)$value[$id];
            }
        }

        $data = NULL;
        $tmp = 1;
        foreach($arrayDataByPos as $id => $value){
            $data[$id]['seriesname'] = '';
            // Xử lý đếm đơn hàng
            switch ($tmp) {
                case 1:
                    $data[$id]['color'] = '00c0ef';
                    break;
                case 2:
                    $data[$id]['color'] = 'dd4b39';
                    break;
                case 3:
                    $data[$id]['color'] = 'f39c12';
                    break;
                case 4:
                    $data[$id]['color'] = '00a65a';
                    break;
                case 5:
                    $data[$id]['color'] = 'a60c80';
                    break;
                case 6:
                    $data[$id]['color'] = '337ab7';
                    break;
                default:
                    break;

            }//End xử lý đếm đơn hàng

            $data[$id]['data'] = $value;
            $tmp++;
        }

        return  array_values($data);
    }

    public function bookMarkTop($ids,$type,$start,$end){
        $dayArray = SiteController::actionCountDay($start,$end);

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

            if ($BookmarkPosObj) {
                // Convert giá trị thời gian - id
                foreach ($BookmarkPosObj as $key1 => $value1) {
                    $BookmarkPosObj[$key1]['created_at'] = date('Y-m-d',$value1['created_at']->sec);
                    $BookmarkPosObj[$key1]['_id'] = $value1['_id']->__toString();
                }

                // lấy ra các phần tử, kiểm tra xem phần tử nào trùng khớp với ngày của mảng tổng ở trên thì cộng thêm giá trị vào vào index đó.
                foreach($BookmarkPosObj as $key => $value1){
                    foreach($objDataByDayAll as $day => $arrayPos){
                        foreach($arrayPos as $id => $value){
                            if($value1['created_at'] === $day && $value1['pos_id'] == $id){
                                $objDataByDayAll[$day][$id] = $value+1;
                            }
                        }
                    }

                }
            }


            $data = TopController::sumDetailTop($objDataByDayAll,$ids,NULL);
//            echo '<pre>';
//            var_dump($data);
//            echo '</pre>';
//            die();

        }else{
            foreach($dayArray as $day){
                if(!isset($objDataByDayAll[$day])){
                    $objDataByDayAll[$day] = 0;
                }
            }
        }



        return $arrayElementBookMark = [
            'count' => $data,
            'detail' => $BookmarkPosObj,
        ];
    }

    public function actionSumOrtherTop($modelSum){

        $total = 0;
        foreach($modelSum as $value){
            $total = array_sum($value)/2 + $total;
        }
        return $total;
    }

    public function sumBookMarkTop($priceOnlineTotaL){
        // Get name Pos_id
        $priceDetail = NULL;
        foreach ($priceOnlineTotaL as $key => $value){
            foreach($value as $key1 => $value1){
                if($key1 == 0){
                    $priceDetail[$key][0] = $value1;
                }else{
                    array_push($priceDetail[$key], (int)$value1,(string)$value1);
                }
            }
        }
        return  $priceDetail;
    }

    public function actionStatisticsTop($top,$bottom){

        $startDateTime = date("Y-m-d 00:00:00", strtotime("-7 days"));
        $endDateTime = date("Y-m-d H:i:s");
        $start = new \MongoDate(strtotime($startDateTime));
        $end = new \MongoDate(strtotime($endDateTime));


        $posSearch = new DmposSearch();
        $posIdArr = $posSearch->getIds();
        $pos = $posSearch->searchAllPosById($posIdArr);
        $idMaps = ArrayHelper::map($pos,'POS_NAME','ID');
        $ids = array_map('intval',$idMaps);

        $posNameMap = ArrayHelper::map($pos,'ID','POS_NAME');


        // Lấy doanh thu để so sánh.
        $priceDetail = SiteController::priceDetail($ids,$start,$end);


        // Lấy tổng doanh thu của một chi nhánh.
        $sortArray = NULL;
        foreach ($priceDetail['priceDetail'] as $key => $value) {
            $sortArray[$key] = (int)array_sum($value);
        }


        // Lấy tổng hóa đơn của một chi nhánh (Lấy cho chú giải)
        $sumOrderNote = NULL;
        foreach ($priceDetail['orderDetail'] as $key => $value) {
            $sumOrderNote[$key] = (int)array_sum($value);
        }

        $idRank = NULL;
        if ($top) {
            arsort($sortArray, SORT_NUMERIC);// sap xep mang theo thu tu giam dan
            $priceRank = array_slice($sortArray, 0,$top,true);// Cat so luong phan tu theo lua chon top

            // Lấy Id các chi nhánh
            foreach($priceRank as $key => $value){
                $idRank[] = (int)$key;
            }
        }else if ($bottom){
            asort($sortArray, SORT_NUMERIC);// sap xep mang theo thu tu tăng dan
            $priceRank = array_slice($sortArray, 0,$bottom,true);// Cat so luong phan tu theo lua chon top

            foreach($priceRank as $key => $value){
                $idRank[] = (int)$key;
            }
        }else{
            $idRank = $ids;
            $priceRank = $sortArray;
        }


        $priceOnlineTotal = SiteController::sumSales($idRank,'TA',$start,$end);

        $arrayPriceOnline = TopController::sumDetailTop($priceOnlineTotal['price'],$idRank,'price');

        $arrayOrderOnline = TopController::sumDetailTop($priceOnlineTotal['order'],$idRank,'order');

        $priceOfflineTotal = SiteController::sumSales($idRank,'OTS',$start,$end);
        $arrayPriceOffline = TopController::sumDetailTop($priceOfflineTotal['price'],$idRank,'price');
        $arrayOrderOffline = TopController::sumDetailTop($priceOfflineTotal['order'],$idRank,'order');

        $arrayWishlist = TopController::bookMarkTop($idRank,1,$start,$end);


        $priceAllTotal = SiteController::sumSales($idRank,null,$start,$end);

        $priceDetail = end($priceAllTotal['price']); //Tính array Tinh Price
        $orderDetail = end($priceAllTotal['order']); //Tính array Tinh Order




        $orderpriceDetail = array();


        foreach($priceDetail as $id => $value){
            foreach($orderDetail as $id1 => $value1){
                if($id === $id1){
                    $orderpriceDetail[$id]['order'] = $value1;
                    $orderpriceDetail[$id]['price'] = $value;
                    break;
                }
            }
        }


        $priceTotal = SiteController::sumSalesAllAjax($ids,$start,$end);




        $memberId = array();
        foreach($priceTotal as $value){
            if(date("Ymd",$value['Sale_Date']->sec) == date('Ymd')){ //Chec
                $memberId[$value['Membership_Id'].'-'.$value['Pos_Id']] = (string)$value['Membership_Id'];
            }
        }


        // Lấy dữ liệu khách hàng
        $allMember = SiteController::getMember($ids,$memberId);


        //$arrayBeenHere = SiteController::sumBookMark($idRank,2,$start,$end);
        //$arrayBeenHere = SiteController::sumDetailTop($beenHere,$idRank,'order');

        //$arrayCheckin = SiteController::sumBookMark($idRank,3,$start,$end);
        //$arrayCheckin = SiteController::sumDetailTop($checkin,$idRank,'order');

        $arrayShareFB = TopController::bookMarkTop($idRank,4,$start,$end);

        $shareFbDetail = SiteController::sumDetail($arrayShareFB['detail'],$ids,$start,$end);


        $arrayShareFBDetail = array();
        $arrayMemberShareFB = array();
        foreach($arrayShareFB['detail'] as $value){
            if($value['created_at'] === date('Y-m-d')){
                if(isset($arrayShareFBDetail[(string)$value['user_id']])){
                    $arrayShareFBDetail[(string)($value['user_id'])] ++ ;
                }else{
                    $arrayMemberShareFB[$value['user_id']] = $value['user_id'];
                    $arrayShareFBDetail[(string)($value['user_id'])] = 1;
                }

            }
        }


        $shareFacebook = count($arrayShareFB['detail']);

        $allMemberNameSearch = new DmmembershipSearch();
        $memberFbName = $allMemberNameSearch->searchMemberById($arrayMemberShareFB);
        $memberNameMap = ArrayHelper::map($memberFbName,'ID','MEMBER_NAME');




        $rateTotal = SiteController::sumRate($idRank,$start,$end);
        $arrayRate = TopController::sumDetailTop($rateTotal['count'],$idRank,'order');



        $oderRateSorted = SiteController::ratingDetail($rateTotal['full'],$rateTotal['detail']);



        // Tinh Order Online
        $orderOnline = TopController::actionSumOrtherTop($arrayOrderOnline);
        // Tinh Order Offline
        $orderOffline = TopController::actionSumOrtherTop($arrayOrderOffline);
        // Tinh Price Online
        $priceOnline = TopController::actionSumOrtherTop($arrayPriceOnline);
        // Tinh Price Offline
        $priceOffline = TopController::actionSumOrtherTop($arrayPriceOffline);

        // Tinh Rate
        $scoreRate = array_sum(end($rateTotal['count']));

//        echo '<pre>';
//        var_dump($scoreRate);
//        echo '</pre>';
//        die();

        // Tính toán số liệu cho phần chú giải
        $arrayNote = NULL;
        foreach($priceRank as $idPrice => $valuePrice){
            foreach($ids as $name => $id){
                foreach($sumOrderNote as $idOrder => $valueOrder){
                    if($id === $idPrice && $id === $idOrder){
                        $arrayNote[$name] = number_format($valuePrice).' đ /'.$valueOrder.' đơn hàng';
                    }
                }
            }
        }

//        echo '<pre>';
//        var_dump($sumOrderNote);
//        echo '</pre>';
//        die();


        $model = new Dmposstats();

        $dayArray = SiteController::actionCountDay($start,$end,'D');
        foreach($dayArray as $key => $day){
            $allDay[]['label'] = $day;
        }

        $orderOnToday = array_sum(end($priceOnlineTotal['order']));
        $orderOffToday = array_sum(end($priceOfflineTotal['order']));



        $priceOnToday = array_sum(end($priceOnlineTotal['price']));
        $priceOffToday = array_sum(end($priceOfflineTotal['price']));

        if(count($ids) >6){
            $maxNumber = 6;
        }else{
            $maxNumber = count($ids);
        }

//        echo '<pre>';
//        var_dump($arrayPriceOnline);
//        echo '</pre>';
//        die();

        return $data = [
            'arrayPriceOnline'=>$arrayPriceOnline,
            'arrayOrderOnline'=>$arrayOrderOnline,
            'arrayPriceOffline'=>$arrayPriceOffline,
            'arrayOrderOffline'=>$arrayOrderOffline,
            'orderpriceDetail'=>$orderpriceDetail,

            /* Dữ liệu cho ngày hôm nay*/
            'orderOnToday' => $orderOnToday,
            'orderOffToday' => $orderOffToday,
            'priceOnToday' => $priceOnToday,
            'priceOffToday' => $priceOffToday,


            'orderOffline'=>$orderOffline,
            'orderOnline'=>$orderOnline,
            'priceOffline'=>$priceOffline,
            'priceOnline'=>$priceOnline,
            'scoreRate'=>$scoreRate,

            'oldMember' => $allMember['oldMember'],
            'newMember' => $allMember['newMember'],
            'memberName' => $allMember['memberName'],


            //'arrayCheckin'=>$arrayCheckin,
            'arrayShareFB'=>$arrayShareFB['count'],
            'facebookDetail'=>$arrayShareFBDetail,
            'arrayWishlist'=>$arrayWishlist['count'],
            'memberNameMap'=>$memberNameMap,

            'arrayRate'=>$arrayRate,

            'posNameMap'=>$posNameMap,

            'arrayNote'=>$arrayNote, // Phục vụ cho chú giải các nhà hàng

            'oderRateSorted'=>$oderRateSorted,
            //'priceDetail'=> $priceDetail['priceDetail'],
            'allDay'=>$allDay,
            //'orderDetail'=>$priceDetail['orderDetail'],
            'shareFbDetail'=>$shareFbDetail ,
            'shareFacebook'=>$shareFacebook ,

            'model'=>$model,
            'idRank'=>$idRank,
            'ids'=>$ids,
            'top' => $top,
            'bottom' => $bottom,
            'maxNumber' => $maxNumber,
        ];
    }

}
