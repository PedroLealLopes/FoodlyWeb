<?php

namespace frontend\modules\api\controllers;

use common\models\Dishes;
use yii\rest\ActiveController;
use Yii;

/**
 * DishesController implements the CRUD actions for Orders model.
 */
class DishesController extends ActiveController
{
   public $modelClass = 'common\models\Dishes';

   public function behaviors()
   {
       return [
           [
               'class' => \yii\filters\ContentNegotiator::className(),
               'only' => ['index', 'view'],
               'formats' => [
                   'application/json' => \yii\web\Response::FORMAT_JSON,
               ],
           ],
       ];
   }

   //custom action para saber o total de registos.
   public function actionTotal(){
      $ordersModel = new $this->modelClass;
      $recs = $ordersModel::find()->all();
      return ['total' => count($recs)];
   }

   //custom action que permite receber os pedidos pelo userId
   public function actionRestaurant($id){
      $menusModel = new $this->modelClass;
      $connection = Yii::$app->getDb();
      $command = $connection->createCommand("
         SELECT *
         FROM dishes
         WHERE menuId =
         (
            SELECT menuId 
            FROM foodly.menus 
            WHERE date = 
            (
               SELECT MAX(date) 
               FROM 
               (
                  SELECT * 
                  FROM foodly.menus 
                  WHERE restaurantId = $id
               ) t1
            )
         );
      ");
      $recs = $command->queryAll();
      return['records'=> $recs];
   }
}
