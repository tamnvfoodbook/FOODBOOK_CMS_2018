<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmitemcombo */

$this->title = 'Create Dmitemcombo';
$this->params['breadcrumbs'][] = ['label' => 'Dmitemcombos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmitemcombo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
