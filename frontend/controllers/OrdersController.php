<?php

namespace frontend\controllers;

use yii\rest\ActiveController;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends ActiveController
{
   public $modelClass = 'common\models\Orders';

   public function actionTotal(){
      $ordersModel = new $this->modelClass;
      $recs = $ordersModel::find()->all();
      return ['total' => count($recs)];
   }

   public function actionClient($id){
      $ordersModel = new $this->modelClass;
      $recs = $ordersModel::find()->where("userId = $id")->all();
      return['records'=> $recs];
   }
}
