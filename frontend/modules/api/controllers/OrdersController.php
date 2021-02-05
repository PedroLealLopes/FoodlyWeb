<?php

namespace frontend\modules\api\controllers;

use common\models\OrderItems;
use Yii;
use common\models\Orders;
use yii\rest\ActiveController;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends ActiveController
{
   public $modelClass = 'common\models\Orders';

   public function actions()
   {
      $actions = parent::actions();
      unset($actions['create']);
      return $actions;
   }

   public function actionCreate()
   {
      $request = Yii::$app->request;
      $post = $request->post();
      if (isset($post["userId"])) {
         $userId = $post["userId"];
         $order = new Orders();
         $order->date = date('Y-m-d H:m');
         $order->userId = $userId;
         $order->estado = 0;
         if ($order->validate()) {
            $order->save();
            $order->refresh();
            $orderId = $order->orderId;
            return $orderId;
         } else {
            return -1;
         }
      }
   }

   //custom action para saber o total de registos.
   public function actionTotal()
   {
      $ordersModel = new $this->modelClass;
      $recs = $ordersModel::find()->all();
      return ['total' => count($recs)];
   }

   //custom action que permite receber os pedidos pelo userId
   public function actionClient($id)
   {
      $ordersModel = new $this->modelClass;
      $recs = $ordersModel::find()->where("userId = $id")->all();
      return ['records' => $recs];
   }
}
