<?php
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model common\models\AdRealEstate */
/* @var $realEstateProperty common\models\AdRealEstateReference */

$this->title = Yii::t('app', 'Create Ad Real Estate');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ad Real Estates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$items = [];
foreach($model->realEstatePropertyList as $key => $value):
    switch ($key) {
        case 1:
            $items[] = [
                'label' => Yii::t('references', $value),
                'content' => $this->render('create/rooms', ['model' => $model, 'title' => $value]),
            ];
            break;
        case 2:
            $items[] = [
                'label' => Yii::t('references', $value),
                'content' => $this->render('create/apartments', ['model' => $model, 'title' => $value]),
            ];
            break;
        case 3:
            $items[] = [
                'label' => Yii::t('references', $value),
                'content' => $this->render('create/houses-cottages', ['model' => $model, 'title' => $value]),
            ];
            break;
        case 4:
            $items[] = [
                'label' => Yii::t('references', $value),
                'content' => $this->render('create/land-plot', ['model' => $model, 'title' => $value]),
            ];
            break;
        case 5:
            $items[] = [
                'label' => Yii::t('references', $value),
                'content' => $this->render('create/garages-parking', ['model' => $model, 'title' => $value]),
            ];
            break;
        case 6:
            $items[] = [
                'label' => Yii::t('references', $value),
                'content' => $this->render('create/property-abroad', ['model' => $model, 'title' => $value]),
            ];
            break;
        case 7:
            $items[] = [
                'label' => Yii::t('references', $value),
                'content' => $this->render('create/commercial-property', ['model' => $model, 'title' => $value]),
            ];
            break;
    }
endforeach;

echo Tabs::widget([
    'items' => $items,
]);
?>

