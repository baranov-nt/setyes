<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdRealEstateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Ad Real Estates');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="ad-real-estate-index">

        <h1><?= Html::encode($this->title) ?></h1>
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>

        <p>
            <?= Html::a(Yii::t('app', 'Create Ad Real Estate'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item'],
            'itemView' => function ($model, $key, $index, $widget) {
                return Html::a(Html::encode($model->id), ['view', 'id' => $model->id]);
            },
        ]) ?>
    </div>
</div>
