<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Dmtag */

$this->title = 'Create Dmtag';
$this->params['breadcrumbs'][] = ['label' => 'Dmtags', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmtag-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
