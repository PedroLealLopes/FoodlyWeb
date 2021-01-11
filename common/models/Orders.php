<?php

namespace common\models;

use Yii;
use Bluerhinos\phpMQTT;

/**
 * This is the model class for table "orders".
 *
 * @property int $orderId
 * @property string $date
 * @property int $userId
 *
 * @property OrderItems[] $orderItems
 * @property Dishes[] $dishes
 * @property Profiles $user
 *
 *
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'userId'], 'required'],
            [['orderId', 'userId'], 'integer'],
            [
                ['date'],
                'match',
                'pattern' => '(^\d{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])\s([0-2][0-3]:[0-5][0-9])$)',
                'message' =>'Invalid date'
            ],
            [['orderId'], 'unique'],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'id']],
        ];

    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'orderId' => 'Order ID',
            'date' => 'Date',
            'userId' => 'User ID',
        ];
    }

    /**
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItems::className(), ['orderId' => 'orderId']);
    }

    /**
     * Gets query for [[Dishes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDishes()
    {
        return $this->hasMany(Dishes::className(), ['dishId' => 'dishId'])->viaTable('order_items', ['orderId' => 'orderId']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Profiles::className(), ['userId' => 'userId']);
    }

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);

        $id = $this->orderId;
        $data = $this->date;
        $userId = $this->userId;

        $myObj = new \stdClass();
        $myObj->id = $id;
        $myObj->data = $this->date;
        $myObj->userId = $this->userId;
        $myJSON = json_encode($myObj);
        if($insert){
            $this->FazPublish("INSERT", $myJSON);
        }
        else{
            $this->FazPublish("UPDATE", $myJSON);
        }
    }

    public function afterDelete(){
        parent::afterDelete();
        $prod_id= $this->orderId;
        $myObj=new \stdClass();
        $myObj->id=$prod_id;
        $myJSON = json_encode($myObj);
        $this->FazPublish("DELETE",$myJSON);
    }

    public function FazPublish($canal, $msg){
        $server = "127.0.0.1";
        $port = 1883;
        $username = "";
        $password = "";
        $client_id = "phpMQTT-publisher";
        $mqtt = new phpMQTT($server,$port,$client_id);
        if($mqtt->connect(true, NULL, $username, $password)){
            $mqtt->publish($canal, $msg, 0);
            $mqtt->close();
        }
    }
}
