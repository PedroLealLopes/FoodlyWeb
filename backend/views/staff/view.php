<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Staff */

$this->title = $model->user->username;
$this->params['breadcrumbs'][] = ['label' => 'Staff', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$role = "";
if (isset(Yii::$app->authManager->getRolesByUser($model->user->id)['cook'])) {
    $role = "Cook";
} else {
    if (isset(Yii::$app->authManager->getRolesByUser($model->user->id)['admin'])) {
        $role = "Admin";
    }
}
?>
<div class="staff-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->userId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->userId], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>

        <?php
        if (!(Yii::$app->user->identity->id == $model->userId)) {
            if (isset(Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->id)['admin'])) {
                if ($role == "Cook") {
                    echo  Html::a('Change role to Admin', ['admin', 'id' => $model->userId], ['class' => 'btn btn-info']);
                }
                if ($role == "Admin") {
                    echo  Html::a('Change role to Cook', ['cook', 'id' => $model->userId], ['class' => 'btn btn-info']);
                }
            }
        }
        ?>


    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'user.username',
            'user.email',
            [
                'label' => 'User Created At',
                'value' => date("l jS \of F Y h:i:s A", $model->user->created_at),
            ],
            [
                'label' => 'Role',
                'value' => $role
            ],
        ],
    ])


    ?>

</div>