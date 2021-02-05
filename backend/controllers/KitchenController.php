<?php

namespace backend\controllers;

use common\models\Menus;
use Yii;
use yii\web\Controller;
use common\models\Staff;
use common\models\Orders;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;

class KitchenController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'mqtt', 'finish'],
                        'allow' => true,
                        'roles' => ['admin', 'cook'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex(){        
        $userId = Yii::$app->user->identity->id;
        $restaurantId = (Staff::find()->where(['userId' => $userId])->one())->restaurantId;
        $menus = Menus::find()->where(['restaurantId' => $restaurantId])->all();
        $menuId = -1;
        foreach($menus as $menu){
            $menuId = $menu->menuId; 
        }
        $sql = "SELECT orders.orderId, orders.date, orders.estado, profiles.fullname, profiles.alergias, dishes.type, dishes.name, dishes.description, order_items.quantity 
        FROM orders
        INNER JOIN profiles ON orders.userId = profiles.userId
        INNER JOIN order_items ON orders.orderId = order_items.orderId
        INNER JOIN dishes ON order_items.dishId = dishes.dishId
        WHERE orders.estado = 0 AND dishes.menuId = $menuId";

        $connection = Yii::$app->getDb();
        $command = $connection->createCommand($sql);
        $recs = $command->queryAll();

        return $this->render('index', [
            'orders' => $recs,
        ]);
    }
    
    public function actionFinish($id){
        $order = new Orders();
        $order = $order->find()->where(['orderId' => $id])->one();
        $date = $date = date_create($order->date);
        $order->date = date_format($date,"Y-m-d H:i");
        $order->estado = 1;
        $order->save();
        $order->update();

        return $this->redirect(['index']);
    }

    public function actionMqtt(){
        $server = 'localhost';     // change if necessary
        $port = 1883;              // change if necessary
        $username = '';            // set your username
        $password = '';            // set your password
        $client_id = 'phpMQTT-subscribe-msg'; // make sure this is unique for connecting to sever - you could use uniqid()
        $mqtt = new \Bluerhinos\phpMQTT($server, $port, $client_id);
        if(!$mqtt->connect(true, NULL, $username, $password)) {
            exit(1);
        }
        $msg = $mqtt->subscribeAndWaitForMessage('INSERT', 0);
        $mqtt->close();

        return $msg;
    }

}