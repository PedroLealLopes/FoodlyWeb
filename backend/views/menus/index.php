<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Menuses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menus-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Menus', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'menuId',
            'restaurantId',
            'date',
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {delete}',
            ],
        ],
    ]); ?>


</div>
