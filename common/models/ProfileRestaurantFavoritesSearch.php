<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ProfileRestaurantFavorites;

/**
 * ProfileRestaurantFavoritesSearch represents the model behind the search form of `common\models\ProfileRestaurantFavorites`.
 */
class ProfileRestaurantFavoritesSearch extends ProfileRestaurantFavorites
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profiles_userId', 'restaurant_restaurantId'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ProfileRestaurantFavorites::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'profiles_userId' => $this->profiles_userId,
            'restaurant_restaurantId' => $this->restaurant_restaurantId,
        ]);

        return $dataProvider;
    }
}
