<?php

namespace frontend\modules\api\controllers;

use yii\rest\ActiveController;

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
      $recs = $menusModel::find()->where("restaurantId = $id")->all();
      return['records'=> $recs];
   }
}
