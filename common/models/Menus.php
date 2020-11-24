<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "menus".
 *
 * @property int $menuId
 * @property int $restaurantId
 * @property string $date
 *
 * @property Dishes[] $dishes
 * @property Restaurant $restaurant
 */
class Menus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['restaurantId', 'date'], 'required'],
            [['restaurantId'], 'integer'],
            [['date'], 'match',
            'pattern' => '(^((0[1-9]|[12][0-9]|3[01])(/)(0[13578]|1[02]))|((0[1-9]|[12][0-9])(/)(02))|((0[1-9]|[12][0-9]|3[0])(/)(0[469]|11))(/)\d{4}$)',
            'message' =>'Invalid date'],
        [['restaurantId'], 'exist', 'skipOnError' => true, 'targetClass' => Restaurant::className(), 'targetAttribute' => ['restaurantId' => 'restaurantId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'menuId' => 'Menu ID',
            'restaurantId' => 'Restaurant ID',
            'date' => 'Date',
        ];
    }

    /**
     * Gets query for [[Dishes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDishes()
    {
        return $this->hasMany(Dishes::className(), ['menuId' => 'menuId']);
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
}
