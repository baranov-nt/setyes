<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 23.12.2015
 * Time: 14:47
 */
use yii\helpers\Html;
use yii\helpers\Url;

d($model->id);
?>
<?= Html::a(Html::encode('Открыть'), Url::to(['/ads/default/view', 'id' => $model->id]), ['class' => 'btn btn-primary']) ?>
