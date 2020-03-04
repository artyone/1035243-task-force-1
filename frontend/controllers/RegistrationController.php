<?php


namespace frontend\controllers;

use frontend\models\Cities;
use yii\web\Controller;
use frontend\models\RegistrationForm;
use yii;



class RegistrationController extends Controller
{

    public function actionIndex()
    {
$error = null;
        $query = Cities::find();

        $model = new RegistrationForm();
        $model->load(Yii::$app->request->post());
        if(!$model->validate()){
            $error = $model->getErrors();
        }

        $cities = $query
            ->all();



        return $this->render('index', [
            'cities' => $cities,
            'model' => $model,
            'error' => $error
        ]);
    }


/*    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }*/

}
