<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmposparentpolicy */

$this->title = 'Create Dmposparentpolicy';
$this->params['breadcrumbs'][] = ['label' => 'Dmposparentpolicies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmposparentpolicy-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
