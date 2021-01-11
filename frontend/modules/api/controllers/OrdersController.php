<?php

namespace frontend\modules\api\controllers;

use yii\rest\ActiveController;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends ActiveController
{
   public $modelClass = 'common\models\Orders';

   //custom action para saber o total de registos.
   public function actionTotal(){
      $ordersModel = new $this->modelClass;
      $recs = $ordersModel::find()->all();
      return ['total' => count($recs)];
   }

   //custom action que permite receber os pedidos pelo userId
   public function actionClient($id){
      $ordersModel = new $this->modelClass;
      $recs = $ordersModel::find()->where("userId = $id")->all();
      return['records'=> $recs];
   }
}
