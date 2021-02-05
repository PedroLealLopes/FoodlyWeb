<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\StaffSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cozinha';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="staff-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <div id="mqttData"></div>
    <br>

    <div class="container">
        <div class="row justify-content-center">
            <?php
            if($orders != null){
            $lastId = $orders[0]["orderId"];
            for ($i = 0; $i < sizeof($orders); $i++) {
                $order = $orders[$i];
                if ($lastId != $order["orderId"]) {
            ?>
                    <a href="<?= Url::toRoute('kitchen/finish') ?>?id=<?= $lastId ?>" class="btn btn-primary m-2">Terminar Pedido</a>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
        <?php
                }
        ?>
        <div id="order" class="card m-2" style="width: 18rem;">
            <div class="card-body">
                <h4 id="dishName" class="card-title"><?= $order["name"] ?></h5>
                    <h6 id="dishType"><?= $order["type"] ?></h3>
                        <p class="card-text"><?= $order["description"] != "" ? $order["description"] : "sem descrição" ?></p>
                        <p id="dishQuantity"><?= $order["quantity"] ?></p>
                        <p id="dishQuantity">alergias: <?= $order["alergias"] ?></p>
                        <p id="date"><?= $order["date"] ?></p>

            </div>
        </div>
    <?php
                $lastId = $order["orderId"];
            }
            ?>
            <a href="<?= Url::toRoute('kitchen/finish') ?>?id=<?= $lastId ?>" class="btn btn-primary m-2">Terminar Pedido</a>
                </div>
            </div>
            <?php
        }
    ?>

    

    <script>
        setInterval(function() {
            location.reload();
        }, 15000)
    </script>