<?php


namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\RegistrationForm;
use yii;



class RegistrationController extends Controller
{

    public function actionIndex()
    {

        $model = new RegistrationForm();

        if ($model->load(Yii::$app->request->post()) && $model->registration()) {
            return $this->goHome();
        }

        return $this->render('index', [
            'model' => $model
        ]);
    }


}
