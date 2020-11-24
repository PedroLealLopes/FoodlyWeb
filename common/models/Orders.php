<?php

namespace common\models;

use Yii;

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
            [['orderId', 'date', 'userId'], 'required'],
            [['orderId', 'userId'], 'integer'],
            [
                ['date'],
                'match',
                'pattern' => '(^((0[1-9]|[12][0-9]|3[01])(/)(0[13578]|1[02]))|((0[1-9]|[12][0-9])(/)(02))|((0[1-9]|[12][0-9]|3[0])(/)(0[469]|11))(/)\d{4}$)',
                'message' =>'Invalid date'
            ],
            [['orderId'], 'unique'],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => Profiles::className(), 'targetAttribute' => ['userId' => 'userId']],
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
