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

   public function actionCreate(){
      $request = Yii::$app->request;
      $post = $request->post();

      if(isset($post["userId"]) && isset($post["dishId"]) && isset($post["quantity"])){
         $userId = $post["userId"];
         $dishId = $post["dishId"];
         $quantity = $post["quantity"];

         $order = new Orders();      
         $order->date = date('Y-m-d H:m');
         $order->userId = $userId;
         if(!$order->validate()){
            return $order->getErrors();
         }
         else{
            $order->save();
            $order->refresh();
            $orderId = $order->orderId;

            $orderItems = new OrderItems();
            $orderItems->orderId = $orderId;
            $orderItems->dishId = $dishId;
            $orderItems->quantity = $quantity;

            if(!$orderItems->validate()){               
               return $orderItems->getErrors();
            }
            else{
               $orderItems->save();
               return true;
            }
         }
      }
   }

   public function actionShoworder($id){

      $sql = "SELECT orders.orderId, orders.date, orders.userId, dishes.dishId, dishes.type, dishes.price, dishes.menuId, dishes.name, quantity 
      FROM order_items 
      INNER JOIN orders ON order_items.orderId = orders.orderId 
      INNER JOIN dishes ON order_items.dishId = dishes.dishId
      WHERE orders.orderId = $id;";

      $connection = Yii::$app->getDb();
      $command = $connection->createCommand($sql);
      $recs = $command->queryAll();
      return $recs;
   }

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
