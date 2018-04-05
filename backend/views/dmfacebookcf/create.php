<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmfacebookcf */

$this->title = 'Create Dmfacebookcf';
$this->params['breadcrumbs'][] = ['label' => 'Dmfacebookcfs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmfacebookcf-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
