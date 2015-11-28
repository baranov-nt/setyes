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
$lang = Yii::$app->language;
switch($lang):
    case 'en':
        $current = 'English';
        break;
    case 'ru':
        $current = 'Русский';
        break;
    case 'de':
        $current = "German";
        break;
    case 'fr':
        $current = "French";
        break;
endswitch;
?>
    <div class="navbar-nav navbar-right nav">
        <div class="dropdown">
            <a href="#" data-toggle="dropdown" class="dropdown-toggle"><?= $current ?><b class="caret"></b></a>
            <?php
            echo LanguageDropdown::widget();
            ?>
        </div>
    </div>
<?php


