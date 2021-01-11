<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
$errorCode = (int) filter_var($this->title, FILTER_SANITIZE_NUMBER_INT); 
?>

<div class="site-error">
    <div class="text-center">
        <div class="error mx-auto" data-text=" <?= Html::encode($errorCode) ?>"> <?= Html::encode($errorCode) ?></div>
        <p class="lead text-gray-800 mb-5"><?= nl2br(Html::encode($message)) ?></p>
        <p class="text-gray-500 mb-0">It looks like you found a glitch in the matrix...</p>
        <a href="index.php">← Back to Home Page</a>
    </div>
</div>
