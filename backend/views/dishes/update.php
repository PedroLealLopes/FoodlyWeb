<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Dishes */

$this->title = 'Update Dishes: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Dishes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->dishId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dishes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
