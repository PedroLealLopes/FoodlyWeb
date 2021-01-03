<?php

namespace frontend\controllers;

use yii\rest\ActiveController;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class RestaurantsController extends ActiveController
{
   public $modelClass = 'common\models\Restaurant';

   public function actionLocation($cidade){
      $restaurantModel = new $this->modelClass;
      $recs = $restaurantModel::find()->where("location LIKE '%$cidade%'")->all();
      return['records'=> $recs];
   }

   public function actionTotal(){
      $restaurantModel = new $this->modelClass;
      $recs = $restaurantModel::find()->all();
      return ['total' => count($recs)];
   }
}
