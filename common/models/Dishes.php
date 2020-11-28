<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dishes".
 *
 * @property int $dishId
 * @property string $name
 * @property string|null $description
 * @property string $type
 * @property float $price
 * @property int $menuId
 *
 * @property DishReview[] $dishReviews
 * @property Profiles[] $profilesUsers
 * @property Menus $menu
 * @property DishesIngredients[] $dishesIngredients
 * @property Ingredients[] $ingredients
 * @property OrderItems[] $orderItems
 * @property Orders[] $orders
 */
class Dishes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dishes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type', 'price', 'menuId'], 'required'],
            [['description', 'type'], 'string'],
            [['price'], 'number'],
            [['menuId'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['menuId'], 'exist', 'skipOnError' => true, 'targetClass' => Menus::className(), 'targetAttribute' => ['menuId' => 'menuId']],
            ['price', 'compare', 'compareValue' => '0', 'operator' => '>', 'type' => 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'dishId' => 'Dish ID',
            'name' => 'Name',
            'description' => 'Description',
            'type' => 'Type',
            'price' => 'Price',
            'menuId' => 'Menu ID',
        ];
    }

    /**
     * Gets query for [[DishReviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDishReviews()
    {
        return $this->hasMany(DishReview::className(), ['dishes_dishId' => 'dishId']);
    }

    /**
     * Gets query for [[ProfilesUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfilesUsers()
    {
        return $this->hasMany(Profiles::className(), ['userId' => 'profiles_userId'])->viaTable('dish_review', ['dishes_dishId' => 'dishId']);
    }

    /**
     * Gets query for [[Menu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menus::className(), ['menuId' => 'menuId']);
    }

    /**
     * Gets query for [[DishesIngredients]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDishesIngredients()
    {
        return $this->hasMany(DishesIngredients::className(), ['dishId' => 'dishId']);
    }

    /**
     * Gets query for [[Ingredients]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIngredients()
    {
        return $this->hasMany(Ingredients::className(), ['ingredientId' => 'ingredientId'])->viaTable('dishes_ingredients', ['dishId' => 'dishId']);
    }

    /**
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItems::className(), ['dishId' => 'dishId']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::className(), ['orderId' => 'orderId'])->viaTable('order_items', ['dishId' => 'dishId']);
    }
}
