<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\COUPONLOG */

$this->title = 'Create Couponlog';
$this->params['breadcrumbs'][] = ['label' => 'Couponlogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$type = \Yii::$app->session->get('type_acc');

?>
<div class="couponlog-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
        if($type ==1){
            echo $this->render('_form', [
                'model' => $model,
                'posNameMap' => $posNameMap,
                'posNameUserMap' => $posNameUserMap,
                'couponList' => $couponList,
                'posParentMap' => $posParentMap,
                'couponType' => $couponType,
            ]);
        }else{
            $posIdListSes = \Yii::$app->session->get('pos_id_list');
            if($posIdListSes == NULL || $posIdListSes == ''){
                echo $this->render('_form_posparent', [
                    'model' => $model,
                    'posNameMap' => $posNameMap,
                    'posNameUserMap' => $posNameUserMap,
                    'couponList' => $couponList,
                    'posParentMap' => $posParentMap,
                    'couponType' => $couponType,
                ]);
            }else{
                echo $this->render('_form_pos', [
                    'model' => $model,
                    'posNameMap' => $posNameMap,
                    'posNameUserMap' => $posNameUserMap,
                    'couponList' => $couponList,
                    'posParentMap' => $posParentMap,
                    'couponType' => $couponType,
                ]);
            }

        }
     ?>

</div>
