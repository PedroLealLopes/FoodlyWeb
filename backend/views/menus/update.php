<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Menus */

$this->title = 'Update Menus: ' . $model->menuId;
$this->params['breadcrumbs'][] = ['label' => 'Menuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->menuId, 'url' => ['view', 'id' => $model->menuId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="menus-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
