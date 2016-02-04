<?php
use yii\bootstrap\Nav;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $modelAdRealEstate common\models\AdRealEstate */
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
    'items' => $modelAdRealEstate->realEstatePropertyList,
    'activateParents' => true,
    'encodeLabels' => false,
    'options' => [
        'class' => 'nav nav-tabs',
    ]
]);
?>

<?php if($modelAdRealEstate->scenario != 'default'): ?>
    <?= $this->render('_form', [
        'modelAdRealEstate' => $modelAdRealEstate,
        'pjaxUrl' => $pjaxUrl
    ]) ?>
<?php
endif;
?>

<?php
Pjax::end();
?>

