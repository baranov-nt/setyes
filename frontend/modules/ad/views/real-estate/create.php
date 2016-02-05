<?php
use yii\bootstrap\Nav;
use yii\widgets\Pjax;
use common\widgets\Chosen\ChosenAsset;
use common\widgets\FontAwesome\AssetBundle;
use yii\widgets\MaskedInput;

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
AssetBundle::register($this);
ChosenAsset::register($this);
MaskedInput::widget([
    'name' => 'masked-input_init',
    'clientOptions' => [
        'alias' => 'decimal',
    ],
]);
//
echo Nav::widget([
    'items' => $modelAdRealEstate->realEstatePropertyList,
    'activateParents' => true,
    'encodeLabels' => false,
    'options' => [
        'class' => 'nav nav-tabs',
    ]
]);
?>

<?php if($modelAdRealEstate->scenario != 'default'):
    ?>
    <?= $this->render('_form', [
        'modelAdRealEstate' => $modelAdRealEstate,
        'pjaxUrl' => $pjaxUrl
    ]);

    ?>
<?php
endif;
?>

<?php
Pjax::end();
?>

