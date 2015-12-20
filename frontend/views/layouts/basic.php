<?php
use frontend\assets\AppAsset;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use common\widgets\Alert;
use yii\helpers\Url;
use cybercog\yii\googleanalytics\widgets\GATracking;
use common\widgets\GooglePlacesAutoComplete\GooglePlacesAutoComplete;

/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 28.02.2015
 * Time: 1:48
 */
/* @var $content string
 * @var $this \yii\web\View */
AppAsset::register($this);
$this->beginPage();
?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">
    <head>
        <?= Html::csrfMetaTags() ?>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta property="og:type" content="website" />
        <meta property="og:site_name" content="<?= Yii::$app->controller->siteNameMeta ?>"/>
        <meta property="og:title" content="<?= Yii::$app->controller->titleMeta ?>" />
        <meta property="og:site_name" content="<?= Yii::$app->controller->siteNameMeta ?>"/>
        <meta property="og:description" content="<?= Yii::$app->controller->descriptionMeta ?>" />
        <meta property="og:image" content="<?= Yii::$app->controller->imageMeta ?>" />
        <meta property="og:url" content="<?= Yii::$app->controller->urlMeta ?>" />
        <meta property="og:locale" content="<?= Yii::$app->language ?>" />
        <meta property="fb:app_id" content="<?= Yii::$app->controller->appFbIdMeta ?>" />
        <?php $this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1']); ?>
        <?= GATracking::widget(
            [
                'trackingId' => 'UA-61158765-2'
            ]
        ) ?>
        <title><?= Yii::$app->name ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody(); ?>

    <div class="wrap">
        <?php
        NavBar::begin(
            [
                'options' => [
                    'class' => 'navbar navbar-default',
                    'style' => 'padding: 0; margin: 0',
                    'id' => 'main-menu'
                ],
                'renderInnerContainer' => true,
                'innerContainerOptions' => [
                    'class' => 'container'
                ],
                'brandLabel' => Yii::$app->name,
                'brandUrl' => [
                    '/main/index'
                ],
                'brandOptions' => [
                    'class' => 'navbar-brand'
                ]
            ]
        );

        if(Yii::$app->user->can('Создатель')):
            $menuItems = [
                [
                    'label' => Yii::t('app', 'Rules').'<span class="glyphicon glyphicon-question-sign"></span>',
                    'url' => [
                        '#'
                    ],
                    'linkOptions' => [
                        'data-toggle' => 'modal',
                        'data-target' => '#modal',
                        'style' => 'cursor: pointer; outline: none;'
                    ],
                ],
            ];
        endif;

        if (!Yii::$app->user->isGuest):
            $user = Yii::$app->user->identity;
            /* @var $user common\models\User */
            if($user->profile->imagesOfObjects):
            foreach($user->profile->imagesOfObjects as $one):
                /* @var $one common\models\ImagesOfObject */
                $image = Html::img('/images/'.$one->image->path_small_image, ['style' => 'width: 35px; border: 2px solid #ffffff; border-radius: 3px;']);
            endforeach;
            else:
                $image = '<span class="btn btn-default glyphicon glyphicon-user" style=""></span>';
            endif;
            $menuItems[] = [
                'label' => $image,
                'items' => [
                    '<li class="dropdown-header">'.Yii::$app->user->identity['email'].'</li>',
                    '<li class="divider"></li>',
                    [
                        'label' => Yii::t('app', 'Profile'),
                        'url' => Url::to(['/main/profile'])
                    ],
                    [
                        'label' => Yii::t('app', 'Logout'),
                        'url' => Url::to(['/main/logout'])
                    ]
                ],
                'linkOptions' => [
                    'style' => 'margin: 6px 0 0 20px; padding: 0'
                ]
            ];

        else:
            $menuItems[] = [
                'label' => '<span class="btn btn-default glyphicon glyphicon-question-sign" style=""></span>',
                'items' => [
                    '<li class="dropdown-header">'.Yii::t('app', 'Authorization').'</li>',
                    '<li class="divider"></li>',
                    [
                        'label' => Yii::t('app', 'Login'),
                        'url' => Url::to(['/main/login'])
                    ],
                    [
                        'label' => Yii::t('app', 'Registration'),
                        'url' => Url::to(['/main/reg'])
                    ]
                ],
                'linkOptions' => [
                    'style' => 'margin: 6px 0 0 20px; padding: 0'
                ]
            ];

        endif;

        $menuItems[] = \common\widgets\LanguageSelect\LanguageSelect::widget();

        echo Nav::widget([
            'items' => $menuItems,
            'activateParents' => true,
            'encodeLabels' => false,
            'options' => [
                'class' => 'navbar-nav navbar-right'
            ]
        ]);

        Modal::begin(
            [
                'size' => "modal-lg",
                'header' => '<h2>'.Yii::t('app', 'Feed ads').'</h2>',
                'id' => 'modal'
            ]
        );
        echo Yii::t('app', 'Rules');
        Modal::end();
        ?>


        <?php
        //if(!Yii::$app->user->isGuest && Yii::$app->user->can('Создатель')):
            ActiveForm::begin([
                'action' => ['/main/select-city'],
                'options' => [
                'class' => 'navbar-right col-md-6',
                'style' => 'margin: 7px 0 8px 0;'
            ]]);
        ?>
                        <?php
            echo '<div class="input-group">';

            echo GooglePlacesAutoComplete::widget([
                'name' => 'place',
                'value' => ''
            ]);

            echo '<span class="input-group-btn">';
            echo Html::submitButton(
                '<span class="glyphicon glyphicon-search"></span>',
                [
                    'class' => 'btn btn-success',
                ]
            );
            echo '</span></div>';
        ?>
        <?php
            ActiveForm::end();
            ?>

            <?php
        //endif;

        NavBar::end();

        if(Yii::$app->controller->id == 'main' && Yii::$app->controller->action->id == 'index'):
            ?>
            <?= $content ?>
            <div class="container">
                <?= Alert::widget() ?>
            </div>
            <?php
        else:
            ?>
            <div class="container">
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
            <?php
        endif;
        ?>
    </div>

    <footer class="footer" style="background-color: #337ab7; max-height: 100%;">
        <div class="container" >
            <span class="badge badge-primary">
                <span class="glyphicon glyphicon-copyright-mark"></span> <?= Yii::$app->name.' '.date('Y') ?>
            </span>
        </div>
    </footer>

    <?php $this->endBody(); ?>
    </body>
    </html>
<?php
$this->endPage();