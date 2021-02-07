<?php

namespace frontend\modules\api\controllers;

use Yii;
use yii\web\Response;
use common\models\User;
use common\models\Profiles;
use yii\rest\ActiveController;
use frontend\models\SignupForm;

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

   public function actionRegister(){
      $request = Yii::$app->request;
      $post = $request->post();
      if(isset($post["username"]) && isset($post["password"]) && isset($post["email"]) && isset($post["fullname"]) && isset($post["age"]))
      {
         $username = $post["username"];
         $password = $post["password"];
         $email = $post["email"];
         $fullname = $post["fullname"];
         $age = $post["age"];
         $genero = null;
         $telefone = null;
         $morada = null;
         $alergias = null;

         if(isset($post["genero"])){
            $genero = $post["genero"];
         }
         if(isset($post["telefone"])){
            $telefone = $post["telefone"];
         }
         if(isset($post["morada"])){
            $morada = $post["morada"];
         }
         if(isset($post["alergias"])){
            $alergias = $post["alergias"];
         }

         $user = new User();
         $profile = new Profiles();
         $user->username = $username;
         $user->email = $email;
         $user->setPassword($password);
         $user->generateAuthKey();
         $user->status = 10;
         if($user->validate()){  
            $user->save(false);
            $user->update();
            $profile->userId = $user->getId();
            $profile->alergias = $alergias;
            $profile->telefone = $telefone;
            $profile->morada = $morada;
            $profile->genero = $genero;
            $profile->fullname = $fullname;
            $profile->age = $age;

            if($profile->validate()){
               $profile->save(false);
               $auth = \Yii::$app->authManager;
               $authorRole = $auth->getRole('user');
               $auth->assign($authorRole, $user->getId());
               
            }      
            return $user->getId();
         }
      }
      return -1;
   }
}