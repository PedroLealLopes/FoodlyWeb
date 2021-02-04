<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">

    <div class="card o-hidden border-0 shadow-lg my-5">

            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

                            <?php $form = ActiveForm::begin(['id' => 'form-signup', 'class' => 'user']); ?>
                            <div class="overflow-auto" style="max-height: 150px;">
                                    <?php foreach ($restaurants as $restaurant): ?>
                                    <div class="restaurant-card">
                                        <div class="form-check">
                                        <label class="form-check-label" style="cursor: pointer">
                                            <input type="radio" class="form-check-input" id="<?= $restaurant->restaurantId ?>" name="SignupForm[restaurantId]" value="<?= $restaurant->restaurantId ?>"/>
                                            <i> <?= $restaurant->name ?> </i>
                                        </label>
                                        </div>
                                    </div>
                                        <?php endforeach; ?>
                                </div>
                                
                                <hr>
                                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                                <?= $form->field($model, 'email') ?>

                                <?= $form->field($model, 'password')->passwordInput() ?>

                                
                                <?= $form->field($model, 'roleId')->radioList( [0=>'Cook', 1 => 'Admin'] ); ?>
                                

                                <div class="form-group" style="margin-top: 15px;">
                                    <?= Html::submitButton('Register Account', ['class' => 'btn btn-primary btn-user btn-block', 'name' => 'signup-button']) ?>
                                </div>

                            <?php ActiveForm::end(); ?>

                            <hr>
                            <div class="text-center">
                                <a class="small" href="forgot-password.html">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="./login">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>