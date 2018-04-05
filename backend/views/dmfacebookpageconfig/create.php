<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmfacebookpageconfig */

$this->title = 'Create Dmfacebookpageconfig';
$this->params['breadcrumbs'][] = ['label' => 'Dmfacebookpageconfigs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmfacebookpageconfig-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
