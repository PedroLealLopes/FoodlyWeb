<?php

namespace frontend\modules\api\controllers;

use yii\rest\ActiveController;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class RestaurantsController extends ActiveController
{
   public $modelClass = 'common\models\Restaurant';

   //custom action para pesquisar restaurantes com base na localização
   public function actionLocation($cidade){
      $restaurantModel = new $this->modelClass;
      $recs = $restaurantModel::find()->where("location LIKE '%$cidade%'")->all();
      return['records'=> $recs];
   }

   //custom action para saber o total de registos.
   public function actionTotal(){
      $restaurantModel = new $this->modelClass;
      $recs = $restaurantModel::find()->all();
      return ['total' => count($recs)];
   }
}
