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
 * @property int $currentPeople
 * @property string $openingHour
 * @property string $closingHour
 * @property int $allowsPets
 * @property int $hasVegan
 * @property string $description
 * @property string $wifiPassword
 *
 * @property Menus[] $menuses
 * @property ProfileRestaurantFavorites[] $profileRestaurantFavorites
 * @property Profiles[] $profilesUsers
 * @property RestaurantReviews[] $restaurantReviews
 * @property Profiles[] $profilesUsers0
 * @property Staff[] $staff
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
            [['location', 'name', 'maxPeople', 'currentPeople', 'openingHour', 'closingHour', 'allowsPets', 'hasVegan', 'description', 'wifiPassword'], 'required'],
            [['maxPeople', 'currentPeople'], 'integer'],
            [['allowsPets', 'hasVegan'], 'boolean'],
            [['openingHour', 'closingHour'], 'safe'],
            [['description'], 'string'],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['location', 'name', 'wifiPassword'], 'string', 'max' => 255],
            ['currentPeople', 'compare', 'compareAttribute' => 'maxPeople', 'operator' => '<', 'type' => 'number'],
            ['maxPeople', 'compare', 'compareAttribute' => 'currentPeople', 'operator' => '>', 'type' => 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'restaurantId' => 'Restaurant ID',
            'image' => 'Image',
            'location' => 'Location',
            'name' => 'Name',
            'maxPeople' => 'Max People',
            'currentPeople' => 'Current People',
            'openingHour' => 'Opening Hour',
            'closingHour' => 'Closing Hour',
            'allowsPets' => 'Allows Pets',
            'hasVegan' => 'Has Vegan',
            'description' => 'Description',
            'wifiPassword' => 'Wifi Password',
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
}
