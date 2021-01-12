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
  
      return $models;
   }

}
