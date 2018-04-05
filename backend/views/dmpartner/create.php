<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmpartner */

$this->title = 'Tạo đối tác';
$this->params['breadcrumbs'][] = ['label' => 'Đối tác', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmpartner-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
