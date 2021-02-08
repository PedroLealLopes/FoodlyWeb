<?php

namespace backend\controllers;

use common\models\Contact;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class MessagesController extends Controller
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
                        'actions' => ['index', 'view', 'update'],
                        'allow' => true,
                        'roles' => ['admin'],
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
        $mensagens = new Contact();
        $mensagens = $mensagens->find()->all();    
        return $this->render('index', ['mensagens' => $mensagens]);
    }


    public function actionView($id){
        $mensagem = new Contact();
        $mensagem = $mensagem->find()->where(['contactId' => $id])->one();
        return $this->render('view', ['model' => $mensagem]);
    }

    public function actionUpdate($id){
        $mensagem = new Contact();
        $mensagem = $mensagem->find()->where(['contactId' => $id])->one();
        $mensagem->isRead = 1;
        $mensagem->save();
        $mensagem->update();
        return $this->redirect('index');
    }
}