<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Orders */

$this->title = $model->orderId;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$totalValue = 0;
?>
<div class="orders-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->orderId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->orderId], [
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
            'orderId',
            'date',
            'userId',
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
        foreach($orderItems as $orderItem){
            if($orderItem->quantity > 1){
                $totalValue += $orderItem->dish->price * $orderItem->quantity;
                
            for($i = 1; $i <= $orderItem->quantity; $i++){
                echo "<tr><td>". $orderItem->dish->name . "</td><td>". $orderItem->dish->price . "</td><td>". $orderItem->dish->type . "</td><td>". $orderItem->dish->description . "</td></tr>";
            };
            }else{
                $totalValue += $orderItem->dish->price;
                
                echo "<tr><td>". $orderItem->dish->name . "</td><td>". $orderItem->dish->price . "</td><td>". $orderItem->dish->type . "</td><td>". $orderItem->dish->description . "</td></tr>";
            }
        }
        echo "</tbody>";
        echo "</table>";
    ?>


    <h1 style='margin-top: 5rem;'>Total Order Value: <?= $totalValue ?>€</h1>

</div>
