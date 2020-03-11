<?php


namespace frontend\controllers;

use frontend\service\UserService;
use yii\web\Controller;
use frontend\models\RegistrationForm;
use yii;



class RegistrationController extends Controller
{

    public function actionIndex()
    {

        $userRegisterForm = new RegistrationForm();
        if ($userRegisterForm->load(Yii::$app->request->post()) && $userRegisterForm->validate()) {
            $service = new UserService();
            if($service->registration($userRegisterForm)) {
                return $this->goHome();
            }
        }

        return $this->render('index', [
            'userRegisterForm' => $userRegisterForm
        ]);
    }


}
