<?php

use yii\widgets\DetailView;

if($model->created_at){
    $created_at = date(Yii::$app->params['DATE_TIME_FORMAT'],strtotime($model->created_at));
}else{
    $created_at = $model->created_at;
}
?>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'order_data_item',
        [
            'attribute' => 'created_at',
            'value' => $created_at
        ],
        [
            'attribute' => 'status',
            'value' => Yii::t('yii',$model->status)
        ],
        'pos_id',
        //'duration',
        'to_address',

        //'distance',
        //'total_fee',
    ],
]) ?>

<?= \yii\helpers\Html::hiddenInput('lastorder',json_encode($model->oldAttributes))?>
