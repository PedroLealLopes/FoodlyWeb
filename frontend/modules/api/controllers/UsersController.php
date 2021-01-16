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
         $profile = $user->getProfile()->one();
         $imageName = $profile->image;
         if($imageName != null){

            $path = "../../common/images/profiles/$imageName";
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

            $profile->image = $base64;
         }

         if($user->validatePassword($password)){
            
            $connection = Yii::$app->getDb();
            $command = $connection->createCommand("
               SELECT id, username, email, fullname, age, alergias, genero, telefone, morada
               FROM user INNER JOIN profiles ON user.id = profiles.userId
               WHERE username LIKE '$username';
            ");
            $recs = $command->query();
            $json = $recs->read();
            $json += ["image" => $profile->image];
            return $json;
         }
      }
      return ["id"=>-1];
   }
}