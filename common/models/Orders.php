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
                'pattern' => '(^\d{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])\s([0-2][0-9]:[0-5][0-9])$)',
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
}
