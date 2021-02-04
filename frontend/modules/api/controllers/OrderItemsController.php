<?php

namespace frontend\modules\api\controllers;

use common\models\OrderItems;
use Yii;
use common\models\Orders;
use yii\rest\ActiveController;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrderItemsController extends ActiveController
{
   public $modelClass = 'common\models\OrderItems';

   public function actions()
   {
      $actions = parent::actions();
      unset($actions['create']);
      return $actions;
   }

   public function actionCreate(){
      $request = Yii::$app->request;
      $post = $request->post();
      if(isset($post["orderId"]) && isset($post["dishId"]) && isset($post["quantity"])){
         $orderId = $post["orderId"];
         $dishId = $post["dishId"];
         $quantity = $post["quantity"];
         $order = Orders::findOne(['orderId' => $orderId]);
         if($order != null){
            $orderItems = new OrderItems();      
            $orderItems->orderId = $orderId;         
            $orderItems->dishId = $dishId;         
            $orderItems->quantity = $quantity;         
            if($orderItems->validate()){
               $orderItems->save();
               $orderItems->refresh();
               return true;
            }
         }
      }
      return false;
   }
}
