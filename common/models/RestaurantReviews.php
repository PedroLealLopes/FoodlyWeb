<?php

namespace common\models;

use Yii;
use yii\debug\models\search\Profile;

/**
 * This is the model class for table "restaurant_reviews".
 *
 * @property int $restaurant_restaurantId
 * @property int $profiles_userId
 * @property float $stars
 * @property string|null $comment
 *
 * @property Profiles $profilesUser
 * @property Restaurant $restaurantRestaurant
 */
class RestaurantReviews extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'restaurant_reviews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['restaurant_restaurantId', 'profiles_userId', 'stars'], 'required'],
            [['restaurant_restaurantId', 'profiles_userId'], 'integer'],
            [['stars'], 'number'],
            [['comment'], 'string'],
            [['creation_date'], 'date'],
            [['restaurant_restaurantId', 'profiles_userId'], 'unique', 'targetAttribute' => ['restaurant_restaurantId', 'profiles_userId']],
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
            'restaurant_restaurantId' => 'Restaurant Restaurant ID',
            'profiles_userId' => 'Profiles User ID',
            'stars' => 'Stars',
            'creation_date' =>'date',
            'comment' => 'Comment',
        ];
    }
    
    public function fields()
    {
        return ['restaurant_restaurantId', 'profiles_userId', 'stars', 'comment', 'creation_date',
            'username' => function($model){
                $profile = $model->profiles_userId;
                $profile = new Profiles();
                $profile = $profile->findIdentity($model->profiles_userId);
                return $profile->fullname;
            },
            'image' => function ($model) { 
                $profile = $model->profiles_userId;
                $profile = new Profiles();
                $profile = $profile->findIdentity($model->profiles_userId);
                $imageName = $profile->image;
                if($imageName != null){
                    $path = "../../common/images/profiles/$imageName";
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = file_get_contents($path);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

                    $profile->image = $base64;
                    return $profile->image;
                }
            },
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
