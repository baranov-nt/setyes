<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Ads');

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ads-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Ads'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php /*echo ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->id), ['view', 'id' => $model->id]);
        },
    ])*/ ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{summary}\n{items}<div class='col-md-12'>{pager}</div>",
        'itemView' => function ($model, $key, $index, $widget) {
            return $this->render('_ads',[
                'model' => $model,
                'key' => $key,
                'index' => $index,
                'widget' => $widget
            ]);
        },
        'itemOptions' => [
            'tag' => 'div',
            'class' => 'col-md-4',
        ],
        'pager' => [
            'firstPageLabel' => 'первая',
            'lastPageLabel' => 'последняя',
            'nextPageLabel' => 'следующая',
            'prevPageLabel' => 'предыдущая',
            'maxButtonCount' => 3,
        ],
        'summaryOptions' => [
            'tag' => 'div',
            'class' => 'col-md-12',
        ],
        'options' => [
            'tag' => 'div',
            'class' => 'list-wrapper row',
            'id' => 'list-wrapper',
        ],
    ]); ?>

</div>
<?php
d($model->id);
?>