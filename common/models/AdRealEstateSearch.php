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
            [['id', 'property', 'property_type', 'operation_type', 'rooms_in_the_apartment', 'material_housing', 'floor', 'floors_in_the_house', 'area', 'system_measure', 'lease_term', 'price', 'price_period', 'necessary_furniture', 'internet', 'condition'], 'integer'],
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
            'property_type' => $this->property_type,
            'operation_type' => $this->operation_type,
            'rooms_in_the_apartment' => $this->rooms_in_the_apartment,
            'material_housing' => $this->material_housing,
            'floor' => $this->floor,
            'floors_in_the_house' => $this->floors_in_the_house,
            'area' => $this->area,
            'system_measure' => $this->system_measure,
            'lease_term' => $this->lease_term,
            'price' => $this->price,
            'price_period' => $this->price_period,
            'necessary_furniture' => $this->necessary_furniture,
            'internet' => $this->internet,
            'condition' => $this->condition,
        ]);

        return $dataProvider;
    }
}
