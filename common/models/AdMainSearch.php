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
    public $deal_type;
    public $deal_query;
    public $not_owner;
    public $not_this;
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
        $this->deal_query = [];
        if($this->deal_type)
            $this->deal_query = ['deal_type' => $this->deal_type];
        if($this->not_owner)
            $this->not_owner = ['!=', 'user_id', Yii::$app->user->id];
        if($this->not_this)
            $this->not_owner = ['!=', 'user_id', $this->id];
        $query = AdMain::find()
            ->joinWith('adCategory')
            ->joinWith([
                'adCategory.ad' => function ($query) {
                    $query->andWhere(['temp' => 0]);
                    $query->andWhere($this->deal_query);
                },
            ])
            ->where($this->not_owner)
            ->orderBy([
                'updated_at' => SORT_DESC]);

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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchFavorites($params)
    {
        $query = AdMain::find()
            ->joinWith('adCategory')
            ->joinWith([
                'adCategory.ad' => function ($query) {
                    $query->andWhere(['temp' => 0]);
                },
            ])
            ->joinWith('adFavorites')
            ->andWhere([AdFavorite::tableName().'.user_id' => Yii::$app->user->id])
            ->orderBy([
                'updated_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        return $dataProvider;
    }
}
