<?php
namespace frontend\controllers;

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
                        return $this->redirect(Url::to(['/ad/view/all']));
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
        Yii::$app->placeManager->testBrowser();
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
                        return $this->redirect(Url::to(['/ad/view/all']));
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

    public function actionUpdatePhone()
    {
        $emailActivation = Yii::$app->params['emailActivation'];
        $modelReg = $emailActivation ? new RegForm(['scenario' => 'emailActivation']) : new RegForm();

        if ($modelReg->load(Yii::$app->request->post())):
            $phoneMask = $modelReg->getPhoneMask();
            d($phoneMask);
            return $this->render(
                'reg',
                [
                    'model' => $modelReg,
                    'phoneMask' => $phoneMask,
                ]
            );
        endif;

        return $this->render(
            'reg',
            [
                'model' => $modelReg,
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

        return $this->redirect(Url::to(['/ad/view/all']));
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['/ad/view/all']);
    }

    public function actionLogin()
    {
        Yii::$app->placeManager->testBrowser();

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
        $cityId = Yii::$app->placeManager->setMainCity($place);
        if($cityId) {
            return $this->redirect(Url::to(['/ad/view/all', 'cityId' => $cityId]));
        }
        /* Если объект не найден, переходим на главную страницу */
        return $this->redirect(Url::to(['/ad/view/all']));
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
