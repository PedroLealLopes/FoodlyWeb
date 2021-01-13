<?php

namespace frontend\modules\api\controllers;

use yii\rest\ActiveController;

/**
 * MenusController implements the CRUD actions for Menus model.
 */
class UsersController extends ActiveController
{
   public $modelClass = 'common\models\User';

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

   public function actionTotal(){
      $userModel = new $this->modelClass;
      $recs = $userModel::find()->all();
      return ['total' => count($recs)];
   }

   
   public function actionRestaurant($id){
      $userModel = new $this->modelClass;
      $recs = $userModel::find()->where("id = $id")->all();
      return['records'=> $recs];
   }
}
