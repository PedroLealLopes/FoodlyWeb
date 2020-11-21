<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ingredients".
 *
 * @property int $ingredientId
 * @property string $name
 * @property float $stock
 *
 * @property DishesIngredients[] $dishesIngredients
 * @property Dishes[] $dishes
 */
class Ingredients extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ingredients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'stock'], 'required'],
            [['stock'], 'number'],
            [['name'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ingredientId' => 'Ingredient ID',
            'name' => 'Name',
            'stock' => 'Stock',
        ];
    }

    /**
     * Gets query for [[DishesIngredients]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDishesIngredients()
    {
        return $this->hasMany(DishesIngredients::className(), ['ingredientId' => 'ingredientId']);
    }

    /**
     * Gets query for [[Dishes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDishes()
    {
        return $this->hasMany(Dishes::className(), ['dishId' => 'dishId'])->viaTable('dishes_ingredients', ['ingredientId' => 'ingredientId']);
    }
}
