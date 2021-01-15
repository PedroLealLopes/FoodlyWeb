<?php

namespace frontend\modules\api\controllers;

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
}
