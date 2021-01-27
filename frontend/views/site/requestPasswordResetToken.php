<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Request password reset';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="header-container">
    <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 335.9 65.02" width="150" height="50"><path fill="#7b2cbf" d="M4.24 29a50.62 50.62 0 0036 14.93A50.61 50.61 0 0076.31 29l4.24 4.24a56.58 56.58 0 01-40.27 16.64A56.59 56.59 0 010 33.19z"></path><path fill="#9d4edd" d="M11.35 21.84a40.63 40.63 0 0028.93 12 40.63 40.63 0 0028.92-12l4.24 4.24a46.6 46.6 0 01-33.16 13.74A46.6 46.6 0 017.11 26.08z"></path><path fill="#c77dff" d="M18.46 14.73a30.66 30.66 0 0021.82 9 30.64 30.64 0 0021.81-9L66.33 19a36.6 36.6 0 01-26 10.8A36.61 36.61 0 0114.22 19z"></path><path fill="#0a0a0a" d="M99.65 11.58v12.67h22.2v8.91h-22.2v17.47h-11.1v-48h36.24v8.91zM129.87 32.2c0-11.1 8.57-19 20.28-19s20.21 7.88 20.21 19-8.49 19-20.21 19-20.28-7.9-20.28-19zm29.67 0c0-6.37-4-10.21-9.39-10.21s-9.45 3.84-9.45 10.21 4.11 10.21 9.45 10.21 9.39-3.84 9.39-10.21z"></path><path fill="#0a0a0a" d="M178.36 32.27c0-11.1 8.57-19 20.28-19s20.21 7.88 20.21 19-8.49 19-20.21 19-20.28-7.9-20.28-19zm29.67 0c0-6.37-4-10.21-9.39-10.21s-9.45 3.84-9.45 10.21 4.11 10.21 9.45 10.21S208 38.64 208 32.27zM267-.07v50.84h-10.21v-4.25c-2.67 3.22-6.57 4.8-11.51 4.8-10.41 0-18.43-7.4-18.43-19s8-19 18.43-19c4.53 0 8.36 1.44 11 4.45V-.07zm-10.48 32.41c0-6.37-4.11-10.21-9.39-10.21s-9.45 3.84-9.45 10.21 4.11 10.21 9.45 10.21 9.39-3.84 9.39-10.21zM275 0h10.69v50.84H275zM335.9 14l-16.65 39.1c-3.57 8.9-8.64 11.58-15.25 11.58-3.77 0-7.88-1.24-10.28-3.36l3.91-7.61a9.45 9.45 0 006 2.33c2.94 0 4.59-1.3 6-4.59l.13-.34L293.83 14h11l10.37 25 10.42-25z"></path></svg>
    <nav class="main-nav">
        <ul class="main-nav-list">
            <li>
                <a aria-current="page" href="/">Home</a>
            </li>
            <li>
                <a href="/restaurants">Restaurants</a>
            </li>
            <li>
                <a href="/profile">Profile</a>
            </li>
        </ul>
    </nav>
    <?php if (is_null(Yii::$app->user->identity)): ?>
        <a style="margin-left: 50px;" href="/login">
            <button type="text" class="btn-header" style="color: rgb(245, 245, 245);">Login</button>
        </a>
    <?php else: ?>
        <a style="margin-left: 50px;" href="/site/logout">
            <button type="text" class="btn-header" style="color: rgb(245, 245, 245);">Logout (<?=Yii::$app->user->identity->username ?>)</button>
        </a>
    <?php endif; ?>
</div>


<div class="site-request-password-reset container-password-reset-token">
    <div class="password-reset-token">
        <h1><?= Html::encode($this->title) ?></h1>
    
        <p>Please fill out your email. A link to reset password will be sent there.</p>
    
        <div class="row">
            <div class="col-lg-5">
                <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
    
                    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
    
                    <div class="form-group">
                        <?= Html::submitButton('Send', ['class' => 'btn btn-primary']) ?>
                    </div>
    
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>


<style>
    .container-password-reset-token{
        height: calc(100vh - 81px);
        margin-top: 81px;
        align-items: flex-start;
        flex-flow: row wrap;
    }

    .password-reset-token{
        position: relative;
        display: flex;
        flex-flow: column nowrap;
        width: 100%;
        height: 33vh;
        padding: 0 15% 0 15%;
    }
</style>