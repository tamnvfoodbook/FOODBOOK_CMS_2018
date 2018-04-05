<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmvoucherlog */

$this->title = 'Create Dmvoucherlog';
$this->params['breadcrumbs'][] = ['label' => 'Dmvoucherlogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmvoucherlog-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
