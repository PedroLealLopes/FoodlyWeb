<?php

namespace common\models;

use Yii;
use Bluerhinos\phpMQTT;

/**
 * This is the model class for table "order_items".
 *
 * @property int $dishId
 * @property int $orderId
 * @property int $quantity
 *
 * @property Dishes $dish
 * @property Orders $order
 */
class OrderItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dishId', 'orderId', 'quantity'], 'required'],
            [['dishId', 'orderId', 'quantity'], 'integer'],
            [['dishId', 'orderId'], 'unique', 'targetAttribute' => ['dishId', 'orderId']],
            [['dishId'], 'exist', 'skipOnError' => true, 'targetClass' => Dishes::className(), 'targetAttribute' => ['dishId' => 'dishId']],
            [['orderId'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::className(), 'targetAttribute' => ['orderId' => 'orderId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'dishId' => 'Dish ID',
            'orderId' => 'Order ID',
            'quantity' => 'Quantity'
        ];
    }

    /**
     * Gets query for [[Dish]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDish()
    {
        return $this->hasOne(Dishes::className(), ['dishId' => 'dishId']);
    }

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Orders::className(), ['orderId' => 'orderId']);
    }

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);

        $id = $this->orderId;
        $dishId = $this->dishId;
        $quantity = $this->quantity;

        $myObj = new \stdClass();
        $myObj->id = $id;
        $myObj->dishId = $dishId;
        $myObj->quantity = $quantity;
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
