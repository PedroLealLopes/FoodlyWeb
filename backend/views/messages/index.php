<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\web\UrlRule;

/* @var $this yii\web\View */
/* @var $searchModel common\models\StaffSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mensagens';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="staff-index">
    <h1><?= Html::encode($this->title) ?></h1>

<div class="container" id="messages">
    <div class="row" >
        <div class="col"><h5>Data:</h5></div>
        <div class="col"><h5>Categoria:</h5></div>
        <div class="col"><h5>Email:</h5></div>    
        <div class="col"><h5>Lido:</h5></div>    
        <div class="col"><h5>Ação</h5></div>
    </div>
    <?php 
        if($mensagens != null){
            foreach($mensagens as $mensagem){
            ?>
            <div class="row">
               <div class="col"><?= $mensagem->date?></div>
                <div class="col"><?= $mensagem->category?></div>
                <div class="col"><?= $mensagem->email?></div>    
                <div class="col"><?= $mensagem->isRead? "Sim":"Nao" ?></div>    
                <div class="col"><a href="<?= Url::toRoute('messages/view')."?id=$mensagem->contactId"?>">Abrir</a></div> 
            </div>
            <?php
            }
        }
        else{
            ?>
                <div class="row">
                    <div class="col">Sem mensagens</div>
                </div>
            <?php
        }
    ?>
</div>