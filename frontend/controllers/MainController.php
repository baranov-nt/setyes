<?php
namespace frontend\controllers;

use common\models\PlaceCity;
use common\models\PlaceCountry;
use common\models\PlaceRegion;
use Yii;
use frontend\models\RegForm;
use common\models\LoginForm;
use common\models\User;
use common\models\UserProfile;
use frontend\models\SendEmailForm;
use frontend\models\ResetPasswordForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\helpers\Url;
use frontend\models\AccountActivation;
use yii\web\ErrorAction;

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
        return $this->render(
            'index',
            [

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
                        Yii::$app->session->setFlash('success', Yii::t('app', 'Letter to activate your account was sent to the email <strong> {email} </strong> (check spam folder).', ['email' => $modelUser->email]));
                        return $this->redirect(Url::to(['/main/index']));
                    else:
                        Yii::$app->session->setFlash('error', Yii::t('app', 'Error. The letter was not sent.'));
                        Yii::error(Yii::t('app', 'Error. The letter was not sent.'));
                    endif;
                    return $this->refresh();
                endif;
            else:
                Yii::$app->session->setFlash('error', Yii::t('app', 'There was an error during the registration process.'));
                Yii::error(Yii::t('app', 'There was an error during the registration process.'));
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
                        Yii::$app->session->setFlash('success', Yii::t('app', 'Letter to activate your account was sent to the email <strong> {email} </strong> (check spam folder).', ['email' => $user->email]));
                        return $this->redirect(Url::to(['/main/index']));
                    else:
                        Yii::$app->session->setFlash('error', Yii::t('app', 'Error. The letter was not sent.'));
                        Yii::error(Yii::t('app', 'Error. The letter was not sent.'));
                    endif;
                    return $this->refresh();
                endif;
            else:
                Yii::$app->session->setFlash('error', Yii::t('app', 'There was an error during the registration process.'));
                Yii::error(Yii::t('app', 'There was an error during the registration process.'));
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
            Yii::$app->session->setFlash('error', Yii::t('app', 'Invalid key. Repeat registration.'));
            throw new BadRequestHttpException($e->getMessage());
        }

        if($user = $user->activateAccount()):
            Yii::$app->session->setFlash('success', Yii::t('app', 'Activation was successful.'));
            Yii::$app->getUser()->login($user);
            return $this->redirect(['/main/profile']);
        else:
            Yii::$app->session->setFlash('error', Yii::t('app', 'Activation error.'));
            Yii::error(Yii::t('app', 'Activation error.'));
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

        $model = new LoginForm();

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

    public function actionSendEmail()
    {
        $model = new SendEmailForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if($model->sendEmail()):
                    Yii::$app->getSession()->setFlash('warning', Yii::t('app', 'Link to the password recovery has been sent to your email.'));
                    return $this->goHome();
                else:
                    Yii::$app->getSession()->setFlash('error', Yii::t('app', 'You can not reset the password.'));
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
                Yii::$app->getSession()->setFlash('warning', Yii::t('app', 'Your password is changed.'));
                return $this->redirect(['/main/login']);
            }
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionUser()
    {
        $modelUserProfile = ($modelUserProfile = UserProfile::findOne(Yii::$app->user->id)) ? $modelUserProfile : new UserProfile();

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
                'modelUserProfile' => $modelUserProfile,
                'modelUser' => $modelUser
            ]
        );
    }

    public function actionProfile()
    {
        /* @var $modelUserProfile \common\models\UserProfile */

        $modelUserProfile = $modelUserProfile = UserProfile::findOne(Yii::$app->user->id);

        $imagesObject = $modelUserProfile->imagesOfObjects;

        $modelUser = ($modelUser = User::findOne(Yii::$app->user->id)) ? $modelUser : new User();

        if($modelUserProfile->load(Yii::$app->request->post()) && $modelUserProfile->validate()):
            if($modelUserProfile->updateProfile()):
                if(!$modelUserProfile->user->errors):
                    Yii::$app->session->setFlash('success', Yii::t('app', 'Profile changed'));
                endif;
            else:
                Yii::$app->session->setFlash('error', Yii::t('app', 'Profile not changed'));
                Yii::error(Yii::t('app', 'Profile not changed'));
                return $this->refresh();
            endif;
        endif;

        return $this->render(
            'profile',
            [
                'modelUserProfile' => $modelUserProfile,
                'modelUser' => $modelUser,
                'imagesObject' => $imagesObject
            ]
        );
    }

    public function actionViewProfile($id)
    {
        /* @var $modelUserProfile \common\models\UserProfile */

        $modelUserProfile = ($model = UserProfile::findOne($id)) ? $model : new UserProfile();
        $this->titleMeta = $modelUserProfile->first_name.' '.$modelUserProfile->second_name;
        $this->descriptionMeta = Yii::t('app', 'Card User');
        foreach($modelUserProfile->imagesOfObjects as $one):
            $this->imageMeta = Yii::$app->urlManager->createAbsoluteUrl('').'images/'.$one->image->path_small_image;
        endforeach;

        return $this->render(
            'view-profile', [
                'modelUserProfile' => $modelUserProfile
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
            $cityPlaceId = $object->place_id;                               // идентификатор города

            /* Находим введенный город в базе по place_id */
            /* @var $modelPlaceCity \common\models\PlaceCity */
            $modelPlaceCity = PlaceCity::findOne(['place_id' => $cityPlaceId]);

            if($modelPlaceCity):
                // если город найден выставляем куки и переходим на главную страницу с get переменной city
                $this->setCookie($formattedAddress, $modelPlaceCity);
                Yii::$app->session->set('_cityId', $modelPlaceCity->id);
                return $this->redirect(Url::to(['/main/index', 'city' => $modelPlaceCity->id]));
            else:
                // если город не найден, находим регион
                $objectRegion = \Yii::$app->googleApi->getGeoCodeObject($region.' '.$country, null);
                $regionPlaceId = $objectRegion->place_id;
                // ищем регион в базе
                /* @var $modelPlaceRegion \common\models\PlaceRegion */
                $modelPlaceRegion = PlaceRegion::findOne(['place_id' => $regionPlaceId]);

                if($modelPlaceRegion):
                    // если регион найден
                    $modelPlaceCity = new PlaceCity();
                    // добавляем новый город к найденному региону, пишем куки и переходим на главную страницу с get переменной city
                    $modelPlaceCity = $modelPlaceCity->createCity($modelPlaceRegion, $cityPlaceId);
                    $this->setCookie($formattedAddress, $modelPlaceCity);
                    Yii::$app->session->set('_cityId', $modelPlaceCity->id);
                    return $this->redirect(Url::to(['/main/index', 'city' => $modelPlaceCity->id]));
                else:
                    // если регион не найден, находим страну
                    foreach($object->address_components as $one):
                        if($one->types[0] == 'country'):
                            $country = $one->short_name;
                        endif;
                    endforeach;
                    $modelPlaceCountry = PlaceCountry::findOne(['iso2' => $country]);
                    // если страна найдена
                    if($modelPlaceCountry):
                        $modelPlaceRegion = new PlaceRegion();
                        // Добавляем новый регион и город, пишем куки и переходим на главную страницу с get переменной city
                        $modelPlaceCity = $modelPlaceRegion->createRegionAndCity($modelPlaceCountry, $regionPlaceId, $cityPlaceId);
                        $this->setCookie($formattedAddress, $modelPlaceCity);
                        Yii::$app->session->set('_cityId', $modelPlaceCity->id);
                        return $this->redirect(Url::to(['/main/index', 'city' => $modelPlaceCity->id]));
                    endif;
                endif;
            endif;
        endif;

        /* Если объект не найден, чистим куки в переходим на главную страницу */
        $this->clearCookie();

        return $this->redirect(Url::to(['/main/index']));
    }

    public function setCookie($formattedAddress, $modelPlaceCity)
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
            'value' => $modelPlaceCity->id,
            'expire' => time() + 86400 * 365,
        ]));

        /* place_id города */
        $cookies->add(new \yii\web\Cookie([
            'name' => '_cityPlaceId',
            'value' => $modelPlaceCity->place_id,
            'expire' => time() + 86400 * 365,
        ]));

        /* place_id региона */
        $cookies->add(new \yii\web\Cookie([
            'name' => '_regionId',
            'value' => $modelPlaceCity->region->place_id,
            'expire' => time() + 86400 * 365,
        ]));

        /* Страна в iso2 (например RU) */
        $cookies->add(new \yii\web\Cookie([
            'name' => '_countryId',
            'value' => $modelPlaceCity->region->country->id,
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
