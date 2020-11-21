<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_items".
 *
 * @property int $dishId
 * @property int $orderId
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
            [['dishId', 'orderId'], 'required'],
            [['dishId', 'orderId'], 'integer'],
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
}
