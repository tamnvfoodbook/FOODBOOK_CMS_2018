<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Wmitemimagelist */
//echo '<pre>';
//var_dump($POS_ID);
//echo '</pre>';
//die();

$this->title = 'Tạo ảnh';
$type = \Yii::$app->session->get('type_acc');
if($type ==1){
    $this->params['breadcrumbs'][] = ['label' => 'Nhà hàng', 'url' => ['dmpositem/index']];
}
$this->params['breadcrumbs'][] = ['label' => 'Danh sách ảnh', 'url' => ['index','id' => $model->POS_ID]];
//$this->params['breadcrumbs'][] = ['label' => 'Danh sách ảnh', 'url' => ['index','id'=>$model->ID]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wmitemimagelist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'allPosMap' => $allPosMap,
    ]) ?>

</div>
