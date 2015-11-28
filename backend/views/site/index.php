<?php
use yii\bootstrap\Dropdown;
use common\widgets\LanguageDropdown\LanguageDropdown;
/* @var $this yii\web\View */

$this->title = 'Управение продуктами';



if(Yii::$app->user->can('Управлять товарами')):
    ?>
    <h1>Управление продукцией</h1>
    <?php
elseif(Yii::$app->user->can('Управлять пользователями')):
    ?>
    <h1>Управление продукцией и пользователями</h1>
    <?php
else:
    ?>
    <h1>У вас нет прав к данному разделу!!!</h1>
    <?php
endif;
?>
            <?php
            echo \common\widgets\LanguageSelect\LanguageSelect::widget();
            ?>
<?php


