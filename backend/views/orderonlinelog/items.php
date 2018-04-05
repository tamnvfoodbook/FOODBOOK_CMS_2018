
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 12/21/2015
 * Time: 10:29 AM
 */
//$posId = (int)$posId;
//echo '<pre>';
//var_dump($posId);
//echo '</pre>';
//die();

$itemType = NULL;

$itemType = \backend\models\Dmitem::find()
    ->select(['ID','ITEM_IMAGE_PATH','ITEM_IMAGE_PATH_THUMB','ITEM_NAME','TA_PRICE','OTS_PRICE','ITEM_TYPE_ID','DESCRIPTION'])
    ->where(['ACTIVE'=> 1])
    ->andWhere(['POS_ID' => (int)$posId])
    ->andWhere(['like','ITEM_TYPE_ID',$posIdCategory])
    ->asArray()
    ->all();

//echo '<pre>';
//var_dump($itemType);
//echo '</pre>';
//die();

foreach($itemType as $pos){
    //echo $pos['ITEM_NAME'];
  echo '<input type="hidden" pimage="'.$pos["ITEM_IMAGE_PATH_THUMB"].'" pprice="'.$pos["TA_PRICE"].'" pname="'.$pos["ITEM_NAME"].'" pcategory="'.$pos["ITEM_TYPE_ID"].'" pdesc="'.$pos["DESCRIPTION"].'"  pid="'.$pos["ITEM_NAME"].'">';
}
