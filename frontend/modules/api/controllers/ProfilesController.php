<?php

namespace frontend\modules\api\controllers;

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

            $path = "../../common/images/profiles/$imageName";
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

            $profile->image = $base64;
         }      
      }  
      return $models;
   }

}
