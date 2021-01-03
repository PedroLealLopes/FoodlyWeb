<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Menus;

/**
 * MenusSearch represents the model behind the search form of `common\models\Menus`.
 */
class MenusSearch extends Menus
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['menuId', 'restaurantId'], 'integer'],
            [['date'], 'safe'],
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
        $query = Menus::find();

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
            'menuId' => $this->menuId,
            'restaurantId' => $this->restaurantId,
            'date' => $this->date,
        ]);

        return $dataProvider;
    }
}
