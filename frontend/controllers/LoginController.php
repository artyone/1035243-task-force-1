<?php


namespace frontend\controllers;

use frontend\service\UserService;
use yii\web\Controller;
use frontend\models\LoginForm;
use yii;
use yii\widgets\ActiveForm;
use yii\web\Response;


/**
 * Registration controller
 */
class LoginController extends Controller
{

    /**
     * Регистрация пользователя.
     *
     * @return mixed
     */
    public function actionIndex()
    {

/*        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }*/

/*        $userLoginForm = new LoginForm();
        if (Yii::$app->request->getIsPost()) {
            $userLoginForm->load(Yii::$app->request->post());
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($userLoginForm);
            }
            if ($userLoginForm->validate() && UserService::login($userLoginForm->user)) {
                return $this->goBack();
            }
        }*/
        $userLoginForm = new LoginForm();
        if (Yii::$app->request->getIsPost()) {
            $userLoginForm->load(Yii::$app->request->post());
            if ($userLoginForm->validate()) {
                $user = $userLoginForm->getUser();
                Yii::$app->user->login($user);
                return $this->goBack();
            }
        }

        return $this->render('index', [
            'userLoginForm' => $userLoginForm
        ]);
    }


}
