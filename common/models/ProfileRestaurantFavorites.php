<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "profile_restaurant_favorites".
 *
 * @property int $profiles_userId
 * @property int $restaurant_restaurantId
 *
 * @property Profiles $profilesUser
 * @property Restaurant $restaurantRestaurant
 */
class ProfileRestaurantFavorites extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile_restaurant_favorites';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profiles_userId', 'restaurant_restaurantId'], 'required'],
            [['profiles_userId', 'restaurant_restaurantId'], 'integer'],
            [['profiles_userId', 'restaurant_restaurantId'], 'unique', 'targetAttribute' => ['profiles_userId', 'restaurant_restaurantId']],
            [['profiles_userId'], 'exist', 'skipOnError' => true, 'targetClass' => Profiles::className(), 'targetAttribute' => ['profiles_userId' => 'userId']],
            [['restaurant_restaurantId'], 'exist', 'skipOnError' => true, 'targetClass' => Restaurant::className(), 'targetAttribute' => ['restaurant_restaurantId' => 'restaurantId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'profiles_userId' => 'Profiles User ID',
            'restaurant_restaurantId' => 'Restaurant Restaurant ID',
        ];
    }

    /**
     * Gets query for [[ProfilesUser]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfilesUser()
    {
        return $this->hasOne(Profiles::className(), ['userId' => 'profiles_userId']);
    }

    /**
     * Gets query for [[RestaurantRestaurant]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurantRestaurant()
    {
        return $this->hasOne(Restaurant::className(), ['restaurantId' => 'restaurant_restaurantId']);
    }
}
