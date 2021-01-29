<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RestaurantSearch */
/* @var $form yii\widgets\ActiveForm */
?>


  <?php $form = ActiveForm::begin([
      'action' => ['restaurants'],
      'method' => 'get',
      'options' => [
          'class' => 'restaurants-form'
      ]
  ]); ?>
<div class="field">
  <?= $form->field($model, 'name')->textInput(['class' => '', 'style' => 'width: 100%'])->label('Search for Restaurant: ', ['style' => "
  font-size: 32px;
  "]) ?>
</div>

  <?php ActiveForm::end(); ?>
