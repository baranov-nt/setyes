<?php
namespace frontend\controllers;

use Yii;
use frontend\models\RegForm;
use common\models\LoginForm;
use common\models\User;
use common\models\Profile;
use frontend\models\SendEmailForm;
use frontend\models\ResetPasswordForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\AccountActivation;
use common\models\Carousel;
use yii\web\ErrorAction;
use common\models\City;
use common\models\Region;
use common\models\Country;

class MainController extends BehaviorsController
{
    public $layout = 'basic';
    public $defaultAction = 'login';

    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::className(),
            ],
        ];
    }

    public function actionIndex()
    {
        $carousel = Carousel::find()->all();

        return $this->render(
            'index',
            [
                'carousel' => $carousel
            ]);
    }

    public function actionFinishReg($id)
    {
        /* @var $modelUser \common\models\User */
        /* @var $model \frontend\models\RegForm */

        $modelUser = User::findOne($id);

        if($modelUser->email == ''):
            $model = new RegForm(['scenario' => 'phoneAndEmailFinish']);
        elseif($modelUser->email != ''):
            $model = new RegForm(['scenario' => 'phoneFinish']);
        endif;

        if ($model->load(Yii::$app->request->post()) && $model->validate()):
            if ($modelUser = $model->finishReg($id)):
                if ($modelUser->status === User::STATUS_ACTIVE):
                    if (Yii::$app->getUser()->login($modelUser)):
                        return $this->goHome();
                    endif;
                else:
                    if($model->sendActivationEmail($modelUser)):
                        Yii::$app->session->setFlash('success', 'Письмо с активацией отправлено на емайл <strong>'.Html::encode($modelUser->email).'</strong> (проверьте папку спам).');
                        return $this->redirect(Url::to(['/main/login']));
                    else:
                        Yii::$app->session->setFlash('error', 'Ошибка. Письмо не отправлено.');
                        Yii::error('Ошибка отправки письма.');
                    endif;
                    return $this->refresh();
                endif;
            else:
                Yii::$app->session->setFlash('error', 'Возникла ошибка при регистрации.');
                Yii::error('Ошибка при регистрации');
                return $this->refresh();
            endif;
        endif;

        return $this->render(
            'reg',
            [
                'modelUser' => $modelUser,
                'model' => $model
            ]
        );
    }

    public function actionReg()
    {
        //dd(Yii::$app->request->post());
        $emailActivation = Yii::$app->params['emailActivation'];
        $model = $emailActivation ? new RegForm(['scenario' => 'emailActivation']) : new RegForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()):
            if ($user = $model->reg()):
                if ($user->status === User::STATUS_ACTIVE):
                    if (Yii::$app->getUser()->login($user)):
                        return $this->goHome();
                    endif;
                else:
                    if($model->sendActivationEmail($user)):
                        Yii::$app->session->setFlash('success', 'Письмо с активацией отправлено на емайл <strong>'.Html::encode($user->email).'</strong> (проверьте папку спам).');
                    else:
                        Yii::$app->session->setFlash('error', 'Ошибка. Письмо не отправлено.');
                        Yii::error('Ошибка отправки письма.');
                    endif;
                    return $this->refresh();
                endif;
            else:
                Yii::$app->session->setFlash('error', 'Возникла ошибка при регистрации.');
                Yii::error('Ошибка при регистрации');
                return $this->refresh();
            endif;
        endif;

        return $this->render(
            'reg',
            [
                'model' => $model
            ]
        );
    }

    public function actionActivateAccount($key)
    {
        /* @var $modelUser \common\models\User */

        if (!Yii::$app->user->isGuest):
            return $this->goHome();
        endif;

        try {
            $user = new AccountActivation($key);
        }
        catch(InvalidParamException $e) {
            Yii::$app->session->setFlash('error', 'Не верный ключ. Повторите регистрацию.');
            throw new BadRequestHttpException($e->getMessage());
        }

        if($user = $user->activateAccount()):
            Yii::$app->session->setFlash('success', 'Активация прошла успешно. Теперь вы можете заказывать продукцию компании Бояр на дом!!!');
            Yii::$app->getUser()->login($user);
            return $this->redirect(['/main/profile']);
        else:
            Yii::$app->session->setFlash('error', 'Ошибка активации.');
            Yii::error('Ошибка при активации.');
        endif;

        return $this->redirect(Url::to(['/main/index']));
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['/main/index']);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest):
            return $this->goHome();
        endif;

        $loginWithEmail = Yii::$app->params['loginWithEmail'];

        $model = $loginWithEmail ? new LoginForm(['scenario' => 'loginWithEmail']) : new LoginForm(['scenario' => 'default']);

        if ($model->load(Yii::$app->request->post()) && $model->login()):
            return $this->goBack();
        endif;

        return $this->render(
            'login',
            [
                'model' => $model
            ]
        );
    }

    public function actionSearch()
    {
        $search = Yii::$app->session->get('search');
        Yii::$app->session->remove('search');

        if ($search):
            Yii::$app->session->setFlash(
                'success',
                'Результат поиска'
            );
        else:
            Yii::$app->session->setFlash(
                'error',
                'Не заполнена форма поиска'
            );
        endif;

        return $this->render(
            'search',
            [
                'search' => $search
            ]
        );
    }

    public function actionSendEmail()
    {
        $model = new SendEmailForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if($model->sendEmail()):
                    Yii::$app->getSession()->setFlash('warning', 'Проверьте емайл.');
                    return $this->goHome();
                else:
                    Yii::$app->getSession()->setFlash('error', 'Нельзя сбросить пароль.');
                endif;
            }
        }

        return $this->render('sendEmail', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($key)
    {
        try {
            $model = new ResetPasswordForm($key);
        }
        catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate() && $model->resetPassword()) {
                Yii::$app->getSession()->setFlash('warning', 'Пароль изменен.');
                return $this->redirect(['/main/login']);
            }
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionUser()
    {
        $modelProfile = ($modelProfile = Profile::findOne(Yii::$app->user->id)) ? $modelProfile : new Profile();

        $modelUser = ($modelUser = User::findOne(Yii::$app->user->id)) ? $modelUser : new User();

        if($modelUser->load(Yii::$app->request->post()) && $modelUser->validate()):
            if($modelUser->updateUser()):
                //Yii::$app->session->setFlash('success', 'Профиль изменен');
            else:
                //Yii::$app->session->setFlash('error', 'Профиль не изменен');
                Yii::error('Ошибка записи. Профиль не изменен');
                return $this->refresh();
            endif;
        endif;

        return $this->render(
            'profile',
            [
                'modelProfile' => $modelProfile,
                'modelUser' => $modelUser
            ]
        );
    }

    public function actionProfile()
    {
        /* @var $modelProfile \common\models\Profile */

        $modelProfile = $modelProfile = Profile::findOne(Yii::$app->user->id);

        $imagesObject = $modelProfile->imagesOfObjects;

        $modelUser = ($modelUser = User::findOne(Yii::$app->user->id)) ? $modelUser : new User();

        if($modelProfile->load(Yii::$app->request->post()) && $modelProfile->validate()):
            if($modelProfile->updateProfile()):
                if(!$modelProfile->user->errors):
                    Yii::$app->session->setFlash('success', 'Профиль изменен');
                endif;
            else:
                Yii::$app->session->setFlash('error', 'Профиль не изменен');
                Yii::error('Ошибка записи. Профиль не изменен');
                return $this->refresh();
            endif;
        endif;

        return $this->render(
            'profile',
            [
                'modelProfile' => $modelProfile,
                'modelUser' => $modelUser,
                'imagesObject' => $imagesObject
            ]
        );
    }

    public function actionViewProfile($id)
    {
        /* @var $modelProfile \common\models\Profile */

        $modelProfile = ($model = Profile::findOne($id)) ? $model : new Profile();
        $this->titleMeta = $modelProfile->first_name.' '.$modelProfile->second_name;
        $this->descriptionMeta = 'Карточка пользователя';
        foreach($modelProfile->imagesOfObjects as $one):
            $this->imageMeta = Yii::$app->urlManager->createAbsoluteUrl('').'images/'.$one->image->path_small_image;
        endforeach;

        return $this->render(
            'view-profile', [
                'modelProfile' => $modelProfile
            ]
        );
    }

    public function actionSelectCity()
    {
        $place = Yii::$app->request->post('place');
        $object = \Yii::$app->googleApi->getGeoCodeObject($place, null);

        /* Если вернулся объект города */
        if(isset($object)):
            $city = '';
            $region = '';
            $country = '';
            foreach($object->address_components as $one):
                if($one->types[0] == 'locality'):
                    $city = $one->short_name;
                endif;
                if($one->types[0] == 'administrative_area_level_1'):            // ищем облать-регион
                    $region = $one->short_name;
                endif;
                if($one->types[0] == 'country'):
                    $country = $one->short_name;
                endif;
            endforeach;

            $object = \Yii::$app->googleApi->getGeoCodeObject($city.' '.$region.' '.$country, null);
            $formattedAddress = $object->formatted_address;            // форматированный адрес (строка)
            $cityId = $object->place_id;                               // идентификатор города

            /* Находим введенный город в базе по place_id */
            /* @var $modelCity \common\models\City */
            $modelCity = City::findOne(['place_id' => $cityId]);

            if($modelCity):
                // если город найден выставляем куки и переходим на главную страницу с get переменной city
                $this->setCookie($formattedAddress, $modelCity);
                Yii::$app->session->set('_cityId', $modelCity->id);
                return $this->redirect(Url::to(['/main/index', 'city' => $modelCity->id]));
            else:
                // если город не найден, находим регион
                $objectRegion = \Yii::$app->googleApi->getGeoCodeObject($region.' '.$country, null);
                $regionId = $objectRegion->place_id;
                // ищем регион в базе
                /* @var $modelRegion \common\models\Region */
                $modelRegion = Region::findOne(['place_id' => $regionId]);

                if($modelRegion):
                    // если регион найден
                    $modelCity = new City();
                    // добавляем новый город к найденному региону, пишем куки и переходим на главную страницу с get переменной city
                    $modelCity = $modelCity->createCity($modelRegion, $cityId);
                    $this->setCookie($formattedAddress, $modelCity);
                    Yii::$app->session->set('_cityId', $modelCity->id);
                    return $this->redirect(Url::to(['/main/index', 'city' => $modelCity->id]));
                else:
                    // если регион не найден, находим страну
                    foreach($object->address_components as $one):
                        if($one->types[0] == 'country'):
                            $country = $one->short_name;
                        endif;
                    endforeach;
                    $modelCountry = Country::findOne(['iso2' => $country]);
                    // если страна найдена
                    if($modelCountry):
                        $modelRegion = new Region();
                        // Добавляем новый регион и город, пишем куки и переходим на главную страницу с get переменной city
                        $modelCity = $modelRegion->createRegionAndCity($modelCountry, $regionId, $cityId);
                        $this->setCookie($formattedAddress, $modelCity);
                        Yii::$app->session->set('_cityId', $modelCity->id);
                        return $this->redirect(Url::to(['/main/index', 'city' => $modelCity->id]));
                    endif;
                endif;
            endif;
        endif;

        /* Если объект не найден, чистим куки в переходим на главную страницу */
        $this->clearCookie();

        return $this->redirect(Url::to(['/main/index']));
    }

    public function setCookie($formattedAddress, $modelCity)
    {
        $cookies = Yii::$app->response->cookies;
        $cookies->add(new \yii\web\Cookie([
            'name' => '_city',
            'value' => $formattedAddress,
            'expire' => time() + 86400 * 365,
        ]));

        /* Страна в iso2 (например RU) */
        $cookies->add(new \yii\web\Cookie([
            'name' => '_cityId',
            'value' => $modelCity->id,
            'expire' => time() + 86400 * 365,
        ]));

        /* place_id города */
        $cookies->add(new \yii\web\Cookie([
            'name' => '_cityPlaceId',
            'value' => $modelCity->place_id,
            'expire' => time() + 86400 * 365,
        ]));

        /* place_id региона */
        $cookies->add(new \yii\web\Cookie([
            'name' => '_regionId',
            'value' => $modelCity->region->place_id,
            'expire' => time() + 86400 * 365,
        ]));

        /* Страна в iso2 (например RU) */
        $cookies->add(new \yii\web\Cookie([
            'name' => '_countryId',
            'value' => $modelCity->region->country->id,
            'expire' => time() + 86400 * 365,
        ]));
    }

    public function clearCookie()
    {
        $cookies = Yii::$app->response->cookies;
        $cookies->remove('_city');
        $cookies->remove('_cityId');
        $cookies->remove('_cityPlaceId');
        $cookies->remove('_regionId');
        $cookies->remove('_countryId');
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
        return false;
    }
}
