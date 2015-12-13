<?php
use frontend\assets\AppAsset;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use yii\helpers\Html;
use common\widgets\Alert;
use yii\widgets\Breadcrumbs;

/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 28.02.2015
 * Time: 1:48
 */
/* @var $content string
 * @var $this \yii\web\View */
/* @var \common\models\User $user */
$user = Yii::$app->user->identity;

AppAsset::register($this);

$this->beginPage();
?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <?= Html::csrfMetaTags() ?>
        <meta charset="<?= Yii::$app->charset ?>">
        <?php $this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1']); ?>
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
                'brandLabel' => Yii::t('app', 'Manage Site'),
                'brandUrl' => [
                    '/site/index'
                ],
                'brandOptions' => [
                    'class' => 'navbar-brand'
                ]
            ]
        );

        /*if(Yii::$app->user->can('Редактор')):
            $menuItems = [
                [
                    'label' => 'Управление контентом <span class="glyphicon glyphicon-th-list"></span>',
                    'items' => [
                        '<li class="dropdown-header">Выбрать раздел</li>',
                        '<li class="divider"></li>',
                    ]
                ],
            ];
        endif;*/

        if(Yii::$app->user->can('Администратор')):
            $menuItems[] =
                [
                    'label' => 'Bootstrap <span class="glyphicon glyphicon-cog"></span>',
                    'items' => [
                        [
                            'label' => 'Bootstrap дополнения.',
                            'url' => ['/bootstrap/index']
                        ],
                        [
                            'label' => 'Semantic UI.',
                            'url' => ['/bootstrap/semantic']
                        ],
                        [
                            'label' => 'Animate.css',
                            'url' => ['/bootstrap/animate']
                        ],
                        [
                            'label' => 'Scroll To',
                            'url' => ['/bootstrap/scroll-to']
                        ],
                    ]
                ];
            $menuItems[] =
                [
                    'label' => 'Работа с DB',
                    'items' => [
                        [
                            'label' => 'Работа с Active Record используя Join',
                            'url' => ['/db/active-record-join']
                        ],
                        [
                            'label' => 'Работа с Active Record',
                            'url' => ['/db/active-record']
                        ],
                        [
                            'label' => 'Работа с Query используя Join',
                            'url' => ['/db/query-join']
                        ],
                        [
                            'label' => 'Работа с Query',
                            'url' => ['/db/query']
                        ],
                        [
                            'label' => 'Работа с DAO',
                            'url' => ['/db/dao']
                        ]
                    ]
                ];
            $menuItems[] =
                [
                    'label' => Yii::t('app', 'Managing the application').' <span class="glyphicon glyphicon-cog"></span>',
                    'items' => [
                        '<li class="dropdown-header">'.Yii::t('app', 'Select a section').'</li>',
                        '<li class="divider"></li>',
                        [
                            'label' => Yii::t('app', 'Translate Panel'),
                            'url' => ['/translate-panel/index']
                        ],
                        [
                            'label' => Yii::t('app', 'User management'),
                            'url' => ['/user/index']
                        ],
                    ]
                ];
        endif;

        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => 'Войти', 'url' => ['/site/login']];
        } else {
            $menuItems[] = [
                'label' => 'Выйти (' . $user->email . ')',
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'post']
            ];
        }

        $menuItems[] = \common\widgets\LanguageSelect\LanguageSelect::widget();

        echo Nav::widget([
            'items' => $menuItems,
            'activateParents' => true,
            'encodeLabels' => false,
            'options' => [
                'class' => 'navbar-nav navbar-right'
            ]
        ]);

        NavBar::end();
           ?>

            <div class="container">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
    </div>

    <footer class="footer">
        <div class="container" >
            <span class="badge badge-primary">
                <span class="glyphicon glyphicon-copyright-mark"></span> Бояр <?= date('Y') ?>
            </span>
        </div>
    </footer>

    <?php $this->endBody(); ?>
    </body>
    </html>
<?php
$this->endPage();