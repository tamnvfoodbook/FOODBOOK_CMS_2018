<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\models\DMPOS;
?>

<?php
$posId = \Yii::$app->session->get('pos_id_list');
$posParent = \Yii::$app->session->get('pos_parent');
$arrayPosId = (explode(',', $posId));
// Phan quyen
if ($posId == null){
    $arrayPosId = null;
    $tmparrayPosId = DMPOS::find()
        ->select(['ID','POS_NAME'])
        ->where(['POS_PARENT' => $posParent])
        ->asArray()
        ->all();
    $arrayPos = ArrayHelper::map($tmparrayPosId,'ID','POS_NAME');
}else{
    $tmparrayPosId = DMPOS::find()
        ->select(['ID','POS_NAME'])
        ->where(['ID' => $arrayPosId])
        ->asArray()
        ->all();
    $arrayPos = ArrayHelper::map($tmparrayPosId,'ID','POS_NAME');

}

?>


<?= Html::beginForm(); ?>	
    <?= Html::dropDownList('possource','text',$arrayPos,
        ['options' =>
            [
                'class' => 'selectpicker'
            ]
    ]) ?>
    <?= Html::dropDownList('postaget','text',$arrayPos,
        ['options' =>
            [
                'class' => 'selectpicker'
            ]
    ]) ?>

    <?= Html::a('So sánh', 'index.php?r=top', [
        'data' => [
            'method' => 'post',
            'params' => [
                'action' => 'createNew',             
            ]
        ]
    ])?>
<?= Html::endForm(); ?>