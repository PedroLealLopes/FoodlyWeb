<?php

namespace frontend\modules\api\controllers;

use common\models\Restaurant;
use yii\rest\ActiveController;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class RestaurantsController extends ActiveController
{
   public $modelClass = 'common\models\Restaurant';

   public function actions()
   {
      $actions = parent::actions();

      // customize the data provider preparation with the "prepareDataProvider()" method
      $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

      return $actions;
   }

   public function prepareDataProvider()
   {
      $query = Restaurant::find();
      $dataProvider = new \yii\data\ActiveDataProvider([
           'query' => $query,
           'pagination' => ['pageSize' => 0]
      ]);

      $models = $dataProvider->getModels();
      foreach($models as $restaurant){
         $imageName = $restaurant->image;
         if($imageName != null){

            $path = "../../common/images/restaurants/$imageName";
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

            $restaurant->image = $base64;
         }      
      }      
  
      return $models;
   }

   //custom action para pesquisar restaurantes com base na localização
   public function actionLocation($cidade){
      $restaurantModel = new $this->modelClass;
      $recs = $restaurantModel::find()->where("location LIKE '%$cidade%'")->all();
      return['records'=> $recs];
   }

   //custom action para saber o total de registos.
   public function actionTotal(){
      $restaurantModel = new $this->modelClass;
      $recs = $restaurantModel::find()->all();
      return ['total' => count($recs)];
   }
}
