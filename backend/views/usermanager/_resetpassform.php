<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
//echo '<pre>';
//var_dump($model->pos_id_list);
//$ipPos = explode(",", $model->pos_id_list);
//var_dump($ipPos);
//echo '</pre>';
//die();
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'action' => 'index.php?r=usermanager/resetpw',
    ]);?>

    <?= $form->field($model, 'newpass')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'repeatnewpass')->passwordInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


