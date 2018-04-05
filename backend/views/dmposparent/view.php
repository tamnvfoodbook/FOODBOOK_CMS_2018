<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;

use backend\assets\AppAsset;
AppAsset::register($this);

$this->registerJsFile('plugins/jQuery/jQuery-2.1.4.min.js',  ['position' => \yii\web\View::POS_HEAD]);

/* @var $this yii\web\View */
/* @var $model backend\models\Dmposparent */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Dmposparents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmposparent-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary']) ?>
        <a href="#" class="btn btn-danger" id="btn_reset" >Đặt lại dữ liệu</a>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ID',
            'DESCRIPTION',
            'AHAMOVE_ID',
            'IMAGE',
        ],
    ]) ?>

</div>

<?php
Modal::begin([
    'header' => '<h4>Nhập mật khẩu</h4>',
    //'footer' => '<h4>Footer Detail</h4>',
    'id' => 'modal2',
    'size' => 'modal-lg',
]);
echo '<div id="checkpassContent">';?>
<?= $this->render('checkpass', [
    'pos_parent' => $model->ID,
    'userModel' => $userModel
]) ?>
<?php echo '</div>';
Modal::end();
?>

<script>
    $(function(){
        $('#btn_reset').click(function(){
            $('#modal2').modal('show')
                .find('#checkpassContent')
                .load($(this).attr('value'));
        });
    });
</script>
