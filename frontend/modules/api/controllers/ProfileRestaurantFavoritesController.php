<?php

namespace frontend\modules\api\controllers;

use Yii;
use yii\rest\ActiveController;

/**
 * ProfileRestaurantFavoritesController implements the CRUD actions for ProfileRestaurantFavorites model.
 */
class ProfileRestaurantFavoritesController extends ActiveController
{
   public $modelClass = 'common\models\ProfileRestaurantFavorites';

   //custom action que permite receber os pedidos pelo userId
   public function actionUser($id){
      $ProfileRestaurantFavoritesModel = new $this->modelClass;
      $recs = $ProfileRestaurantFavoritesModel::find()->where("profiles_userId = $id")->all();
      return $recs;
   }

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
