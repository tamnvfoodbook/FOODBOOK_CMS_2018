<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmitemtypemaster */

$this->title = 'Create Dmitemtypemaster';
$this->params['breadcrumbs'][] = ['label' => 'Dmitemtypemasters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmitemtypemaster-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
