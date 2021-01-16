<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "profiles".
 *
 * @property int $userId
 * @property string $fullname
 * @property int $age
 * @property string|null $alergias
 * @property string|null $genero
 *
 * @property DishReview[] $dishReviews
 * @property Dishes[] $dishesDishes
 * @property Orders[] $orders
 * @property ProfileRestaurantFavorites[] $profileRestaurantFavorites
 * @property Restaurant[] $restaurantRestaurants
 * @property User $user
 * @property RestaurantReviews[] $restaurantReviews
 * @property Restaurant[] $restaurantRestaurants0
 */
class Profiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profiles';
    }

    public function fields()
    {
        return [
            'userId', 'fullname', 'age', 'alergias', 'genero', 'telefone', 'morada',
            'image' => function ($model) { 
                $imageName = $model->image;
                if($imageName != null){
                    $path = "../../common/images/profiles/$imageName";
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = file_get_contents($path);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        
                    $model->image = $base64;
                    return $model->image;
                }
            },
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fullname', 'age'], 'required'],
            [['age'], 'integer'],
            [['alergias'], 'string'],
            ['genero', 'in', 'range' => ['M', 'F']],
            [['fullname'], 'string', 'max' => 45],
            [['userId'], 'unique'],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'userId' => 'User ID',
            'fullname' => 'Fullname',
            'image' => 'Image',
            'age' => 'Age',
            'alergias' => 'Alergias',
            'genero' => 'Genero',
        ];
    }

    /**
     * Gets query for [[DishReviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDishReviews()
    {
        return $this->hasMany(DishReview::className(), ['profiles_userId' => 'userId']);
    }

    /**
     * Gets query for [[DishesDishes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDishesDishes()
    {
        return $this->hasMany(Dishes::className(), ['dishId' => 'dishes_dishId'])->viaTable('dish_review', ['profiles_userId' => 'userId']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::className(), ['userId' => 'userId']);
    }

    /**
     * Gets query for [[ProfileRestaurantFavorites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfileRestaurantFavorites()
    {
        return $this->hasMany(ProfileRestaurantFavorites::className(), ['profiles_userId' => 'userId']);
    }

    /**
     * Gets query for [[RestaurantRestaurants]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurantRestaurants()
    {
        return $this->hasMany(Restaurant::className(), ['restaurantId' => 'restaurant_restaurantId'])->viaTable('profile_restaurant_favorites', ['profiles_userId' => 'userId']);
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

    /**
     * Gets query for [[RestaurantReviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurantReviews()
    {
        return $this->hasMany(RestaurantReviews::className(), ['profiles_userId' => 'userId']);
    }

    /**
     * Gets query for [[RestaurantRestaurants0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurantRestaurants0()
    {
        return $this->hasMany(Restaurant::className(), ['restaurantId' => 'restaurant_restaurantId'])->viaTable('restaurant_reviews', ['profiles_userId' => 'userId']);
    }
}
