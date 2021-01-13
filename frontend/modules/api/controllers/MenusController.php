<?php

namespace frontend\modules\api\controllers;

use yii\rest\ActiveController;
use Yii;
/**
 * MenusController implements the CRUD actions for Menus model.
 */
class MenusController extends ActiveController
{
   public $modelClass = 'common\models\Menus';

   //custom action para saber o total de registos.
   public function actionTotal(){
      $menusModel = new $this->modelClass;
      $recs = $menusModel::find()->all();
      return ['total' => count($recs)];
   }

   //custom action que permite receber os pedidos pelo userId
   public function actionRestaurant($id){
      $menusModel = new $this->modelClass;
      $connection = Yii::$app->getDb();
      $command = $connection->createCommand("
            SELECT * 
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
               );
      ");
      $recs = $command->queryAll();
      return['records'=> $recs];
   }
}
