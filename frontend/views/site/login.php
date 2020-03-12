<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Cities;

/** @var $userLoginForm */

?>

<section class="registration__user">
    <h1 align="center">Вход на сайт</h1>
    <div class="registration-wrapper">

        <?php $form = ActiveForm::begin([
            'id' => 'user-login-form',
            'options' => ['class' => 'registration__user-form form-create'],
            'action' => ['/login'],
            'method' => 'post',
            'enableAjaxValidation' => true
        ]) ?>

        <?= $form->field($userLoginForm, 'email', [
            'options' => ['class' => '']
        ])
            ->textinput([
                'class' => 'input textarea',
                'style' => 'width: 100%',
                'placeholder' => 'ivanov@mail.ru'
            ])
            ->error(['tag' => 'span', 'style' => 'display:inline-block, margin-bottom:12px']) ?>

        <?= $form->field($userLoginForm, 'password', [
            'options' => ['class' => ''],

        ])
            ->passwordInput([
                'class' => 'input textarea',
                'style' => 'width: 100%',
                'type' => 'password'
            ])
            ->error(['tag' => 'span', 'style' => 'display:inline-block, margin-bottom:12px']) ?>



        <div class="form-group">
            <?= Html::submitButton('Войти',
                ['class' => 'button button__login', 'name' => 'login-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</section>