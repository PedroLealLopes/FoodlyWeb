<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Menus;
use yii\filters\VerbFilter;
use common\models\Restaurant;
use DateTime;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * MenusController implements the CRUD actions for Menus model.
 */
class MenusController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Menus models.
     * @return mixed
     */
    public function actionIndex()
    {
        $userId = Yii::$app->user->identity->id;
        $dataProvider = new ActiveDataProvider([
            'query' => Menus::find()->where("restaurantId = (SELECT restaurantId FROM staff WHERE userId = $userId)"),
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Menus model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Menus model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $userId = Yii::$app->user->identity->id;
        $restaurant = Restaurant::findBySql("SELECT * FROM restaurant WHERE restaurantId = (SELECT restaurantId FROM staff WHERE userId = $userId)")->all();
        $restaurant = $restaurant[0];
        $menu = new Menus();
        $menu->restaurantId = $restaurant->restaurantId;
        $menu->date = date("Y-m-d");
        if($menu->validate()){
            $menu->save();
            return $this->redirect(['view', 'id' => $menu->menuId]);
        }
        else{
            return $this->redirect(['index']);
        }
    }

    /**
     * Updates an existing Menus model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->menuId]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Menus model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Menus model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menus the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menus::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
