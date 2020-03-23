<?php


namespace frontend\controllers;


use frontend\models\LoginForm;
use frontend\models\RegistrationForm;
use frontend\models\tasks\Tasks;
use frontend\service\UserService;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii;

class SiteController extends SecuredController
{

    public function actionIndex()
    {
        return Yii::$app->response->redirect(['tasks/index']);
    }

    public function actionLogin()
    {
        $userLoginForm = new LoginForm();
        if (Yii::$app->request->getIsPost()) {
            $userLoginForm->load(Yii::$app->request->post());
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($userLoginForm);
            }
            if ($userLoginForm->validate()) {
                $user = $userLoginForm->getUser();
                Yii::$app->user->login($user);
                return $this->goBack();
            }
        }

        return $this->render('login', [
            'userLoginForm' => $userLoginForm,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * Регистрация пользователя.
     *
     * @return mixed
     */
    public function actionRegistration()
    {

        $userRegisterForm = new RegistrationForm();
        if (Yii::$app->request->getIsPost()) {
            $userRegisterForm->load(Yii::$app->request->post());
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($userRegisterForm);
            }
            if ($userRegisterForm->validate()) {
                if ((new UserService)->registration($userRegisterForm)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('registration', [
            'userRegisterForm' => $userRegisterForm
        ]);
    }

    /**
     * Отображение лэндинга сайта
     *
     * @return mixed
     */
    public function actionLanding()
    {
        $query = Tasks::find()
            ->orderBy(['creation_time' => SORT_DESC])
            ->where(['status' => Tasks::STATUS_NEW])
            ->limit(4);

        $tasks = $query->all();

        $userLoginForm = new LoginForm();
        if (Yii::$app->request->getIsPost()) {
            $userLoginForm->load(Yii::$app->request->post());
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($userLoginForm);
            }
            if ($userLoginForm->validate()) {
                $user = $userLoginForm->getUser();
                Yii::$app->user->login($user);
                return $this->goHome();
            }
        }

        return $this->renderPartial('landing', [
            'tasks' => $tasks,
            'userLoginForm' => $userLoginForm
        ]);
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
}