<?php

namespace frontend\modules\api\controllers;

use Yii;
use yii\rest\ActiveController;

/**
 * RestaurantReviewsController implements the CRUD actions for RestaurantReviews model.
 */
class RestaurantReviewsController extends ActiveController
{
   public $modelClass = 'common\models\RestaurantReviews';

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

   //custom action que permite receber os pedidos pelo userId
   public function actionApagar(){
      $request = Yii::$app->request;
      $post = $request->post();
      if($post["profile_id"] != null && $post["restaurant_id"] != null){
         $RestaurantReviewsModel = new $this->modelClass;
         $recs = $RestaurantReviewsModel::find()->where("profiles_userId =". $post["profile_id"] ." AND restaurant_restaurantId = ". $post["restaurant_id"])->one();
         if($recs != null){
            $recs->delete();
            return true;
         }
      }
      return false;  
   }

}
