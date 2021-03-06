<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30.10.2015
 * Time: 9:01
 *
 * Используется только для авторизации через социальные сети !!!!
 */
namespace frontend\controllers;

use Yii;
use common\models\Auth;
use common\models\User;
use yii\helpers\Url;
use yii\web\Controller;
use common\models\UserProfile;
use yii\authclient\AuthAction;
use common\models\UserPrivilege;
use common\rbac\helpers\RbacHelper;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'auth' => [
                'class' => AuthAction::className(),
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
            /*'timezone' => [
                'class' => 'yii2mod\timezone\TimezoneAction',
            ],*/
        ];
    }

    public function actionTimezone()
    {
        //dd(\Yii::$app->getRequest()->get('timezone', false));
        $timezone = \Yii::$app->getRequest()->get('timezone', false);

        $zoneList = \DateTimeZone::listIdentifiers();

        if (!$timezone || empty($timezone) || !in_array($timezone, $zoneList)) {
            $timezoneAbbr = \Yii::$app->getRequest()->get('timezoneAbbr');
            $timezoneOffset = \Yii::$app->getRequest()->get('timezoneOffset');
            $timezone = timezone_name_from_abbr($timezoneAbbr, $timezoneOffset * 3600);
        }

        if (!$timezone || !in_array($timezone, $zoneList)) {
            $timezone = date_default_timezone_get();
        }

        \Yii::$app->session->set('timezone', $timezone);
        return $this->goBack();
        //return $this->goHome();
    }

    public function onAuthSuccess($client)
    {
        /* @var $client \yii\authclient\OAuth2*/
        /* @var $user \common\models\User */

        $attributes = $client->getUserAttributes();

        /* @var $auth Auth */
        $auth = Auth::find()->where([
            'source' => $client->getId(),
            'source_id' => $attributes['id'],
        ])->one();

        if (Yii::$app->user->isGuest) {
            if ($auth) {                    // вход
                $user = $auth->user;
                if($user->status == User::STATUS_NOT_ACTIVE && $user->email == ''):
                    Yii::$app->getSession()->setFlash('success', [
                        Yii::t('app', "To complete registration, enter the phone number and confirm the e-mail address."),
                    ]);
                    return $this->redirectUser($url = Url::to(['/main/finish-reg', 'id' => $user->id]));
                elseif($user->status == User::STATUS_NOT_ACTIVE && $user->email != ''):
                    Yii::$app->getSession()->setFlash('success', [
                        Yii::t('app', "To complete registration, enter a phone number."),
                    ]);
                    return $this->redirectUser($url = Url::to(['/main/finish-reg', 'id' => $user->id]));
                elseif($user->status == User::STATUS_DELETED):
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app', "This user is blocked."),
                    ]);
                    return $this->redirectUser($url = Url::to(['/ad/view/all']));
                endif;
                Yii::$app->user->login($user);
            } else {                        // регистрация
                if (isset($attributes['email']) && $user = User::findOne(['email' => $attributes['email']])) {
                    // Если пользователь регитрировался ранее через форму регистации.
                    if($user):
                        if($user->status == User::STATUS_DELETED):
                            Yii::$app->getSession()->setFlash('error',
                                Yii::t('app', "User <strong> {email} </strong> blocked.", ['email' => $user->email]));
                        elseif($user->auths->source):
                            Yii::$app->getSession()->setFlash('error', [
                                Yii::t('app', "Authorization using the email address <strong> {email} </strong> is already happening through the account <strong> {auths} </strong>.
                            Log on using the account <strong> {auths} </strong> or use the link <strong> Forgot your password? </strong> for email <strong> {email} </strong> to restore the password..", ['email' => $user->email, 'auths' => $user->auths->source]),
                            ]);
                        else:
                            Yii::$app->getSession()->setFlash('error',
                                Yii::t('app', "Authorization using the email address <strong> {email} </strong> has successfully passed through the registration form. Click on the link <strong> Forgot your password? </strong> to restore the password.", ['email' => $user->email]));
                        endif;
                    endif;
                    return $this->redirectUser($url = Url::to(['/main/login']));
                } else {
                    // Полученные данные заносим в переменные
                    /* @var $email string */
                    /* @var $first_name string */
                    /* @var $last_name string */
                    if(Yii::$app->request->get('authclient') == 'google'):
                        $first_name = $attributes['name']['givenName'];
                        $last_name = $attributes['name']['familyName'];
                        $email = $attributes['emails'][0]['value'];
                    elseif(Yii::$app->request->get('authclient') == 'yandex'):
                        $first_name = $attributes['first_name'];
                        $last_name = $attributes['last_name'];
                        $email = $attributes['default_email'];
                    elseif(Yii::$app->request->get('authclient') == 'facebook'):
                        $names = explode(' ', $attributes['name']);
                        $first_name = $names[0];
                        $last_name = $names[1];
                        $email = $attributes['email'];
                    elseif(Yii::$app->request->get('authclient') == 'vkontakte'):
                        $first_name = $attributes['first_name'];
                        $last_name = $attributes['last_name'];
                        $email = false;
                    elseif(Yii::$app->request->get('authclient') == 'twitter'):
                        $names = $attributes['name'];
                        $names = explode(' ', $names);
                        $first_name = $names[0];
                        $last_name = $names[1];
                        $email = false;
                    elseif(Yii::$app->request->get('authclient') == 'linkedin'):
                        $first_name = $attributes['first_name'];
                        $last_name = $attributes['last_name'];
                        $email = $attributes['email'];
                    endif;

                    $password = Yii::$app->security->generateRandomString(6);

                    if($email == false) {
                        $email = '';
                    }

                    $user = new User([
                        'email' => $email,
                        'password' => $password,
                        'status' => User::STATUS_NOT_ACTIVE,
                        'country_id' => 182,
                    ]);

                    $user->generateAuthKey();
                    $user->generateSecretKey();
                    $transaction = $user->getDb()->beginTransaction();

                    if ($user->save()) {
                        $auth = new Auth([
                            'user_id' => $user->id,
                            'source' => $client->getId(),
                            'source_id' => (string)$attributes['id'],
                        ]);
                        if ($auth->save()) {
                            /* @var $modelProfile /common/models/UserProfile */
                            $modelProfile = new UserProfile();
                            $modelProfile->user_id = $user->id;
                            $modelProfile->first_name = $first_name;
                            $modelProfile->last_name = $last_name;
                            if($modelProfile->save()):
                                if(RbacHelper::assignRole($user->id)) {
                                    $modelUserPrivilege = new UserPrivilege();
                                    $modelUserPrivilege->link('user', $user);
                                    $transaction->commit();
                                }
                                // если нет емайл, делаем перенаправление на main/finish-reg
                                if($email == false):
                                    Yii::$app->getSession()->setFlash('success', [
                                        Yii::t('app', "To complete registration, enter the phone number and confirm the e-mail address."),
                                    ]);
                                    return $this->redirectUser($url = Url::to(['/main/finish-reg', 'id' => $user->id]));
                                endif;
                                Yii::$app->getSession()->setFlash('success', [
                                    Yii::t('app', "To complete registration, enter a phone number."),
                                ]);
                                return $this->redirectUser($url = Url::to(['/main/finish-reg', 'id' => $user->id]));
                            endif;
                        } else {
                            d($auth->getErrors());
                        }
                    } else {
                        /* @var $user \common\models\User */
                        $user = User::findOne(['email' => $user->email]);
                        // Если пользователь регитрировался ранее через форму регистации.
                        if($user):
                            if($user->status == User::STATUS_DELETED):
                                Yii::$app->getSession()->setFlash('error',
                                    Yii::t('app', "User <strong> {email} </strong> blocked.", ['email' => $user->email]));
                            elseif($user->auths->source):
                                Yii::$app->getSession()->setFlash('error', [
                                    Yii::t('app', "Authorization using the email address <strong> {email} </strong> is already happening through the account <strong> {auths} </strong>.
                            Log on using the account <strong> {auths} </strong> or use the link <strong> Forgot your password? </strong> for email <strong> {email} </strong> to restore the password..", ['email' => $user->email, 'auths' => $user->auths->source]),
                                ]);
                            else:
                                Yii::$app->getSession()->setFlash('error',
                                    Yii::t('app', "Authorization using the email address <strong> {email} </strong> has successfully passed through the registration form. Click on the link <strong> Forgot your password? </strong> to restore the password.", ['email' => $user->email]));
                            endif;
                        endif;
                        return $this->redirectUser($url = Url::to(['/main/login']));
                    }
                }
            }
        } else { // user already logged in
            if (!$auth) { // add auth provider
                $auth = new Auth([
                    'user_id' => Yii::$app->user->id,
                    'source' => $client->getId(),
                    'source_id' => $attributes['id'],
                ]);
                $auth->save();
            }
        }
        return true;
    }

    public function redirectUser($url) {
        /* Если пользователь с таким эл. адресом существуе, делаем переход обратно на страницу входа */
        $viewFile = '@frontend/views/main' . DIRECTORY_SEPARATOR . 'redirect.php';  // файл перехода
        $viewData = [
            'url' =>$url,
            'enforceRedirect' => true,
        ];
        $response = Yii::$app->getResponse();
        $response->content = Yii::$app->getView()->renderFile($viewFile, $viewData);
        return $response;
    }
}