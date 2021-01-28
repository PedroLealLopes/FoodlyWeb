<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "staff".
 *
 * @property int $restaurantId
 * @property int $userId
 *
 * @property Restaurant $restaurant
 * @property User $user
 */
class Staff extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'staff';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['restaurantId', 'userId'], 'required'],
            [['restaurantId', 'userId'], 'integer'],
            [['userId'], 'unique'],
            [['restaurantId'], 'exist', 'skipOnError' => true, 'targetClass' => Restaurant::className(), 'targetAttribute' => ['restaurantId' => 'restaurantId']],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'restaurantId' => 'Restaurant ID',
            'userId' => 'User ID',
        ];
    }

    /**
     * Gets query for [[Restaurant]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurant()
    {
        return $this->hasOne(Restaurant::className(), ['restaurantId' => 'restaurantId']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }
}
