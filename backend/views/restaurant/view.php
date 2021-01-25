<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Restaurant */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Restaurants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="restaurant-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->restaurantId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->restaurantId], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'restaurantId',
            'location',
            'name',
            'maxPeople',
            'currentPeople',
            'openingHour',
            'closingHour',
            'allowsPets',
            'hasVegan',
            'description:ntext',
            'wifiPassword',
            // [
            //     'attribute'=>'image',
            //     'value' => Yii::getAlias('@restaurantUrlPath'.'/'.$model->image),
            //     'format'=>['image',['width'=>'100', 'height'=>'100']],
            // ],
        ],
    ]) ?>

</div>
