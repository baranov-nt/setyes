<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AdMainSearch represents the model behind the search form about `common\models\AdMain`.
 */
class AdMainSearch extends AdMain
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'place_city_id', 'category_id', 'ad_style_id'], 'integer'],
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
        $query = AdMain::find()
            ->joinWith('adCategory')
            ->joinWith([
                'adCategory.ad' => function ($query) {
                    $query->andWhere(['temp' => 0]);
                },
            ]);

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
            'user_id' => $this->user_id,
            'place_city_id' => $this->place_city_id,
            'category_id' => $this->category_id,
            'ad_style_id' => $this->ad_style_id,
        ]);

        return $dataProvider;
    }
}
