<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Staff */

$this->title = 'Update Staff: ' . $model->userId;
$this->params['breadcrumbs'][] = ['label' => 'Staff', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->userId, 'url' => ['view', 'id' => $model->userId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="staff-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>