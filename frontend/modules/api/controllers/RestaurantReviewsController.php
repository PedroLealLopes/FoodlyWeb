<?php

namespace frontend\modules\api\controllers;

use yii\rest\ActiveController;

/**
 * RestaurantReviewsController implements the CRUD actions for RestaurantReviews model.
 */
class RestaurantReviewsController extends ActiveController
{
   public $modelClass = 'common\models\RestaurantReviews';

   protected function verbs() {
      $verbs = parent::verbs();
      $verbs =  [
         'create' => ['POST'],
         'update' => ['PUT', 'PATCH'],
         'delete' => ['DELETE']
      ];
      return $verbs;
   }

   //custom action para saber o total de registos.
   public function actionTotal(){
      $RestaurantReviewsModel = new $this->modelClass;
      $recs = $RestaurantReviewsModel::find()->all();
      return ['total' => count($recs)];
   }

   //custom action que permite receber os pedidos pelo userId
   public function actionRestaurant($id){
      $RestaurantReviewsModel = new $this->modelClass;
      $recs = $RestaurantReviewsModel::find()->where("restaurant_restaurantId = $id")->all();
      return $recs;
   }

   //custom action que permite receber os pedidos pelo userId
   public function actionUser($id){
      $RestaurantReviewsModel = new $this->modelClass;
      $recs = $RestaurantReviewsModel::find()->where("profiles_userId = $id")->all();
      return $recs;
   }
}
