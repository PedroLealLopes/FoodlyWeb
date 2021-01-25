<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\RestaurantReviews;

/**
 * RestaurantReviewsSearch represents the model behind the search form of `common\models\RestaurantReviews`.
 */
class RestaurantReviewsSearch extends RestaurantReviews
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['restaurant_restaurantId', 'profiles_userId'], 'integer'],
            [['stars'], 'number'],
            [['comment'], 'safe'],
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
        $query = RestaurantReviews::find();

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
            'restaurant_restaurantId' => $this->restaurant_restaurantId,
            'profiles_userId' => $this->profiles_userId,
            'stars' => $this->stars,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
