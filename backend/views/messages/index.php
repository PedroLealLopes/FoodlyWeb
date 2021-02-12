<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\web\UrlRule;

/* @var $this yii\web\View */
/* @var $searchModel common\models\StaffSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mensagens';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="staff-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'date',
            'category',
            'email',
            [
                'label' => 'isRead',
                'value' => function ($dataProvider, $key, $index, $column) {
                    return $dataProvider->isRead == 0 ? 'No' : 'Yes';
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
            ],
        ],
    ]);
    ?>
</div>