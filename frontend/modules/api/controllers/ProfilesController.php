<?php

namespace frontend\modules\api\controllers;

use Yii;
use common\models\Profiles;
use yii\rest\ActiveController;

/**
 * ProfilesController implements the CRUD actions for Orders model.
 */
class ProfilesController extends ActiveController
{
   public $modelClass = 'common\models\Profiles';

   public function actionUpload($id){
      $request = Yii::$app->request;
      $post = $request->post();
      $img = $post["image"];

      $blob = base64_decode($img);
      
      $profile = Profiles::findIdentity($id);
      $profile->image = $blob;
   
      return $profile->save();
   }

}
