<?php

namespace frontend\modules\api\controllers;

use common\models\Profiles;
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
      $profile = new Profiles();
      $profile = $profile->findIdentity($id);
      $recs = $RestaurantReviewsModel::find()->where("profiles_userId = $id")->all();
      if($profile != null){
         $recs += ['username' => $profile->fullname];
         $imageName = $profile->image;
         if($imageName != null){
            $path = "../../common/images/profiles/$imageName";
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
   
            $profile->image = $base64;
         $recs += [
                     'image' => $profile->image
                  ];
                  
         return $recs;
         }
      }
      return -1;
   }
}
