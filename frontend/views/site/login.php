<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Foodly | Login';
$this->params['breadcrumbs'][] = $this->title;
?>
    <section class="container login-container">
        <div class="login">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div style="color:#999;margin:1em 0">
                    Don't have an account? <?= Html::a('Signup', ['site/signup']) ?>
                    <br>
                    Forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
                    <br>
                    Need new verification email? <?= Html::a('Resend', ['site/resend-verification-email']) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn-header', 'name' => 'login-button', 'style' => "color: rgb(245, 245, 245); width: 100%;"]) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </section>