<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Menus */

$this->title = $model->menuId;
$this->params['breadcrumbs'][] = ['label' => 'Menuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="menus-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->menuId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->menuId], [
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
            'menuId',
            'restaurantId',
            'date',
        ],
    ]) ?>

    <h1 style='margin-top: 5rem;'>Dishes</h1>
    <?php
        echo "<table class='table table-striped table-bordered detail-view dataTable'>";
        echo '<thead>';
        echo '<tr>';
        echo "<th>";
        echo "Dish Name";
        echo "</th>";
        echo "<th>";
        echo "Dish Price";
        echo "</th>";
        echo "<th>";
        echo "Dish Type";
        echo "</th>";
        echo "<th>";
        echo "Dish Description";
        echo "</th>";
        echo '</tr>';
        echo "</thead>";
        echo "<tbody>";
        foreach($dishes as $dish)
            echo "<tr><td>". $dish->name . "</td><td>". $dish->price . "</td><td>". $dish->type . "</td><td>". $dish->description . "</td></tr>";
        echo "</tbody>";
        echo "</table>";
    ?>

</div>
