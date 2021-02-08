<?php

use yii\helpers\Url;
use yii\web\UrlRule;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\StaffSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mensagem';
$this->params['breadcrumbs'][] = ['label' => 'Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="staff-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Html::a('Marcar como lido', ['update', 'id' => $model->contactId], ['class' => 'btn btn-primary']) ?></p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'date',
            'category',
            'email',
            'body',
        ],

    ]) ?>