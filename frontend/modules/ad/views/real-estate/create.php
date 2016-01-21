<?php
use yii\bootstrap\Nav;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\AdRealEstate */
/* @var $realEstateProperty common\models\AdRealEstateReference */
/* @var $pjaxUrl string */

$this->title = Yii::t('app', 'Create Ad Real Estate');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ad Real Estates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
Pjax::begin([
    //'enablePushState' => false,
]);
Yii::$app->view->registerJs('$(".chosen-select").chosen({disable_search_threshold: 10});', \yii\web\View::POS_READY);
echo Nav::widget([
    'items' => $model->realEstatePropertyList,
    'activateParents' => true,
    'encodeLabels' => false,
    'options' => [
        'class' => 'nav nav-tabs',
    ]
]);
?>

<?php if($model->scenario != 'default'): ?>
    <?= $this->render('_form', [
        'model' => $model,
        'pjaxUrl' => $pjaxUrl
    ]) ?>
<?php
endif;
?>

<?php
Pjax::end();
?>

