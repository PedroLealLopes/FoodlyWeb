<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
?>
<div class="site-login">
            <div class="row justify-content-center">

<div class="col-xl-10 col-lg-12 col-md-9">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                <div class="col-lg-6">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                        </div>



                        
                        <?php $form = ActiveForm::begin(['id' => 'login-form', 'class' => 'user', 
                            'fieldConfig' => [
                                'template' => "{input}\n{hint}\n{error}",
                                'horizontalCssClasses' => [
                                    'error' => 'error',
                                ],
                            ]]); ?>

                            <?= $form->field($model, 'username')->textInput(['placeholder' => 'Username','autofocus' => true, 'class' => 'form-control form-control-user'], ['errorOptions'=>['class'=>'error']]) ?>

                            <div class="form-group">
                                <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password','class' => 'form-control form-control-user']) ?>
                            </div>

                            <?= $form->field($model, 'rememberMe')->checkbox() ?>
                            <hr>

                            <div class="form-group">
                                <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-user btn-block', 'name' => 'login-button']) ?>
                            </div>

                            <?php ActiveForm::end(); ?>

                        <div class="text-center">
                            <a class="small" href="forgot-password.html">Forgot Password?</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="./signup">Create an Account!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

</div>

            
</div>