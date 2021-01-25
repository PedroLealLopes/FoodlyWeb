<?php

namespace frontend\modules\api\controllers;

use common\models\Profiles;
use common\models\User;
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
      $post = $request->post();
      if(isset($post["username"]) && isset($post["password"]))
      {
         $username = $post["username"];
         $password = base64_decode($post["password"]);      
         $user = new User();
         $user = $user->findByUsername($username);
         if($user != null){
            if($user->validatePassword($password)){               
               $connection = Yii::$app->getDb();
               $image = $connection->createCommand("
                  SELECT image
                  FROM user INNER JOIN profiles ON user.id = profiles.userId
                  WHERE username LIKE '$username';
               ");
               $command = $connection->createCommand("
                  SELECT id, username, email, fullname, age, alergias, genero, telefone, morada
                  FROM user INNER JOIN profiles ON user.id = profiles.userId
                  WHERE username LIKE '$username';
               ");
               $recs = $command->query();
               $image = $image->query();
               $json = $recs->read();
               

               $imageJson = $image->read();
               //$image = base64_encode(array_values($imageJson)[0]);
               $json += ['image' => array_values($imageJson)[0]];

               return $json;
            }  
         }
      }
      return ["id"=>-1];
   }
}