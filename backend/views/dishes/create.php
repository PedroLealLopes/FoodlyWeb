<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Dishes */

$this->title = 'Create Dishes';
$this->params['breadcrumbs'][] = ['label' => 'Dishes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dishes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
