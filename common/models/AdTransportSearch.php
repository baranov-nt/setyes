<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AdTransport;

/**
 * AdTransportSearch represents the model behind the search form about `common\models\AdTransport`.
 */
class AdTransportSearch extends AdTransport
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'transport', 'deal_type', 'id_car_model', 'mileage', 'measurement_of_mileage', 'price', 'price_for_the_period', 'condition', 'images_label'], 'integer'],
            [['video_link', 'model_scenario'], 'safe'],
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
        $query = AdTransport::find();

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
            'transport' => $this->transport,
            'deal_type' => $this->deal_type,
            'id_car_model' => $this->id_car_model,
            'mileage' => $this->mileage,
            'measurement_of_mileage' => $this->measurement_of_mileage,
            'price' => $this->price,
            'price_for_the_period' => $this->price_for_the_period,
            'condition' => $this->condition,
            'images_label' => $this->images_label,
        ]);

        $query->andFilterWhere(['like', 'video_link', $this->video_link])
            ->andFilterWhere(['like', 'model_scenario', $this->model_scenario]);

        return $dataProvider;
    }
}
