<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "restaurant".
 *
 * @property int $restaurantId
 * @property string $location
 * @property string $name
 * @property int $maxPeople
 *
 * @property Menus[] $menuses
 * @property ProfileRestaurantFavorites[] $profileRestaurantFavorites
 * @property Profiles[] $profilesUsers
 * @property RestaurantReviews[] $restaurantReviews
 * @property Profiles[] $profilesUsers0
 * @property Staff[] $staff
 * @property Users[] $users
 */
class Restaurant extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'restaurant';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['location', 'name', 'maxPeople'], 'required'],
            [['maxPeople'], 'integer'],
            [['location', 'name'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'restaurantId' => 'Restaurant ID',
            'location' => 'Location',
            'name' => 'Name',
            'maxPeople' => 'Max People',
        ];
    }

    /**
     * Gets query for [[Menuses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMenuses()
    {
        return $this->hasMany(Menus::className(), ['restaurantId' => 'restaurantId']);
    }

    /**
     * Gets query for [[ProfileRestaurantFavorites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfileRestaurantFavorites()
    {
        return $this->hasMany(ProfileRestaurantFavorites::className(), ['restaurant_restaurantId' => 'restaurantId']);
    }

    /**
     * Gets query for [[ProfilesUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfilesUsers()
    {
        return $this->hasMany(Profiles::className(), ['userId' => 'profiles_userId'])->viaTable('profile_restaurant_favorites', ['restaurant_restaurantId' => 'restaurantId']);
    }

    /**
     * Gets query for [[RestaurantReviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurantReviews()
    {
        return $this->hasMany(RestaurantReviews::className(), ['restaurant_restaurantId' => 'restaurantId']);
    }

    /**
     * Gets query for [[ProfilesUsers0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfilesUsers0()
    {
        return $this->hasMany(Profiles::className(), ['userId' => 'profiles_userId'])->viaTable('restaurant_reviews', ['restaurant_restaurantId' => 'restaurantId']);
    }

    /**
     * Gets query for [[Staff]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasMany(Staff::className(), ['restaurantId' => 'restaurantId']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['userId' => 'userId'])->viaTable('staff', ['restaurantId' => 'restaurantId']);
    }
}
