<?php

namespace frontend\modules\api\controllers;

use yii\rest\ActiveController;
use Yii;
use yii\web\Response;

/**
 * MenusController implements the CRUD actions for Menus model.
 */
class UsersController extends ActiveController
{
   public $modelClass = 'common\models\User';

   public function actionTotal(){
      $userModel = new $this->modelClass;
      $recs = $userModel::find()->all();
      return ['total' => count($recs)];
   }

   public function actionLogin(){
      $request = Yii::$app->request;
      $post    = $request->post();
      if(isset($post["email"]) && isset($post["password"]))
      {
         $email = $post["email"];
         $password = $post["password"];
         $connection = Yii::$app->getDb();
         $command = $connection->createCommand("
            SELECT * 
            FROM `user` 
            WHERE email LIKE '$email' AND password_hash LIKE '$password'
         ");
         $recs = $command->queryAll();
         return $recs;
      }
   }
}