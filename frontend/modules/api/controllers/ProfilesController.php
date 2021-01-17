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

   public function actions()
   {
      $actions = parent::actions();

      // disable the "delete" and "create" actions
      unset($actions['delete'], $actions['create']);

      // customize the data provider preparation with the "prepareDataProvider()" method
      $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

      return $actions;
   }

   public function prepareDataProvider()
   {
      $query = Profiles::find();
      $dataProvider = new \yii\data\ActiveDataProvider([
         'query' => $query,
         'pagination' => ['pageSize' => 0]
      ]);

      $models = $dataProvider->getModels();
      foreach($models as $profile){
         $imageName = $profile->image;
         if($imageName != null){
            $base64 = 'data:image/jpeg;base64,' . base64_encode($profile->image);
            $profile->image = $base64;
         }      
      }  
      return $models;
   }

   public function actionUpload($id){
      $request = Yii::$app->request;
      $post = $request->post();
      $img = $post["image"];

      // $pos = strpos($img, 'base64,');
      // $img = substr($img, $pos + 7);

      // $blob = base64_decode($img);
      
      $profile = Profiles::findIdentity($id);
      $profile->image = $img;
   
      return $profile->save();
   }

}
