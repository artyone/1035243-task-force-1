<?php


namespace frontend\controllers;

use frontend\service\UserService;
use yii\web\Controller;
use frontend\models\RegistrationForm;
use yii;
use yii\widgets\ActiveForm;
use yii\web\Response;


/**
 * Registration controller
 */
class RegistrationController extends Controller
{

    /**
     * Регистрация пользователя.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $userRegisterForm = new RegistrationForm();
        if (Yii::$app->request->getIsPost()) {
            $userRegisterForm->load(Yii::$app->request->post());
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($userRegisterForm);
            }
            if ($userRegisterForm->validate()) {
                $service = new UserService();
                if($service->registration($userRegisterForm)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('index', [
            'userRegisterForm' => $userRegisterForm
        ]);
    }


}
