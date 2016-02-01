<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AdRealEstate;

/**
 * AdRealEstateSearch represents the model behind the search form about `common\models\AdRealEstate`.
 */
class AdRealEstateSearch extends AdRealEstate
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'property', 'type_of_property', 'deal_type', 'place_address_id', 'rooms_in_the_apartment', 'material_housing', 'floor', 'floors_in_the_house', 'area_of_property', 'area_of_land', 'system_measure', 'lease_term', 'price', 'price_for_the_period', 'necessary_furniture', 'internet', 'pets_allowed', 'condition'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = AdRealEstate::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'property' => $this->property,
            'type_of_property' => $this->type_of_property,
            'deal_type' => $this->deal_type,
            'place_address_id' => $this->place_address_id,
            'rooms_in_the_apartment' => $this->rooms_in_the_apartment,
            'material_housing' => $this->material_housing,
            'floor' => $this->floor,
            'floors_in_the_house' => $this->floors_in_the_house,
            'area_of_property' => $this->area_of_property,
            'area_of_land' => $this->area_of_land,
            'system_measure' => $this->system_measure,
            'lease_term' => $this->lease_term,
            'price' => $this->price,
            'price_for_the_period' => $this->price_for_the_period,
            'necessary_furniture' => $this->necessary_furniture,
            'internet' => $this->internet,
            'pets_allowed' => $this->pets_allowed,
            'condition' => $this->condition,
        ]);

        return $dataProvider;
    }
}