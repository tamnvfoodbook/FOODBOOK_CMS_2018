<?php
use kartik\checkbox\CheckboxX;

/* @var $this yii\web\View */
/* @var $model backend\models\Pmemployee */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="form-group">
    <label class="cbx-label" for="kv-adv-8">
        <?= CheckboxX::widget([
            'name' => 'kv-adv-8',
            'initInputType' => CheckboxX::INPUT_CHECKBOX,
            'options'=>['id'=>'kv-adv-8'],
            'pluginOptions' => [
                'theme' => 'krajee-flatblue',
                'enclosedLabel' => true
            ]
        ]); ?>
        Default
    </label>
</div>