<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Profiles */

$this->title = 'Create Profiles';
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profiles-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
